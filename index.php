<?php

require_once __DIR__ . '/vendor/autoload.php';

use Telema\Db;
use Telema\Queries;
use Telema\StringUtil;

$db = Db::create();
$db->runSqlQueries();
