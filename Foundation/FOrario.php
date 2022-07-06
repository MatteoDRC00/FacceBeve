<?php

/**
 * La classe FOrario fornisce query per gli oggetti EOrario
 * @author Gruppo 8
 * @package Foundation
 */

class FOrario{
    /** classe foundation */
    private static $class="FOrario";
	/** tabella con la quale opera */          
    private static $table="orario";
    /** valori della tabella */
    private static $values="(:codicegiorno,:giorno,:orarioApertura,:orarioChiusura)";

    /** costruttore*/ 
    public function __construct(){}

    /**
    * Questo metodo lega gli attributi dell'Orario da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EOrario $orario Orario i cui i dati devono essere inseriti nel DB
    */
    public static function bind($stmt, EOrario $orario){
        $stmt->bindValue(':codicegiorno', NULL, PDO::PARAM_INT);
		$stmt->bindValue(':giorno', $orario->getGiornoSettimana(), PDO::PARAM_STR);    //Potrebbe dare problemi
		$stmt->bindValue(':orarioApertura',$orario->getOrarioApertura(), PDO::PARAM_STR);
		$stmt->bindValue(':orarioChiusura',$orario->getOrarioChiusura(), PDO::PARAM_STR);
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
    * Metodo che permette la store di un Utente
    * @param Orario $orario da salvare
    */
    public static function store($orario){
        $db=FDB::getInstance();
        $id=$db->store(static::getClass() ,$orario);
    }


    /**
    * Permette la load sul database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $utente Utente
    */
    public static function loadByField($field, $id){
        $utente = null;
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {           
		    $orario=new EOrario($result['giorno'],$result['orarioApertura'],$result['orarioChiusura']); //Carica un Orario dal database
            $orario->setCodice($result['codicegiorno']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
                    $orario[] =new EOrario($result[$i]['giorno'],$result[$i]['orarioApertura'],$result[$i]['orarioChiusura']); //Carica un array di oggetti UOrario dal database
                    $orario[$i]->setCodice($result[$i]['codicegiorno']);
                }
            }
        }
        return $orario;
    }

    /**
    * Funzione che permette di verificare se esiste un Utente nel database
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
    * Metodo che aggiorna i campi di un Utente
    * @param $id valore della primary key da usare come riferimento per la riga
    * @param $newvalue nuovo valore da assegnare
    * @param $field campo in cui si vuo modificare il valore
	*@param pk chiave primaria della classe interessata
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
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
      if($result) return true;
        else return false;
    }   

}

?>