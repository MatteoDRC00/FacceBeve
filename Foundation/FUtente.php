<?php

require_once 'autoload.php';

/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */
class FUtente
{

    /**
     * Classe Foundation
     * @var string
     */
    private static $class = "FUtente";

    /**
     * Tabella con la quale opera nel DB
     * @var string
     */
    private static $table = "utente";

    /**
     * Valori della tabella nel DB
     * @var string
     */
    private static $values = "(:username,:nome,:cognome,:email,:password,:dataIscrizione,:idImg,:state)";

    /**
     * Costruttore della classe
     */
    public function __construct()
    {
    }

    /**
     * Metodo che lega gli attributi dell'Utente da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EUtente $utente
     */
    public static function bind(PDOStatement $stmt, EUtente $utente)
    {
        $stmt->bindValue(':username', $utente->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':nome', $utente->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':cognome', $utente->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $utente->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($utente->getPassword()), PDO::PARAM_STR);
        if ($utente->getImgProfilo() != null)
            $stmt->bindValue(':idImg', $utente->getImgProfilo()->getId());
        else
            $stmt->bindValue(':idImg', null);
        $stmt->bindValue(':dataIscrizione', $utente->getIscrizione());
        $stmt->bindValue(':state', $utente->getState(), PDO::PARAM_BOOL);

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
     * Metodo che permette il salvataggio una Utente nel db
     * @param EUtente $utente
     * @return string
     */
    public static function store(EUtente $utente)
    {
        $db = FDB::getInstance();
        return $db->store(static::getClass(), $utente);
    }

    /**
     * Metodo che verifica l'esistenza di un Utente nel DB dato un attributo
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
     * metodo che aggiorna il valore di un attributo dell'Utente sul DB data la chiave primaria
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
     * Metodo che elimina un Utente dal DB dato il valore di un attributo
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
     * Metodo che carica Utente dal DB dato il valore di un attributo
     * @param string $attributo
     * @param string $valore
     * @return array|EUtente|null
     */
    public static function loadByField(string $attributo, string $valore)
    {
        $utente = null;
        $db = FDB::getInstance();
        list($result, $num) = $db->load(static::getClass(), $attributo, $valore);
        if (($result != null) && ($num == 1)) {
            $utente = new EUtente($result['password'], $result['nome'], $result['cognome'], $result['username'], $result['email']);
            $utente->setIscrizione($result['dataIscrizione']);
            if ($result['idImg'] != null){
                $img_profilo = FImmagine::loadByField('id', $result['idImg']);
                $utente->setImgProfilo($img_profilo[0]);
            }
            $utente->setState($result['state']);
        } else {
            if (($result != null) && ($num > 1)) {
                $utente = array();
                for ($i = 0; $i < count($result); $i++) {
                    $utente[$i] = new EUtente($result[$i]['password'], $result[$i]['nome'], $result[$i]['cognome'], $result[$i]['username'], $result[$i]['email']);
                    $utente[$i]->setIscrizione($result[$i]['dataIscrizione']);
                    if($result[$i]['idImg'] != null){
                        $img_profilo = FImmagine::loadByField('id', $result[$i]['idImg']);
                        $utente[$i]->setImgProfilo($img_profilo[0]);
                    }
                    $utente[$i]->setState($result[$i]['state']);
                }
            }
        }
        return $utente;
    }

    /**
     * Metodo che verifica se esiste un Proprietario date le credenziali
     * @param $user
     * @param $pass
     * @return array|EUtente|null
     */
    public static function verificaLogin($user, $pass)
    {
        $db = FDB::getInstance();
        $utente = $db->loadVerificaAccesso($user, $pass, static::getClass());

        if (!empty($utente))
            return self::loadByField("username", $utente["username"]);
        else
            return null;

    }


    //da eliminare e sostituire dove viene richiamato con la load by field
    /**
     * @param int $state
     * @return array|EUtente
     */
    public static function loadUtentiByState(int $state)
    {
        $utente = null;
        $db = FDB::getInstance();
        list ($result, $num) = $db->getUtentiByState($state);
        if (($result != null) && ($num == 1)) {
            $utente = new EUtente($result['password'], $result['nome'], $result['cognome'], $result['username'], $result['email']);
            $utente->setIscrizione($result['dataIscrizione']);
            $utente->setImgProfilo(FImmagine::loadByField('id', $result['idImg'])[0]);
            $utente->setState($state);
        } else {
            if (($result != null) && ($num > 1)) {
                $utente = array();
                for ($i = 0; $i < count($result); $i++) {
                    $utente[$i] = new EUtente($result[$i]['password'], $result[$i]['nome'], $result[$i]['cognome'], $result[$i]['username'], $result[$i]['email']);
                    $utente[$i]->setIscrizione($result[$i]['dataIscrizione']);
                    $utente[$i]->setImgProfilo(FImmagine::loadByField('id', $result[$i]['idImg'])[0]);
                    $utente[$i]->setState($state);
                }
            }
        }
        return $utente;
    }


}

?>