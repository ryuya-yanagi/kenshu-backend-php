<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Usecase\Errors\ValidationException;
use Exception;

interface iBasePresentator
{
  public static function viewException(Exception $e);
  public static function viewValidationException(ValidationException $e);
  public static function viewNotFound();
  public static function viewUnauthorized();
}
