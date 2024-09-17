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
  private array $queries;

  public function __construct($db) {
    // в конструктор пробрось об'ект класса queries
    // и добавь приватное поле queries
    // по итогу єтот класс Db будет содержать 2 приватних поля
    // 1е - pdo - соедениене с бд
    // 2е - queries - ассоц массив sql запросов
    new Queries();
    $this->db = $db;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');
    $db = new PDO($dsn);              
    $query = new Db($db);          
    return $query;
  }

  public function getCurrentDatabase() {
    // вот тут вместо константи класса используй свой класс Queries
    $queryName = 'get_current_database';
    $sqlText = $this->queries->get($queryName);
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    $currentDatabase = $statement->fetchColumn();
    return $currentDatabase;
  }

  public function getCustomer() {
    $queryName = 'get_customer';
    $sqlText = $this->queries->get($queryName);
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    return $statement->fetchAll();
  }
}

$query = Db::create();
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
<p>All Salespeople</p>
<pre>
  <?php print_r($query->getCustomer()) ?>