<?php

namespace App\Adapter\Presentators\Interfaces;

interface iUserPresentator extends iBasePresentator
{
  public function index(array $userList);
}
