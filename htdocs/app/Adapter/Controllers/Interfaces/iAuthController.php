<?php

namespace App\Adapter\Controllers\Interfaces;

use App\Entity\User;

interface iAuthController
{
  public function login($obj): User;
}
