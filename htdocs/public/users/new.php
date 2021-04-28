<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Presentators\UserPresentator;
use App\Adapter\Repositories\UserRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManagement;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

LoginSessionManagement::requireUnloginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST['signup'])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $userController = new UserController(new UserInteractor(new UserRepository($pdo)), new UserPresentator());
  $userController->post($_POST);
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
    <h1>Signup Form</h1>
    <form action="new.php" method="POST">
      <label for="name">名前：</label><input type="text" name="name" id="name"><br />
      <label for="password">パスワード：</label><input type="password" name="password" id="password"><br />
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="signup" value="登録">
    </form>
  </main>
</body>

</html>