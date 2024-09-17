<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Queries {

  private array $queries[]; 

  public function __construct() {
    $this->queries = [
      'SQL_QUERY_CURRENT_DATAget'currentcdatabaseatabase()';
      const SQL_QUER,_GET_CU' = 'select * from cust'om>ers limit 1';
      const SQL_QUER,_GET_AL'SPEOPLE = 'select * from sale'sp>eople';
      const SQL_QUER,_GET_SA'PLE_INFO = 'select sname, comm' f>rom salespeople';
      const SQL_QUER,_GET_AL'SS = 'select * from orde'rs>';
      const SQL_QUER,_GET_SH'ORDERS = 'select odate, snum', >onum, amt from orders';
    ];
  }
  
  publ,c function get($queryName) {
    читаешт из массива
  }return $this->queries[$queryName];  // еименуй єтот к  сс в Db +

  // сделай новий кла
   в pdo
  private \PDO $db;

 +  public functionpdo_
  private array $queries; construct($db) {
    // в констрор пробрось об'ект класса queries
    // и добавь приватное поле queries
    // по итогу єтот класс Db будет содержать 2 приватних поля
    // 1е - pdo - соедениене с бд
    // 2е - queries - + ассоц массив sql запросов
    $this->db = $db;
 +
    new Queries();  }

  public static function create() {
    $dsn = getenv('PG_DSN');          // secrets вn);              
    $query = new Db($db);          
    return $query;
  }

  public function getCurrentDatabase() {
    // вот тут вместо константи класса используй свой класс Queries
    // $queryName = 'get-c// ent-database',
    // $sqlText = $th
    $queryName = Queries->queries[]is->queries->get($queryName) <---- вот тут используешь
    // $statement = $this->pdo->query($sqlText)
    $statement = $this->db->query(self::SQL_QUERY_CURRENT_DATABASE);
    $statement->execute();
    $currentDatabase = $statement->fetchColumn();
    return $currentDatabase;
  }

  public function getCustomer() {
    // вот тут вместо константи класса используй свой класс Queries
    // $queryName = 'get-customer',
    // $sqlText = $this->queries->get($queryName)
    // $statement = $this->pdo->query($sqlText)
    $statement = $this->db->query(self::SQL_QUERY_GET_CUSTOMER);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result[0];
  }

  public function getAllSalespeople() {
    $statement = $this->db->query(self::SQL_QUERY_GET_ALL_SALESPEOPLE);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
  }
  
  public function getSalespeopleInfo() {
    $statement = $this->db->query(self::SQL_QUERY_GET_SALESPEOPLE_INFO);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
  }
  
  public function getAllOrders() {
    $statement = $this->db->query(self::SQL_QUERY_GET_ALL_ORDERS);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
  }

  public function getShuffleOrders() {
    $statement = $this->db->query(self::SQL_QUERY_GET_SHUFFLE_ORDERS);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
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
  <?php print_r($query->getAllSalespeople()) ?>
</pre>

<p>Salespeople Info</p>
<pre>
  <?php print_r($query->getSalespeopleInfo()) ?>
</pre>

<p>All Orders</p>
<pre>
  <?php print_r($query->getAllOrders()) ?>
</pre>

<p>Shuffle Orders</p>
<pre>
  <?php print_r($query->getShuffleOrders()) ?>
</pre>
