<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Query {
  const SQL_QUERY_CURRENT_DATABASE = 'select current_database()';
  const SQL_QUERY_GET_CUSTOMER = 'select * from customers limit 1';
  const SQL_QUERY_GET_SALESPEOPLE = 'select * from salespeople';
  
  private \PDO $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');          // getenv?! $dsn - строка вида 'mysql:host=localhost;dbname=test'
    $db = new PDO($dsn);              // установка соеденения с бд. $dsn - параметр конструктора
    $query = new Query($db);          // целый объект PDO параметр констурктора?!
    return $query;
  }

  public function getCurrentDatabase() {
    $statement = $this->db->query(self::SQL_QUERY_CURRENT_DATABASE);   // 
    $statement->execute();      // выполняем запрос
    $currentDatabase = $statement->fetchColumn();
    return $currentDatabase;
  }

  public function getCustomer() {
    $statement = $this->db->query(self::SQL_QUERY_GET_CUSTOMER);
    $statement->execute();
    $customers = $statement->fetchAll();
    return $customers[0];
  }

  public function getSalespeople() {
    $statement = $this->db->query(self::SQL_QUERY_GET_SALESPEOPLE);
    $statement->execute();
    $customers = $statement->fetchAll();
    return $customers;
  }
}

$query = Query::create();
?>
<pre>
  <?php print_r($query->getSalespeople()) ?>
</pre>
