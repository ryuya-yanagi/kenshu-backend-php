<?php

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Presentators\ArticlePresentator;
use App\Adapter\Repositories\ArticleRepository;
use App\Usecase\ArticleInteractor;

session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use function App\External\Database\Connection;

$pdo = Connection();
$articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo)));
$articles = $articleController->index();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Articles</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>記事一覧</h1>
    <?php ArticlePresentator::viewArticleList($articles) ?>
  </main>
</body>

</html>