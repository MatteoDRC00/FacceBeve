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

    /**
     * Restituisce (se immesso) il valore del campo nome locale
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getNomeLocale(){
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
    public function getNomeEvento(){
        $value = null;
        if (isset($_POST['nomeEvento']))
            $value = $_POST['nomeEvento'];
        return $value;
    }

    /**
     * Restituisce (se immesso) il valore del campo data di un evento
     * Inviato con metodo post
     * @return string contenente il valore inserito dall'utente
     */
    public function getDataEvento(){
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
    public function getCitta(){
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
    public function getCategorie(){
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
    public function getTipoRicerca(){
        $value = null;
        if (isset($_POST['ricerca']))
            $value = $_POST['ricerca'];
        return $value;
    }

    /**
     * Mostra la pagina contenente i dettagli del locale selezionato
     * @param array contiene l'id dell'array da visualizzare
     * @throws SmartyException
     */
    public function dettagliLocale($result, $logged) {

        if ($logged == "no")
            $this->smarty->assign('userLogged', 'nouser'); //Solo gli utenti registrati possono vedere gli eventi

        if (is_array($result->getImmagini())) {
            foreach ($result->getImmagini() as $item) {
                $pic64locale[] = base64_encode($item->getData());
                //$typeA[] = $item->getType();
            }
            //$this->smarty->assign('n_img_annuncio', count($med_annuncio) - 1);
            $this->smarty->assign('pic64locale', $pic64locale);
        }
        elseif ($result->getImmagini() !== null) {
            $pic64ann = base64_encode($result->getImmagini()->getData());
           // $typeA = $med_annuncio->getType();
        }
        if ($logged == "si"){
            if (is_array($result->getEventi())) {
                foreach ($result->getEventi() as $evento) {
                    if (is_array($evento->getImmagini())) {
                        foreach ($evento->getImmagini() as $itemE) {
                            $pic64evento[] = base64_encode($itemE->getData());
                            //$typeA[] = $item->getType();
                        }
                    }
                    $this->smarty->assign('pic64evento', $pic64evento);
                }
            }
        }
       // $this->smarty->assign('media_ann', $med_annuncio);
       // list($type,$pic64) = VUtente::setImage($img_utente, 'user');
       // $this->smarty->assign('type', $type);
       // $this->smarty->assign('pic64', $pic64);
        if(CUtente::isLogged())
            $this->smarty->assign('userlogged',"loggato"); //Potrà cosi visualizzare gli eventi

        //Recensioni

        $this->smarty->assign('ris', $result);
        $this->smarty->display('dettagli_loc.tpl');


    }

}