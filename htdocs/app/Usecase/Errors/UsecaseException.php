<?php

namespace App\Usecase\Errors;

use Exception;

class UsecaseException extends Exception
{
  public function __construct($message = null, $code = 0, Exception $previous = null)
  {
    parent::__construct(json_encode($message), $code, $previous);
  }

  public function getArrayMessage($assoc = false)
  {
    return json_decode($this->getMessage(), $assoc);
  }
}
