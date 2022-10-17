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
    function getEmail(): ?string
    {
        $value = null;
        if (isset($_POST['email']))
            $value = $_POST['email'];
        return $value;
    }

    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getGenere(): ?string
    {
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
    function getDescrizione(): ?string
    {
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
    function getUsername(): ?string
    {
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
    function getId(): ?string
    {
        $value = null;
        if (isset($_POST['valore']))
            $value = $_POST['valore'];
        return $value;
    }

    /**
     * Funzione che permette di visualizzare la pagina home dell'admin (contenente tutti gli utenti della piattaforma),divisi in attivi e bannati.
     * @param $utentiAttivi array di utenti attivi
     * @param $utentiBannati array di utenti bannati
     * @param $categorie array di oggetti ECategoria --> categorie del sito
     * @param $proprietari array dei proprietari dei locali
     * @param $recensioni array delle recensioni segnalate
     * @throws SmartyException
     */
    public function HomeAdmin($utentiAttivi, $utentiBannati, $categorie, $recensioni, $proprietari) {

        $this->smarty->assign('categorie',$categorie);
        $this->smarty->assign('proprietari',$proprietari);
        $this->smarty->assign('recensioni',$recensioni);
        $this->smarty->assign('utentiAttivi',$utentiAttivi);
        $this->smarty->assign('utentiBannati',$utentiBannati);
        $this->smarty->display('dashboardAdmin.tpl');
    }

}