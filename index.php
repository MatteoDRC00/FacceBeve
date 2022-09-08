<?php

require_once 'utility/autoload.php';
require_once 'StartSmarty.php';

$controller = new CFrontController();
$controller->run($_SERVER['REQUEST_URI']);

print $_SERVER['REQUEST_URI'];