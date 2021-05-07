<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\Errors\NotFoundException;
use App\Adapter\Repositories\ArticleRepository;
use App\Entity\Errors\ValidationException;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManager;
use App\Usecase\ArticleInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

$pdo = Connection();
$articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo)));

if (!empty($_POST['update'])) {
  if (intval($_SESSION["user_id"]) !== intval($_POST["user_id"])) {
    return http_response_code(403);
  }

  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  try {
    $articleController->update((object) $_POST);
  } catch (ValidationException $e) {
    $validationError = $e->getArrayMessage();
  } catch (Exception $e) {
    $exception = $e;
  }
}

try {
  $article = $articleController->show(explode('/', $_SERVER['REQUEST_URI'])[2]);
  if ($_SESSION["user_id"] !== $article->user_id) {
    return http_response_code(403);
  }
} catch (NotFoundException $e) {
  $notFoundException = $e;
} catch (Exception $e) {
  $exception = $e;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 編集</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 編集</h1>
    <?php if (isset($notFoundException)) : ?>
      <?php include("../../view/errors/NotFound.php") ?>
    <?php elseif (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php else : ?>
      <form action="edit.php" method="POST" enctype="multipart/form-data">
        <div class="mb-5">
          <label for="title" class="form-label">タイトル</label>
          <input type="text" class="form-control" name="title" id="title" value="<?= $article->title ?>" aria-describedby="titleHelp">
          <?php if (isset($validationError["title"])) : ?>
            <p id="titleHelp" class="form-text text-danger"> <?= $validationError["title"] ?></p>
          <?php else : ?>
            <div id="titleHelp" class="form-text">1~30文字の間で入力してください（必須項目）</div>
          <?php endif; ?>
        </div>
        <div class="mb-5">
          <label for="photos" class="form-label">画像</label>
          <br />
          <?php foreach ($article->photos as $photo) : ?>
            <img src="<?= $photo ?>" alt="photo" height="100px" />
          <?php endforeach ?>
        </div>
        <div class="mb-5">
          <label for="body" class="form-label">本文</label>
          <textarea name="body" class="form-control" id="body" rows="7" cols="33"><?= $article->body ?></textarea>
          <?php if (isset($validationError["body"])) : ?>
            <p id="bodyHelp" class="form_text text-danger"><?= $validationError["body"] ?></p>
          <?php else : ?>
            <p id="bodyHelp" class="form-text">1~200文字の間で入力してください（必須項目）</p>
          <?php endif; ?>
        </div>
        <div class="mb-5">
          <ul class="d-flex flex-wrap">
            <?php foreach ($article->tags as $tag) : ?>
              <li class="mx-2">#<?= $tag ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <input type="hidden" name="id" value="<?= $article->id ?>">
        <input type="hidden" name="user_id" value="<?= $article->user_id ?>">
        <input type="hidden" name="thumbnail_id" value="<?= $article->thumbnail_id ?>">
        <input type="hidden" name="token" value="<?= $csrftoken ?>">
        <input type="submit" name="update" class="submit" value="更新">
      </form>
    <?php endif; ?>
  </main>
</body>

</html>