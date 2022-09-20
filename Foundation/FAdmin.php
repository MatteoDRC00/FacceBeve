<?php

/**
 * La classe FAdmin fornisce query per gli oggetti EAdmin
 * @author Gruppo8
 * @package Foundation
 */
class FAdmin
{

    /**
     * Classe Foundation
     *
     */
    private static $class = "FAdmin";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Admin";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:username,:email,:password)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi dell'Admin da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EAdmin $admin
     */
    public static function bind(PDOStatement $stmt, EAdmin $admin)
    {
        $stmt->bindValue(':username', $admin->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $admin->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $admin->getPassword(), PDO::PARAM_STR);
    }


    /**
     * Metodo che restituisce il nome della classe per la costruzione delle query
     * @return string
     */
    public static function getClass()
    {
        return self::$class;
    }

    /**
     * Metodo che restituisce il nome della tabella per la costruzione delle query
     * @return string
     */
    public static function getTable()
    {
        return self::$table;
    }

    /**
     * Metodo che restituisce l'insieme dei valori per la costruzione delle query
     * @return string
     */
    public static function getValues()
    {
        return self::$values;
    }

    /**
     * Metodo che permette il salvataggio di un Admin nel db
     * @param EAdmin $admin Admin da salvare
     * @return string
     */
    public static function store(EAdmin $admin): string
    {
        $db = FDB::getInstance();
        return $db->store(self::getClass(), $admin);
    }

    /**
     * Metodo che verifica l'esistenza di un Admin nel DB dato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo, string $valore)
    {
        $db = FDB::getInstance();
        return $db->exist(static::getClass(), $attributo, $valore);
    }

    /**
     * Metodo che aggiorna il valore di un attributo dell'Admin sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk)
    {
        $db = FDB::getInstance();
        return $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * Metodo che elimina dal DB un Admin sul DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore)
    {
        $db = FDB::getInstance();
        return $db->delete(static::getClass(), $attributo, $valore);
    }


    /**
     * Metodo che carica Admin dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $admin = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $admin = new EAdmin($result['username'], $result['email'], $result['password']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $admin[$i] = new EAdmin($result[$i]['username'], $result[$i]['email'], $result[$i]['password']);
                }
            }
        }
        return $admin;
    }

    /**
     * Metodo che verifica se esiste un Admin date le credenziali
     * @param string $username
     * @param string $password
     * @return array|EAdmin|null
     */
    public static function verificaLogin(string $username, string $password)
    {
        $db = FDB::getInstance();
        $admin = $db->loadVerificaAccesso($username, $password, static::getClass());
        if (!empty($admin))
            return self::loadByField("username", $admin["username"]);
        else
            return null;
    }

}