<?php

/**
 * La classe FCategoria fornisce query per gli oggetti ECategoria
 * @author Gruppo 8
 * @package Foundation
 */

class FCategoria{
    /** classe foundation */
    private static $class="FCategoria";
	/** tabella con la quale opera */          
    private static $table="categoria";
    /** valori della tabella */
    private static $values="(:giorno,:orarioApertura,:orarioChiusura)";

    /** costruttore*/ 
    public function __construct(){}

    /**
    * Questo metodo lega gli attributi dell'Orario da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EOrario $orario Orario i cui i dati devono essere inseriti nel DB
    */
    public static function bind($stmt, ECategoria $categoria){
        $stmt->bindValue(':categoria', $categoria->getGenere(), PDO::PARAM_STR);    //Potrebbe dare problemi
		$stmt->bindValue(':descrizione',$categoria->getDescrizione(), PDO::PARAM_STR);
        }

    /**
    * questo metodo restituisce il nome della classe per la costruzione delle Query
    * @return string $class nome della classe
    */
    public static function getClass(){
        return self::$class;
    }

    /**
    * questo metodo restituisce il nome della tabella per la costruzione delle Query
    * @return string $table nome della tabella
    */
    public static function getTable(){
        return self::$table;
    }

    /**
    * questo metodo restituisce l'insieme dei valori per la costruzione delle Query
    * @return string $values nomi delle colonne della tabella
    */
    public static function getValues(){
        return self::$values;
    }

    /**
    * Metodo che permette la store di una categoria 
    * @param $utente Utenteloggato da salvare
    */
    public static function store($utente){
        $db=FDB::getInstance();
        $id=$db->store(static::getClass() ,$utente);
    }


    /**
    * Permette la load sul database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $categoria Categoria 
    */
    public static function loadByField($field, $id){
        $utente = null;
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {           
		   $categoria=new ECategoria($result['genere'],$result['descrizione']); //Carica una Categoria dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
					$categoria =new ECategoria($result[$i]['genere'],$result[$i]['descrizione']); //Carica un array di oggetti Categoria dal database
                }
            }
        }
        return $categoria;
    }

    /**
    * Funzione che permette di verificare se esiste una categoria nel database
    * @param  $id valore della riga di cui si vuol verificare l'esistenza
    * @param  string $field colonna su ci eseguire la verifica
    * @return bool $ris
    */
    public static function exist($field, $id){
        $db=FDB::getInstance();
        $result=$db->exist(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB -->  ritorna tutti gli attributi di un'istanza dando come parametro di ricerca il valore di un attributo
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
    * Metodo che aggiorna i campi di un Categoria
    * @param $id valore della primary key da usare come riferimento per la riga
    * @param $newvalue nuovo valore da assegnare
    * @param $field campo in cui si vuo modificare il valore
	* @param pk chiave primaria della classe interessata
    * @return true se esiste il mezzo, altrimenti false
    */
    public static function update($field, $newvalue, $pk, $id){
        $db=FDB::getInstance();
        $result = $db->update(static::getClass(), $field, $newvalue, $pk, $id); //funzione richiamata,presente in FDB -->  Aggiorna una riga nel db che fa match con il campo id
        if($result) return true;
        else return false;
    }

    /**
    * Permette la delete sul db in base all'id
    * @param int l'id dell'oggetto da eliminare dal db
    * @return bool
    */
     public static function delete($field, $id){
      $db=FDB::getInstance();
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata,presente in FDB
      if($result) return true;
        else return false;
    }   

}

?>