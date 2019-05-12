<?php

require $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";

require VENDOR_DIR . "autoload.php";

$page = new \app\services\Router();
$page->runController();