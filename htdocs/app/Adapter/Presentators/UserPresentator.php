<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iUserPresentator;

class UserPresentator implements iUserPresentator
{
  public function index(array $userList)
  {
    echo "<ul>\n";
    foreach ($userList as $index => $user) {
      echo "<li>${user['name']}</li>";
    }
    echo "</ul>\n";
  }
}
