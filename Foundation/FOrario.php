<?php

/**
 * La classe FOrario fornisce query per gli oggetti EOrario
 * @author Gruppo 8
 * @package Foundation
 */
class FOrario
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FOrario";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Orario";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:giorno,:OrarioApertura,:OrarioChiusura)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi dell'Orario da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EOrario $orario
     */
    public static function bind(PDOStatement $stmt, EOrario $orario)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':giorno', $orario->getGiornoSettimana(), PDO::PARAM_STR);
        $stmt->bindValue(':OrarioApertura', $orario->getOrarioApertura(), PDO::PARAM_STR);
        $stmt->bindValue(':OrarioChiusura', $orario->getOrarioChiusura(), PDO::PARAM_STR);
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
     * Metodo che permette il salvataggio di una Orario nel DB
     * @param EOrario $orario
     * @return string
     */
    public static function store(EOrario $orario)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $orario);
    }

    /**
     * Metodo che verifica l'esistenza di un Orario nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo dell'Orario sul DB data la chiave primaria
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
     * Metodo che elimina un Orario dal DB
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
     * Metodo che carica Orario dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $orario = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $orario[0] = new EOrario($result['giorno'], $result['OrarioApertura'], $result['OrarioChiusura']); //Carica un Orario dal database
            $orario[0]->setId($result['id']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $orario[$i] = new EOrario($result[$i]['giorno'], $result[$i]['OrarioApertura'], $result[$i]['OrarioChiusura']); //Carica un array di oggetti UOrario dal database
                    $orario[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $orario;
    }

    /**
     * Metodo che restituisce gli orari di un un locale
     * @param $id_locale
     * @return array
     */
    public static function loadByLocale($id_locale)
    {
        $orario = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadByTable("Locale_Orari", "ID_Locale", $id_locale);

        if (($result != null) && ($num == 1)) {
            $orario = self::loadByField("id", $result["ID_Orario"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $orario = array_merge($orario, self::loadByField("id", $result[$i]["ID_Orario"]));
                }
            }
        }
        return $orario;
    }
}

?>