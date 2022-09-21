<?php

/**
 * La classe FProprietario fornisce query per gli oggetti EProprietario
 * @author Gruppo 8
 * @package Foundation
 */
class FProprietario
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FProprietario";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Proprietario";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:username,:nome,:cognome,:email,:password,:idImg)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi del Proprietario da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EProprietario $proprietario
     */
    public static function bind(PDOStatement $stmt, EProprietario $proprietario)
    {
        $stmt->bindValue(':username', $proprietario->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':nome', $proprietario->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':cognome', $proprietario->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $proprietario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($proprietario->getPassword()), PDO::PARAM_STR);
        if ($proprietario->getImgProfilo() != null)
            $stmt->bindValue(':idImg', $proprietario->getImgProfilo()->getId());
        else
            $stmt->bindValue(':idImg', null);

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
     * Metodo che permette il salvataggio di un Proprietario nel DB
     * @param EProprietario $proprietario
     * @return false|string|null
     */
    public static function store(EProprietario $proprietario)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $proprietario);
    }

    /**
     * Metodo che verifica l'esistenza di un Proprietario nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo del Proprietario sul DB data la chiave primaria
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
     * Metodo che elimina un Proprietario dal DB
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
     * Metodo che carica Proprietario dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array|EProprietario
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $proprietario = null;
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $proprietario = new EProprietario($result['nome'], $result['cognome'], $result['email'], $result['username'], $result['password']); //Carica un Proprietario dal database
            $img_profilo[0] = FImmagine::loadByField('id', $result['idImg']);
            $proprietario->setImgProfilo($img_profilo);
        } else {
            if (($result != null) && ($num > 1)) {
                $proprietario = array();
                for ($i = 0; $i < count($result); $i++) {
                    $proprietario[$i] = new EProprietario($result[$i]['nome'], $result[$i]['cognome'], $result[$i]['email'], $result[$i]['username'], $result[$i]['password']); //Carica un array di oggetti Proprietario dal database
                    $img_profilo[0] = FImmagine::loadByField('id', $result[$i]['idImg']);
                    $proprietario[$i]->setImgProfilo($img_profilo);
                }
            }
        }
        return $proprietario;
    }

    /**
     * Metodo che restituisce la lista di tutti i proprietari
     * @return array
     */
    public static function loadAllProprietari()
    {
        $proprietario = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->getAll("Proprietario");
        if (($result != null) && ($num == 1)) {
            $proprietario[0] = new EProprietario($result['nome'], $result['cognome'], $result['email'], $result['username'], $result['password']); //Carica un Proprietario dal database
            $img_profilo[0] = FImmagine::loadByField('id', $result['idImg']);
            $proprietario[0]->setImgProfilo($img_profilo);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $proprietario[$i] = new EProprietario($result[$i]['nome'], $result[$i]['cognome'], $result[$i]['email'], $result[$i]['username'], $result[$i]['password']); //Carica un array di oggetti Proprietario dal database
                    $img_profilo[0] = FImmagine::loadByField('id', $result[$i]['idImg']);
                    $proprietario[$i]->setImgProfilo($img_profilo);
                }
            }
        }
        return $proprietario;
    }


    /**
     * Metodo che verifica se esiste un Proprietario date le credenziali
     * @param $user
     * @param $pass
     * @return array|EProprietario|null
     */
    public static function verificaLogin($user, $pass)
    {
        $db = FDB::getInstance();
        $proprietario = $db->loadVerificaAccesso($user, $pass, static::getClass());
        if (!empty($proprietario))
            return self::loadByField("username", $proprietario["username"]);
        else
            return null;
    }

}

?>