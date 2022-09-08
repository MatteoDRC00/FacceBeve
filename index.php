<?php

require_once 'utility\autoload.php';
require_once 'StartSmarty.php';

$controller = new CFrontController();

$path = $_SERVER['REQUEST_URI'];
$controller->run($path);