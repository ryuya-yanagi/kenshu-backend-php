<?php

namespace App\Adapter\Presentators;

use App\Adapter\Presentators\Interfaces\iUserPresentator;
use App\Entity\User;

class UserPresentator extends BasePresentator implements iUserPresentator
{
  public static function viewUserList(array $userList)
  {
    echo "<ul>\n";
    foreach ($userList as $index => $user) {
      echo "<li><a href='/users/" . $user["id"] . "' >" . $user["name"] . "</a></li>";
    }
    echo "</ul>\n";
  }

  public static function viewUser(User $user)
  {
    echo "<h3 style='margin-top: 20px;'>{$user->name}</h3>";
    echo "<hr style='margin: 20px 0;' />";
    foreach ($user->articleList as $article) {
      echo "<p><a href='/articles/" . $article["articleId"] . "' >" . $article["title"] . "</a></p>";
    }
  }
}
