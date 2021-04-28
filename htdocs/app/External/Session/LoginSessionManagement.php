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

  public static function setLoginSession(string $username)
  {
    if (!$username) {
      echo "ログインセッションの設定に失敗しました";
      return;
    }
    $_SESSION['username'] = $username;
  }

  public static function unsetLoginSession()
  {
    setcookie(session_name(), '', 1);
    session_destroy();
  }

  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
