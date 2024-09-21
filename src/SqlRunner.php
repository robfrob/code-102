<?php

namespace Telema;

class SqlRunner {

  public function runSelectMethods($db) {
    foreach ($this->listSelectMethods($db) as $methodName) {
      $methodResult = call_user_func([$db, $methodName]);
      $this->echoSelectMethod($methodName, $methodResult);
    }
  }

  private function listSelectMethods($db) {
    $classMethods = get_class_methods($db);
    return array_filter(
      $classMethods,
      fn($methodName) => strpos($methodName, 'select') === 0 && $methodName !== 'select');
  }

  private function echoSelectMethod($methodName, $methodResult) { 
  ?>
    <p>
      <?php echo Converters::camelToSnake($methodName) ?>
    </p>
    <pre>
      <?php print_r($methodResult);?>
    </pre>
  <?php
  }
}