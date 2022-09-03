<?php

class VRecensione{
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
     * Restituisce il titolo della recensione che si vuole scrivere
     * Inviato con metodo post
     * @return string
     */
    public function getTitolo(){
        $value = null;
        if (isset($_POST['titolo']))
            $value = $_POST['titolo'];
        return $value;
    }

    /**
     * Restituisce la data in cui la recensione viene scritta
     * Inviato con metodo post
     * @return DateTime|false|string
     */
    public function getDataScrittura()
    {
        $value = null;
        if (isset($_POST['titolo']) && isset($_POST['valutazione']))
            $value = date("d-m-Y");
        return $value;
    }

    /**
     * Restituisce il nome del locale che si vuole recensire
     * Inviato con metodo post
     * @return string
     */
    public function getNomeLocale(): ?string
    {
        //VEDI PRIMA COOKIE E SESSIONI
        $value = null;
        if (isset($_POST['nomeLocale']))
            $value = $_POST['nomeLocale'];
        return $value;
    }

    /**
     * Restituisce il nome del locale che si vuole recensire
     * Inviato con metodo post
     * @return string
     */
    public function getLocalizzazioneLocale(): ?string
    {
        //VEDI PRIMA COOKIE E SESSIONI
        $value = null;
        if (isset($_POST['localizzazione']))
            $value = $_POST['localizzazione'];
        return $value;
    }

    /**
     * Restituisce la valutazione della recensione che si vuole scrivere
     * Inviato con metodo post
     * @return string
     */
    public function getValutazione(){
        $value = null;
        if (isset($_POST['valutazione']))
            $value = $_POST['valutazione'];
        return $value;
    }

    /**
     * Restituisce la descrizione della recensione che si vuole scrivere
     * Inviato con metodo post
     * @return string
     */
    public function getDescrizione(){
        $value = null;
        if (isset($_POST['descrizione']))
            $value = $_POST['descrizione'];
        return $value;
    }

    /**
     * Restituisce la descrizione della risposta ad una recensione
     * Inviato con metodo post
     * @return string
     */
    public function getDescrizioneRisposta(){
        $value = null;
        if (isset($_POST['descrizioneRisposta']))
            $value = $_POST['descrizioneRisposta'];
        return $value;
    }

    /**
     * Metodo richiamato quando un utente scrive/crea una recensione.
     * In caso di errori nella compilazione dei campi della recensione, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente  utente che effettua l'inserimento dei dati nei campi della recensione
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di scrittura della recensione
     * @throws SmartyException
     */
    public function showFormPost($utente,$error)
    {
        //RICORDARSIDI PIAZZARE LO SCRIPT SMARTY PER ERRORCLASS ED ERROREMPTY
        if (get_class($utente) == "EUtente") {
             switch ($error) {
                case "wrong_class" :
                    $this->smarty->assign('errorClass', "errore");
                    break;
                case "vuoto" :
                    $this->smarty->assign('errorEmpty', "errore");
                    break;
            }
        }elseif(get_class($utente) == "EProprietario"){
            switch ($error) {
                case "wrong_class" :
                    $this->smarty->assign('errorClass', "errore");
                    break;
                case "vuoto" :
                    $this->smarty->assign('errorEmpty', "errore");
                    break;
            }
        }
        $this->smarty->assign('username', $utente->getUsername());
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->display('InfoLocale.tpl');
    }

}