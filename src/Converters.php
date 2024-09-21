<?php

namespace Telema;

class Converters {

  public static function camelToSnake($camelCase) {
    $snakeCase = '';

    for ($i = 0; $i < strlen($camelCase); $i++) { 
        if (ctype_upper($camelCase[$i])) { 
          $snakeCase .= ' ' . strtolower($camelCase[$i]); 
        } else { 
          $snakeCase.= $camelCase[$i]; 
        } 
    } 

    $snakeCase = ltrim($snakeCase, ' ');
    return ucfirst($snakeCase); 
  }
}