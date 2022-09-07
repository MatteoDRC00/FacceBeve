<?php

class VGestioneLocale{

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
     * Restituisce il nome del locale che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getNomeLocale(): ?string
    {
        $value = null;
        if (isset($_POST['nomeLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['nomeLocale'];
        return $value;
    }

    /**
     * Restituisce il nome dell'evento che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getNomeEvento(): ?string
    {
        $value = null;
        if (isset($_POST['nomeEvento'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['nomeEvento'];
        return $value;
    }

    /**
     * Restituisce la descrizione del locale che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getDescrizioneLocale(): ?string
    {
        $value = null;
        if (isset($_POST['descrizioneLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['descrizioneLocale'];
        return $value;
    }

    /**
     * Restituisce la descrizione dell'evento che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getDescrizioneEvento(): ?string
    {
        $value = null;
        if (isset($_POST['descrizioneEvento'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['descrizioneEvento'];
        return $value;
    }

    /**
     * Restituisce la descrizione dell'evento che si vuole creare
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getDataEvento(): ?string
    {
        $value = null;
        if (isset($_POST['dataEvento'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['dataEvento'];
        return $value;
    }


    /**
     *               DA MODIFICAREEE
     * Metodo richiamato quando un Proprietario crea un locale.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi del locale
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @throws SmartyException
     */
    public function showFormCreation($utente,$error)
    {
        if (($utente->getUsername() == "admin") || ($utente->getUsername() == "Admin")) {
            switch ($error) {
                case "type" :
                    $this->smarty->assign('errorType', "errore");
                    break;
                case "size" :
                    $this->smarty->assign('errorSize', "errore");
                    break;
            }
            $this->smarty->assign('nome', $utente->getName());
            $this->smarty->assign('cognome', $utente->getSurname());
            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('infoLocale.tpl');
        }
        elseif (get_class($utente) == "ECliente") {
            $this->smarty->assign('errorClas', $error);
            $this->smarty->assign('nome', $utente->getName());
            $this->smarty->assign('cognome', $utente->getSurname());
            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('infoLocale.tpl');
        }
    }

    /**
     * Restituisce il numero di telefono del locale che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getNumTelefono(): ?string
    {
        $value = null;
        if (isset($_POST['numTelefonoLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['numTelefonoLocale'];
        return $value;
    }

    /**
     * Restituisce le categorie/attività correlate al locale che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getCategoria(){
        $value = null;
        if (isset($_POST['categoriaLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['categoriaLocale'];
        return $value;
    }

    //RELATIVO ALLA LOCALIZZAZIONE, DA DISCUTERE

    /**
     * Restituisce l'indirizzo del locale, inteso come via/piazza ecc...
     * Inviato con metodo post
     * @return string
     */
    public function getIndirizzo(): ?string
    {
        $value = null;
        if (isset($_POST['indirizzoLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['indirizzoLocale'];
        return $value;
    }

    /**
     * Restituisce l'indirizzo del locale, inteso come numero civico
     * Inviato con metodo post
     * @return string
     */
    public function getNumeroCivico(): ?string
    {
        $value = null;
        if (isset($_POST['numeroCivicoLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['numeroCivicoLocale'];
        return $value;
    }

    /**
     * Restituisce l'indirizzo del locale, inteso come la città dove è situato
     * Inviato con metodo post
     * @return string
     */
    public function getCitta(): ?string
    {
        $value = null;
        if (isset($_POST['cittaLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['cittaLocale'];
        return $value;
    }

    /**
     * Restituisce l'indirizzo del locale, inteso come la nazione
     * Inviato con metodo post
     * @return string
     */
    public function getNazione(): ?string
    {
        $value = null;
        if (isset($_POST['nazioneLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['nazioneLocale'];
        return $value;
    }

    /**
     * Restituisce l'indirizzo del locale, inteso come il CAP
     * Inviato con metodo post
     * @return int
     */
    public function getCAP(): ?int
    {
        $value = null;
        if (isset($_POST['capLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['capLocale'];
        return $value;
    }

    //RELATIVO ALLA LOCALIZZAZIONE, DA DISCUTERE

    //Alla creazione non ha eventi organizzati

    public function getOrario(){
        $value = null;
        if (isset($_POST['Orario'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['Orario'];
        return $value;
    }

}