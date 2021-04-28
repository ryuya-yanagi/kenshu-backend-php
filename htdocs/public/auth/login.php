<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\AuthController;
use App\Adapter\Presentators\AuthPresentator;
use App\Adapter\Repositories\AuthRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManagement;
use App\Usecase\AuthInteractor;

use function App\External\Database\Connection;

LoginSessionManagement::requireUnloginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST['login'])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $authController = new AuthController(new AuthInteractor(new AuthRepository($pdo)), new AuthPresentator());

  $result = $authController->login($_POST);

  if ($result) {
    session_regenerate_id(true);
    LoginSessionManagement::setLoginSession($result->name);
    header('Location: /mypage');
    exit;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Users</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>Login Form</h1>
    <form action="login.php" method="POST">
      <label for="name">名前：</label><input type="text" name="name" id="name"><br />
      <label for="password">パスワード：</label><input type="password" name="password" id="password"><br />
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="login" value="ログイン">
    </form>
  </main>
</body>

</html>