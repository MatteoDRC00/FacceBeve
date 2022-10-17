<?php

/**
 * La classe VGestioneRecensione si occupa dell'input-output per la scrittura di risposte e recensioni
 * @author Gruppo8
 * @package View
 */
class VGestioneRecensione{
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
     * Restituisce la descrizione della recensione che si vuole scrivere
     * Inviato con metodo post
     * @return string
     */
    public function getDescrizione(): ?string
    {
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
    public function getDescrizioneRisposta(): ?string
    {
        $value = null;
        if (isset($_POST['descrizioneRisposta']))
            $value = $_POST['descrizioneRisposta'];
        return $value;
    }

    /**
     * Restituisce la descrizione della risposta ad una recensione
     * Inviato con metodo post
     * @return int
     */
    public function getIdLocale(): ?int
    {
        $value = null;
        if (isset($_POST['idLocale']))
            $value = $_POST['idLocale'];
        return $value;
    }

    /**
     * Restituisce il form nel quale è stata scritta la recensione
     * Inviato con metodo post
     * @return string
     */
    public function getFormRecensione(){
        $titolo = $_POST['titolo'];
        $valutazione = $_POST['valutazione'];
        $descrizione = $_POST['descrizione'];

        $value = array($titolo, $valutazione, $descrizione);
        return $value;
    }

}