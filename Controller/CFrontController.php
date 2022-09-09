<?php

require_once 'autoload.php';
require_once 'StartSmarty.php';

class CFrontController{

    public function run ($path)
    {
        $resource = explode('/', $path);

        array_shift($resource);
        array_shift($resource);

        if($resource[0] != "index.php") {
            $controller = "C" . $resource[0];
            $dir = 'Controller';
            $eledir = scandir($dir);

            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) {
                    $objController = $controller::getInstance();
                    $function = $resource[1];
                    if (method_exists($objController, $function)) {
                        $objController->$function();
                    }
                }
            }
        }else{
            $controller = CRicerca::getInstance();
            $controller->mostraHome();
        }
    }




    /*public function run ($path)
    {
        if($path !='/'){
            //$sessione = new USession();

            //$method = $_SERVER['REQUEST_METHOD'];

            $resource = explode('/', $path); //Divide l'URL ricevuto in sezioni

            //Shift a sinistra, i.e. , rimuove la stringa http/https e il dominio?
            array_shift($resource);
            array_shift($resource);

            $controller = "C" . $resource[0];
            $dir = 'Controller';
            $eledir = scandir($dir); //Elenco dei Controller presenti

            //Se il controller richiesto è presente lo si esegue
            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) { //La function da eseguire, se esiste
                    $function = $resource[1];
                    if (method_exists($controller, $function)) { //Se la funzione per quel controller esiste allora si esegue

                        $param = array();
                        for ($i = 2; $i < count($resource); $i++) {
                            //Valore dei parametri per la funzione
                            $param[] = $resource[$i];
                            $a = $i - 2;
                        }
                        $num = (count($param)); //Parametri passati al metodo del controller
                        if ($num == 0) $controller::$function();
                        else if ($num == 1) $controller::$function($param[0]);
                        else if ($num == 2) $controller::$function($param[0], $param[1]);
                        //else if ($num == 3) $controller::$function($param[0], $param[1], $param[2]);
                        //else if ($num == 4) $controller::$function($param[0], $param[1], $param[2], $param[3]);
                        //else if ($num == 5) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4]);
                        //else if ($num == 6) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);

                    }
                    else {
                        //Se il metodo richiesto non è presente nel Controller cercato, l'applicazione rimanda alla homepage dei rispettivi tipi di utenti:
                        //Admin --> Sua homepage
                        //Proprietario/Utente --> la loro homepage con i rispettivi dettagli
                        //Utente non loggato --> homepage di default
                        if ($sessione->leggi_valore('utente')) {
                            $utente = unserialize($sessione->leggi_valore('utente'));
                            if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin"))
                                header('Location: /FacceBeve/Admin/homepage');
                            else {
                                //$smarty = StartSmarty::configuration();
                                CRicerca::Home($utente);
                            }
                        }
                        else {
                            //$smarty = StartSmarty::configuration();
                            CRicerca::Home();
                        }
                    }
                }
                else {
                    //Se il path inserito, nonostante il Controller richiesto sia presente, risulta essere incompleto, i.e., senza una funzione richiesta, allora l'applicazione rimanda alla homepage dei rispettivi tipi di utenti:
                    //Admin --> Sua homepage
                    //Proprietario/Utente --> la loro homepage con i rispettivi dettagli
                    //Utente non loggato --> homepage di default
                    if ($sessione->leggi_valore('utente')) {
                        $utente = unserialize($sessione->leggi_valore('utente'));
                        if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin"))
                            header('Location: /FacceBeve/Admin/homepage');
                        else {
                            //$smarty = StartSmarty::configuration();
                            CRicerca::Home($utente);
                        }
                    }
                    else {
                        //$smarty = StartSmarty::configuration();
                        CRicerca::Home();
                    }
                }
            }
            else {
                //Se il path è sbagliato, i.e., Controller non presente, l'applicazione rimanda alla pagina di errore 404, dalla quale si può poi tornare alla homepage
                $view = new VError();
                $view->error(4);
            }
        }
        else{
            $view = new VUtente();
            $view->showHome();
        }
    }*/
}
