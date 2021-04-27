<?php

namespace App\External\Session;

class LoginSessionManagement
{
  public function requireUnloginedSession()
  {
    @session_start();
    if (isset($_SESSION['username'])) {
      header('Location: /mypage');
      exit;
    }
  }

  public function requireLoginedSession()
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
