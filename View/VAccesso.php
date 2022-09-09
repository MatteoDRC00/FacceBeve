<?php

require_once "Smarty/autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe utilizzata per la visualizzazione e il recupero delle informazioni dalle pagine relative all'accesso e alla registrazione degli utenti.
 * @package View
 */
class VAccesso
{

    /**
     * Funzione che si occupa di gestire la visualizzazione della homepage dopo il login, i.e.,
     * un utente registrato può adesso, se il login è andato bene, visualizzare gli eventi
     * @param $array elenco di eventi da visualizzare
     * @param $tipo tipo di utente che si è loggato, se Utente gli vengiono mostarti gli eventi a lui disponibili, se proprietario no.
     * @throws SmartyException
     */
    public function loginOk($array,$tipo) {
        $this->smarty->assign('userlogged',"loggato"); //Permette la ricerca di eventi
        if($tipo == "EUtente"){
            $this->smarty->assign('array', $array); //Visualizza eventi dei locali seguiti
        }
        $this->smarty->assign('tipo',$tipo);
        $this->smarty->display('home.tpl');
    }

    /**
     * Restituisce (se immesso) lo username inserito dall'utente(utilizzato nei login/registrazione/modifica profilo)
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getUsername(){
        $value = null;
        if (isset($_POST['username']))
            $value = $_POST['username'];
        return $value;
    }

    /**
     * Restituisce (se immesso) la password inserita dall'utente(utilizzato nei login/registrazione/modifica profilo)
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getPassword(){
        $value = null;
        if (isset($_POST['password']))
            $value = $_POST['password'];
        return $value;
    }



}