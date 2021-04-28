<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use App\External\Session\LoginSessionManagement;

LoginSessionManagement::requireLoginedSession();

LoginSessionManagement::unsetLoginSession();
header("Location: /");
