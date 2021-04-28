<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iUserPresentator;

class UserPresentator extends BasePresentator implements iUserPresentator
{
  public static function viewUserList(array $userList)
  {
    echo "<ul>\n";
    foreach ($userList as $index => $user) {
      echo "<li>{$user['name']}</li>";
    }
    echo "</ul>\n";
  }

  public static function viewUser(object $user)
  {
    echo "<span>ID：{$user->id}</span><br/>";
    echo "<span>Name：{$user->name}</span><br/>";
  }
}
