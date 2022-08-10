<?php

/**
 * La classe FRisposta fornisce query per gli oggetti ERisposta
 * @author Gruppo 8
 * @package Foundation
 */
class FRisposta{

    /** classe Foundation */
    private static $class = "FRisposta";

    /** tabella con la quale opera nel DB */
    private static $table = "Risposta";

    /** valori della tabella nel DB */
    private static $values="(:id,:descrizione,:proprietario,:recensione)";

    /** costruttore */
    public function __construct() {

    }

    /**
     * metodo che lega gli attributi della Risposta da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ERisposta $risposta
     */
    public static function bind(PDOStatement $stmt, ERisposta $risposta) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':descrizione',$risposta->getDescrizione(),PDO::PARAM_STR);
        $stmt->bindValue(':proprietario',$risposta->getProprietario()->getUsername(),PDO::PARAM_INT);
        $stmt->bindValue(':recensione',$risposta->getRecensione()->getId(),PDO::PARAM_INT);
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
     * metodo che permette il salvataggio una Risposta nel db
     * @param ERisposta $risposta Risposta da salvare
     */
    public static function store(ERisposta $risposta) {
        $id = null;
        $db = FDB::getInstance();
        $proprietario = $db->exist("FProprietario", "username", $risposta->getProprietario()->getUsername());
        $recensione = $db->exist("FRecensione", "id", $risposta->getRecensione()->getId());
        if($proprietario && $recensione){
            $id = $db->store(static::getClass(), $risposta);
        }
        return $id;
    }

    /**
     * Permette la load sul db
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $rec Recensione
     */
    public static function loadByField($field, $id) {
        $ris = null;
        $db = FDB::getInstance();
        $result = $db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);
        if(($result != null) && ($rows_number == 1)) {
            $ris = new ERisposta($result['titolo'],$result['descrizione'],$result['proprietario'],$result['recensione']);
            $ris->setCodice($result['codicerisposta']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $ris = array();
                for($i = 0; $i < count($result); $i++){
                    $ris[] = new ERisposta($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['proprietario'],$result[$i]['recensione']);
                    $ris[$i]->setCodice($result[$i]['codicerisposta']);
                }
            }
        }
        return $ris;
    }



    /**
     * metodo che verifica l'esistenza di una Risposta nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo della Risposta sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDatabase::getInstance();
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
        $ris = null;
        $db = FDB::getInstance();
        list ($result, $rows_number)=$db->getAllRev();
        if(($result != null) && ($rows_number == 1)) {
            $ris = new ERisposta($result['titolo'],$result['descrizione'],$result['proprietario'],$result['recensione']);
            $ris->setCodice($result['codicerisposta']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $ris = array();
                for($i = 0; $i < count($result); $i++){
                    $ris[] = new ERisposta($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['proprietario'],$result[$i]['recensione']);
                    $ris[$i]->setCodice($result[$i]['codicerisposta']);
                }
            }
        }
        return $ris;
    }

    /**
     *
     * @param $parola valore da ricercare all'interno del campo text
     * @return object $rec Recensione
     */
    public static function loadByParola($parola) {
        $ris = null;
        $db = FDB::getInstance();
        list ($result, $rows_number)=$db->CercaByKeyword(static::getClass(),"descrizione",$parola);
        if(($result != null) && ($rows_number == 1)) {
            $ris = new ERisposta($result['titolo'],$result['descrizione'],$result['proprietario'],$result['recensione']);
            $ris->setCodice($result['codicerisposta']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $rec = array();
                for($i = 0; $i < count($result); $i++){
                    $ris[] = new ERisposta($result[$i]['titolo'],$result[$i]['descrizione'],$result[$i]['proprietario'],$result[$i]['recensione']);
                    $ris[$i]->setCodice($result[$i]['codicerisposta']);
                }
            }
        }
        return $ris;
    }


}