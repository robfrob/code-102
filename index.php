<?php

// https://www.php.net/manual/en/book.pdo.php
// https://console.neon.tech/app/projects/cool-lab-76158961?database=yolo

class Query {
  const SQL_QUERY_CURRENT_DATABASE = 'select current_database()';
  const SQL_QUERY_GET_CUSTOMER = 'select * from customers limit 1';

  private \PDO $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');
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
    $customers = $statement->fetchAll();
    return $customers[0];
  }
}

$query = Query::create();
?>
<pre>
  <?php print_r($query->getCustomer()) ?>
</pre>
