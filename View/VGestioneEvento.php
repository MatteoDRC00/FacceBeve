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
     * Metodo richiamato quando un Proprietario crea un evento.
     * @throws SmartyException
     */
    public function showFormCreaEvento($id_locale)
    {
        $pm = FPersistentManager::getInstance();
        $locale = $pm->load("id", $id_locale, "FLocale");
        $this->smarty->assign('locale', $locale[0]);
        $this->smarty->display('registrazioneEvento.tpl');
    }

    public function showFormModificaEvento($evento)
    {
        $this->smarty->assign('evento', $evento[0]);
        $this->smarty->display('gestioneEvento.tpl');
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
        if (($_POST['dataEvento'] != null)){
            $value1 = explode("-",$_POST['dataEvento']);
            $value = $value1[2]."/".$value1[1]."/".$value1[0];
        }
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
        $size = $_FILES['img_evento']['size'];
        $arrayImg = array($nome, $size, $type, file_get_contents($file));
        return $arrayImg;
    }


}