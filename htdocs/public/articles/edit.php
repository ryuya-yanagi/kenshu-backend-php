<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Repositories\ArticleRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManagement;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

$loginSessionManager = new LoginSessionManagement();
$loginSessionManager->requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

$pdo = Connection();
$articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo)));

try {
  $article = $articleController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}

if ($_POST['update']) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Articles</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>記事の編集</h1>
    <form action="new.php" method="POST" enctype="multipart/form-data">
      <div style="margin-top: 20px;">
        <label for="title">タイトル</label>
        <br />
        <input type="text" name="title" id="title" value="<?= $article->title ?>"></br>
        <?php if (isset($validationError["title"])) : ?>
          <p class="error__message"><?= $validationError["title"] ?></p>
        <?php endif; ?>
      </div>
      <div style="margin-top: 20px;">
        <label for="photos">画像</label>
        <br />
        <input type="file" name="photos[]" id="photos" accept="image/*" multiple></br>
        <?php if (isset($validationError["image"])) : ?>
          <p class="error_message"><?= $validationError["image"] ?></p>
        <?php endif; ?>
      </div>
      <div style="margin-top: 20px;">
        <label for="body">本文</label>
        <br />
        <textarea name="body" id="body" rows="5" cols="33"><?= $article->body ?></textarea>
      </div>
      <?php if (isset($validationError["body"])) : ?>
        <p class="error__message"><?= $validationError["body"] ?></p>
      <?php endif; ?>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="post" value="更新">
    </form>
  </main>
</body>

</html>