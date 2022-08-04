<?php

/**
 * La classe FAdmin fornisce query per gli oggetti EAdmin
 * @author Gruppo8
 * @package Foundation
 */
class FAdmin{

    /** classe Foundation */
    private static $class="FAdmin";

    /** tabella con la quale opera nel DB */
    private static $table="Admin";

    /** valori della tabella nel DB */
    private static $values="(:id;:username,:email,:password)";

    /** costruttore*/
    public function __construct(){

    }

    /**
     * metodo che lega gli attributi dell'Admin da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAdmin $admin
     */
    public static function bind($stmt, EAdmin $admin){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':username', $admin->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $admin->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $admin->getPassword(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di un Admin nel db
     * @param EAdmin $admin Admin da salvare
     * @return void
     */
    public static function store(EAdmin $admin){
        $db=FDB::getInstance();
        $db->store(self::getClass(),$admin);
    }

    /**
     * metodo che verifica l'esistenza di un Admin nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $ris = false;
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            $ris = true;
        return $ris;
    }

}