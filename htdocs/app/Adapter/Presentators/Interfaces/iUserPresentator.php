<?php

namespace App\Adapter\Presentators\Interfaces;

use App\Entity\User;

interface iUserPresentator extends iBasePresentator
{
  public static function viewUserList(array $userList);
  public static function viewUser(User $user);
}
