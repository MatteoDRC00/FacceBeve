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
    private static $table="orario";

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
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT);
		$stmt->bindValue(':giorno', $orario->getGiornoSettimana());
		$stmt->bindValue(':orarioApertura',$orario->getOrarioApertura());
		$stmt->bindValue(':orarioChiusura',$orario->getOrarioChiusura());
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
     * @return string
     */
    public static function store(EOrario $orario){
        $db = FDB::getInstance();
        $id = $db->store(static::getClass(), $orario);
        //$orario->setId($id);
        echo $id;
        return $id;
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
     * metodo che verifica l'esistenza di un Orario nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo dell'Orario sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDB::getInstance();
        $result = $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
        if($result)
            return true;
        else
            return false;
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db=FDB::getInstance();
        $result = $db->delete(static::getClass(), $attributo, $valore);
        if($result)
            return true;
        else
            return false;
    }

}

?>