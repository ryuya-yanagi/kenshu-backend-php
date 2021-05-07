<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Controllers\TagController;
use App\Adapter\Repositories\ArticleRepository;
use App\Adapter\Repositories\ArticleTagRepository;
use App\Adapter\Repositories\PhotoRepository;
use App\Adapter\Repositories\TagRepository;
use App\Adapter\Uploaders\PhotoUploader;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\Usecase\ArticleInteractor;
use App\Entity\Errors\ValidationException;
use App\External\Session\LoginSessionManager;
use App\Usecase\TagInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$csrftoken = CsrfTokenManager::h(CsrfTokenManager::generateToken());

$pdo = connection();
$tagController = new TagController(new TagInteractor(new TagRepository($pdo)));
$tagList = $tagController->index();

if (isset($_POST['post'])) {
  if (!CsrfTokenManager::validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo), new PhotoRepository($pdo), new PhotoUploader, new ArticleTagRepository($pdo)));

  try {
    $articleController->post($_SESSION['user_id'], (object) $_POST, $_FILES["photos"]);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1 class="title">記事 | 新規</h1>
    <?php if (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
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
        <input type="file" class="form-control" name="photos[]" id="photos" accept="image/*" aria-describedby="photoHelp" multiple>
        <?php if (isset($validationError["image"])) : ?>
          <p id="photoHelp" class="form-text text-danger"><?= $validationError["image"] ?></p>
        <?php else : ?>
          <p id="photoHelp" class="form-text">cmdと同時にクリックすることで複数選択できます（任意項目）</p>
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
      <div class="mb-5">
        <label for="tag" class="form-label">タグ（複数選択可）</label>
        <select id="tag" class="form-select" name="tags[]" aria-describedby="tagHelp" multiple>
          <option value="">選択してください</option>
          <?php foreach ($tagList as $tag) : ?>
            <option value="<?= $tag["id"] ?>"><?= $tag["name"] ?></option>
          <?php endforeach; ?>
        </select>
        <p id="tagHelp" class="form-text">
          cmdと同時にクリックすることで複数選択できます（任意項目）<br />
          タグの新規作成は<a href="/tags/new">こちら</a>から可能です
        </p>
      </div>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="post" class="submit mb-5" value="投稿">
    </form>
  </main>
</body>

</html>