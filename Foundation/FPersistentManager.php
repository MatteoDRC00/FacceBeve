<?php

class FPersistentManager {

    /** Metodo che permette di salvare un oggetto sul db */
    public static function store($obj) {
        $EClass = get_class($obj);
        $EClass[0] = "F";
        $FClass = $EClass;
        $FClass::store($obj);
    }



    /**   Metodo che permette di salvare un media di un oggetto sul db
     * @param obj oggetto di cui si vuole salavare il media
     * @param nome_file ,nome del media da salvare
     */

    public static function storeMedia($obj,$nome_file) {
        $EClass = get_class($obj);
        $Fclass = str_replace("E", "F", $EClass);
        $Fclass::store($obj,$nome_file);

    }


    /**  Metodo che permette di cancellare il valore di un campo passato come parametro
     *   @param field , campo interessato
     *   @param val ,valore da eliminare ,
     *   @param Fclass ,classe Foundation interessata
     */
    public static function delete($field, $val,$Fclass) {
        $Fclass::delete($field,$val);
    }

    /**  Metodo che accerta l'esistenza di un valore di un campo passato come parametro
     * @param campo da testare
     * @param val ,valore da cercare
     * @param Fclass, calsse Foundation interessata
     */
    public static function exist($field, $val,$Fclass) {
        $ris = null;
        $ris = $Fclass::exist($field,$val);
        return $ris;
    }

    /**  Metodo che permette di cercare/caricare un campo con un valore passato come parametro
     *  @param field , campo da caricare
     *  @param  val , valore da caricare
     *  @param  Fclass ,calsse Foundation interessata
     */
    public static function load($field, $val,$Fclass) {
        $ris = null;
        $ris = $Fclass::loadByField($field,$val);
        return $ris;
    }


    /**  Metodo che permette il caricamento di una form(modulo) riempita con i parametri passati in input alla funzione
     * @param part1 nome locale / evento
     * @param part2 città locale/ nome locale
     * @param part3 categorie locale / citta evento
     * @param part4 null per Locale / data evento
     */
    public static function loadForm ($part1, $part2, $part3, $part4,$tipo) {
        $ris = null;
        if($tipo=="Locale")
            $ris = FLocale::loadByForm ($part1, $part2, $part3);
        else
            $ris = FEvento::loadByForm ($part1, $part2, $part3, $part4);
        return $ris;
    }



    /**  Metodo che permette il login di un utente date le credenziali (email e password)
     *
     */
    public static function loadLogin ($user, $pass) {
        $ris = null;
        $ris = FUtenteloggato::loadLogin($user, $pass);
        return $ris;
    }


    /** Metodo che permette il caricamento dei soli annunci dei trasporti (utilizzata nella home) e nella parte mobile */
    public static function loadTrasporti () {
        $ris = null;
        $ris = FAnnuncio::initialLoad();
        return $ris;
    }


    /** Metodo che permette l'aggiornamento del valore di un campo passato per parametro */
    public static function update($field, $newvalue, $pk, $val,$Fclass) {
        $ris = null;
        if ($Fclass == "FAnnuncio" || $Fclass == "FMezzo" || $Fclass == "FTappa" || $Fclass == "FTrasportatore" || $Fclass == "FUtenteloggato" || $Fclass == "FCliente")
            $ris = $Fclass::update($field, $newvalue, $pk, $val);
        else
            print ("METODO NON SUPPORTATO DALLA CLASSE");
        return $ris;
    }


    /** Metodo che permette il caricamento dei nomi di tutti i luoghi presenti nel db*/
    public static function loadNomiLuoghi ($input) {
        $ris = null;
        $ris = FLuogo::loadNames($input);
        return $ris;
    }


    /** Metodo che permette il caricamento delle sole tuple che abbiano in un loro campo una parola data in input
     *  @param input parola da cercare
     *@param Fclass , classe Foundation interessata
     */
    public static function loadByParola($input, $Fclass) {
        $ris = null;
        $ris = $Fclass::loadByParola($input);
        return $ris;
    }


    /** Metodo che permette il caricamento degli utenti in base al loro stato
     * @param input, stato immesso
     */
    public static function loadUtenti ($input) {
        $ris = null;
        $ris = FUtenteloggato::loadUtenti($input);
        return $ris;
    }


    /** Metodo che permette di caricare tutte le recensioni presenti sul db */
    public static function loadAllRec () {
        $ris = null;
        $ris = FRecensione::loadAll();
        return $ris;
    }

    /** Metodo che permette il caricamento degli utenti avendo come parametro di ricerca nome e/o cognome passati in input
     * @param string ,string passato in input
     */
    public static function loadUtentiByString ($string) {
        $ris = null;
        $ris = FUtenteloggato::loadUtentiByString($string);
        return $ris;
    }

    /** Metodo che permette l'inserimento di una nuova tappa nel db
     * @param ad , fk annuncio
     * @param place ,fk del luogo
     */
    public function insertTappa ($ad,$place) {
        $ris = null;
        $ris = FTappa::insert($ad,$place);
        return $ris;
    }

    /**   Metodo che permette il caricamento di una chat e quindi lo scambio di messaggi tra due utenti che vengono identificati
     *dal sistema tramite la loro email
     *  *@param email ,email del utente
     *  @param pass, password dell utente
     */
    public function loadChats ($email, $email2){
        $ris = null;
        $ris = FMessaggio::loadChats($email, $email2);
        return $ris;
    }

}