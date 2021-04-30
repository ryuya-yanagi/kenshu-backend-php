<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\External\Session\LoginSessionManagement;

$loginSessionManager = new LoginSessionManagement();
$loginSessionManager->requireLoginedSession();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <title>Mypage</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../view/components/Header.php') ?>
  <main class="container">
    <h1>ようこそ、<?= $loginSessionManager->h($_SESSION['username']) ?></h1>
  </main>
</body>

</html>