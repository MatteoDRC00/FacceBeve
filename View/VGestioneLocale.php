<?php

/**
 * La classe VGestioneLocale si occupa dell'input-output per operazioni relative ad un locale
 * @author Gruppo8
 * @package View
 */
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
   * Funzione utilizzata per mostrare il from nel quale inserire i dati per la creazione di un locale
   * @param $categorie categorie disponibili per locali
   */
    public function showFormCreaLocale($categorie){
        $this->smarty->assign('categorie', $categorie);
        $this->smarty->display('registrazioneLocale.tpl');
    }

    /**
     * Funzione utilizzata per mostrare il from nel quale inserire i dati per la creazione di un locale
     * @param $categorie categorie disponibili per locali
     * @param $locale che si sta modificando
     * @param $eventi eventi organizzati dal locale
     * @param $immagini img del locale
     */
    public function showFormModificaLocale($locale, $categorie, $eventi, $immagini){
        $this->smarty->assign('locale', $locale);
        $this->smarty->assign('categorie', $categorie);
        $this->smarty->assign('eventi', $eventi);
        $this->smarty->assign('immagini', $immagini);
        $this->smarty->display('gestioneLocale.tpl');
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
            $value = (int) $_POST['CAPLocale'];
        return $value;
    }

    /**
     * Restituisce l''orario di apertura del locale'
     */
    public function getOrarioApertura(){
        return $_POST["orarioapertura"];
    }

    /**
     * Restituisce l''orario di chiusura del locale'
     */
    public function getOrarioChiusura(){
        return $_POST["orariochiusura"];
    }

    /**
     * Restituisce il valore di "Chiuso" per vedere se il locale quel girono è chiuso o meno'
     */
    public function getOrarioClose(){
        return $_POST["close"];
    }


    /**
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getImgLocale(): array
    {
        if($_FILES['img_locale']['type'] == "" || $_FILES['img_locale']['name'] == "" || $_FILES['img_locale']['tmp_name'] == "" || $_FILES['img_locale']['size'] == ""){
            $arrayImg = array();
        }else{
            $type = $_FILES['img_locale']['type'];
            $nome = $_FILES['img_locale']['name'];
            $file = $_FILES['img_locale']['tmp_name'];
            $size = $_FILES['img_locale']['size'];
            $arrayImg = array($nome, $size, $type, file_get_contents($file));
        }
        return $arrayImg;
    }

}