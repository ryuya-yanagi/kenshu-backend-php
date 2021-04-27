<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iBasePresentator;
use App\Usecase\Errors\UsecaseException;

class BasePresentator implements iBasePresentator
{
  public function outMessage(string $message)
  {
    echo "$message";
  }

  public function outUsecaseError(UsecaseException $e)
  {
    foreach ($e->getArrayMessage() as $key => $value) {
      echo "$key: $value";
      echo "<br/>";
    }
  }

  public function viewNotFound()
  {
    echo "Not Found!";
  }
}
