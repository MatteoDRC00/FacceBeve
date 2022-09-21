<?php

/**
 * La classe FLocalizzazione fornisce query per gli oggetti ELocalizzazione
 * @author Gruppo 8
 * @package Foundation
 */
class FLocalizzazione {

    /**
     * Classe Foundation
     * @var string
     */
    private static $class="FLocalizzazione";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table="Localizzazione";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values="(:id,:indirizzo,:numCivico,:citta, :CAP)";

    /**
     * Costruttore della classe
     */
    public function __construct(){
    }

    /**
    * Metodo che lega gli attributi della Localizzazione da inserire con i parametri della INSERT
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
    * Metodo che restituisce il nome della classe per la costruzione delle query
    * @return string
    */
    public static function getClass(){
        return self::$class;
    }

    /**
    * Metodo che restituisce il nome della tabella per la costruzione delle query
    * @return string
    */
    public static function getTable(){
        return self::$table;
    }

    /**
    * Metodo che restituisce l'insieme dei valori per la costruzione delle uery
    * @return string
    */
    public static function getValues(){
        return self::$values;
    }

    /**
     * Metodo che permette il salvataggio di una Localizzazione nel db
     * @param ELocalizzazione $localizzazione
     * @return false|string|null
     */
    public static function store(ELocalizzazione $localizzazione){
        $db = FDB::getInstance();
        return $db->store(static::getClass() ,$localizzazione);
    }

    /**
     * Metodo che verifica l'esistenza di una Localizzazione nel DB dato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        return $db->exist(static::getClass(), $attributo, $valore);
    }

    /**
     * Metodo che aggiorna il valore di un attributo della Localizzazione sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk): bool
    {
        $db=FDB::getInstance();
        return $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * Metodo che elimina una Localizzazione dal DB dato il valore di un attibuto
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db = FDB::getInstance();
        return $db->delete(static::getClass(), $attributo, $valore);
    }


    /**
     * Metodo che carica Localizzazione dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore){
        $localizzazione = null;
        $db = FDB::getInstance();
        list($result,$num) = $db->load(static::getClass(), $attributo, $valore);
        if(($result!=null) && ($num == 1)) {
            $localizzazione = new ELocalizzazione($result['indirizzo'],$result['numCivico'],$result['citta'], $result['CAP']); //Carica un Luogo dal database
            $localizzazione->setId($result['id']);
        }
        else {
            if(($result!=null) && ($num > 1)){
                $localizzazione = array();
        	    for($i=0; $i<count($result); $i++){
                    $luogo[$i] = new ELocalizzazione($result[$i]['indirizzo'], $result[$i]['numCivico'], $result[$i]['citta'], $result[$i]['CAP']); //Carica un array di oggetti Localizzazione dal database
                    $luogo[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $localizzazione;
    }

}

?>