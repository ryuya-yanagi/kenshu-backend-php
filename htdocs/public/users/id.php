<?php
session_start();

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\UserController;
use App\Adapter\Presentators\UserPresentator;
use App\Adapter\Repositories\UserRepository;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

$pdo = Connection();
$userController = new UserController(new UserInteractor(new UserRepository($pdo)));

try {
  $user = $userController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>User Detail</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>ユーザー詳細</h1>
    <?php
    if (isset($user)) {
      UserPresentator::viewUser($user);
    }

    if (isset($notFoundException)) {
      UserPresentator::viewNotFound();
    } elseif (isset($exception)) {
      UserPresentator::viewException($exception);
    }
    ?>
  </main>
</body>

</html>