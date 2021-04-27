<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Presentators\UserPresentator;
use App\Adapter\Repositories\UserRepository;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

if (isset($_POST['signup'])) {
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
  <h1>Signup Form</h1>
  <form action="new.php" method="POST">
    <label for="name">名前：</label><input type="text" name="name" id="name"><br />
    <label for="password">パスワード：</label><input type="password" name="password" id="password"><br />
    <input type="submit" name="signup" value="登録">
  </form>
</body>

</html>