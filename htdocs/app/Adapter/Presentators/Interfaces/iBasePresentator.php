<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Usecase\Errors\UsecaseException;

interface iBasePresentator
{
  public function outMessage(string $message);
  public function outUsecaseError(UsecaseException $e);
  public function viewNotFound();
}
