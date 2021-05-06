<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Entity\User;

interface iUserInteractor
{
  public function ListUser(): array;
  public function FindById(int $id): ?User;
  public function FindByName(string $name): ?User;
  public function Save(CreateUserDto $createUserDto): int;
  public function Update(UpdateUserDto $updateUserDto): bool;
  public function Delete(int $id): bool;
}
