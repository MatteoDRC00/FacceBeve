<?php

/**
 * La classe VGestioneEvento si occupa dell'input-output per operazioni relative ad un evento
 * @author Gruppo8
 * @package View
 */
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
    public function showFormCreaEvento($locale)
    {
        $this->smarty->assign('locale', $locale);
        $this->smarty->display('registrazioneEvento.tpl');
    }

    public function showFormModificaEvento($evento)
    {
        $img = $evento->getImg();
        $this->smarty->assign('evento', $evento);
        $this->smarty->assign('img', $img);
        $this->smarty->display('gestioneEvento.tpl');
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
        if($_FILES['img_evento']['type'] == "" || $_FILES['img_evento']['name'] == "" || $_FILES['img_evento']['tmp_name'] == "" || $_FILES['img_evento']['size'] == ""){
            $arrayImg = array();
        }else{
            $type = $_FILES['img_evento']['type'];
            $nome = $_FILES['img_evento']['name'];
            $file = $_FILES['img_evento']['tmp_name'];
            $size = $_FILES['img_evento']['size'];
            $arrayImg = array($nome, $size, $type, file_get_contents($file));
        }
        return $arrayImg;
    }

}