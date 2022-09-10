<?php

/**
 * La classe FRecensione fornisce query per gli oggetti ERecensione
 * @author Gruppo 8
 * @package Foundation
 */
class FRecensione{

    /** classe Foundation */
    private static $class = "FRecensione";

    /** tabella con la quale opera nel DB */
    private static $table = "Recensione";

    /** valori della tabella nel DB */
    private static $values="(:id,:titolo,:descrizione,:voto,:data,:segnalato,:counter,:utente,:locale)";

    /** costruttore */
    public function __construct() {

    }

    /**
     * metodo che lega gli attributi della Recensione da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ERecensione $recensione
     */
    public static function bind(PDOStatement $stmt, ERecensione $recensione) {
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT);
        $stmt->bindValue(':titolo',$recensione->getTitolo(),PDO::PARAM_STR);
        $stmt->bindValue(':descrizione',$recensione->getDescrizione(),PDO::PARAM_STR);
        $stmt->bindValue(':voto',$recensione->getVoto(),PDO::PARAM_INT);
        $stmt->bindValue(':data',$recensione->getData());
        $stmt->bindValue(':segnalato',$recensione->isSegnalata(),PDO::PARAM_BOOL);
        $stmt->bindValue(':counter',$recensione->getCounter(),PDO::PARAM_INT);
        $stmt->bindValue(':utente',$recensione->getUtente()->getUsername(),PDO::PARAM_INT);
        $stmt->bindValue(':locale',$recensione->getLocale()->getId(),PDO::PARAM_INT);
        //$stmt->bindValue(':visibilità',$recensione->getVisibilita,PDO::PARAM_BOOL);
    }

    /**
     * metodo che restituisce il nome della classe per la costruzione delle query
     * @return string $class Nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     * metodo che restituisce il nome della tabella per la costruzione delle query
     * @return string $table Nome della tabella
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * metodo che restituisce l'insieme dei valori per la costruzione delle query
     * @return string $values Nomi delle colonne della tabella
     */
    public static function getValues(){
        return self::$values;
    }

    /**
     * metodo che permette il salvataggio una Recensione nel db
     * @param ERecensione $recensione Recensione da salvare
     */
    public static function store(ERecensione $recensione) {
        $id = NULL;
        $db = FDB::getInstance();
        $utente = $db->exist("FUtente", "username", $recensione->getUtente()->getUsername());
        $locale = $db->exist("FLocale", "id", $recensione->getLocale()->getId());
        if($utente && $locale){
            $id = $db->store(static::getClass(), $recensione);
        }
        return $id;
    }

    /**
     * Permette il caricamento dal db dato un campo e il valore di quel campo
     * @param $campo mixed
     * @param $valore mixed
     * @return array|mixed|null
     */
    public static function loadByField($campo, $valore) {
        $db = FDB::getInstance();
        return $db->load(static::getClass(), $campo, $valore);
        /*
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);
        if(($result != null) && ($rows_number == 1)) {
            $rec = new ERecensione($result['titolo'],$result['descrizione'],$result['data'],$result['segnalato'],$result['counter'],$result['utente'],$result['nomelocale'],$result['luogolocale']);
            $rec->setCodice($result['codicerecensione']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $rec = array();
                for($i = 0; $i < count($result); $i++){
                     $rec[] = new ERecensione($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['data'],$result[$i]['segnalato'],$result[$i]['counter'],$result[$i]['utente'],$result[$i]['nomelocale'],$result[$i]['luogolocale']);
                     $rec[$i]->setCodice($result[$i]['id']);
                }
            }
        }
        return $rec;*/
    }

    /**
     * metodo che verifica l'esistenza di una Recensione nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo della Recensione sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDB::getInstance();
        $result = $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
        if($result)
            return true;
        else
            return false;
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db=FDB::getInstance();
        $result = $db->delete(static::getClass(), $attributo, $valore);
        if($result)
            return true;
        else
            return false;
    }

    /**
     * Ritorna tutte le recensioni presenti sul db
     * @return object $rec Recensione
     */
    public static function loadAll() {
        $rec = null;
        $db = FDB::getInstance();
        list ($result, $rows_number)=$db->getAllRev();
        if(($result != null) && ($rows_number == 1)) {
            $rec = new ERecensione($result['titolo'],$result['descrizione'],$result['data'],$result['segnalato'],$result['counter'],$result['utente'],$result['nomelocale'],$result['luogolocale']);
            $rec->setCodice($result['id']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $rec = array();
                for($i = 0; $i < count($result); $i++){
                    $rec[] = new ERecensione($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['data'],$result[$i]['segnalato'],$result[$i]['counter'],$result[$i]['utente'],$result[$i]['nomelocale'],$result[$i]['luogolocale']);
                    $rec[$i]->setCodice($result[$i]['id']);
                }
            }
        }
        return $rec;
    }

    /**
     *
     * @param $parola valore da ricercare all'interno del campo
     * @return object $rec Recensione
     */
    public static function loadByParola($parola) {
        $rec = null;
        $db = FDB::getInstance();
        list ($result, $rows_number)=$db->CercaByKeyword(static::getClass(),"descrizione",$parola);
        if(($result != null) && ($rows_number == 1)) {
            $rec = new ERecensione($result['titolo'],$result['descrizione'],$result['data'],$result['segnalato'],$result['counter'],$result['utente'],$result['nomelocale'],$result['luogolocale']);
            $rec->setCodice($result['id']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $rec = array();
                for($i = 0; $i < count($result); $i++){
                    $rec[] = new ERecensione($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['data'],$result[$i]['segnalato'],$result[$i]['counter'],$result[$i]['utente'],$result[$i]['nomelocale'],$result[$i]['luogolocale']);
                    $rec[$i]->setCodice($result[$i]['id']);
                }
            }
        }
        return $rec;
    }

    /**
     * metodo che permette il salvataggio di un Locale nel db
     * @param int $id Locale
     * @return float value

    public static function ValutazioneLocale($id): float    {
        $value=0;
        $db = FDB::getInstance();
        $result=$db->load(static::getClass(), "id", $id);
        $rows_number = $db->interestedRows(static::getClass(), "locale", $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        $sum = 0;
        if(($result!=null) && ($rows_number == 1)) {
            $value = $result['voto'];
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                for($i=0; $i<count($result); $i++){
                    $sum=$sum+$result[$i]['voto'];
                }
                $value=$sum/count($result);
            }
        }
        return $value;
    } */


}