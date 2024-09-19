<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Queries {

  private $queries = []; 

  public function __construct() {
    $this->queries = [
      'select_current_database' => 'select current_database()',  
      'select_customer' => 'select * from customers limit 1',
      'select_all_salespeople' => 'select * from salespeople',
      'select_salespeople_info' => 'select sname, comm from salespeople',
      'select_all_orders' => 'select * from orders',
      'select_shuffle_orders' => 'select odate, snum, onum, amt from orders',
    ];
  }
  
  public function get($queryName) {
    return $this->queries[$queryName];  
  }
}

class Db {
   
  private \PDO $pdo;
  private \Queries $queries;

  public function __construct($pdo, $queries) {
    $this->pdo = $pdo;
    $this->queries = $queries;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');
    $pdo = new PDO($dsn); 
    $queries = new Queries();
    $db = new Db($pdo, $queries);          
    return $db;
  }

  private function select($sqlQuery) {
    $sqlText = $this->queries->get($sqlQuery);
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    return $statement->fetchAll();
  }

  private function listOfSelectMethods() {
    $listOfSelectMethods = [];
    $classMethods = get_class_methods($this);
    foreach ($classMethods as $methodName) {
      if (strpos($methodName, 'select') === 0 && $methodName !== 'select') { 
          $listOfSelectMethods[] = $methodName;
      }
    }
    return $listOfSelectMethods;
  }

  public function echoSelectMethod($methodName, $methodResult) { 
  ?>
    <p>
      <?php print_r(StringUtil::convertCamelCaseToSnakeCase($methodName));?>
    </p>
    <pre>
      <?php print_r(call_user_func(array($this, $methodName)));?>
    </pre>
  <?php
  }
  
  public function runSqlQueries() {
    foreach ($this->listOfSelectMethods() as $methodName) {
      $methodResult = call_user_func(array($this, $methodName));
      $this->echoSelectMethod($methodName, $methodResult);
    }
  }

  public function selectCurrentDatabase() {
   return $this->select('select_current_database');
  }

  public function selectCustomer() {
   return $this->select('select_customer');
  }
 
  public function selectAllSalespeople() {
    return $this->select('select_all_salespeople');
  }

  public function selectSalespeopleInfo() {
    return $this->select('select_salespeople_info');
  }

  public function selectAllOrders() {
    return $this->select('select_all_orders');
  }

  public function selectShuffleOrders() {
    return $this->select('select_shuffle_orders');
  }
 
}

class StringUtil {
  
  public static function convertCamelCaseToSnakeCase($camelCase) {
    $snakeCase = '';

    for ($i = 0; $i < strlen($camelCase); $i++) { 
        if (ctype_upper($camelCase[$i])) { 
          $snakeCase .= ' ' . strtolower($camelCase[$i]); 
        } else { 
          $snakeCase.= $camelCase[$i]; 
        } 
    } 

    $snakeCase = ltrim($snakeCase, ' ');
    return ucfirst($snakeCase); 
  }
}

$db = Db::create();
$db->runSqlQueries();
