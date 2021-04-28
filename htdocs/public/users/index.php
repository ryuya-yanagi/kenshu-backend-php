<?php
session_start();

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Presentators\UserPresentator;
use App\Adapter\Repositories\UserRepository;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

$pdo = Connection();
$userController = new UserController(new UserInteractor(new UserRepository($pdo)), new UserPresentator());
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
    <h1>ユーザ一覧</h1>
    <?php
    $userController->index();
    ?>
  </main>
</body>

</html>