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
     * Restituisce l'id del locale che si vuole creare(Hidden)
     * Inviato con metodo post
     * @return int
     */
    public function getIdLocale(): ?int
    {
        $value = null;
        if (isset($_POST['IdLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['IdLocale'];
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



    public function showFormCreaLocale($categorie){
        $this->smarty->assign('categorie', $categorie);
        $this->smarty->display('registrazioneLocale.tpl');
    }


    /**
     * Metodo richiamato quando un Proprietario crea un locale.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi del locale
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @param $locale
     * @throws SmartyException
     */
    public function showFormModify($error,$locale) //Poi vedo Id
    {
            switch ($error) {
                case "type" :
                    $this->smarty->assign('errorType', "errore");
                    break;
                case "size" :
                    $this->smarty->assign('errorSize', "errore");
                    break;
            }
            //Foto?
            $this->smarty->assign('nomeLocale', $locale->getNome());
            $this->smarty->assign('descrizione', $locale->getNome());
            $this->smarty->assign('numTelefono', $locale->getNumTelefono());

            $this->smarty->assign('indirizzo', $locale->getLocalizzazione()->getIndirizzo());
            $this->smarty->assign('numCivico', $locale->getLocalizzazione()->getNumCivico());
            $this->smarty->assign('numTelefono', $locale->getLocalizzazione()->getCitta());
            $this->smarty->assign('CAP', $locale->getLocalizzazione()->getCAP());
            $this->smarty->assign('Categorie', $locale->getCategoria());
            $this->smarty->assign('Orario', $locale->getOrario());

            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('infoLocale.tpl');
    }

    /**
     * Restituisce il numero di telefono del locale che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getNumTelefono(): ?string
    {
        $value = null;
        if (isset($_POST['numeroLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['numeroLocale'];
        return $value;
    }

    /**
     * Restituisce le categorie/attività correlate al locale che si vuole creare
     * Inviato con metodo post
     * @return array
     */
    public function getCategorie(): ?array
    {
        return $_POST['genereLocale'];
    }


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
        if (isset($_POST['civicoLocale'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['civicoLocale'];
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
     * Restituisce l'indirizzo del locale, inteso come il CAP
     * Inviato con metodo post
     * @return int
     */
    public function getCAP(): ?int
    {
        $value = null;
        if (isset($_POST['CAPLocale']))
            $value = $_POST['CAPLocale'];
        return $value;
    }


    public function getOrarioApertura(){
        return $_POST["orarioapertura"];
    }

    public function getOrarioChiusura(){
        return $_POST["orariochiusura"];
    }

    public function getOrarioClose(){
        return $_POST["close"];
    }

    /**
     * Preleva l'id del immagine del locale, caricata in un campo hidden e prelevata dal vettore $_POST
     * @return int|null
     */
    public function getIdImmagine(): ?int
    {
        $value = null;
        if (isset($_POST['idImg']))
            $value = $_POST['idImg'];
        return $value;
    }

    /**
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getImgLocale(): array
    {
        $type = $_FILES['img_locale']['type'];
        $nome = $_FILES['img_locale']['name'];
        $file = $_FILES['img_locale']['tmp_name'];
        $size = $_FILES['img_locale']['size'];
        $arrayImg = array($nome, $size, $type, file_get_contents($file));
        return $arrayImg;
    }

}