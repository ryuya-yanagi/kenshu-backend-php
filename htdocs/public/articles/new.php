<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\Adapter\Controllers\ArticleController;
use App\Adapter\Presentators\ArticlePresentator;
use App\Adapter\Repositories\ArticleRepository;
use App\External\Csrf\TokenManager as CsrfTokenManager;
use App\External\Session\LoginSessionManagement;
use App\Usecase\ArticleInteractor;
use App\Usecase\Errors\ValidationException;

use function App\External\Database\Connection;

LoginSessionManagement::requireLoginedSession();

$csrfTokenManager = new CsrfTokenManager();
$csrftoken = $csrfTokenManager->h($csrfTokenManager->generateToken());

if (isset($_POST['post'])) {
  if (!$csrfTokenManager->validateToken(filter_input(INPUT_POST, 'token'))) {
    return http_response_code(400);
  }

  $pdo = Connection();
  $articleController = new ArticleController(new ArticleInteractor(new ArticleRepository($pdo)));

  try {
    $articleController->post($_SESSION['user_id'], $_POST);
  } catch (ValidationException $e) {
    $validationException = $e;
  } catch (Exception $e) {
    $exception = $e;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Article New</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../../view/components/Header.php') ?>
  <main class="container">
    <h1>新規投稿</h1>
    <?php
    if (isset($validationException)) {
      ArticlePresentator::viewValidationException($validationException);
    } elseif (isset($exception)) {
      ArticlePresentator::viewException($exception);
    }
    ?>
    <form action="new.php" method="POST">
      <label for="title">タイトル：</label><input type="text" name="title" id="title"></br>
      <label for="body">本文：</label><textarea name="body" id="body"></textarea></br>
      <input type="hidden" name="token" value="<?= $csrftoken ?>">
      <input type="submit" name="post" value="投稿">
    </form>
  </main>
</body>

</html>