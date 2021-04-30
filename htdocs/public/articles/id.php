<?php

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Presentators\ArticlePresentator;
use App\Adapter\Repositories\ArticleRepository;
use App\Usecase\ArticleInteractor;

session_start();

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use function App\External\Database\Connection;

$pdo = Connection();
$articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo)));

try {
  $article = $articleController->show($_SERVER['REQUEST_URI']);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Article Detail</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>記事詳細</h1>
    <?php
    if (isset($article)) {
      ArticlePresentator::viewArticle($article);
    }

    if (isset($notFoundException)) {
      ArticlePresentator::viewNotFound();
    } elseif (isset($exception)) {
      ArticlePresentator::viewException($exception);
    }
    ?>
  </main>
</body>

</html>