<?php

/**
 * La classe FImmagine fornisce query per gli oggetti EImmagine (foto)
 * @author Gruppo 8
 * @package Foundation
 */
class FImmagine
{
    /**
     * Classe Foundation
     * @var string
     */
    private static string $class = "FImmagine";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Immagine";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:nome,:size,:type,:immagine)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi dell'oggetto multimediale da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EImmagine $img media i cui dati devono essere inseriti nel DB
     */
    public static function bind(PDOStatement $stmt, EImmagine $img)
    {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT); //l'id � posto a NULL poich� viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome', $img->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':size', $img->getSize(), PDO::PARAM_INT);
        $stmt->bindValue(':type', $img->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':immagine', base64_encode($img->getImmagine()), PDO::PARAM_LOB);
    }

    /**
     * Metodo che restituisce il nome della classe per la costruzione delle Query
     * @return string
     */
    public static function getClass()
    {
        return self::$class;
    }

    /**
     *
     * Metodo che restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string
     */
    public static function getTable()
    {
        return static::$table;
    }

    /**
     * Metodo che restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string
     */
    public static function getValues()
    {
        return static::$values;
    }

    /**
     * Metodo che aggiunge una Immagine nel DB
     * @param EImmagine $immagine
     * @return int
     */
    public static function store(EImmagine $immagine): int
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $immagine);
    }

    /**
     * Metodo che aggiorna il valore di un attributo dell'Immagine sul DB data la chiave primaria
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
     * Metodo che elimina una Immagine dal DB dato il valore di un attibuto
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
     * Metodo che carica Immagine dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $img = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $img[0] = new EImmagine($result['nome'], $result['size'], $result['type'], $result['immagine']);
            $img[0]->setId($result['id']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $img[$i] = new EImmagine($result[$i]['nome'], $result[$i]['size'], $result[$i]['type'], $result[$i]['immagine']);
                    $img[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $img;
    }

    /**
     * Metodo che restituisce le Immagini di un locale
     * @param $id_locale
     * @return array
     */
    public static function loadByLocale($id_locale)
    {
        $img = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadByTable("Locale_Immagini", "ID_Locale", $id_locale);

        if (($result != null) && ($num == 1)) {
            $img = self::loadByField("id", $result["ID_Immagine"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $img = array_merge($img, self::loadByField("id", $result["ID_Immagine"]));
                }
            }
        }
        return $img;
    }

}

?>

