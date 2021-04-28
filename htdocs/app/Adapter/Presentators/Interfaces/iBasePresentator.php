<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Usecase\Errors\UsecaseException;
use Exception;

interface iBasePresentator
{
  public static function viewException(Exception $e);
  public static function viewUsecaseException(UsecaseException $e);
  public static function viewNotFound();
  public static function viewUnauthorized();
}
