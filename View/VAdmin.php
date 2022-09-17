<?php

/**
 * La classe VAdmin si occupa dell'input-output per la sezione privata dell'admin
 * @author Gruppo8
 * @package View
 */
class VAdmin
{
    private $smarty;
    /**
     * Funzione che inizializza e configura smarty.
     */
    function __construct ()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getEmail(){
        $value = null;
        if (isset($_POST['email']))
            $value = $_POST['email'];
        return $value;
    }

    //POI SCRIVI BENE
    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getGenere(){
        $value = null;
        if (isset($_POST['genere']))
            $value = $_POST['genere'];
        return $value;
    }

    /**
     * Restituisce l'email dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getDescrizione(){
        $value = null;
        if (isset($_POST['descrizione']))
            $value = $_POST['descrizione'];
        return $value;
    }

    /**
     * Restituisce la username dell'utente da bannare/riattivare dal campo hidden input
     * Inviato con metodo post
     * @return string contenente l'email dell'utente
     */
    function getUsername(){
        $value = null;
        if (isset($_POST['username']))
            $value = $_POST['username'];
        return $value;
    }

    /**
     * Restituisce l'id della recensione da eliminare (proviene dal campo input hidden)
     * Inviato con metodo post
     * @return string contenente l'id della recensione
     */
    function getId(){
        $value = null;
        if (isset($_POST['valore']))
            $value = $_POST['valore'];
        return $value;
    }

    /**
     * Restituisce la parola immessa nella barra di ricerca
     * Inviato con metodo post
     * @return string contenente l'id della recensione
     */
    function getParola(){
        $value = null;
        if (isset($_POST['parola']))
            $value = $_POST['parola'];
        return $value;
    }


    /**
     * Funzione che permette di visualizzare la pagina home dell'admin (contenente tutti gli utenti della piattaforma),divisi in attivi e bannati.
     * @param $utentiAttivi array di utenti attivi
     * @param $utentiBannati array di utenti bannati
     * @param $img_attivi array di immagini degli utenti attivi
     * @param $img_bann array di immagini degli utenti bannati
     * @param $categorie array di oggetti ECategoria --> categorie del sito
     * @throws SmartyException
     */
    public function HomeAdmin(array $utentiAttivi, $utentiBannati, $img_attivi, $img_bann, $categorie) {
        //Gestione immagini degli utenti attivi
        list($typeAttivi,$pic64att) = $this->SetImageRecensione($img_attivi);
        if ($typeAttivi == null && $pic64att == null)
            $this->smarty->assign('immagine', "no");
        if (isset($img_attivi)) {
            if (is_array($img_attivi)) {
                $this->smarty->assign('typeAttivi', $typeAttivi);
                $this->smarty->assign('pic64att', $pic64att);
                $this->smarty->assign('n_attivi', count($img_attivi) - 1);
            }
            else {
                $this->smarty->assign('typeA', $typeAttivi);
                $this->smarty->assign('pic64att', $pic64att);
            }
        }
        else
            $this->smarty->assign('n_attivi', 0);

        //Gestione immagini degli utenti bannati
        list($typeBannati,$pic64ban) = $this->SetImageRecensione($img_bann);
        if ($typeBannati == null && $pic64ban == null)
            $this->smarty->assign('immagine_1', "no");
        if (isset($img_bann)) {
            if (is_array($img_bann)) {
                $this->smarty->assign('typeBannati', $typeBannati);
                $this->smarty->assign('pic64ban', $pic64ban);
                $this->smarty->assign('n_bannati', count($img_bann) - 1);
            }
            else {
                $this->smarty->assign('typeB', $typeBannati);
                $this->smarty->assign('pic64ban', $pic64ban);
            }
        }
        else
            $this->smarty->assign('n_bannati', 0);

        $this->smarty->assign('categorie',$categorie);
        $this->smarty->assign('utenti',$utentiAttivi);
        $this->smarty->assign('utentiBan',$utentiBannati);
        $this->smarty->display('admin_HP.tpl');
    }


    public function getUtentiAttivi($utentiAttivi,$imgAttivi){

    }

