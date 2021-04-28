<?php

namespace App\Adapter\Presentators\Interfaces;

interface iUserPresentator extends iBasePresentator
{
  public static function viewUserList(array $userList);
  public static function viewUser(object $user);
}
