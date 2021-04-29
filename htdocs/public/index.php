<?php
session_start();
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
?>

<!DOCTYPE html>
<html>

<head>
  <title>Top</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <?php include('../view/components/Header.php') ?>
  <main class="container">
    <h1>Topページ</h1>
  </main>
</body>

</html>