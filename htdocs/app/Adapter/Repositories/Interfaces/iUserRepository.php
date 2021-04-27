<?php

namespace App\Adapter\Repositories\Interfaces;

use App\Entity\User;

interface iUserRepository
{
  public function SelectAll();
  public function SelectById(int $id);
  public function SelectByName(string $name);
  public function Insert(User $user);
  public function Update(User $user);
  public function Delete(int $id);
}
