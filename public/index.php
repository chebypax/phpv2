<?php

require $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";

require VENDOR_DIR . "autoload.php";
\app\services\Sessions::start();
$page = new \app\services\Router();
$page->runController();