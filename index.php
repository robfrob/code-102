<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = Telema\Db::create();
$db->runSqlQueries();