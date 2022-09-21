<?php

/**
 * La classe FEvento fornisce query per gli oggetti EEvento
 * @author Gruppo8
 * @package Foundation
 */
class FEvento
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FEvento";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Evento";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:nome,:descrizione,:data,:idImg)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi dell'Evento da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EEvento $evento
     * @return void
     */
    public static function bind(PDOStatement $stmt, EEvento $evento)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $evento->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $evento->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':data', $evento->getData());
        if ($evento->getImg() != null)
            $stmt->bindValue(':idImg', $evento->getImg()->getId());
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
     * Metodo che aggiunge un Evento nel DB
     * @param EEvento $evento
     * @return false|string|null
     */
    public static function store(EEvento $evento)
    {
        $db = FDB::getInstance();
        return $db->store(self::getClass(), $evento);
    }

    /**
     * Metodo che verifica l'esistenza di un Evento nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo dell'Evento sul DB data la chiave primaria
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
     * Metodo che elimina un Evento dal DB dato il valore di un attibuto
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
     * Metodo che carica Evento dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $evento = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $immagine = FImmagine::loadByField("id", $result['idImg']);
            $evento[0] = new EEvento($result['nome'], $result['descrizione'], $result['data']); //Carica un evento dal database
            $evento[0]->setImg($immagine);
            $evento[0]->setId($result['id']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $immagine = FImmagine::loadByField("id", $result[$i]['idImg']);
                    $evento[$i] = new EEvento($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['data']); //Carica un array di oggetti Evento dal database
                    $evento[$i]->setImg($immagine);
                    $evento[$i]->setId($result['id']);
                }
            }
        }
        return $evento;
    }

    /**
     * Metodo che restituisce gli eventi organizzati da un locale
     * @param $id_locale
     * @return array
     */
    public static function loadByLocale($id_locale)
    {
        $eventi = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadByTable("Locale_Eventi", "ID_Locale", $id_locale);

        if (($result != null) && ($num == 1)) {
            $eventi = self::loadByField("id", $result["ID_Evento"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $eventi = array_merge($eventi, self::loadByField("id", $result[$i]["ID_Evento"]));
                }
            }
        }
        return $eventi;
    }


    /**
     * Metodo che permette di caricare un evento che ha determinati parametri, i quali vengono passati in input da una form
     * @param $part1
     * @param $part2
     * @param $part3
     * @param $part4
     * @return array[]
     */
    public static function loadByForm($part1, $part2, $part3, $part4)
    {
        $evento = array();
        $locale = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadMultipleEvento($part1, $part2, $part3, $part4);
        if (($result != null) && ($num == 1)) {
            $id_locale = $db->loadLocaleByEvento($result["id"]);
            $locale[0] = FLocale::loadByField("id", $id_locale);
            $evento[0] = new EEvento($result["nome"], $result["descrizione"], $result["data"]);
            $evento[0]->setImg(FImmagine::loadByField('id', $result['idImg']));
            $evento[0]->setId($result["id"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $id_locale = $db->loadLocaleByEvento($result["id"]);
                    $locale[$i] = FLocale::loadByField("id", $id_locale);
                    $evento[$i] = new EEvento($result[$i]["nome"], $result[$i]["descrizione"], $result[$i]["data"]);
                    $evento[$i]->setImg(FImmagine::loadByField('id', $result[$i]['idImg']));
                    $evento[$i]->setId($result[$i]["id"]);
                }
            }
        }
        return array($evento, $locale);
    }

}