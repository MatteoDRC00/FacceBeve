<?php

class FPersistentManager {

    private static FPersistentManager $_instance;

    /** Metodo che permette di salvare un oggetto sul db */
    public static function store($obj) {
        $EClass = get_class($obj);
        $EClass[0] = "F";
        $FClass = $EClass;
        $FClass::store($obj);
    }

    /**   Metodo che permette di salvare un media di un oggetto sul db
     * @param obj oggetto di cui si vuole salvare il media
     * @param nome_file ,nome del media da salvare
     */

    public static function storeMedia($obj,$nome_file) {
        $EClass = get_class($obj);
        $Fclass = str_replace("E", "F", $EClass);
        $Fclass::store($obj,$nome_file);
    }

    public static function getInstance(): FPersistentManager{
        if ( !(self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Metodo utilizzato per caricare TUTTE le categorie di locale presenti sul sito
    */
    public function getCategorie(){
        $return = FCategoria::loadAll();
        return $return;
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @param string $Fclass
     * @return void
     */
    public static function delete(string $attributo, string $valore, string $Fclass) {
        $Fclass::delete($attributo,$valore);
    }

    /**
     * metodo che accerta l'esistenza di un valore di un campo passato come parametro
     * @param string $class
     * @param string $attributo
     * @param string $valore
     * @return mixed
     */
    public static function exist(string $class, string $attributo, string $valore) {
        $result = $class::exist($attributo,$valore);
        return $result;
    }

    /**  Metodo che permette di cercare/caricare un campo con un valore passato come parametro
     *  @param field , campo da caricare
     *  @param  val , valore da caricare
     *  @param  Fclass ,classe Foundation interessata
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

    /**
     * metodo che permette l'aggiornamento del valore di un campo passato per parametro
     * @param string $class
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return mixed
     */
    public static function update(string $class, string $attributo, string $newvalue, string $attributo_pk, string $value_pk) {
        $result = $class::update($attributo, $newvalue, $attributo_pk, $value_pk);
        return $result;
    }


    /** Metodo che permette il caricamento di tutti gli elementi di una classe/tabella*/
    public static function loadAll(string $class) {
        $ris = null;
        $ris = $class::loadNames();
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
        $ris = FUtente::loadUtenti($input);
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
        $ris = FUtente::loadUtentiByString($string);
        return $ris;
    }

    /**  Metodo che permette il login di un utente, date le credenziali (username e password)
     *
     */
    public static function loadLogin ($user, $pass) {
        $ris = null;
        $ris = FUtente::loadLogin($user, $pass);
        if($ris==null){
            $ris = FProprietario::loadLogin($user, $pass);
        }
        return $ris;
    }

    /**   Metodo che permette il caricamento di una chat e quindi lo scambio di messaggi tra due utenti che vengono identificati
     *dal sistema tramite la loro email
     *  *@param email ,email del utente
     *  @param pass, password dell utente
     */
    public function loadEventi($utentelogged){
        $ris = null;
        $ris = FEvento::loadByUtente($utentelogged->getUsername());
        return $ris;
    }

}