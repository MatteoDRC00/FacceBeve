<?php

/**
 * La classe FLocalizzazione fornisce query per gli oggetti ELocalizzazione
 * @author Gruppo 8
 * @package Foundation
 */

class FLocalizzazione{
    /** classe foundation */
    private static $class="FLocalizzazione";
	/** tabella con la quale opera */          
    private static $table="localizzazione";
    /** valori della tabella */
    private static $values="(:indirizzo,:numCivico,:citta,:nazione,:CAP)";

    /** costruttore*/ 
    public function __construct(){}

    /**
    * Questo metodo lega gli attributi della Localizzazione del legale da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param ELocalizzazione $luogo i cui i dati devono essere inseriti nel DB
    */
    public static function bind($stmt, ELocalizzazione $localizzazione){
        $stmt->bindValue(':indirizzo', $localizzazione->getIndirizzo(), PDO::PARAM_STR); 
		$stmt->bindValue(':numCivico',$localizzazione->getNumCivico(), PDO::PARAM_STR);
		$stmt->bindValue(':citta',$localizzazione->getCitta(), PDO::PARAM_STR);
        $stmt->bindValue(':nazione', $localizzazione->getNazione(), PDO::PARAM_STR); 
        $stmt->bindValue(':CAP', $localizzazione->getCAP(), PDO::PARAM_BOOL);
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
    * @param $utente Utenteloggato da salvare
    */
    public static function store($utente){
        $db=FDB::getInstance();
        $id=$db->store(static::getClass() ,$utente);
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
		   $luogo=new ELocalizzazione($result['indirizzo'],$result['numCivico'],$result['citta'], $result['nazione'], $result['CAP']); //Carica un Luogo dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
                    $luogo[]=new ELocalizzazione($result[$i]['indirizzo'], $result[$i]['numCivico'], $result[$i]['citta'], $result[$i]['nazione'], $result[$i]['CAP']); //Carica un array di oggetti Localizzazione dal database
                }
            }
        }
        return $luogo;
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
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
      if($result) return true;
        else return false;
    }   

}

?>