<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Presentators\ArticlePresentator;
use App\Adapter\Repositories\ArticleRepository;
use App\Adapter\Repositories\PhotoRepository;
use App\Adapter\Uploaders\PhotoUploader;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManagement;
use App\Usecase\ArticleInteractor;
use App\Entity\Errors\ValidationException;

use function App\External\Database\Connection;

LoginSessionManagement::requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST['post'])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo), new PhotoRepository($pdo), new PhotoUploader));

  try {
    $articleController->post($_SESSION['user_id'], $_POST, $_FILES);
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
  <title>Article New</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>新規投稿</h1>
    <?php
    if (isset($exception)) {
      ArticlePresentator::viewException($exception);
    }
    ?>
    <form action="new.php" method="POST" enctype="multipart/form-data">
      <div style="margin-top: 20px;">
        <label for="title">タイトル</label>
        <br />
        <input type="text" name="title" id="title"></br>
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
        <textarea name="body" id="body"></textarea>
      </div>
      <?php if (isset($validationError["body"])) : ?>
        <p class="error__message"><?= $validationError["body"] ?></p>
      <?php endif; ?>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="post" value="投稿">
    </form>
  </main>
</body>

</html>