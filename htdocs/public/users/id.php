<?php

use App\Adapter\Controllers\UserController;
use App\Adapter\Presentators\UserPresentator;
use App\Adapter\Repositories\UserRepository;
use App\Usecase\UserInteractor;

use function App\External\Connection;

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

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
  <?php
  $userController->show($_SERVER['REQUEST_URI']);
  ?>
</body>

</html>