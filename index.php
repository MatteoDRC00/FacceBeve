<?php

require_once 'utility/autoload.php';
require_once 'StartSmarty.php';

$utente = new EUtente("123","utente1","ut1","USER1","utente1@mail.it");

$id = FUtente::store($utente);

print $id;