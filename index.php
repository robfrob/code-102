<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Queries {
  
  private array $queries = ['' => '',];

  public function __construct() {
    
  }

  public static function getQueryName() {
    
  }
  
}

class Db {
  // переименуй єтот класс в Db +

  // сделай новий класс Queries +
  // в котором будет приватное поле массив +
  // ключ в массиве - єто строка - имя sql запроса
  // значение в массиве - єто строка - текст sql запроса
  // 
  // добавь метод get(queryName)
  // которий принимает строку имя sql запроса
  // и возвращает текст sql запроса
  // то есть по сути читает из массива всех запросов
  // и перенеси все єти константи в новий класс
  // инициализируй массив в конструкторе класса Queries
  
  const SQL_QUERY_CURRENT_DATABASE = 'select current_database()';
  const SQL_QUERY_GET_CUSTOMER = 'select * from customers limit 1';
  const SQL_QUERY_GET_ALL_SALESPEOPLE = 'select * from salespeople';
  const SQL_QUERY_GET_SALESPEOPLE_INFO = 'select sname, comm from salespeople';
  const SQL_QUERY_GET_ALL_ORDERS = 'select * from orders';
  const SQL_QUERY_GET_SHUFFLE_ORDERS = 'select odate, snum, onum, amt from orders';

  // єто поле переименуй в pdo
  private \PDO $db;

  public function __construct($db) {
    // в конструктор пробрось об'ект класса queries
    // и добавь приватное поле queries
    // по итогу єтот класс Db будет содержать 2 приватних поля
    // 1е - pdo - соедениене с бд
    // 2е - queries - ассоц массив sql запросов
    $this->db = $db;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');          // secrets в репле
    $db = new PDO($dsn);              
    $query = new Db($db);          
    return $query;
  }

  public function getCurrentDatabase() {
    // вот тут вместо константи класса используй свой класс Queries
    // $queryName = 'get-current-database',
    // $sqlText = $this->queries->get($queryName)
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
