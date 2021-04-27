<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\Dto\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;

interface iUserInteractor
{
  public function ListUser();
  public function FindById(int $id);
  public function FindByName(string $name);
  public function Save(CreateUserDto $user);
  public function Update(UpdateUserDto $user);
  public function Delete(int $id);
}
