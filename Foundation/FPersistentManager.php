<?php

require_once "autoload.php";
/**
 * La classe FPersistentManager viene utilizzata come interfaccia tra le classi Foundation e i Controller
 * @author Gruppo8
 * @package Foundation
 */
class FPersistentManager {

    /**
     * @var FPersistentManager
     */
    private static FPersistentManager $_instance;

    /**
     * Costruttore di classe.
     */
    private function __construct(){

    }

    /**
     * Metodo che instanzia un unico oggetto di questa classe richiamando il costruttore se non è stato già istanziato un oggetto
     * @return FPersistentManager
     */
    public static function getInstance(): FPersistentManager{
        if ( !isset(self::$_instance) ) {
            self::$_instance = new FPersistentManager();
        }
        return self::$_instance;
    }

    /**
     * Metodo che permette di salvare un oggetto sul db
     * @param $obj
     * @return mixed
     */
    public function store($obj) {
        $EClass = get_class($obj);
        $EClass[0] = "F";
        $FClass = $EClass;
        return $FClass::store($obj);
    }

    /**
     * Metodo che richiama la delete della classe foundation tra i parametri
     * @param string $attributo
     * @param string $valore
     * @param string $Fclass
     * @return void
     */
    public function delete(string $attributo, string $valore, string $Fclass) {
        return $Fclass::delete($attributo,$valore);
    }


    /**
     * Metodo che richiama la exist della classe foundation tra i parametri
     * @param string $class
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public function exist(string $class, string $attributo, string $valore): bool
    {
        return $class::exist($attributo,$valore);
    }

    /**
     * Metodo che richiama la load della classe foundation tra i parametri
     * @param $field
     * @param $val
     * @param $Fclass
     * @return mixed
     */
    public function load($field, $val, $Fclass) {
        return $Fclass::loadByField($field,$val);
    }

    /**
     * Metodo che richiama la exist delle classi delle relazioni n a n
     * @param string $class
     * @param string $attributo1
     * @param string $chiave1
     * @param string $attributo2
     * @param string $chiave2
     * @return bool
     */
    public function existEsterne(string $class, string $attributo1, string $chiave1,  string $attributo2, string $chiave2): bool
    {
        $db = FDB::getInstance();
        return $db->existEsterne($class, $attributo1, $chiave1, $attributo2, $chiave2);
    }

    /**
     * Metodo che richiama la store delle classi delle relazioni n a n
     * @param string $table
     * @param string $field1
     * @param string $field2
     * @param string $fk1
     * @param string $fk2
     * @return bool|null
     */
    public function storeEsterne(string $table, string $field1, string $field2, string $fk1, string $fk2) {
        $db = FDB::getInstance();
        return $db->storeEsterne($table, $field1, $field2, $fk1, $fk2);
    }

    /**
     * Metodo che richiama la delete delle classi delle relazioni n a n
     * @param string $table
     * @param string $field
     * @param string $fk
     * @return bool|null
     */
    public function deleteEsterne(string $table, string $field, string $fk) {
        $db = FDB::getInstance();
        return $db->deleteEsterne($table, $field, $fk);
    }

    /**
     * Metodo utilizzato per caricare TUTTE le categorie di locale presenti sul sito
     * @return array
     */
    public function getCategorie(): array{
        return FCategoria::loadAllCategorie();
    }

    /**
     * Restituisce gli eventi di un un locale dato il suo id
     * @param $id_locale
     * @return array
     */
    public function getEventiByLocale($id_locale){
        return FEvento::loadByLocale($id_locale);
    }

    /**
     * Restituisce le immagini di un un locale dato il suo id
     * @param $id_locale
     * @return array
     */
    public function getImmaginiByLocale($id_locale){
        return FImmagine::loadByLocale($id_locale);
    }

    /**
     * Metodo che permette il caricamento di una form(modulo) riempita con i parametri passati in input alla funzione
     * @param $part1
     * @param $part2
     * @param $part3
     * @param $part4
     * @param $tipo
     * @return array[]
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
        return $class::update($attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * Metodo che permette il caricamento di tutti gli elementi di una classe/tabella
     * @param string $class
     * @return mixed
     */
    public function loadAll(string $class) {
        return $class::loadAll();
    }

    /**
     * Metodo che permette il login di un utente, date le credenziali (username e password)
     * @param $user
     * @param $pass
     * @return array|EAdmin|EProprietario|EUtente|null
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

    /**
     * Metodo che restituisce i 4 locali con la valutazione più alta sul sito
     * @return array
     */
    public function top4Locali(){
        return FLocale::getTopLocali();
    }

    /**
     * Metodo che restituisce gli eventi disponibili per un utente dato il suo username
     * @param string $username
     * @return array[]
     */
    public function eventiUtente(string $username){
        return FEvento::loadByUtente($username);
    }

    /**
     * Restituisce le recensioni di un locale dato il suo id
     * @param $id
     * @return array
     */
    public function loadRecensioniByLocale($id){
        $result = FRecensione::loadByField("locale", $id);
        return $result;
    }

    /**
     * Restituisce i locali preferiti di un utente dato il suo id
     * @param $id_utente
     * @return array
     */
    public function getLocaliPreferiti($id_utente): array
    {
        return FLocale::loadByUsername($id_utente);
    }

    /**
     * Rimuove un locale dai preferiti di un utente dato l'username e l'id del locale
     * @param $utente
     * @param $locale
     * @return bool
     */
    public function deleteUtentiLocali($utente, $locale){
        $db = FDB::getInstance();
        return $db->deleteUtentiLocali($locale, $utente);
    }
}