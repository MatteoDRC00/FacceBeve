<?php

/**
 * La classe FCategoria fornisce query per gli oggetti ECategoria
 * @author Gruppo 8
 * @package Foundation
 */
class FCategoria {

    /** classe Foundation */
    private static $class="FCategoria";

	/** tabella con la quale opera nel DB */
    private static $table="Categoria";

    /** valori della tabella nel DB */
    private static $values="(:id,:genere,:descrizione)";

    /** costruttore*/ 
    public function __construct(){}

    /**
     * metodo che lega gli attributi della Categoria da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ECategoria $categoria
     * @return void
     */
    public static function bind(PDOStatement $stmt, ECategoria $categoria){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':genere', $categoria->getGenere(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione',$categoria->getDescrizione(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di una Categoria nel db
     * @param ECategoria $categoria Categoria da salvare
     * @return void
     */
    public static function store(ECategoria $categoria){
        $db=FDB::getInstance();
        $db->store(static::getClass(), $categoria);
    }



}

?>