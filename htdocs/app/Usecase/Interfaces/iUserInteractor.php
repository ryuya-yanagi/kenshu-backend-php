<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;

interface iUserInteractor
{
  public function ListUser(): array;
  public function FindById(int $id): ?object;
  public function FindByName(string $name): ?object;
  public function Save(CreateUserDto $user): int;
  public function Update(UpdateUserDto $user): bool;
  public function Delete(int $id): bool;
}
