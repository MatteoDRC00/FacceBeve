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
     * Restituisce (se immesso) il nome inserito dall'utente(utilizzato nei login/registrazione/modifica profilo)
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getNome(){
        $value = null;
        if (isset($_POST['nome']))
            $value = $_POST['nome'];
        return $value;
    }

    /**
     * Restituisce (se immesso) il cognome inserito dall'utente(utilizzato nei login/registrazione/modifica profilo)
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getCognome(){
        $value = null;
        if (isset($_POST['cognome']))
            $value = $_POST['cognome'];
        return $value;
    }

    /**
     * Restituisce (se immessa) la email inserita dall'utente(utilizzato nei login/registrazione/modifica profilo)
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getEmail(){
        $value = null;
        if (isset($_POST['email']))
            $value = $_POST['email'];
        return $value;
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

    public function getNewPassword(){
        $value = null;
        if (isset($_POST['newpassword']))
            $value = $_POST['newpassword'];
        return $value;
    }

    public function getImgProfilo(){
        $value = null;
        if (isset($_FILES['img_profilo']))
            $value = $_FILES['img_profilo'];
        return $value;
    }



    /**
     * Funzione che si occupa di gestire la visualizzazione della form di login
     * @throws SmartyException
     */
    public function showFormLogin(){
        if (isset($_POST['username']))
           $this->smarty->assign('username',$_POST['username']);
        $this->smarty->display('login.tpl');
    }

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
            $this->smarty->assign('tipo',$tipo);
        }
        $this->smarty->display('home.tpl');
    }

    public function showHome(){
        $this->smarty->display('home.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori in fase login
     * @throws SmartyException
     */
    public function loginError() {
        $this->smarty->assign('error',"errore"); //Utente inesistente
        $this->smarty->display('login.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo utente
     * @param $user informazioni sull' utente da visualizzare
     * @param $locali elenco di locali seguiti dall'utente
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function profileUtente($user,$locali,$img) {
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('array',$locali);
        $this->smarty->display('areaPersonaleUtente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo trasportatore
     * @param $user informazioni sull' utente da visualizzare
     * @param $ann elenco di annunci pubblicati dall'utente
     * @param $img immagine dell'utente
     * @param $locali elenco dei locali gestiti
     * @throws SmartyException
     * */

    public function profileProprietario($user,$img,$locali) {
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('array',$locali);
        $this->smarty->display('areaPersonaleProprietario.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del Utente
     * @throws SmartyException
     */
    public function registra_utente() {
        $this->smarty->display('RegistrazioneUtente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del Proprietario
     * @throws SmartyException
     */
    public function registra_proprietario() {
        $this->smarty->display('RegistrazioneProprietario.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per il trasportatore
     * @param $email tipo di errore derivante dall'email inserita
     * @param $mezzo tipo di errore derivante dall'immagine inserita
     * @param $error tipo di errore da visualizzare nella form
     * @throws SmartyException
     */
    public function registrazionePropError ($username, $error) {
        if ($username)
            $this->smarty->assign('errorUsername',"errore");
        switch ($error) {
            case "typeimg" :
                $this->smarty->assign('errorType',"errore");
                break;
            case "size" :
                $this->smarty->assign('errorSize',"errore");
                break;
        }
        $this->smarty->display('registrazioneProprietario.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per il cliente
     * @param $error tipo di errore da visualizzare
     * @throws SmartyException
     */
    public function registrazioneUtenteError ($error) {
        switch ($error) {
            case "email":
                $this->smarty->assign('errorUsername',"errore"); //Username già esistente
                break;
            case "typeimg" :
                $this->smarty->assign('errorType',"errore"); //Formato immagine non supportato
                break;
            case "size" :
                $this->smarty->assign('errorSize',"errore"); //Dimensione Immagine non supportata(troppo grande)
                break;
        }
        $this->smarty->display('registrazioneUtente.tpl');
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