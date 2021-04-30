<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Entity\User;

interface iAuthInteractor
{
  public function Validate(LoginUserDto $validateUser): ?User;
}
