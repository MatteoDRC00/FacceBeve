<?php

require_once "Smarty/libs/autoloader.php";
require_once "StartSmarty.php";

/**
 * Classe utilizzata per la visualizzazione e il recupero delle informazioni dalle pagine relative all'accesso e alla registrazione degli utenti.
 * @package View
 */
class VAccesso
{

    /**
     * Oggetto _Smarty_ per la compilazione e visualizzazione dei template.
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     * Costruttore di classe. Crea l'oggetto ed esegue la configurazione dell'attributo _$smarty_.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }


    //Metodi su Login\\
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
     * Funzione che si occupa di gestire la visualizzazione degli errori in fase login
     * @throws SmartyException
     */
    public function loginError() {
        $this->smarty->assign('error',"errore"); //Utente inesistente
        $this->smarty->display('login.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di login
     * @throws SmartyException
     */
    public function showFormLogin(){
        // if (isset($_POST['username']))
        //    $this->smarty->assign('username',$_POST['username']);
        $this->smarty->display('login.tpl');
    }
    //\\

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del Utente
     * @throws SmartyException
     */
    public function registra_utente() {
        $this->smarty->display('registrazioneUtente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del Proprietario
     * @throws SmartyException
     */
    public function registra_proprietario() {
        $this->smarty->display('registrazioneProprietario.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per il trasportatore
     * @param $error tipo di errore da visualizzare nella form
     * @throws SmartyException
     */
    public function registrazionePropError ($error) {
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


    //Metodi GET\\

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
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array|null
     */
    public function getImgProfilo() {
        $arrayImg = array();
        if(isset($_FILES['img_profilo'])){
            $type = $_FILES['img_profilo']['type'];
            $nome = $_FILES['img_profilo']['name'];
            $file = $_FILES['img_profilo']['tmp_name'];
            $size = $_FILES['img_profilo']['size'];
            $arrayImg = array($nome, $size, $type, $file);
        }
        return $arrayImg;
    }


    public function erroreLogin(){
        $this->smarty->assign('errore','Errore!Username ');
        $this->smarty->display('login.tpl');
    }


}