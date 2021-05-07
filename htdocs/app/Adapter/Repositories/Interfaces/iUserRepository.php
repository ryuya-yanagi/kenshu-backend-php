<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\User;

interface iUserRepository extends iBaseRepository
{
  public function selectAll(): array;
  public function selectById(int $id): ?array;
  public function selectByName(string $name): ?object;
  public function insert(User $user): int;
  public function update(User $user): bool;
  public function delete(int $id): bool;
}
