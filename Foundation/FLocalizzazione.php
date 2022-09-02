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
    private static $values="(:id,:indirizzo,:numCivico,:citta, :CAP)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi della Localizzazione da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param ELocalizzazione $localizzazione
    */
    public static function bind(PDOStatement $stmt, ELocalizzazione $localizzazione){
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':indirizzo', $localizzazione->getIndirizzo(), PDO::PARAM_STR); 
		$stmt->bindValue(':numCivico',$localizzazione->getNumCivico(), PDO::PARAM_STR);
		$stmt->bindValue(':citta',$localizzazione->getCitta(), PDO::PARAM_STR);
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
        $id = $db->store(static::getClass() ,$localizzazione);
        //$localizzazione->setId($id);
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
		    $luogo=new ELocalizzazione($result['indirizzo'],$result['numCivico'],$result['citta'], $result['CAP']); //Carica un Luogo dal database
            $luogo->setCodice($result['codiceluogo']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $luogo = array();
        	    for($i=0; $i<count($result); $i++){
                    $luogo[]=new ELocalizzazione($result[$i]['indirizzo'], $result[$i]['numCivico'], $result[$i]['citta'], $result[$i]['CAP']); //Carica un array di oggetti Localizzazione dal database
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
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo della Localizzazione sul DB data la chiave primaria
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