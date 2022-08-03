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
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':titolo',$recensione->getTitolo(),PDO::PARAM_STR);
        $stmt->bindValue(':descrizione',$recensione->getDescrizione(),PDO::PARAM_STR);
        $stmt->bindValue(':voto',$recensione->getVoto(),PDO::PARAM_INT);
        $stmt->bindValue(':data',$recensione->getData());
        $stmt->bindValue(':segnalato',$recensione->isSegnalata(),PDO::PARAM_BOOL);
        $stmt->bindValue(':counter',$recensione->getCounter(),PDO::PARAM_INT);
        $stmt->bindValue(':utente',NULL,PDO::PARAM_INT);
        $stmt->bindValue(':locale',NULL,PDO::PARAM_INT);
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
        $db = FDB::getInstance();
        $db->store(static::getClass(), $recensione);
    }

    /**
     * Permette la load sul db
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $rec Recensione
     */
    public static function loadByField($field, $id) {
        $rec = null;
        $db = FDB::getInstance();
        $result = $db->load(static::getClass(), $field, $id);
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
        return $rec;
    }



    /**
     * Funzione che permette di verificare se esiste una Recensione nel database
     * @param  $id valore della riga di cui si vuol verificare l'esistenza
     * @param  string $field colonna su ci eseguire la verifica
     * @return bool $ris
     */
    public static function exist($field, $id) {
        $ris = false;
        $db = FDB::getInstance();
        $result = $db->exist(static::getClass(), $field, $id);
        if($result!=null)
            $ris = true;
        return $ris;
    }

    /**
     * Permette la delete sul db in base all'id
     * @param int l'id dell'oggetto da eliminare dal db
     * @return bool
     */
    public static function delete($field, $id) {
        $db = FDB::getInstance();
        $result = $db->delete(static::getClass(), $field, $id);
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


}