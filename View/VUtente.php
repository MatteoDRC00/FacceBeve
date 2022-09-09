<?php

/**
 * Class VUtente si occupa di gestire l'input-output per le operazioni utente[sia Proprietaro che Utente semplice?]
 */
class VUtente
{
    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }





    /**
     * Funzione che si occupa del supporto per le immagini
     * @param $image immagine da analizzare
     * @param $tipo variabile che indirizza al tipo di file di default da settare nel caso in cui $image = null
     * @return array contenente informazioni sul tipo e i dati che costituiscono un immagine (possono essere anche degli array)
     */
    public function setImage($image, $tipo) {
        if (isset($image)) {
            $pic64 = base64_encode($image->getImmagine());
            $type = $image->getType();
        }
        elseif ($tipo == 'EUtente') {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/utente.png'); //Immagine generica per l'utente
            $pic64= base64_encode($data);
            $type = "image/png";
        }elseif ($tipo == 'EProprietario'){
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/proprietario.png'); //Immagine generica per il proprietario
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        elseif($tipo == 'ELocale') {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/locale.png'); //Immagine generica per il proprietario
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        return array($type, $pic64);
    }

    /**
     * Funzione di supporto per gestire le immagini presenti nell'elenco delle recensioni || DIEEERRECCCCI non so se va in Recensione o in GestioneLocali
     * @param $imgrec elenco di immagini degli utenti presenti nelle recensioni
     * @return array
     */
    public function SetImageRecensione ($imgrec) {
        $type = null;
        $pic64 = null;
        if (is_array($imgrec)) {
            foreach ($imgrec as $item) {
                if (isset($item)) {
                    $pic64[] = base64_encode($item->getImmagine());
                    $type[] = $item->getType();
                } else {
                    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
                    $pic64[] = base64_encode($data);
                    $type[] = "image/png";
                }
            }
        }
        elseif (isset($imgrec)) {
            $pic64 = base64_encode($imgrec->getData());
            $type = $imgrec->getType();
        }
        return array($type, $pic64);
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica del profilo di un Utente
     * @param $user informazioni sull'utente che desidera mdificare i suoi dati
     * @param $img immagine dell'utente
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException
     */
    public function formModificaUtente($user,$img,$error) {
        switch ($error) {
            case "errorEmail" :
                $this->smarty->assign('errorEmail', "errore");
                break;
            case "errorPassw":
                $this->smarty->assign('errorPassw', "errore");
                break;
            case "errorSize" :
                $this->smarty->assign('errorSize', "errore");
                break;
            case "errorType" :
                $this->smarty->assign('errorType', "errore");
                break;
        }
        if (isset($img)) {
            $pic64 = base64_encode($img->getImmagine());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('name',$user->getName());
        $this->smarty->display('areaPersonaleUtente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica del profilo di un Proprietario
     * @param $user informazioni sull'utente che desidera modificare i suoi dati
     * @param $img immagine del proprietario
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException
     */
    public function formModificaUProprietario($user,$img,$error) {
        switch ($error) {
            case "errorEmail" :
                $this->smarty->assign('errorEmail', "errore");
                break;
            case "errorPassw":
                $this->smarty->assign('errorPassw', "errore");
                break;
            case "errorSize" :
                $this->smarty->assign('errorSize', "errore");
                break;
            case "errorType" :
                $this->smarty->assign('errorType', "errore");
                break;
        }
        if (isset($img)) {
            $pic64 = base64_encode($img->getImmagine());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('name',$user->getName());
        $this->smarty->display('areaPersonaleProprietario.tpl');
    }


}