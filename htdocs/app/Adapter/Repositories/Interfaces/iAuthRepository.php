<?php

namespace App\Adapter\Repositories\Interfaces;

interface iAuthRepository extends iBaseRepository
{
  public function SelectUserByName(string $name): ?object;
}
