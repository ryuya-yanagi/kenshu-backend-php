<?php

use App\Adapter\Controllers\TagController;
use App\Adapter\Repositories\TagRepository;
use App\Usecase\TagInteractor;

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use function App\External\Database\Connection;

session_start();

$pdo = Connection();
$tagController = new TagController(new TagInteractor(new TagRepository($pdo)));
$tagList = $tagController->index();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>タグ | 一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include("../../view/components/Header.php") ?>
  <main class="container">
    <h1 class="title">タグ | 一覧</h1>
    <ul class="list-group list-group-flush">
      <?php foreach ($tagList as $tag) : ?>
        <li class="list-group-item"><a href="/tags/<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
      <?php endforeach; ?>
    </ul>
  </main>
</body>

</html>