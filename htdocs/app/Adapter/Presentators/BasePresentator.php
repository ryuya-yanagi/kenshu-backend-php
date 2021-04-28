<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iBasePresentator;
use App\Usecase\Errors\ValidationException;
use Exception;

class BasePresentator implements iBasePresentator
{
  public static function viewException(Exception $e)
  {
    echo
    "<div class='error'>
      <p class='error__message'>{$e->getMessage()}</p>
    </div>";
  }

  public static function viewValidationException(ValidationException $e)
  {
    echo "<div class='error'>";
    foreach ($e->getArrayMessage() as $key => $value) {
      echo "<p class='error__message'>$key: $value</p>";
    }
    echo "</div>";
  }

  public static function viewNotFound()
  {
    echo "Not Found!";
  }

  public static function viewUnauthorized()
  {
    echo "Unauthorized!";
  }
}
