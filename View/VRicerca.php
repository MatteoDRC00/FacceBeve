<?php

/**
 * @method register_object(string $string, contiene $result)
 */
/**
 * La classe VRicerca si occupa dell'input-output per la ricerca di eventi e locali
 * @author Gruppo8
 * @package View
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

    /**
     * Funzione che preleva il valore del pulsante "Aggiungi ai preferiti"
     */
    public function getPreferito(){
        $value = null;
        if (isset($_POST['pref']))
            $value = $_POST['pref'];
        return $value;
    }

    /**
     * Metodo che restituisce l'id' del locale selezionato nella pagina personale del utente/proprietario
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
     * Restituisce (se immesso) il valore del campo nome locale, quando si sta effettuando la ricerca degli eventi
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public static function getNomeLocaleEvento(): ?string
    {
        $value = null;
        if (isset($_POST['nomeLocaleEvento']))
                $value = $_POST['nomeLocaleEvento'];
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
        $return = null;
        if (($_POST['dataEvento'] != null)){
            $value = explode("-",$_POST['dataEvento']);
            $return = $value[2]."/".$value[1]."/".$value[0];
        }
        return $return;
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
            if(static::getTipoRicerca() == "Locali"){
                if (isset($_POST['citta1']))
                    $value = $_POST['citta1'];
            }else{
                if (isset($_POST['citta2']))
                    $value = $_POST['citta2'];
            }

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
    public static function getTipoRicerca(): ?string
    {
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
     * @param $nomelocale nome del locale cercato
     * @param $citta citta' in cui si svolge l'evento/ in cui si trova il locale
     * @param $eventoCat categoria locale/Nome evento
     * @param $data data in cui si svolge l'evento
     * @param $localEventi array utilizzato per accedere ai locali dagli eventi
     * @throws SmartyException
     */
    public function showResult($result, $tipo,$nomelocale,$citta, $eventoCat, $data, $localEventi){

        $this->smarty->assign('array', $result);

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

    /**
     * Funzione utilizzata per visualizzare la homepage del sito
     * @param $tipo tipo di ricerca
     * @param $categorie categorie dei locali
     * @param $eventiUtente eventi visibili all'utente(se connesso e se non è un proprietario)
     * @param $localiEventiUtente per accedere ai locali in cui si svolgono gli eventi visibili all'utente
     * @param $topLocali top4 locali sul sito
     * @param $valutazione valutazione dei top locali
    */
    public function mostraHome($tipo, $categorie, $topLocali, $valutazione, $eventiUtente, $localiEventiUtente){
        $this->smarty->assign('tipo',$tipo);
        $this->smarty->assign('categorie',$categorie);
        $this->smarty->assign('topLocali',$topLocali);
        $this->smarty->assign('valutazione',$valutazione);
        $this->smarty->assign('eventiUtente',$eventiUtente);
        $this->smarty->assign('localiEventiUtente',$localiEventiUtente);

        $this->smarty->display('home.tpl');
    }


    /**
     * Mostra la pagina contenente i dettagli del locale selezionato
     * @param $arrayRecensioni Recensioni del locale
     * @param $arrayRisposte Risposte del proprietario
     * @param $eventiOrganizzati eventi organizzati nella storia del locale
     * @param $proprietario bool per controlare che il profilo che sta visualizzando il locale è ilm proprietario oppure no
     * @param $result locale
     * @param $stato stato del utente collegato(attivo oppure bannato)
     * @param $utente username utente collegato
     * @param $presente utilizzato per verificare se il locale è stato aggiunto ai preferiti dall'utente
     * @param $valutazioneLocale valutazione del locale
     * @param $tipo tipo di utente collegato
     * @throws SmartyException
     */
    public function dettagliLocale($utente, $stato, $tipo, $presente, $result,$arrayRecensioni,$arrayRisposte,$valutazioneLocale,$proprietario,$eventiOrganizzati) {
        $sessione = new USession();
        //Se l'utente è registrato può vedere gli eventi organizzati dal locale
        $this->smarty->assign('eventi', $eventiOrganizzati);

        if(isset($proprietario)){
            $this->smarty->assign('proprietario', $proprietario);
        }
        $this->smarty->assign('arrayRecensioni', $arrayRecensioni);
        $this->smarty->assign('arrayRisposte', $arrayRisposte);
        $this->smarty->assign('valutazioneLocale', $valutazioneLocale);

        $this->smarty->assign('utente', $utente);
        $this->smarty->assign('locale', $result[0]);
        $this->smarty->assign('tipo', $tipo);
        $this->smarty->assign('stato', $stato);
        $this->smarty->assign('presente', $presente);
        $this->smarty->display('InfoLocale.tpl');
    }

}