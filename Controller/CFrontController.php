<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';

/**
 * Classe utilizzata per il controllo dell'esecuzione delle richieste effettuate al server.
 * @package Controller
 */
class CFrontController
{

    public function run($path)
    {
        if ($path != '/FacceBeve/') {
            $resource = explode('/', $path);

            array_shift($resource);
		    array_shift($resource);

            $controller = "C" . $resource[0];
            $dir = 'Controller';
            $eledir = scandir($dir);

            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) {
                    $objController = $controller::getInstance();
                    $function = $resource[1];
                    if (method_exists($objController, $function)) {
                        if (isset($resource[2])) {
                          	$objController->$function(($resource[2]));
                        } else
                            $objController->$function();
                    } else {
                        $controller = CError::getInstance();
                        $controller->mostraPaginaErrore();
                    }
                } else {
                    $controller = CError::getInstance();
                    $controller->mostraPaginaErrore();
                }
            } else {
                $controller = CError::getInstance();
                $controller->mostraPaginaErrore();
            }
        } else {
            $controller = CRicerca::getInstance();
            $controller->mostraHome();
        }
    }

}
