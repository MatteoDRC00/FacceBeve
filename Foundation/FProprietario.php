<?php

/**
 * La classe FProprietario fornisce query per gli oggetti EProprietario
 * @author Gruppo 8
 * @package Foundation
 */
class FProprietario{

    /** classe Foundation */
    private static $class="FProprietario";

	/** tabella con la quale opera nel DB */
    private static $table="Proprietario";

    /** valori della tabella nel DB */
    private static $values="(:username,:nome,:cognome,:email,:password)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi del Proprietario da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EProprietario $proprietario
    */
    public static function bind(PDOStatement $stmt, EProprietario $proprietario){
        $stmt->bindValue(':username', $proprietario->getUsername(), PDO::PARAM_STR);
		$stmt->bindValue(':nome',$proprietario->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':cognome',$proprietario->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $proprietario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $proprietario->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':idImg', $proprietario->getImgProfilo()->getId(), PDO::PARAM_INT);
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
     * @param EProprietario $proprietario
     * @return false|string|null
     */
    public static function store(EProprietario $proprietario){
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $proprietario);
    }


    /**
    * Permette la load sul database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $utente Utente
    */
    public static function loadByField($field, $id){
        $db = FDB::getInstance();
        $result = $db->load(static::getClass(), $field, $id);
        $rows_number = $db->getNumRighe(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $proprietario=new EProprietario($result['nome'],$result['cognome'], $result['email'], $result['username'], $result['password']); //Carica un Proprietario dal database
            $proprietario->setImgProfilo(FImmagine::loadByField('id', $result['idImg']));
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $proprietario = array();
        	    for($i=0; $i<count($result); $i++){
                    $proprietario[$i]=new EProprietario($result[$i]['username'],$result[$i]['nome'],$result[$i]['cognome'], $result[$i]['email'], $result[$i]['password']); //Carica un array di oggetti Proprietario dal database
                    $proprietario[$i]->setImgProfilo(FImmagine::loadByField('id', $result['idImg']));
                }
            }
        }
        return $proprietario;
    }

    /**
     * metodo che verifica l'esistenza di un Proprietario nel DB considerato un attributo
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
     * metodo che aggiorna il valore di un attributo del Proprietario sul DB data la chiave primaria
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

    public static function verificaLogin($user, $pass) {
        $db = FDB::getInstance();
        return  $db->loadVerificaAccesso($user, $pass, static::getClass());
    }

}

?>