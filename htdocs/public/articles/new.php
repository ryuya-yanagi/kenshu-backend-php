<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Repositories\ArticleRepository;
use App\Adapter\Repositories\PhotoRepository;
use App\Adapter\Uploaders\PhotoUploader;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\Usecase\ArticleInteractor;
use App\Entity\Errors\ValidationException;
use App\External\Session\LoginSessionManager;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST['post'])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo), new PhotoRepository($pdo), new PhotoUploader));

  try {
    $articleController->post($_SESSION['user_id'], $_POST, $_FILES["photos"]);
  } catch (ValidationException $e) {
    $validationError = $e->getArrayMessage();
  } catch (Exception $e) {
    $exception = $e;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>記事 | 新規</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 新規</h1>
    <?php if (isset($exception)) : ?>
      <p class="text-danger">?= $exception->getMessage() ?></p>
    <?php else : ?>
      <form action="new" method="POST" enctype="multipart/form-data">
        <div class="mb-5">
          <label for="title" class="form-label">タイトル</label>
          <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp">
          <?php if (isset($validationError["title"])) : ?>
            <p id="titleHelp" class="form-text text-danger"> <?= $validationError["title"] ?></p>
          <?php else : ?>
            <div id="titleHelp" class="form-text">1~30文字の間で入力してください（必須項目）</div>
          <?php endif; ?>
        </div>
        <div class="mb-5">
          <label for="photos" class="form-label">画像（複数選択可）</label>
          <input type="file" class="form-control" name="photos[]" id="photos" accept="image/*" multiple>
          <?php if (isset($validationError["image"])) : ?>
            <p class="form-text text-danger"><?= $validationError["image"] ?></p>
          <?php endif; ?>
        </div>
        <div class="mb-5">
          <label for="body" class="form-label">本文</label>
          <textarea name="body" id="body" class="form-control" rows="7" cols="33" aria-describedby="bodyHelp"></textarea>
          <?php if (isset($validationError["body"])) : ?>
            <p id="bodyHelp" class="form_text text-danger"><?= $validationError["body"] ?></p>
          <?php else : ?>
            <p id="bodyHelp" class="form-text">1~200文字の間で入力してください（必須項目）</p>
          <?php endif; ?>
        </div>
        <input type="hidden" name="token" value="<?= $csrftoken ?>">
        <input type="submit" name="post" class="submit" value="投稿">
      </form>
    <?php endif ?>
  </main>
</body>

</html>