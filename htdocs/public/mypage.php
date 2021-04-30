<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Repositories\UserRepository;
use App\External\Session\LoginSessionManagement;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

$loginSessionManager = new LoginSessionManagement();
$loginSessionManager->requireLoginedSession();

$pdo = Connection();
$userController = new UserController(new UserInteractor(new UserRepository($pdo)));

try {
  $user = $userController->show($_SESSION["user_id"]);
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Mypage</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../view/components/Header.php') ?>
  <main class="container">
    <h1>MyPage</h1>
    <?php if (isset($user)) : ?>
      <h2 style="margin-top: 20px;"><?= $user->name ?></h2>
      <ul>
        <?php foreach ($user->articles as $article) : ?>
          <li style="margin-top: 20px;">
            <?php if ($article["thumbnail_url"]) : ?>
              <img src="<?= $article["thumbnail_url"] ?>" alt="thumbnail" height="100px" />
            <?php endif; ?>
            <p><?= $article["title"] ?></p>
            <a href="/articles/<?= $article["article_id"] ?>">詳細</a>
            <a href="/articles/<?= $article["article_id"] ?>/edit">編集</a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <?php if (isset($exception)) : ?>
      <p class="error__message">現在、ログインしているユーザーの情報は見つかりませんでした</p>
    <?php endif; ?>

  </main>

</body>

</html>