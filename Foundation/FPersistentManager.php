<?php

require_once "autoload.php";

class FPersistentManager {

    private static FPersistentManager $_instance;

    /**
     * Costruttore di classe.
     */
    private function __construct(){

    }

    public static function getInstance(): FPersistentManager{
        if ( !isset(self::$_instance) ) {
            self::$_instance = new FPersistentManager();
        }
        return self::$_instance;
    }

    /** Metodo che permette di salvare un oggetto sul db */
    public function store($obj) {
        $EClass = get_class($obj);
        $EClass[0] = "F";
        $FClass = $EClass;
        return $FClass::store($obj);
    }

    /**   Metodo che permette di salvare un media di un oggetto sul db
     * @param obj oggetto di cui si vuole salvare il media
     * @param nome_file ,nome del media da salvare

    public static function storeMedia($obj,$nome_file) {
        $EClass = get_class($obj);
        $Fclass = str_replace("E", "F", $EClass);
        return $Fclass::store($obj,$nome_file);
    }*/

    /**
     * @param Object $obj
     * @param string $Fclass
     * @param int $id del Locale
     * @return void
     */
    public static function storeEsterne(string $Fclass, Object $obj,int $id) {
        $Fclass::storeEsterne($obj,$id);
    }

    /**
     * Metodo utilizzato per caricare TUTTE le categorie di locale presenti sul sito
    */
    public function getCategorie(): array{
        $result = FCategoria::loadTutteCategorie();
        $genere = array();
        foreach ($result as $c){
            $genere[] = $c['genere'];
        }
        return $genere;
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @param string $Fclass
     * @return void
     */
    public function delete(string $attributo, string $valore, string $Fclass) {
        $Fclass::delete($attributo,$valore);
    }

    /**
     * @param Object $obj
     * @param string $Fclass
     * @return void
     */
    public static function deleteEsterne(string $Fclass, Object $obj) {
        $Fclass::deleteEsterne($obj);
    }

    /**
     * metodo che accerta l'esistenza di un valore di un campo passato come parametro
     * @param string $class
     * @param string $attributo
     * @param string $valore
     * @return mixed
     */
    public function exist(string $class, string $attributo, string $valore) {
        return $class::exist($attributo,$valore);
    }

    /**  Metodo che permette di cercare/caricare un campo con un valore passato come parametro
     *  @param field , campo da caricare
     *  @param  val , valore da caricare
     *  @param  Fclass ,classe Foundation interessata
     *  @return object|null
     */
    public function load($field, $val,$Fclass) {
        return $Fclass::loadByField($field,$val);
    }


    /**  Metodo che permette il caricamento di una form(modulo) riempita con i parametri passati in input alla funzione
     * @param part1 nome locale / evento
     * @param part2 città locale/ nome locale
     * @param part3 categorie locale / citta evento
     * @param part4 null per Locale / data evento
     */
    public static function loadForm ($part1, $part2,$part3, $part4,$tipo) {
        $ris = null;
        if($tipo=="Locali")
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
    public function update(string $class, string $attributo, string $newvalue, string $attributo_pk, string $value_pk) {
        $result = $class::update($attributo, $newvalue, $attributo_pk, $value_pk);
        return $result;
    }


    /**
     * metodo che permette l'aggiornamento di un immagine
     * @param EImmagine $img
     * @param string $nome_file
     * @return bool
     */
    public static function updateMedia(EImmagine $img,string $nome_file){
        return FImmagine::update($img,$nome_file);
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

    /**
     * Metodo che permette il login di un utente, date le credenziali (username e password)
     */
    public function verificaLogin($user, $pass) {
        $ris = FUtente::verificaLogin($user, $pass);
        if($ris == null){
            $ris = FProprietario::verificaLogin($user, $pass);
            if($ris == null){
                $ris = FAdmin::verificaLogin($user, $pass);
            }
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

    /**
     * Metodo che restituisce i 4 locali con la valutazione più alta sul sito
    */
    public function top4Locali(){
        $locali=null;
        $result = FLocale::getTopLocali();
        if(!empty($result)){
            if(count($result)>4){
                for($i=0; $i<4; $i++){
                    $locali[] = $result[$i];
                }
            }
        }else
            $locali = $result;
        return $locali;
    }


    public function loadRecensioniByLocale($id){
        $result = FRecensione::loadByField("locale", $id);
        return $result;
    }

    public function getLocaliPreferiti($id_utente){
        $db = FDB::getInstance();
        $utente_locali = $db->loadByTable("utenti_locali", "ID_Utente", $id_utente);

        $locali_preferiti = array();

        if(!empty($utente_locali)){
            for($i=0; $i<count($utente_locali); $i++){
                $locali_preferiti[] = self::load("id", $utente_locali[$i]['ID_Locale'], "FLocale");
            }
        }
        return $locali_preferiti;
    }

    public function storeCategorieLocale($categoria, $locale){
        $db = FDB::getInstance();
        $db->storeCategorieLocale($locale, $categoria);
    }

    public function deleteCategorieLocale($id_locale){
        $db = FDB::getInstance();
        $db->deleteCategorieLocale($id_locale);
    }

    public function storeOrariLocale($orario, $locale){
        $db = FDB::getInstance();
        $db->storeOrariLocale($locale, $orario);
    }

    public function storeImmagineLocale($immagine, $locale){
        $db = FDB::getInstance();
        $db->storeImmagineLocale($locale, $immagine);
    }

}