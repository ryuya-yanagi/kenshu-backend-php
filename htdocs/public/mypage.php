<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\Adapter\Controllers\UserController;
use App\Adapter\Repositories\UserRepository;
use App\External\Session\LoginSessionManager;
use App\Usecase\UserInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">マイページ</h1>
    <?php if (isset($user)) : ?>
      <h2><?= $user->name ?></h2>
      <hr />
      <ul class="article-list d-flex justify-content-around flex-wrap">
        <?php if ($user->articles[0]["title"]) : ?>
          <?php foreach ($user->articles as $article) : ?>
            <li class="article-list__item card">
              <a href="/articles/<?= $article["article_id"] ?>">
                <div class="card-header text-center">
                  <?php if (isset($article["thumbnail_url"])) : ?>
                    <img src="<?= $article["thumbnail_url"] ?>" alt="<?= $article["title"] ?>" height="100px" />
                  <?php else : ?>
                    <img src="/assets/img/thumbnail_default.png" alt="<?= $article["title"] ?>" height="100px" />
                  <?php endif; ?>
                </div>
              </a>
              <div class="card-body">
                <h3 style="font-size: 1.4rem;"><?= $article["title"] ?></h3>
              </div>
              <div class="card-footer d-flex justify-content-around">
                <a href="/articles/<?= $article["article_id"] ?>">詳細</a>
                <a href="/articles/<?= $article["article_id"] ?>/edit">編集</a>
                <a href="/articles/<?= $article["article_id"] ?>/delete">削除</a>
              </div>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
    <?php if (isset($exception)) : ?>
      <p class="error__message">現在、ログインしているユーザーの情報は見つかりませんでした</p>
    <?php endif; ?>

  </main>

</body>

</html>