<?php

namespace Telema;

class Db {

  private \PDO $pdo;
  private Queries $queries;

  public function __construct($pdo, $queries) {
    $this->pdo = $pdo;
    $this->queries = $queries;
  }

  private function select($sqlQuery) {
    $sqlText = $this->queries->get($sqlQuery);
    $statement = $this->pdo->query($sqlText);
    $statement->execute();
    return $statement->fetchAll();
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