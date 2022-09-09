<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';

/*
$controller = new CFrontController();

//$path = $_SERVER['REQUEST_URI'];
$path = "/";

$controller->run($path);*/
$c = CRicerca::getInstance();
$c->mostraHome();

