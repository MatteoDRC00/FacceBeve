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
     * Metodo richiamato quando un Proprietario crea un locale.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi dell'evento
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @throws SmartyException
     */
    public function showFormCreation($utente,$error)
    {
            switch ($error) {
                case "type" :
                    $this->smarty->assign('errorType', "errore");
                    break;
                case "size" :
                    $this->smarty->assign('errorSize', "errore");
                    break;
            }
            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('infoLocale.tpl'); //?
    }


    /**
     * Metodo richiamato quando un Proprietario crea un locale.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @param $locale
     * @throws SmartyException
     */
    public function showFormModify($error,$evento) //Poi vedo Id
    {

            switch ($error) {
                case "type" :
                    $this->smarty->assign('errorType', "errore");
                    break;
                case "size" :
                    $this->smarty->assign('errorSize', "errore");
                    break;
            }
            if ($evento->getImg() != null) {
                $pic64 = base64_encode($evento->getImg());
            }
            else {
                $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/template/img/user.png');
                $pic64 = base64_encode($data);
            }
            $this->smarty->assign('pic64', $evento->getImg());
            $this->smarty->assign('nomeEvento', $evento->getNome());
            $this->smarty->assign('descrizioneEvento', $evento->getDescrizione());
            $this->smarty->assign('dataEvento', $evento->getData());

            $this->smarty->assign('userlogged', "loggato");
            $this->smarty->display('infoLocale.tpl'); //?
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
     * Restituisce l'id del locale che si vuole creare(Hidden)
     * Inviato con metodo post
     * @return int
     */
    public function getIdEvento(): ?int
    {
        $value = null;
        if (isset($_POST['IdEvento'])) //NON SO SE VANNO UTLIZZATI NOMI DIVERSI
            $value = $_POST['IdEvento'];
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