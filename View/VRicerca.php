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
     * @param $tipo definisce il tipo di annuncio da visualizzare (carichi/trasporti)
     * @throws SmartyException
     */
    public function dettagliLocale($result, $tipo, $nome, $cognome, $tappa,$img_utente,$med_annuncio,$cont) {

        if ($cont == "no")
            $this->smarty->assign('contatta', $cont);

        if (is_array($med_annuncio)) {
            foreach ($med_annuncio as $item) {
                $pic64ann[] = base64_encode($item->getData());
                $typeA[] = $item->getType();
            }
        }
        elseif (isset($med_annuncio)) {
            $pic64ann = base64_encode($med_annuncio->getData());
            $typeA = $med_annuncio->getType();
        }
        if (isset($med_annuncio)) {
            if (is_array($med_annuncio)) {
                $this->smarty->assign('typeA', $typeA);
                $this->smarty->assign('pic64ann', $pic64ann);
                $this->smarty->assign('n_img_annuncio', count($med_annuncio) - 1);
            }
            else {
                $this->smarty->assign('typeA', $typeA);
                $this->smarty->assign('pic64ann', $pic64ann);
            }
            //$this->smarty->assign('n_img_annuncio', count($med_annuncio) - 1);
        }
        else
            $this->smarty->assign('n_img_annuncio', 0);

        $this->smarty->assign('media_ann', $med_annuncio);
        list($type,$pic64) = VUtente::setImage($img_utente, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);

        if(CUtente::isLogged())
            $this->smarty->assign('userlogged',"loggato");

        $this->smarty->assign('ris', $result);
        $this->smarty->assign('nome', $nome);
        $this->smarty->assign('cognome', $cognome);
        if ($tipo == "carichi")
            $this->smarty->display('dettagli_ann_cliente.tpl');
        else {
            $this->smarty->assign('tappa', $tappa);
            $this->smarty->display('dettagli_ann_trasp.tpl');
        }

    }

}