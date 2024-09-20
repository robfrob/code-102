<?php

namespace Telema;

class Db {

  private \PDO $pdo;
  private Queries $queries;

  public function __construct($pdo, $queries) {
    $this->pdo = $pdo;
    $this->queries = $queries;
  }

  public static function create() {
    $dsn = getenv('PG_DSN');
    $pdo = new \PDO($dsn); 
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

  // private function listOfSelectMethods() {
  //   $listOfSelectMethods = [];
  //   $classMethods = get_class_methods($this);
  //   foreach ($classMethods as $methodName) {
  //     if (strpos($methodName, 'select') === 0 && $methodName !== 'select') { 
  //         $listOfSelectMethods[] = $methodName;
  //     }
  //   }
  //   return $listOfSelectMethods;
  // }
  
  private function listOfSelectMethods() {
    $classMethods = get_class_methods($this);
    return array_values(array_filter(
      $classMethods,
      fn($methodName) => strpos($methodName, 'select') === 0 && $methodName !== 'select'));
  }

  private function echoSelectMethod($methodName, $methodResult) { 
  ?>
    <p>
      <?php print(StringUtil::convertCamelCaseToSnakeCase($methodName));?>
    </p>
    <pre>
      <?php print_r($methodResult);?>
    </pre>
  <?php
  }

  public function runSqlQueries() {
    foreach ($this->listOfSelectMethods() as $methodName) {
      $methodResult = call_user_func([$this, $methodName]);
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