<?php

require_once 'utility/autoload.php';
require_once 'StartSmarty.php';

$utente = new EUtente("123","sfdgu","ut1","USER5","utente1@mail.it");
$utente->Iscrizione();

$id = FUtente::store($utente);

print $id;