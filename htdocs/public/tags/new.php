<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\TagController;
use App\Adapter\Repositories\TagRepository;
use App\Entity\Errors\ValidationException;
use App\External\Session\LoginSessionManager;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\Usecase\TagInteractor;

use function App\External\Database\Connection;

LoginSessionManager::requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST["submit"])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $tagController = new TagController(new TagInteractor(new TagRepository($pdo)));

  try {
    $tagController->post((object) $_POST);
  } catch (ValidationException $e) {
    $validationError = $e;
  } catch (Exception $e) {
    $exception = $e;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>タグ | 新規</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include("../../view/components/Header.php") ?>
  <main class="container">
    <h1 class="title">タグ | 新規</h1>
    <?php if (isset($exception)) : ?>
      <p class="text-danger"><?= $exception->getMessage() ?></p>
    <?php endif; ?>
    <form action="new" method="POST">
      <div class="mb-5">
        <label for="name" class="form-label">タグ名</label>
        <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
        <?php if (isset($validationError["name"])) : ?>
          <p id="nameHelp" class="form-text text-danger"><?= $validationError["name"] ?></p>
        <?php else : ?>
          <p id="nameHelp" class="form-text">入力必須項目</p>
        <?php endif; ?>
      </div>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="submit" class="submit" value="登録">
    </form>
  </main>
</body>

</html>