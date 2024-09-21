<?php

namespace Telema;

private \PDO $pdo;
private Queries $queries;

class SqlRunner {

  public static function main() {
    
  }
  
  public static function createDb() {
    $dsn = getenv('PG_DSN');
    $pdo = new \PDO($dsn); 
    $queries = new Queries();
    $db = new Db($pdo, $queries);          
    return $db;
  }

  private function listSelectMethods() {
    $classMethods = get_class_methods($this);
    return array_values(array_filter(
      $classMethods,
      fn($methodName) => strpos($methodName, 'select') === 0 && $methodName !== 'select'
    ));
  }

  public function runSelectMethods() {
    foreach ($this->listOfSelectMethods() as $methodName) {
      $methodResult = call_user_func([$this, $methodName]);
      $this->echoSelectMethod($methodName, $methodResult);
    }
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

  
}