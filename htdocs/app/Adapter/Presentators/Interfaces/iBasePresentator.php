<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Usecase\Errors\UsecaseException;

interface iBasePresentator
{
  public function outError(UsecaseException $e);
}
