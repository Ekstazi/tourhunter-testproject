<?php

namespace app\components;

use app\models\BalanceHistory;
use app\models\User;
use yii\base\Component;
use yii\db\Exception;
use yii\mutex\Mutex;

class Billing extends Component
{
    protected $mutex;

    public function __construct(Mutex $mutex, array $config = [])
    {
        $this->mutex = $mutex;
        parent::__construct($config);
    }

    public function transfer($user_from, $user_to, $amount)
    {
        if (!is_numeric($amount)) {
            throw new Exception('Cannot transfer non numeric amount');
        }

        if ($amount <= 0) {
            throw new Exception('Cannot transfer non positive amount');
        }

        $user_from_model = User::findOrCreate($user_from);
        $user_to_model = User::findOrCreate($user_to);

        // we use mutex because we have invariant with amount_before in history
        if (!$this->mutex->acquire('billing', 30)) {
            throw new Exception('Cannot process operation');
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->transferInternal($user_from_model, $user_to_model, $amount);
            $transaction->commit();
            $this->mutex->release('billing');
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->mutex->release('billing');
            throw $e;
        }
    }

    /**
     * @param User $user_from
     * @param User $user_to
     * @param float $amount
     * @throws Exception
     */
    protected function transferInternal(User $user_from, User $user_to, $amount)
    {
        User::updateAllCounters(['balance' => -$amount], ['id' => $user_from->id]);
        User::updateAllCounters(['balance' => $amount], ['id' => $user_to->id]);

        $history_line = new BalanceHistory([
            'user_id'       => $user_from->id,
            // this is invariant. Balance before must be actual
            'amount_before' => $user_from->balance,
            'amount'        => -$amount,
            'amount_after'  => $user_from->balance - $amount,
            'message'       => 'Sending money to ' . $user_to->login,
        ]);
        if (!$history_line->save()) {
            throw new Exception('Cannot save history' . implode($history_line->getFirstErrors()));
        }

        $history_line = new BalanceHistory([
            'user_id'       => $user_to->id,
            'amount_before' => $user_to->balance,
            'amount'        => $amount,
            'amount_after'  => $user_to->balance + $amount,
            'message'       => 'Receiving money from ' . $user_from->login,
        ]);
        if (!$history_line->save()) {
            throw new Exception('Cannot save history');
        }
    }
}