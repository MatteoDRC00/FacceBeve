<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';


$controller = new CFrontController();
$path = $_SERVER['REQUEST_URI'];
$controller->run($_SERVER['REQUEST_URI']);

/*
$p = new EProprietario("a","a","a@a","propr1","123");

$pm = FPersistentManager::getInstance();
$pm::store($p);*/


