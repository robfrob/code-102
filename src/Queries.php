<?php

namespace Telema;

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