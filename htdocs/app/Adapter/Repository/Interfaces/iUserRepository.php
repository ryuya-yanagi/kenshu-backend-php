<?php

namespace App\Adapter\Repository\Interfaces;

use App\Adapter\Controllers\DTO\User\CreateUserDto;
use App\Adapter\Controllers\DTO\User\UpdateUserDto;

interface iUserRepository
{
  public function SelectAll();
  public function SelectById(int $id);
  public function Insert(CreateUserDto $user);
  public function Update(UpdateUserDto $user);
  public function Delete(int $id);
}
