<?php

/**
 * La classe FLocalizzazione fornisce query per gli oggetti ELocalizzazione
 * @author Gruppo 8
 * @package Foundation
 */
class FLocalizzazione {

    /** classe Foundation */
    private static $class="FLocalizzazione";

	/** tabella con la quale opera nel DB */
    private static $table="Localizzazione";

    /** valori della tabella nel DB */
    private static $values="(:id,:indirizzo,:numCivico,:citta,:nazione,:CAP)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi della Localizzazione da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param ELocalizzazione $localizzazione
    */
    public static function bind(PDOStatement $stmt, ELocalizzazione $localizzazione){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':indirizzo', $localizzazione->getIndirizzo(), PDO::PARAM_STR); 
		$stmt->bindValue(':numCivico',$localizzazione->getNumCivico(), PDO::PARAM_STR);
		$stmt->bindValue(':citta',$localizzazione->getCitta(), PDO::PARAM_STR);
        $stmt->bindValue(':nazione', $localizzazione->getNazione(), PDO::PARAM_STR); 
        $stmt->bindValue(':CAP', $localizzazione->getCAP(), PDO::PARAM_INT);
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
    * metodo che restituisce l'insieme dei valori per la costruzione delle uery
    * @return string $values Nomi delle colonne della tabella
    */
    public static function getValues(){
        return self::$values;
    }

    /**
     * metodo che permette il salvataggio di una Localizzazione nel db
     * @param ELocalizzazione $localizzazione Localizzazione da salvare
     * @return void
     */
    public static function store(ELocalizzazione $localizzazione){
        $db=FDB::getInstance();
        $db->store(static::getClass() ,$localizzazione);
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
            $luogo->setCodice($result['codiceluogo']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $luogo = array();
        	    for($i=0; $i<count($result); $i++){
                    $luogo[]=new ELocalizzazione($result[$i]['indirizzo'], $result[$i]['numCivico'], $result[$i]['citta'], $result[$i]['nazione'], $result[$i]['CAP']); //Carica un array di oggetti Localizzazione dal database
                    $luogo[$i]->setCodice($result[$i]['codiceluogo']);
                }
            }
        }
        return $luogo;
    }

    /**
     * metodo che verifica l'esistenza di una Localizzazione nel DB considerato un attributo
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
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata, presente in FDB
      if($result) return true;
        else return false;
    }   

}

?>