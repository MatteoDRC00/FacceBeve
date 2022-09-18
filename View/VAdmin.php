<?php

/**
 * La classe VAdmin si occupa dell'input-output per la sezione privata dell'admin
 * @author Gruppo8
 * @package View
 */
class VAdmin
{
    private $smarty;
    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct ()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getEmail(){
        $value = null;
        if (isset($_POST['email']))
            $value = $_POST['email'];
        return $value;
    }

    //POI SCRIVI BENE
    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getGenere(){
        $value = null;
        if (isset($_POST['genere']))
            $value = $_POST['genere'];
        return $value;
    }

    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getDescrizione(){
        $value = null;
        if (isset($_POST['descrizione']))
            $value = $_POST['descrizione'];
        return $value;
    }

    /**
     * Restituisce la username dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getUsername(){
        $value = null;
        if (isset($_POST['username']))
            $value = $_POST['username'];
        return $value;
    }

    /**
     * Restituisce l'id della recensione da eliminare (proviene dal campo input hidden)
     * Inviato con metodo post
     * @return string contenente l'id della recensione
     */
    function getId(){
        $value = null;
        if (isset($_POST['valore']))
            $value = $_POST['valore'];
        return $value;
    }

    /**
     * Restituisce la parola immessa nella barra di ricerca
     * Inviato con metodo post
     * @return string contenente l'id della recensione
     */
    function getParola(){
        $value = null;
        if (isset($_POST['parola']))
            $value = $_POST['parola'];
        return $value;
    }


    /**
     * Funzione che permette di visualizzare la pagina home dell'admin (contenente tutti gli utenti della piattaforma),divisi in attivi e bannati.
     * @param $utentiAttivi array di utenti attivi
     * @param $utentiBannati array di utenti bannati
     * @param $categorie array di oggetti ECategoria --> categorie del sito
     * @throws SmartyException
     */
    public function HomeAdmin($utentiAttivi, $utentiBannati, $categorie, $recensioni) {

        $this->smarty->assign('categorie',$categorie);
        $this->smarty->assign('recensioni',$recensioni);
        $this->smarty->assign('utenti',$utentiAttivi);
        $this->smarty->assign('utentiBannati',$utentiBannati);
        $this->smarty->display('dashboardAdmin.tpl');
    }

     /**
     * Metodo richiamato quando l'Admin va a creare una nuova Categoria per il sito.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi del locale
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @throws SmartyException
     */
    public function showFormCategoria($utente,$error)
    {
            switch ($error) {
                case "wrongCategory":
                    $this->smarty->assign('errorType', $error);
                    break;
            }
            $this->smarty->display('pagina.tpl');
    }


}