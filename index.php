<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';

/*
$controller = new CFrontController();
$path = $_SERVER['REQUEST_URI'];
$controller->run($_SERVER['REQUEST_URI']);*/

$c = new ECategoria("rock","bdcecbh");
$pm = FPersistentManager::getInstance();
$pm::store($c);

