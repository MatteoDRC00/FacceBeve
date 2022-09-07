<?php

require_once 'utility/autoload.php';
require_once 'StartSmarty.php';

$utente = new EUtente("123","drking","ut1","USER2","utente1@mail.it");

$id = FUtente::store($utente);

print $id;