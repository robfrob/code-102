<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Query {
  const SQL_QUERY_CURRENT_DATABASE = 'select current_database()';
  const SQL_QUERY_GET_CUSTOMER = 'select * from customers limit 1';
  const SQL_QUERY_GET_ALL_SALESPEOPLE = 'select * from salespeople';
  const SQL_QUERY_GET_SALESPEOPLE_INFO = 'select sname, comm from salespeople';
  const SQL_QUERY_GET_ALL_ORDERS = 'select * from orders';
  const SQL_QUERY_GET_SHUFFLE_ORDERS = 'select odate, snum, onum, amt from orders';
  
  private \PDO $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');          // secrets в репле
    $db = new PDO($dsn);              
    $query = new Query($db);          
    return $query;
  }

  public function getCurrentDatabase() {
    $statement = $this->db->query(self::SQL_QUERY_CURRENT_DATABASE);
    $statement->execute();
    $currentDatabase = $statement->fetchColumn();
    return $currentDatabase;
  }

  public function getCustomer() {
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

$query = Query::create();
?>
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
