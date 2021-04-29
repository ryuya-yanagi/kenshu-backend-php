<?php
session_start();
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\External\Session\LoginSessionManagement;

LoginSessionManagement::requireLoginedSession();
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
    <h1>新規投稿</h1>
  </main>
</body>

</html>