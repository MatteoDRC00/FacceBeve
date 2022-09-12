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
    public function getNomeLocale(): ?string
    {
        $value = null;
        if (isset($_POST['nomeLocale']))
            $value = $_POST['nomeLocale'];
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
        if (isset($_POST['citta']))
            $value = $_POST['citta'];
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
        if (isset($_POST['categorie']))
            $value = $_POST['categorie'];
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
        if (isset($_POST['ricerca']))
            $value = $_POST['ricerca'];
        return $value;
    }

    /**
     * Mostra i risultati del filtraggio della ricerca.
     * @param $result contiene i risultati ottenuti dal database
     * @param $tipo definisce il tipo di ricerca effettuata (Locali/Eventi)
     * @throws SmartyException
     */
    public function showResult($result, $tipo){
       /** $sessione = new USession();
        if($sessione->leggi_valore('utente'))
            $this->smarty->assign('userlogged',"loggato");*/

        $this->smarty->assign('array', $result);
        $this->smarty->assign('tipo', $tipo);
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
    public function dettagliLocale($result,$arrayRecensioni,$votoMedio) {
        $sessione = USession::getInstance();
        //Caricamento immagini del locale
        if (is_array($result->getImmagini())) {
            foreach ($result->getImmagini() as $item) {
                //Per la trasmissione via HTTP bisogna elaborare le img con base64
                $pic64locale[] = base64_encode($item->getImmagine());
            }

        }
        elseif ($result->getImmagini() !== null) {
            $pic64locale = base64_encode($result->getImmagini()->getImmagine());
        }
        $this->smarty->assign('pic64locale', $pic64locale);

        //Se l'utente è registrato può vedere gli eventi organizzati dal locale
        if ($sessione->leggi_valore('utente')){
         $eventi = array();
           if (is_array($result->getEventi())) {
               foreach ($result->getEventi() as $evento) {
                   /**if (is_array($evento->getImmagini())) {
                       $pic64evento=array();
                       foreach ($evento->getImmagini() as $itemE) {
                           $pic64evento[] = base64_encode($itemE->getImmagine()); //Non capisco perchè non funziona come sopra
                       }
                   }
                   $eventi.array_push($evento,$pic64evento); //eventi = evento + le sue foto per ogni evento del locale
                  */
                   $pic64evento = base64_encode($evento->getImmagine()); //Non capisco perchè non funziona come sopra
                   $eventi.array_push($evento,$pic64evento);
               }
               $this->smarty->assign('eventi', $eventi);
           }
           elseif ($result->getEventi() !== null) {
               $pic64evento = base64_encode($result->getEventi()->getImmagine());
               $eventi.array_push($result->getEventi(),$pic64evento);
               $this->smarty->assign('eventi', $eventi);
           }
       }
        $this->smarty->assign('arrayRecensioni', $arrayRecensioni);
        $this->smarty->assign('valutazioneLocale', $votoMedio);
        // list($type,$pic64) = VUtente::setImage($img_utente, 'user');

        //Non so

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