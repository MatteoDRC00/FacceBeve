<?php

class VRicerca
{
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct (){
        $this->smarty = StartSmarty::configuration();
    }

    public function preferiti(){
        $value = null;
        if (isset($_POST['pref']))
            $value = $_POST['pref'];
        return $value;
    }

    /**
     * Restituisce (se immesso) il valore del campo nome locale
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public static function getNomeLocale(): ?string
    {
        $value = null;
        $sessione = new USession();
        if($sessione->isLogged()){
            if (isset($_POST['nomeLocale1']))
                $value = $_POST['nomeLocale1'];
        }else{
            if (isset($_POST['nomeLocale']))
                $value = $_POST['nomeLocale'];
        }
        return $value;
    }

    /**
     * Restituisce (se immesso) il valore del campo nome evento
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getNomeEvento(): ?string
    {
        $value = null;
        if (isset($_POST['nomeEvento']))
            $value = $_POST['nomeEvento'];
        return $value;
    }

    /**
     * Restituisce (se immesso) il valore del campo data di un evento
     * Inviato con metodo post
     * @return string|null contenente il valore inserito dall'utente
     */
    public function getDataEvento(): ?string
    {
        $value = null;
        if (isset($_POST['dataEvento']))
            $value = $_POST['dataEvento'];
        return $value;
    }

    /**
     * Restituisce (se immesso) il valore del campo città/luogo
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getCitta(): ?string
    {
        $value = null;
        $sessione = new USession();
        if($sessione->isLogged()){
            if (isset($_POST['citta1']))
                $value = $_POST['citta1'];
        }else{
            if (isset($_POST['citta']))
                $value = $_POST['citta'];
        }
        return $value;
    }


    /**
     * Restituisce (se immesso) il valore del campo categoria di un locale
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getCategorie(): ?string
    {
        $value = null;
        $sessione = new USession();
        if($sessione->isLogged()){
            if (isset($_POST['categorie1']))
                $value = $_POST['categorie1'];
        }else{
            if (isset($_POST['categorie']))
                $value = $_POST['categorie'];
        }
        return $value;
    }

    /**
     * Restituisce il tipo di ricerca che si vuole effettuare (Locale/Evento)
     * Inviato con metodo post
     * @return string
     */
    public function getTipoRicerca(): ?string
    {
        $value = null;
        $sessione = new USession();
        if($sessione->isLogged()){
            if (isset($_POST['tipo']))
                $value = $_POST['tipo'];
        }else{
            $value = "Locali";
        }
        return $value;
    }

    /**
     * Mostra i risultati del filtraggio della ricerca.
     * @param $result contiene i risultati ottenuti dal database
     * @param $tipo definisce il tipo di ricerca effettuata (Locali/Eventi)
     * @throws SmartyException
     */
    public function showResult($result, $tipo,$nomelocale,$citta, $eventoCat, $data){
        $sessione = new USession();
        if($sessione->isLogged())
            $this->smarty->assign('userlogged',"loggato");

        if(isset($result)){
            $this->smarty->assign('array', $result);
        }else{
            $this->smarty->assign('array', "vuoto");
        }

        $this->smarty->assign('tipo', $tipo);
        if($tipo == "Locali"){
            $this->smarty->assign('nomeLocale', $nomelocale);
            $this->smarty->assign('citta', $citta);
            $this->smarty->assign('categorie', $eventoCat);
        }else{
            $this->smarty->assign('nomeLocale', $nomelocale);
            $this->smarty->assign('citta', $citta);
            $this->smarty->assign('nomeEvento', $eventoCat);
            $this->smarty->assign('dataEvento', $data);
        }
        $this->smarty->display('risultatiRicerca.tpl');
    }


    public function mostraHome($tipo, $genere_cat, $locali){
        $this->smarty->assign('tipo',$tipo);
        $this->smarty->assign('genere_cat',$genere_cat);
        $this->smarty->assign('locali',$locali);

        $this->smarty->display('home.tpl');
    }


    /**
     * Mostra la pagina contenente i dettagli del locale selezionato
     * @param array contiene l'id dell'array da visualizzare
     * @throws SmartyException
     */
    public function dettagliLocale($result,$arrayRecensioni,$arrayRisposte,$valutazioneLocale,$proprietario) {
        $sessione = new USession();
        //Caricamento immagini del locale
        /*if (is_array($result->getImmagini())) {
            foreach ($result->getImmagini() as $item) {
                //Per la trasmissione via HTTP bisogna elaborare le img con base64
                $pic64locale[] = base64_encode($item->getImmagine());
            }

        }
        elseif ($result->getImmagini() !== null) {
            $pic64locale = base64_encode($result->getImmagini()->getImmagine());
        }
        $this->smarty->assign('pic64locale', $pic64locale);*/

        //Se l'utente è registrato può vedere gli eventi organizzati dal locale
       /* if ($sessione->leggi_valore('utente')){
         $eventi = array();
             if (is_array($result->getEventi())) {
                 foreach ($result->getEventi() as $evento) {
                     $pic64evento = base64_encode($evento->getImg()->getImmagine());
                     $evento->getImg()->setImg(base64_encode($pic64evento));
                     $eventi[] = $evento;
                 }
                 $this->smarty->assign('eventi', $eventi);
             }elseif ($result->getEventi() !== null) {
                 $pic64evento = base64_encode($result->getEventi()->getImg()->getImmagine());
                 $result->getEventi()->getImg()->setImg(base64_encode($pic64evento));
                 $eventi = $result->getEventi();
             }
            $this->smarty->assign('eventi', $eventi);
       }*/
        $nrece = count($arrayRecensioni);
        $this->smarty->assign('arrayRecensioni', $arrayRecensioni);
        $this->smarty->assign('nrece', $nrece);
        $this->smarty->assign('arrayRisposte', $arrayRisposte);
        $this->smarty->assign('valutazioneLocale', $valutazioneLocale);
        $this->smarty->assign('proprietario', $proprietario);

        if($sessione->leggi_valore('utente'))
            $this->smarty->assign('userlogged',"loggato"); //Potrà cosi visualizzare gli eventi
        else
            $this->smarty->assign('userlogged',"nouser");

        $this->register_object("locale",$result);
        $this->smarty->assign_by_refsign('locale', $result);
        $this->smarty->display('InfoLocale.tpl');
    }

    //Dubbio
    /**
     * Funzione di supporto per gestire le immagini presenti nell'elenco delle recensioni ||  GestioneLocali
     * @param $imgrec elenco di immagini degli utenti presenti nelle recensioni
     * @return array
     */
    public function SetImageRecensione ($imgrec) {
        $type = null;
        $pic64 = null;
        if (is_array($imgrec)) {
            foreach ($imgrec as $item) {
                if (isset($item)) {
                    $pic64[] = base64_encode($item->getImmagine());
                    $type[] = $item->getType();
                } else {
                    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
                    $pic64[] = base64_encode($data);
                    $type[] = "image/png";
                }
            }
        }
        elseif (isset($imgrec)) {
            $pic64 = base64_encode($imgrec->getData());
            $type = $imgrec->getType();
        }
        return array($type, $pic64);
    }

}