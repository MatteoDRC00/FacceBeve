<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';


$controller = new CFrontController();

//$path = $_SERVER['REQUEST_URI'];
$path = "Accesso/login";

$controller->run($path);

