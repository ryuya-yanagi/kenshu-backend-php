<?php

namespace App\Adapter\Controllers\DTO;

class BaseDto
{
  public static function isExists(...$args)
  {
    return isset($args);
  }
}
