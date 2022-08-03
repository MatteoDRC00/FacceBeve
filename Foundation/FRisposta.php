<?php
//Da aggiustare...
class FRisposta{

    /** nome della classe */
    private static $class = "FRisposta";
    /** tabella con la quale opera */
    private static $table = "Risposta";
    /** valori della tabella */
    private static $values="(:titolo,:descrizione,:proprietario,:recensione)";
    /** costruttore */
    public function __construct() {

    }

    /**
     * Questo metodo lega gli attributi della Recensione da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ERisposta $rec Recensione in cui i dati devono essere inseriti nel DB
     */
    public static function bind(PDOStatement $stmt, ERisposta $risposta) {
        $stmt->bindValue(':titolo',$risposta->getTitolo(),PDO::PARAM_STR);
        $stmt->bindValue(':descrizione',$risposta->getDescrizione(),PDO::PARAM_STR);
        $stmt->bindValue(':proprietario',$risposta->getProprietario());
        $stmt->bindValue(':recensione',$risposta->getRecensione());
    }

    /**
     * Questo metodo restituisce il nome della classe per la costruzione delle Query
     * @return string $class nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     * Questo metodo restituisce il nome della tabella per la costruzione delle Query
     * @return string $table nome della tabella
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Questo metodo restituisce l'insieme dei valori per la costruzione delle Query
     * @return string $values nomi delle colonne della tabella
     */
    public static function getValues(){
        return self::$values;
    }

    /**
     * Metodo che permette di salvare una Recensione
     * @param $rec Recensione da salvare
     * @return $id della Recensione salvata
     */
    public static function store(ERisposta $risposta) {
        $db = FDB::getInstance();
        $db->store(static::getClass(), $risposta);
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