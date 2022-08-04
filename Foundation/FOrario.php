<?php

/**
 * La classe FOrario fornisce query per gli oggetti EOrario
 * @author Gruppo 8
 * @package Foundation
 */
class FOrario {

    /** classe Foundation */
    private static $class="FOrario";

	/** tabella con la quale opera nel DB */
    private static $table="Orario";

    /** valori della tabella nel DB */
    private static $values="(:id,:giorno,:orarioApertura,:orarioChiusura)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi dell'Orario da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EOrario $orario
    */
    public static function bind(PDOStatement $stmt, EOrario $orario){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
		$stmt->bindValue(':giorno', $orario->getGiornoSettimana(), PDO::PARAM_STR);    //Potrebbe dare problemi
		$stmt->bindValue(':orarioApertura',$orario->getOrarioApertura(), PDO::PARAM_STR);
		$stmt->bindValue(':orarioChiusura',$orario->getOrarioChiusura(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di una Orario nel db
     * @param EOrario $orario Orario da salvare
     * @return void
     */
    public static function store(EOrario $orario){
        $db=FDB::getInstance();
        $db->store(static::getClass(), $orario);
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
           // $orario->setCodice($result['codicegiorno']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
                    $orario[] =new EOrario($result[$i]['giorno'],$result[$i]['orarioApertura'],$result[$i]['orarioChiusura']); //Carica un array di oggetti UOrario dal database
                    //$orario[$i]->setCodice($result[$i]['codicegiorno']);
                }
            }
        }
        return $orario;
    }

    /**
     * Permette la load dal database
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $orario
     */
    public static function loadByLocale($id){
        $orario = null;
        $db=FDB::getInstance();
        $result=$db->loadInfoLocale(static::getClass(),"Locale_Orari",$id);
        $rows_number = $result->rowCount();    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $orario=new EOrario($result['giorno'],$result['orarioApertura'],$result['orarioChiusura']); //Carica un Orario dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $orario[] =new EOrario($result[$i]['giorno'],$result[$i]['orarioApertura'],$result[$i]['orarioChiusura']); //Carica un array di oggetti UOrario dal database
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