<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Queries {

  private array $queries; 

  public function __construct() {
    $this->queries = [
      'get_current_database' => 'select current_database()',  
      'get_customer' => 'select * from customers limit 1',
      'get_all_salespeople' => 'select * from salespeople',
      'get_salespeople_info' => 'select sname, comm from salespeople',
      'get_all_orders' => 'select * from orders',
      'get_shuffle_orders' => 'select odate, snum, onum, amt from orders',
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
    $Db = new Db($pdo, $queries);          
    return $Db;
  }

  public function runSqlQueries() {
    $classMethods = get_class_methods($this);
    foreach ($classMethods as $methodName) {
      if (strpos($methodName, 'get') === 0) {
        echo '<p>' . $methodName . '</p>';
        echo '<pre>';
        print_r(call_user_func(array($this, $methodName)));
        echo '</pre>';
      }
    }
  }
  
  public function getCurrentDatabase() {
    $sqlText = $this->queries->get('get_current_database');
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    $currentDatabase = $statement->fetchColumn();
    return $currentDatabase;
  }

  public function getCustomer() {
    $sqlText = $this->queries->get('get_customer');
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    return $statement->fetchAll();
  }
}

$Db = Db::create();
$Db->runSqlQueries();
//$Db->renderSqlQueries();
?>
<!--
вот єтот кусок сделай циклом по методам класса 
цикл (Метод в ВсеПубличниеМетодиКлассаКромеКонструктора)
  
    <p>Имя метода разделенное пробелами</p>
  <pre>print_r(реузльтат вьізова метода) </pre>
конецЦикла

и кусок штмл помести в статический метод класса Db
c именем runSqlQueries

getAllSalespeople превращается в Get all salespeople
getSalespeopleInfo превращается в Get salespeople info

сначала просто имя метода как есть
потом погугли как преобразовать строку из camelCase в underscoreCase 
и сделать первую букву в имени метода заглавной
-->
