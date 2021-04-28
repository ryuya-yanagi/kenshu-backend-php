<?php

namespace App\External\Session;

class LoginSessionManagement
{
  public static function requireUnloginedSession()
  {
    @session_start();
    if (isset($_SESSION['username'])) {
      header('Location: /mypage');
      exit;
    }
  }

  public static function requireLoginedSession()
  {
    @session_start();
    if (!isset($_SESSION['username'])) {
      header('Location: /auth/login.php');
      exit;
    }
  }

  public function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
