<?php

/**
 * @method register_object(string $string, contiene $result)
 */
class VRicerca
{
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct (){
        $this->smarty = StartSmarty::configuration();
    }

    public function getPreferito(){
        $value = null;
        if (isset($_POST['pref']))
            $value = $_POST['pref'];
        return $value;
    }

    /**
     * Metodo che restituisce l'id' del locale selezionate nella pagina personale del utente/proprietario
     * @return int
     */
    public function getIdLocale(): int
    {
        return $_POST['idLocale'];
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
                if($_POST['categorie1'] == "--Scegli il tipo--")
                      $value = "";
                else
                      $value = $_POST['categorie1'];
        }else{
            if (isset($_POST['categorie']))
                if($_POST['categorie'] == "--Scegli il tipo--")
                     $value = "";
                else
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
            if (isset($_POST['checkLocale']))
                $value = "Locali";
            else
                $value = "Eventi";
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
    public function showResult($result, $tipo,$nomelocale,$citta, $eventoCat, $data,$localEventi){
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
            $this->smarty->assign('categoria', $eventoCat);
        }else{
            $this->smarty->assign('locali',$localEventi);
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
    public function dettagliLocale($tipo, $presente, $result,$arrayRecensioni,$arrayRisposte,$valutazioneLocale,$proprietario) {
        $sessione = new USession();
        //Se l'utente è registrato può vedere gli eventi organizzati dal locale
        if($result->getEventiOrganizzati() !== null){
            $this->smarty->assign('eventi', $result->getEventiOrganizzati());
        }
        if(isset($proprietario)){
            $this->smarty->assign('proprietario', $proprietario);
        }
        if(is_array($arrayRecensioni))
            $nrece = count($arrayRecensioni);
        elseif(isset($arrayRecensioni))
            $nrece = 1;
        else
            $nrece = 0;
        $this->smarty->assign('arrayRecensioni', $arrayRecensioni);
        $this->smarty->assign('nrece', $nrece);
        $this->smarty->assign('arrayRisposte', $arrayRisposte);
        $this->smarty->assign('valutazioneLocale', $valutazioneLocale);

        if($sessione->isLogged())
            $this->smarty->assign('userlogged',"loggato"); //Potrà cosi visualizzare gli eventi
        else
            $this->smarty->assign('userlogged',"nouser");

        $this->smarty->assign('utente', $sessione->leggi_valore('utente'));
        $this->smarty->assign('locale', $result);
        $this->smarty->assign('tipo', $tipo);
        $this->smarty->assign('presente', $presente);
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