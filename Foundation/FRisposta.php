<?php

/**
 * La classe FRisposta fornisce query per gli oggetti ERisposta
 * @author Gruppo 8
 * @package Foundation
 */
class FRisposta
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FRisposta";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Risposta";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:descrizione,:proprietario,:recensione)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi della Risposta da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ERisposta $risposta
     */
    public static function bind(PDOStatement $stmt, ERisposta $risposta)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':descrizione', $risposta->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $risposta->getProprietario()->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':recensione', $risposta->getIdRecensione(), PDO::PARAM_INT);
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
     * Metodo che permette il salvataggio una Risposta nel DB
     * @param ERisposta $risposta
     * @return false|string|null
     */
    public static function store(ERisposta $risposta)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $risposta);
    }

    /**
     * Metodo che verifica l'esistenza di una Risposta nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo della Risposta sul DB data la chiave primaria
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
     * Metodo che elimina una Risposta dal DB dato il valore di un attributo
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
     * Permette la load di una risposta dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $risposta = null;
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $proprietario = FProprietario::loadByField("username", $result["proprietario"]);
            $risposta = new ERisposta($result['recensione'], $result['descrizione'], $proprietario);
            $risposta->setId($result['id']);
        } else {
            $risposte = array();
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $proprietario = FProprietario::loadByField("username", $result[$i]["proprietario"]);
                    $risposta[$i] = new ERisposta($result[$i]['recensione'], $result[$i]['descrizione'], $proprietario);
                    $risposta[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $risposta;
    }

}