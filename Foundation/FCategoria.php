<?php

/**
 * La classe FCategoria fornisce query per gli oggetti ECategoria
 * @author Gruppo 8
 * @package Foundation
 */
class FCategoria
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FCategoria";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Categoria";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:genere,:descrizione)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi della Categoria da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ECategoria $categoria
     * @return void
     */
    public static function bind(PDOStatement $stmt, ECategoria $categoria)
    {
        $stmt->bindValue(':genere', $categoria->getGenere(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $categoria->getDescrizione(), PDO::PARAM_STR);
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
     * Metodo che permette il salvataggio di una Categoria nel db
     * @param ECategoria $categoria
     * @return string
     */
    public static function store(ECategoria $categoria)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $categoria);
    }

    /**
     * Metodo che verifica l'esistenza di una Categoria nel DB dato un attributo
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
     * Metodo che aggiorna il valore di un attributo della Categoria sul DB data la chiave primaria
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
     * Metodo che elimina dal DB una Categoria sul DB dato il valore di un attributo
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
     * Metodo che carica Categoria dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $categoria = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $categoria[0] = new ECategoria($result['genere'], $result['descrizione']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $categoria[$i] = new ECategoria($result[$i]['genere'], $result[$i]['descrizione']);
                }
            }
        }
        return $categoria;
    }

    /**
     * Metodo che restituisce le categorie di uu locale
     * @param $id_locale
     * @return array
     */
    public static function loadByLocale($id_locale)
    {
        $categorie = array();
        $db = FDB::getInstance();

        list($result, $num) = $db->loadByTable("Locale_Categorie", "Id_Locale", $id_locale);

        if (($result != null) && ($num == 1)) {
            $categorie = self::loadByField("genere", $result['ID_Categoria']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $categorie = array_merge($categorie, self::loadByField("genere", $result[$i]['ID_Categoria']));
                }
            }
        }
        return $categorie;
    }


    /**
     * Metodo che restituisce tutte le categorie sul DB
     * @return array
     */
    public static function loadAllCategorie()
    {
        $categoria = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->getAll("categoria");
        if (($result != null) && ($num == 1)) {
            $categoria[0] = new ECategoria($result['genere'], $result['descrizione']);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $categoria[$i] = new ECategoria($result[$i]['genere'], $result[$i]['descrizione']);
                }
            }
        }
        return $categoria;
    }

}

?>