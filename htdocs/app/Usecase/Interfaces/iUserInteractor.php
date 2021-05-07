<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;
use App\Entity\User;

interface iUserInteractor
{
  public function findAll(): array;
  public function findById(int $id): ?User;
  public function findByName(string $name): ?User;
  public function save(CreateUserDto $createUserDto): int;
  public function update(UpdateUserDto $updateUserDto): bool;
  public function delete(int $id): bool;
}
