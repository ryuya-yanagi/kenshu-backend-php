<?php

namespace App\Adapter\Repositories\Interfaces;

interface iAuthRepository extends iBaseRepository
{
  public function selectUserByName(string $name): ?object;
}
