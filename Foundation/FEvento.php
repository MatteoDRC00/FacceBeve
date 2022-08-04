<?php
/**
 * La classe FEvento fornisce query per gli oggetti EEvento
 * @author Gruppo8
 * @package Foundation
 */
class FEvento {

    /** classe Foundation */
    private static $class="FEvento";

    /** tabella con la quale opera nel DB */
    private static $table="Evento";

    /** valori della tabella nel DB */
    private static $values="(:id,:nome,:descrizione,:data)";

    public function __construct(){

    }

    /**
     * metodo che lega gli attributi dell'Evento da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EEvento $evento
     * @return void
     */
    public static function bind(PDOStatement $stmt, EEvento $evento){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome', $evento->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $evento->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':data', $evento->getData(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di un Evento nel db
     * @param EEvento $evento Evento da salvare
     * @return void
     */
    public static function store(EEvento $evento){
        $db=FDB::getInstance();
        $db->store(self::getClass(), $evento);
    }

    /**
     * metodo che verifica l'esistenza di un Evento nel DB considerato un attributo
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
     * Permette la load dal database
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $evento
     */
    public static function loadByLocale($id){
        $evento = null;
        $db=FDB::getInstance();
        $result=$db->loadInfoLocale(static::getClass(),"Locale_Eventi",$id);
        $rows_number = $result->rowCount();    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $evento=new EEvento($result['nome'], $result['descrizione'], $result['data']); //Carica un evento dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $evento = array();
                for($i=0; $i<count($result); $i++){
                    $evento[]=new EEvento($result[$i]['nome'], $result[$i]['descrizione'],$result[$i]['data']); //Carica un array di oggetti Evento dal database
                }
            }
        }
        return $evento;
    }

    /**
     * metodo che aggiorna il valore di un attributo dell'Evento sul DB data la chiave primaria
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

}