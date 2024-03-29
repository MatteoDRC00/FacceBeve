<?php

/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */
class FLocale
{
    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FLocale";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "Locale";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:id,:nome,:numtelefono,:descrizione,:proprietario,:localizzazione)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi del Locale da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ELocale $locale
     * @return void
     */
    public static function bind(PDOStatement $stmt, ELocale $locale)
    {
        $stmt->bindValue(':id', NULL); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome', $locale->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':numtelefono', $locale->getNumTelefono(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $locale->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $locale->getProprietario()->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':localizzazione', $locale->getLocalizzazione()->getId(), PDO::PARAM_INT);
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
     * Metodo che permette il salvataggio di un Locale nel DB
     * @param ELocale
     * @return string
     */
    public static function store(ELocale $locale)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $locale);
    }

    /**
     * Metodo che verifica l'esistenza di un Locale nel DB dato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo, string $valore): bool
    {
        $db = FDB::getInstance();
        return $db->exist(static::getClass(), $attributo, $valore);
    }

    /**
     * Metodo che aggiorna il valore di un attributo del Locale sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk): bool
    {
        $db = FDB::getInstance();
        return $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * Metodo che elimina un Locale dal DB dato il valore di un attibuto
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore): bool
    {
        $db = FDB::getInstance();
        return $db->delete(static::getClass(), $attributo, $valore);
    }

    /**
     * Metodo che carica Locale dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array
     */
    public static function loadByField(string $attributo, string $valore): array
    {
        $locale = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $proprietario = FProprietario::loadByField("username", $result["proprietario"]);
            $categorie = FCategoria::loadByLocale($result["id"]);
            $localizzazione = FLocalizzazione::loadByField("id", $result["localizzazione"]);
            $eventi = FEvento::loadByLocale($result["id"]);
            $orari = FOrario::loadByLocale($result["id"]);
            $immagini = FImmagine::loadByLocale($result["id"]);
            $locale[0] = new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario, $localizzazione);
            $locale[0]->setImg($immagini);
            $locale[0]->setCategoria($categorie);
            $locale[0]->setEventiOrganizzati($eventi);
            $locale[0]->setOrario($orari);
            $locale[0]->setId($result["id"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $proprietario = FProprietario::loadByField("username", $result[$i]["proprietario"]);
                    $localizzazione = FLocalizzazione::loadByField("id", $result[$i]["localizzazione"]);
                    $categorie = FCategoria::loadByLocale($result[$i]["id"]);
                    $eventi = FEvento::loadByLocale($result[$i]["id"]);
                    $orari = FOrario::loadByLocale($result[$i]["id"]);
                    $immagine = FImmagine::loadByLocale($result[$i]["id"]);
                    $locale[$i] = new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $proprietario, $localizzazione);
                    $locale[$i]->setImg($immagine);
                    $locale[$i]->setCategoria($categorie);
                    $locale[$i]->setEventiOrganizzati($eventi);
                    $locale[$i]->setOrario($orari);
                    $locale[$i]->setId($result[$i]["id"]);
                }
            }
        }
        return $locale;
    }

    /**
     * Metodo che permette di caricare uno o più eventi con determinati parametri, i quali vengono passati in input da una form
     * @param $part1  string nome del locale
     * @param $part2  categoria del locale
     * @param $part3 string citta' del locale
     * @return array[]
     */
    public static function loadByForm(string $part1, $part2, string $part3): array
    {
        $locale = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadMultipleLocale($part1, $part2, $part3);
        if (($result != null) && ($num == 1)) {
            $proprietario = FProprietario::loadByField("username", $result["proprietario"]);
            $categorie = FCategoria::loadByLocale($result["id"]);
            $localizzazione = FLocalizzazione::loadByField("id", $result["localizzazione"]);
            $eventi[] = FEvento::loadByLocale($result["id"]);
            $orari[] = FOrario::loadByLocale($result["id"]);
            $immagini = FImmagine::loadByLocale($result["id"]);
            $locale[0] = new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario, $localizzazione);
            $locale[0]->setImg($immagini);
            $locale[0]->setCategoria($categorie);
            $locale[0]->setEventiOrganizzati($eventi[0]);
            $locale[0]->setOrario($orari);
            $locale[0]->setId($result["id"]);
        } else {
            if (($result != null) && ($num > 1)) {
                $locale = array();
                $categorie = array();
                $eventi = array();
                $orari = array();
                for ($i = 0; $i < count($result); $i++) {
                    $proprietario = FProprietario::loadByField("username", $result[$i]["proprietario"]);
                    $localizzazione = FLocalizzazione::loadByField("id", $result[$i]["localizzazione"]);
                    $categorie = FCategoria::loadByLocale($result[$i]["id"]);
                    $eventi[] = FEvento::loadByLocale($result[$i]["id"]);
                    $orari[] = FOrario::loadByLocale($result[$i]["id"]);
                    $immagine = FImmagine::loadByLocale($result[$i]["id"]);
                    $locale[$i] = new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $proprietario, $localizzazione);
                    $locale[$i]->setImg($immagine);
                    $locale[$i]->setCategoria($categorie);
                    $locale[$i]->setEventiOrganizzati($eventi[0]);
                    $locale[$i]->setOrario($orari[$i]);
                    $locale[$i]->setId($result[$i]["id"]);
                }
            }
        }
        return $locale;
    }

    /**
     * Metodo che restituisce i locali in ordine di valutazione media
     * @return array
     */
    public static function getTopLocali()
    {
        $locali = array();
        $valutazione = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->getLocaliPerValutazione();
        if (($result != null) && ($num == 1)) {
            $locali = self::loadByField("id", $result["id"]);
            $valutazione[0] = round($result["ValutazioneMedia"], 2);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $locali = array_merge($locali, self::loadByField("id", $result[$i]["id"]));
                    $valutazione[$i] = round($result[$i]["ValutazioneMedia"], 2);
                }
            }
        }
        return array($locali, $valutazione);
    }

    /**
     * Metodo utilizzato per caricare i locali "preferiti" di un utente
     * @param string $username
     * @return array
     */
    public static function loadByUsername(string $username): array
    {
        $locali = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->loadByTable("Utenti_Locali", "ID_Utente", $username);
        if (($result != null) && ($num == 1)) {
            $locali = self::loadByField("id", $result["ID_Locale"]);
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                    $locali = array_merge($locali, self::loadByField("id", $result[$i]["ID_Locale"]));
                }
            }
        }
        return $locali;
    }
    
    /**
     * Metodo che restituisce la lista di tutti i locali
     * @return array
     */
    public static function loadAll(): array
    {
        $locali = array();
        $db = FDB::getInstance();
        list($result, $num) = $db->getAll("Locale");
        if (($result != null) && ($num == 1)) {
        	$proprietario = FProprietario::loadByField('username', $result['proprietario']);
            $localizzazione = FLocalizzazione::loadByField('id', $result['localizzazione']);
            $l = new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario, $localizzazione); //Carica un Proprietario dal database
            $l->setId($result['id']);
            $locali[0] = $l;
        } else {
            if (($result != null) && ($num > 1)) {
                for ($i = 0; $i < count($result); $i++) {
                	$proprietario = FProprietario::loadByField('username', $result[$i]['proprietario']);
                    $localizzazione = FLocalizzazione::loadByField('id', $result[$i]['localizzazione']);
                    $locali[$i] = new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $proprietario, $localizzazione); //Carica un Proprietario dal database
                    $locali[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $locali;
    }


}

?>

