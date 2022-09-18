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

    public function getEventiByLocale($id_locale){
        $db = FDB::getInstance();
        list($result, $num) = $db->getIdEventoByIdLocale($id_locale);
        $eventi = array();

        if(!empty($result)){
            if($num == 1){
                $eventi[] = FEvento::loadByField("id", $result['ID_Evento']);
            }else{
                foreach ($result as $r){
                    $eventi[] = FEvento::loadByField("id", $r['ID_Evento']);
                }
            }

        }

        return $eventi;

    }


    public function getLocaleByEvento($id_evento){
        $db = FDB::getInstance();
        $result = $db->getIdLocaleByIdEvento($id_evento);
        //print_r($result['ID_Locale']);
        return $result['ID_Locale'];

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
     * @return bool
     */
    public function exist(string $class, string $attributo, string $valore): bool
    {
        return $class::exist($attributo,$valore);
    }

    public function existEsterna(string $class, string $attributo1, string $chiave1,  string $attributo2, string $chiave2): bool
    {
        $db = FDB::getInstance();
        return $db->existEsterne($class, $attributo1, $chiave1, $attributo2, $chiave2);
    }

    /**  Metodo che permette di cercare/caricare un campo con un valore passato come parametro
     *  @param field , campo da caricare
     *  @param  val , valore da caricare
     *  @param  Fclass ,classe Foundation interessata
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
        if($tipo=="Locali")
            return FLocale::loadByForm ($part1, $part2, $part3);
        else{
            return FEvento::loadByForm ($part1, $part2, $part3, $part4);
        }
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
    public function loadAll(string $class) {
        $ris = null;
        $ris = $class::loadAll();
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

    /**
     * Metodo che permette il caricamento degli utenti avendo come parametro di ricerca lo stato, i.e.,
     * 0) '0' ==> Bannato
     * 1) '1' ==> Attivo
     */
    public function loadUtentiByState($state) {
        $ris = FUtente::loadUtentiByState($state);
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
        $locali = array();
        list($result, $num) = FLocale::getTopLocali();
        if(!empty($result)){
            if($num>4){
                for($i=0; $i<4; $i++){
                    $locali[] = $result[$i];
                }
            }else
                $locali[] = $result;
        }
        return $locali;
    }


    public function loadRecensioniByLocale($id){
        $result = FRecensione::loadByField("locale", $id);
        return $result;
    }

    public function getLocaliPreferiti($id_utente){
        $db = FDB::getInstance();
        list($utente_locali, $num) = $db->loadByTable("utenti_locali", "ID_Utente", $id_utente);
        $locali_preferiti = array();

        if(!empty($utente_locali)){
            if ($num == 1){
                $locali_preferiti[] = FLocale::loadByField("id", $utente_locali['ID_Locale']);
            }else{
                for($i=0; $i<$num; $i++){
                    $value = $utente_locali[$i];
                    $locali_preferiti[] = FLocale::loadByField("id", $value['ID_Locale']);
                }
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

    public function deleteLocaleCategorie($genere){
        $db = FDB::getInstance();
        $db->deleteLocaleCategorie($genere);
    }

    public function deleteUtenteLocale($id_locale){
        $db = FDB::getInstance();
        $db->deleteUtenteLocale($id_locale);
    }

    public function deleteOrariLocale($id_locale){
        $db = FDB::getInstance();
        $db->deleteOrariLocale($id_locale);
    }

    public function deleteLocaleEvento($id_locale){
        $db = FDB::getInstance();
        $db->deleteLocaleEvento($id_locale);
    }

    public function deleteEventoLocale($id_evento){
        $db = FDB::getInstance();
        $db->deleteEventoLocale($id_evento);
    }

    public function storeOrariLocale($orario, $locale){
        $db = FDB::getInstance();
        $db->storeOrariLocale($locale, $orario);
    }

    public function deleteUtentiLocali($utente, $locale){
        $db = FDB::getInstance();
        return $db->deleteUtentiLocali($locale, $utente);
    }

    public function storeUtentiLocali($utente, $locale){
        $db = FDB::getInstance();
        $db->storeUtentiLocali($locale, $utente);
    }

    public function storeEventiLocale($evento, $locale){
        $db = FDB::getInstance();
        $db->storeEventiLocale($locale, $evento);
    }

    public function storeImmagineLocale($immagine, $locale){
        $db = FDB::getInstance();
        $db->storeImmagineLocale($locale, $immagine);
    }

}