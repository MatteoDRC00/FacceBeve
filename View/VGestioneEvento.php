<?php

class VGestioneEvento{

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





    /**
     * Restituisce il nome dell'evento che si vuole creare
     * Inviato con metodo post
     * @return string
     */
    public function getNomeEvento(): ?string
    {
        $value = null;
        if (isset($_POST['nomeEvento']))
            $value = $_POST['nomeEvento'];
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
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getImgEvento(): array
    {
        $type = $_FILES['img_evento']['type'];
        $nome = $_FILES['img_evento']['name'];
        $file = $_FILES['img_evento']['tmp_name'];
        $dimensione = $_FILES['img_evento']['size'];
        $arrayImg = array($nome,$type, $file, $dimensione);
        return $arrayImg;
    }


}