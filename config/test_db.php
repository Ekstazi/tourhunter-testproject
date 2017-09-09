<?php
$db = require(__DIR__ . '/db.php');
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'sqlite:' . dirname(__DIR__) . '/yii2_test.db';
return $db;