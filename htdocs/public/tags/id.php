<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Controllers\TagController;
use App\Adapter\Repositories\TagRepository;
use App\Usecase\TagInteractor;

use function App\External\Database\Connection;

session_start();

$pdo = Connection();
$tagController = new TagController(new TagInteractor(new TagRepository($pdo)));

try {
  $tag = $tagController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>タグ | 詳細</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include("../../view/components/Header.php") ?>
  <main class="container">
    <h1 class="title">タグ | 詳細</h1>
    <?php if (isset($tag)) : ?>
      <p>ID：<strong><?= $tag->id ?></strong></p>
      <p>タグ名：<strong><?= $tag->name ?></strong></p>
    <?php endif; ?>

    <?php if (isset($notFoundException)) : ?>
      <?php include("../../view/errors/NotFound.php") ?>
    <?php elseif (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
  </main>
</body>

</html>