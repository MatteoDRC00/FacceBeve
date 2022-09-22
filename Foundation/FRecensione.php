<?php

/**
 * La classe FRecensione fornisce query per gli oggetti ERecensione
 * @author Gruppo 8
 * @package Foundation
 */
class FRecensione
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FRecensione";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Recensione";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:titolo,:descrizione,:voto,:data,:segnalato,:utente,:locale)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi della Recensione da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ERecensione $recensione
     */
    public static function bind(PDOStatement $stmt, ERecensione $recensione)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':titolo', $recensione->getTitolo(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $recensione->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':voto', $recensione->getVoto(), PDO::PARAM_INT);
        $stmt->bindValue(':data', $recensione->getData(), PDO::PARAM_STR);
        $stmt->bindValue(':segnalato', $recensione->isSegnalata(), PDO::PARAM_BOOL);
        $stmt->bindValue(':utente', $recensione->getUtente()->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':locale', $recensione->getLocale()->getId(), PDO::PARAM_INT);
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
     * Metodo che permette il salvataggio una Recensione nel db
     * @param ERecensione $recensione
     * @return false|string|null
     */
    public static function store(ERecensione $recensione)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $recensione);
    }

    /**
     * Metodo che verifica l'esistenza di una Recensione nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo della Recensione sul DB data la chiave primaria
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
     * Metodo che elimina una Recensione dal DB
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
     * Metodo che restituisce Recensione dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $db = FDB::getInstance();
        $recensione = array();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $utente = FUtente::loadByField("username", $result['utente']);
            $locale[0] = FLocale::loadByField("id", $result['locale']);
            $recensione[0] = new ERecensione($utente, $result['titolo'], $result['descrizione'], $result['voto'], $result['data'], $locale[0]);
            $recensione[0]->setId($result['id']);
            $recensione[0]->setSegnala($result['segnalato']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $utente = FUtente::loadByField("username", $result[$i]['utente']);
                    $locale = FLocale::loadByField("id", $result[$i]['locale']);
                    $recensione[$i] = new ERecensione($utente, $result[$i]['titolo'], $result[$i]['descrizione'], $result[$i]['voto'], $result[$i]['data'], $locale[0]);
                    $recensione[$i]->setId($result[$i]['id']);
                    $recensione[$i]->setSegnala($result[$i]['segnalato']);
                }
            }
        }
        return $recensione;
    }


}