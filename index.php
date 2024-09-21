<?php

require_once __DIR__ . '/vendor/autoload.php';

use Telema\Db;
use Telema\Queries;
use Telema\SqlRunner;

$dsn = getenv('PG_DSN');
$pdo = new \PDO($dsn); 
$queries = new Queries();
$db = new Db($pdo, $queries);
$runner = new SqlRunner();
$runner->runSelectMethods($db);