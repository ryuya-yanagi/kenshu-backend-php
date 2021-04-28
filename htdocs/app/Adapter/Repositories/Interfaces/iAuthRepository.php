<?php

namespace App\Adapter\Repositories\Interfaces;

interface iAuthRepository
{
  public function SelectUserByName(string $name): ?object;
}
