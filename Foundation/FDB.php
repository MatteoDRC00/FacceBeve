<?php

/**
 * La classe FDB viene utilizzata per la gestione delle operazioni e la connessione con il database.
 * @author Gruppo8
 * @package Foundation
 */
class FDB
{

    /**
     * Oggetto PDO che permette la connessione al DBMS
     * @var PDO
     */
    private PDO $database;

    /**
     * Unica instanza della classe
     * @var FDB|null
     */
    private static ?FDB $_instance = null;

    /**
     * Costruttore della classe
     */
    private function __construct()
    {
        try {
            //global $config;
            //$this->database = new PDO ("mysql:dbname=".$config['database'].";host=localhost; charset=utf8;", $config['username'], $config['password']);
            $db_host = "localhost";
            $db_name = "my_faccebeve";
            $this->database = new PDO("mysql:host=$db_host;dbname=$db_name", "faccebeve", "");
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            die;
        }

    }


    /**
     * Metodo che instanzia un unico oggetto di questa classe richiamando il costruttore se non è stato già istanziato un oggetto
     * @return FDB
     */
    public static function getInstance(): FDB
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new FDB();
        }
        return self::$_instance;
    }

    /**
     * Metodo che permette di salvare informazioni contenute in un oggetto Entity sul database.
     * @param string $class
     * @param object $obj
     * @return false|string|null
     */
    public function store(string $class, object $obj)
    {
        try {
            $this->database->beginTransaction();
            $query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
            $stmt = $this->database->prepare($query); //Prepared Statement
            $class::bind($stmt, $obj);
            $stmt->execute();
            if ($class == "FAdmin" || $class == "FProprietario" || $class == "FUtente")
                $id = $obj->getUsername();
            elseif ($class == "FCategoria")
                $id = $obj->getGenere();
            else {
                $id = $this->database->lastInsertId();
            }
            $this->database->commit();
            $this->closeDbConnection();
            return $id;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo che permette di aggiornare il valore di un attributo nel DB passato come parametro
     * @param string $class
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public function update(string $class, string $attributo, string $newvalue, string $attributo_pk, string $value_pk)
    {
        try {
            $this->database->beginTransaction();
            $query = "UPDATE " . $class::getTable() . " SET " . $attributo . "='" . $newvalue . "' WHERE " . $attributo_pk . "='" . $value_pk . "';";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $this->database->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return false;
        }
    }

    /**
     * Metodo che ritorna tutti gli attributi di un'istanza dando come parametro di ricerca il valore di un attributopassato come parametro
     * @param $class
     * @param $attributo
     * @param $valore
     * @return bool|null
     */
    public function exist($class, $attributo, $valore)
    {
        try {
            $query = "SELECT * FROM " . $class::getTable() . " WHERE " . $attributo . "='" . $valore . "'";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->closeDbConnection();
            if (count($result) >= 1)
                return true;
            else
                return false;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Metodo utilizzato per controllare l'esistenza di una riga in tabelle esterne (per verificare l'esistenza di una relazione fra classi)
     * @param $class
     * @param $attributo1
     * @param $chiave1
     * @param $attributo2
     * @param $chiave2
     * @return bool|null
     */
    public function existEsterne($class, $attributo1, $chiave1, $attributo2, $chiave2)
    {
        try {
            $query = "SELECT * FROM " . $class . " WHERE " . $attributo1 . "='" . $chiave1 . "' AND " . $attributo2 . "='" . $chiave2 . "'";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $num = $stmt->rowCount();
            $this->closeDbConnection();
            if ($num >= 1)
                return true;
            else
                return false;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Funzione che viene utilizzata per far vedere ad un utente loggato gli eventi dei locali che segue
     * @param $class
     * @param $utente
     * @return array|null
     */
    public function loadEventiUtente($class, $utente): ?array
    {
        try {
            $query = "SELECT * FROM " . $class::getTable() . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=Evento.id INNER JOIN Utenti_Locali ON Utenti_Locali.ID_Locale=Locale_Eventi.ID_Locale WHERE Utenti_Locali.ID_Utente ='" . $utente . "';";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo utlizzato per aggiugnere una riga dalle tabelle esterne generate da relazioni N:N
     * @param string $table
     * @param string $field1
     * @param string $field2
     * @param string $fk1
     * @param string $fk2
     * @return bool|null
     */
    public function storeEsterne(string $table, string $field1, string $field2, string $fk1, string $fk2)
    {
        try {
            $this->database->beginTransaction();
            $query = "INSERT INTO " . $table . " (" . $field1 . "," . $field2 . ") VALUES ('" . $fk1 . "','" . $fk2 . "');";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $this->database->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo utlizzato per rimuovere righe dalle tabelle esterne generate da relazioni 1:N
     * @param string $table
     * @param string $field
     * @param string $fk
     * @return bool|null
     */
    public function deleteEsterne(string $table, string $field, string $fk)
    {
        try {
            $this->database->beginTransaction();
            $query = "DELETE FROM " . $table . " WHERE " . $field . " = " . $fk . ";";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $this->database->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo che carica le righe di una tabella in base al valore di un campo, utilizzato per le tabelle esterne generate da relazioni N:N
     * @param $table
     * @param $field
     * @param $id
     * @return array|null
     */
    public function loadByTable($table, $field, $id)
    {
        try {
            $query = "SELECT * FROM " . $table . " WHERE " . $field . "='" . $id . "';";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }


    /**
     * Metodo che restituisce una lista di oggetti caricati dal db
     * @param $class
     * @param $field
     * @param $id
     * @return array
     */
    public function load($class, $field, $id)
    {
        try {
            $query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return array(null, 0);
        }
    }

    /**
     * metodo che elimina un'istanza di una tabella dal DB
     * @param string $class
     * @param string $attributo
     * @param string $value
     * @return bool
     */
    public function delete(string $class, string $attributo, string $value)
    {
        try {
            $this->database->beginTransaction();
            $query = "DELETE FROM " . $class::getTable() . " WHERE " . $attributo . "='" . $value . "';";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $this->database->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
        }
        return false;
    }


    /**
     * Metodo utilizzato per rimuovere un locale tra i "preferiti" di un utente
     * @param $id_locale
     * @param $username
     * @return bool
     */
    public function deleteUtentiLocali($id_locale, $username)
    {
        try {
            $this->database->beginTransaction();
            $query = "DELETE FROM " . "Utenti_Locali" . " WHERE " . "ID_Utente" . "='" . $username . "' AND " . "ID_Locale" . "='" . $id_locale . "';";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $this->database->commit();
            $this->closeDbConnection();
            return true;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
        }
        return false;
    }

    /**
     * Metodo che verifica l'accesso di un utente , controllando che le credenziali (email e password) siano presenti nel db
     * @param $username
     * @param $pass
     * @param $class
     * @return array|mixed|null
     */
    public function loadVerificaAccesso($username, $pass, $class)
    {
        try {
            $query = "SELECT * FROM " . $class::getTable() . " WHERE username ='" . $username . "' AND password ='" . $pass . "';";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return $result;
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo che restituisce i locali che rispettano alcuni parametri di ricerca , passati come parametri alla funzione
     * @param $nome
     * @param $citta
     * @param $categorie
     * @return array|null
     */
    public function loadMultipleLocale($nome, $citta, $categorie): ?array
    {
        try {
            $query = "SELECT Locale.id, Locale.nome, Locale.numtelefono, Locale.descrizione, Locale.proprietario, Locale.localizzazione FROM Locale";
            $i = 0;
            if($categorie != "")
            	$query = $query . " INNER JOIN Locale_Categorie ON  Locale_Categorie.ID_Locale=Locale.id INNER JOIN Categoria ON Categoria.genere=Locale_Categorie.ID_Categoria ";
            if($citta != "")
            	$query = $query . " INNER JOIN Localizzazione ON  Localizzazione.id=Locale.localizzazione";
            $query = $query . " WHERE";
            if($categorie != ""){
            	$query = $query . " Categoria.genere ='" . $categorie . "'";
                $i++;
            }
            if($citta != ""){
            	if($i>0)
            		$query = $query . " AND Localizzazione.citta LIKE '" . $citta . "%'";
                else
                	$query = $query . " Localizzazione.citta LIKE '" . $citta . "%'";
               	$i++;
            }
            if($nome != ""){
            	if($i>0)
            		$query = $query . " AND Locale.nome LIKE '" . $nome . "%'";
                else
                	$query = $query . " Locale.nome LIKE '" . $nome . "%'";
            }
            $query = $query . ";";

            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo che restituisce gli eventi che rispettano alcuni parametri di ricerca ,passati come parametri alla funzione
     * @param $nomelocale
     * @param $nomeevento
     * @param $citta
     * @param $data
     * @return array|null
     */
    public function loadMultipleEvento($nomelocale, $nomeevento, $citta, $data)
    {
        try {
        	$query = "SELECT Evento.id,Evento.nome,Evento.descrizione,Evento.data,Evento.idImg FROM Evento";
            $i = 0;
            $scelto = false;
            if($nomelocale != ""){
            	$query = $query . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=Evento.id INNER JOIN Locale ON Locale_Eventi.ID_Locale=Locale.id";
            	$scelto = true;
            }
            if($citta != ""){
            	if($scelto)
               		$query = $query . " INNER JOIN Localizzazione ON  Localizzazione.id=Locale.localizzazione";
            	else
                	$query = $query . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=Evento.id INNER JOIN Locale ON Locale.id=Locale_Eventi.ID_Locale INNER JOIN Localizzazione ON  Localizzazione.id=Locale.localizzazione";
            }
            $query = $query . " WHERE";
            if($nomelocale != ""){
            	$query = $query . " Locale.nome LIKE '" . $nomelocale . "%'";
                $i++;
            }
            if($nomeevento != ""){
            	if($i>0)
            		$query = $query . " AND Evento.nome  LIKE '" . $nomeevento . "%'";
                else
                	$query = $query . " Evento.nome  LIKE '" . $nomeevento . "%'";
               	$i++;
            }
            if($citta != ""){
            	if($i>0)
            		$query = $query . " AND Localizzazione.citta LIKE '" . $citta . "%'";
                else
                	$query = $query . " Localizzazione.citta LIKE '" . $citta . "%'";
               	$i++;
            }
            if($data != ""){
            	if($i>0)
            		$query = $query . " AND Evento.data ='" . $data . "'";
                else
                	$query = $query . " Evento.data ='" . $data . "'";
            }
            $query = $query . ";";
            
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            //$this->closeDbConnection();
            return array($result, $num);

        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**
     * Metodo che restituisce l'id del locale dato l'id di un suo evento
     * @param $id_evento
     * @return int|null
     */
    public function loadLocaleByEvento($id_evento)
    {
        try {
            $query = "SELECT ID_Locale FROM Locale_Eventi WHERE ID_Evento='" . $id_evento . "';";
            $stmt = $this->database->prepare($query); //Prepared Statement
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } else {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } /*else {
				$result = array();                         //nel caso in cui piu' righe fossero interessate
				$stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
				while ($row = $stmt->fetch())
					$result[] = $row;                    //ritorna un array di righe.
			}*/
            return $result['ID_Locale'];
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
            return null;
        }
    }

    /**  Metodo che chiude la connesione con il db */
    public function closeDbConnection()
    {
        static::$_instance = null;
    }

    /**
     * Metodo che restituisce tutte le righe di una tabella/ tutti gli oggetti di una classe salvati sul db
     * @param $table
     * @return array|null
     */
    public function getAll($table): ?array
    {
        try {
            $query = "SELECT * FROM " . $table . ";";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;
            } elseif ($num == 1) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch())
                    $result[] = $row;
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->db->rollBack();
            return null;
        }
    }


    /**
     * Metodo che restituisce i 4 migliori locali presenti sul sito, valutazione che viene fatta sulla base delle recensioni a questi locali
     * @return array|void
     */
    public function getLocaliPerValutazione()
    {
        try {
            $query = "SELECT Locale.id,AVG(Recensione.voto) AS ValutazioneMedia FROM Locale INNER JOIN Recensione ON Locale.id = Recensione.locale GROUP BY Locale.id ORDER BY AVG(Recensione.voto) DESC LIMIT 4;";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num == 0) {
                $result = null;        //nessuna riga interessata. return null
            } elseif ($num == 1) {                          //nel caso in cui una sola riga fosse interessata
                $result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
            } else {
                $result = array();                         //nel caso in cui piu' righe fossero interessate
                $stmt->setFetchMode(PDO::FETCH_ASSOC);   //imposta la modalità di fetch come array associativo
                while ($row = $stmt->fetch())
                    $result[] = $row;                    //ritorna un array di righe.
            }
            return array($result, $num);
        } catch (PDOException $e) {
            echo "Attenzione errore: " . $e->getMessage();
            $this->database->rollBack();
        }


    }
    
}

?>
