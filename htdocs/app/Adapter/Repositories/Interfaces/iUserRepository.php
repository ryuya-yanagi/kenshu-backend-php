<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\User;

interface iUserRepository extends iBaseRepository
{
  public function SelectAll(): array;
  public function SelectById(int $id): ?array;
  public function SelectByName(string $name): ?object;
  public function Insert(User $user): int;
  public function Update(User $user): bool;
  public function Delete(int $id): bool;
}
