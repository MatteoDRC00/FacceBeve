<?php

class CFrontController{
    public function run ($path)
    {

        $method = $_SERVER['REQUEST_METHOD'];

        $resource = explode('/', $path);

        array_shift($resource);
        array_shift($resource);

        if ($resource[0] != 'api') {

            $controller = "C" . $resource[0];
            $dir = 'Controller';
            $eledir = scandir($dir);

            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) {
                    $function = $resource[1];
                    if (method_exists($controller, $function)) {

                        $param = array();
                        for ($i = 2; $i < count($resource); $i++) {
                            $param[] = $resource[$i];
                            $a = $i - 2;
                        }
                        $num = (count($param));
                        if ($num == 0) $controller::$function();
                        else if ($num == 1) $controller::$function($param[0]);
                        else if ($num == 2) $controller::$function($param[0], $param[1]);
                        //else if ($num == 3) $controller::$function($param[0], $param[1], $param[2]);
                        //else if ($num == 4) $controller::$function($param[0], $param[1], $param[2], $param[3]);
                        //else if ($num == 5) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4]);
                        //else if ($num == 6) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);

                    }
                    else {
                        if (CUtente::isLogged()) {
                            $utente = unserialize($_SESSION['utente']);
                            if ($utente->getEmail() == 'admin@admin.com')
                                header('Location: /FillSpaceWEB/Admin/homepage');
                            else {
                                //$smarty = StartSmarty::configuration();
                                CRicerca::trasportiHome();
                            }
                        }
                        else {
                            //$smarty = StartSmarty::configuration();
                            CRicerca::trasportiHome();
                        }
                    }
                }
                else {
                    if (CUtente::isLogged()) {
                        $utente = unserialize($_SESSION['utente']);
                        if ($utente->getEmail() == 'admin@admin.com')
                            header('Location: /FillSpaceWEB/Admin/homepage');
                        else {
                            //$smarty = StartSmarty::configuration();
                            CRicerca::trasportiHome();
                        }
                    }
                    else {
                        //$smarty = StartSmarty::configuration();
                        CRicerca::trasportiHome();
                    }
                }
            }
            else {
                if (CUtente::isLogged()) {
                    $utente = unserialize($_SESSION['utente']);
                    if ($utente->getEmail() == 'admin@admin.com')
                        header('Location: /FillSpaceWEB/Admin/homepage');
                    else {
                        //$smarty = StartSmarty::configuration();
                        CRicerca::trasportiHome();
                    }
                }
                else {
                    //$smarty = StartSmarty::configuration();
                    CRicerca::trasportiHome();
                }
            }

        } // piattaforma mobile
        else {

            if ($resource[1] == 'annuncio'){
                $val = (int) $resource[2];
                CGestioneMobile::dettagliAnnuncio($val);
            }
            elseif ($resource[1] == 'ads'){
                array_shift($resource);
                array_shift($resource);
                CGestioneMobile::showAds($resource[0]);
            }

            elseif ($resource[1] == 'filtri'){
                $val = json_decode(file_get_contents('php://input'), true);
                print ("ciao");
                CGestioneMobile::filtra($val);

            }

            elseif ($resource[1] == 'login') {
                CGestioneMobile::loginToken();
            }

        }


    }
}