    /**
     * Funzione di supporto che si occupa gestire le immagini degli utenti presenti nell'elenco delle recensioni
     * @param $imgrec
     * @return array $type array dei MIME type delle immagini, $pic64 array dei dati delle immagini
     */
    public function SetImageRecensione ($imgrec): array
    {
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
            $pic64 = base64_encode($imgrec->getImmagine());
            $type = $imgrec->getType();
        }
        return array($type, $pic64);
    }

    /**
     * Funzione che permette di visualizzare la lista delle recensioni presenti nel database
     * @param $rec array di recensioni
     * @param $img array di immagini
     * @throws SmartyException
     */
    public function showRevPage($rec,$img){

        list($type,$pic64att) = $this->SetImageRecensione($img);
        if ($type == null && $pic64att == null)
            $this->smarty->assign('immagine', "no");
        if (isset($img)) {
            if (is_array($img)) {
                $this->smarty->assign('typeA', $type);
                $this->smarty->assign('pic64att', $pic64att);
                $this->smarty->assign('n_attivi', count($img) - 1);
            }
            else {
                $this->smarty->assign('typeA', $type);
                $this->smarty->assign('pic64att', $pic64att);
            }
        }
        $this->smarty->assign('recensioni',$rec);
        $this->smarty->display('dashboardAdmin.tpl');
    }

    /**
     * Funzione che si occupa di presentare l'elenco dei locali presenti nel database
     * @param $localiAttivi array di locali attivi
     * @param $localiBan array di locali bannati
     * @param $img_attivi array di immagini relative agli annunci attivi
     * @param $img_bann array di immagini relative agli annunci bannati
     * @throws SmartyException
     */
    public function showLocalPage($localiAttivi, $localiBan,$img_attivi,$img_bann){
        list($typeA,$pic64att) = $this->SetImageRecensione($img_attivi);
        if ($typeA == null && $pic64att == null)
            $this->smarty->assign('immagine', "no");
        if (isset($img_attivi)) {
            if (is_array($img_attivi)) {
                $this->smarty->assign('typeA', $typeA);
                $this->smarty->assign('pic64att', $pic64att);
                $this->smarty->assign('n_attivi', count($img_attivi) - 1);
            }
            else {
                $this->smarty->assign('typeA', $typeA);
                $this->smarty->assign('pic64att', $pic64att);
            }
        }
        else
            $this->smarty->assign('n_attivi', 0);

        list($typeB,$pic64ban) = $this->SetImageRecensione($img_bann);
        if ($typeB == null && $pic64ban == null)
            $this->smarty->assign('immagine_1', "no");
        if (isset($img_bann)) {
            if (is_array($img_bann)) {
                $this->smarty->assign('typeB', $typeB);
                $this->smarty->assign('pic64ban', $pic64ban);
                $this->smarty->assign('n_bannati', count($img_bann) - 1);
            }
            else {
                $this->smarty->assign('typeB', $typeB);
                $this->smarty->assign('pic64ban', $pic64ban);
            }
        }
        else
            $this->smarty->assign('n_bannati', 0);

        $this->smarty->assign('annunci',$localiAttivi);
        $this->smarty->assign('annunciBan',$localiBan);

        $this->smarty->display('admin_annunci.tpl');
    }


    /**
     * Metodo richiamato quando l'Admin va a creare una nuova Categoria per il sito.
     * In caso di errori nella compilazione dei campi del locale, verrÃ  ricaricata la stessa pagina con un messaggio esplicativo
     * dell'errore commesso in fase di compilazione.
     * @param $utente oggetto utente che effettua l'inserimento dei dati nei campi del locale
     * @param $error codice di errore con svariati significati. In base al suo valore verrÃ  eventualmente visualizzato un messaggio
     * di errore nella pagina di creazione del locale
     * @throws SmartyException
     */
    public function showFormCategoria($utente,$error)
    {
            switch ($error) {
                case "wrongCategory":
                    $this->smarty->assign('errorType', $error);
                    break;
            }
            $this->smarty->display('pagina.tpl');
    }


}