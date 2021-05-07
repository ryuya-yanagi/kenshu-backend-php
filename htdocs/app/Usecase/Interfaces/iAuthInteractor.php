<?php

namespace App\Usecase\Interfaces;

use App\Adapter\Controllers\DTO\Auth\LoginUserDto;
use App\Entity\User;

interface iAuthInteractor
{
  public function validate(LoginUserDto $validateUser): ?User;
}
