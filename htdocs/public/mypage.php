<?php
require_once dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\External\Session\LoginSessionManagement;

$loginSessionManager = new LoginSessionManagement();
$loginSessionManager->requireLoginedSession();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Users</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
  <h1>ようこそ、<?= $loginSessionManager->h($_SESSION['username']) ?></h1>
</body>

</html>