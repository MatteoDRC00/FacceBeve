<?php
/**
 * La classe FAdmin fornisce query per gli oggetti EAdmin
 * @author Gruppo8
 * @package Foundation
 */
class FAdmin{

    /** classe Foundation */
    private static $class="FAdmin";

    /** tabella con la quale opera nel DB */
    private static $table="Admin";

    /** valori della tabella nel DB */
    private static $values="(:username,:email,:password)";

    /** costruttore*/
    public function __construct(){}

    /**
     * metodo che lega gli attributi dell'Admin da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAdmin $admin
     */
    public static function bind(PDOStatement $stmt, EAdmin $admin){
        $stmt->bindValue(':username', $admin->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $admin->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $admin->getPassword(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di un Admin nel db
     * @param EAdmin $admin Admin da salvare
     * @return string
     */
    public static function store(EAdmin $admin): string
    {
        $db = FDB::getInstance();
        return $db->store(self::getClass(), $admin);
    }

    /**
     * metodo che verifica l'esistenza di un Admin nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        return $db->exist(static::getClass(), $attributo, $valore);
    }

    /**
     * metodo che aggiorna il valore di un attributo dell'Admin sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDB::getInstance();
        return $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db = FDB::getInstance();
        return $db->delete(static::getClass(), $attributo, $valore);
    }


    /**
     * @param $field
     * @param $id
     * @return array
     */
    public static function loadByField($field, $id){
        $admin = array();
        $db = FDB::getInstance();
        list($result,$num) = $db->load(static::getClass(), $field, $id);
        if(($result!=null) && ($num == 1)) {
            $admin[0] = new EAdmin($result['username'], $result['email'], $result['password']);
        }
        else {
            if(($result!=null) && ($num > 1)){
                for($i=0; $i<count($result); $i++){
                    $admin[$i] = new EAdmin( $result[$i]['username'], $result[$i]['email'], $result[$i]['password']);
                }
            }
        }
        return $admin;
    }

    public static function verificaLogin($user, $pass) {
        $db = FDB::getInstance();
        $admin = $db->loadVerificaAccesso($user, $pass, static::getClass());
        if(!empty($admin))
            return self::loadByField("username", $admin["username"]);
        else
            return null;
    }

}