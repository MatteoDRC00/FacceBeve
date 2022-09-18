<?php

//if(file_exists('config.php')) require_once 'config.php';

class FDB{

	/** Oggetto PDO che permette la connessione al DBMS
	 * 	@var PDO
	 */
	private PDO $database;

	/**	Unica instanza della classe
	 * 	@var FDB
	 */
	private static ?FDB $_instance = null;

	/**
	 * 	Il costruttore è messo privato perché vogliamo un unico oggetto di questa classe
	 */
	private function __construct ()
	{
		try {
			//global $config;
			//$this->database = new PDO ("mysql:dbname=".$config['database'].";host=localhost; charset=utf8;", $config['username'], $config['password']);
			$db_host = "localhost";
			$db_name = "faccebeve";
			$this->database = new PDO("mysql:host=$db_host;dbname=$db_name", "root", "");
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			die;
		}

	}


	/**	Metodo che instanzia un unico oggetto di questa classe richiamando il costruttore se non è stato già istanziato un oggetto
	 * 	@return FDB
	 */
	public static function getInstance(): FDB{
		if ( !(self::$_instance instanceof self) ) {
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
	public function store(string $class,object $obj){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
			$stmt = $this->database->prepare($query); //Prepared Statement
			$class::bind($stmt,$obj);
			$stmt->execute();
			if($class == "FAdmin" || $class == "FProprietario" || $class == "FUtente")
				$id = $obj->getUsername();
			elseif($class == "FCategoria")
				$id = $obj->getGenere();
			else{
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

	public function storeCategorieLocale($id_locale, $id_categoria){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . "locale_categorie" . " VALUES " . "(".$id_locale.","."'".$id_categoria."'".")".";";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function storeOrariLocale(string $id_locale, string $id_orario){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . "locale_orari (ID_Locale,ID_Orario)" . " VALUES " . "(".$id_locale.",".$id_orario.")".";";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function storeUtentiLocali(string $id_locale, string $username){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . "utenti_locali" . " VALUES " . "(".$id_locale.", '".$username."')".";";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function storeEventiLocale(string $id_locale, string $id_evento){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . "locale_eventi" . " VALUES " . "(".$id_locale.",".$id_evento.")".";";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function storeImmagineLocale(string $id_locale, string $id_immagine){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . "locale_orari (ID_Locale,ID_Immagine)" . " VALUES " . "(".$id_locale.",".$id_immagine.")".";";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	/**Metodo chr permette il salvataggio du un media di un oggetto passato come parametro alla funzione
	 * @param $class, classe di cui si vuole salvare il media
	 * @param obj oggetto interessato
	 * @nome_file, nome del media da salvare
	 */
	public function storeMedia ($class , $obj, $nome_file) {
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO Immagine VALUES ".$class::getValues().";";
			$stmt = $this->database->prepare($query);
			$class::bind($stmt,$obj,$nome_file);
			$stmt->execute();
			$id=$this->database->lastInsertId();
			$this->database->commit();
			$this->closeDbConnection();
			return $id;
		}
		catch(PDOException $e) {
			echo "Attenzione errore: ".$e->getMessage();
			$this->db->rollBack();
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
	public function update(string $class, string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
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

	/**Metodo chr permette l'aggiornamento dui un immagine
	 * @param $class, classe di cui si vuole salvare il media
	 * @param obj oggetto interessato
	 * @nome_file, nome del media da salvare
	 */
	public function updateMedia ($class , $obj, $nome_file) {
		try {
			$this->database->beginTransaction();
			$query = "UPDATE Immagine SET nome= ".$obj->getNome().", type=".$obj->getType().",size=".$obj->getSize().",immagine=".$obj->getImmagine()." where id=".$obj->getId().";";
			$stmt = $this->database->prepare($query);
			$class::bind($stmt,$obj,$nome_file);
			$stmt->execute();
			$id=$this->database->lastInsertId();
			$this->database->commit();
			$this->closeDbConnection();
			return $id;
		}
		catch(PDOException $e) {
			echo "Attenzione errore: ".$e->getMessage();
			$this->db->rollBack();
			return null;
		}
	}

	/**
	 * Metodo che ritorna tutti gli attributi di un'istanza dando come parametro di ricerca il valore di un attributopassato come parametro
	 * @param class ,nome della classe
	 * @field campo della classe
	 * @id ,id della classe
	 */
	public function exist($class, $attributo, $valore){
		try {
			$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $attributo . "='" . $valore . "'";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) >= 1)
				return true;
			else
				return false;
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			return null;
		}
	}

	public function existEsterne($class, $attributo1, $chiave1, $attributo2, $chiave2){
		try {
			$query = "SELECT * FROM " . $class . " WHERE " . $attributo1 . "='" . $chiave1 . "' AND ". $attributo2 . "='" . $chiave2 . "'";
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
	 * Funzione che viene utilizzata per far vedere ad un utente loggato gli eventi dei localli che segue
	 * @param $field campo della tabella  da confrontare
	 * @param $id valore da confrontare
	 * @param $idU idutente-username
	 */
	public function loadEventiUtente($class,$id,$idU): ?array
	{
		try {
			$query = "SELECT * FROM " . $class::getTable() . " INNER JOIN Locali_Eventi ON Locali_Eventi.ID_Evento=" . $id . " INNER JOIN Utenti_Locali ON Utenti_Locali.ID_Locale=Locali_Eventi.ID_Locale WHERE Utenti_Locali.ID_Utente =" . $idU . ";";
			$stmt = $this->db->prepare($query); //Prepared Statement
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
			$this->db->rollBack();
			return null;
		}
	}

	/**
	 * Metodo che va ad inserire le chiavi esterne in tabelle originate da una relazione molti-a-molti
	 * @param string $table Nome della tabella
	 * @param string $field1 Nome della prima chiave
	 * @param string $field2 Nome della seconda chiave
	 * @param string $fk1 Foreign key della prima classe
	 * @param string $fk2 Foreign key della seconda classe
	 */
	public function chiaviEsterne(string $table, string $field1, string $field2, string $fk1, string $fk2){
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . $table . " (" . $field1 . "," . $field2 . ") VALUES (" . $fk1 . "," . $fk2 . ");";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

    public function loadAll($class){
		try {
			$query = "SELECT * FROM " . $class::getTable() . ";";
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
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}
	}


	public function loadByTable($table, $field, $id){
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
	 * @param $class
	 * @param $field
	 * @param $id
	 * @return array
	 */
	public function load($class, $field, $id){
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
			return  array ($result,$num);
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return array(null,0);
		}
	}

	/**
	 * metodo che elimina un'istanza di una tabella dal DB
	 * @param string $class
	 * @param string $attributo
	 * @param string $value
	 * @return bool
	 */
	public function delete(string $class, string $attributo, string $value){
		try {
			$this->database->beginTransaction();
			$esiste = $this->exist($class, $attributo, $value);
			if ($esiste) {
				$query = "DELETE FROM " . $class::getTable() . " WHERE " . $attributo . "='" . $value . "';";
				$stmt = $this->database->prepare($query);
				$stmt->execute();
				$this->database->commit();
				$this->closeDbConnection();
				return true;
			}
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}
		return false;
	}

	public function deleteCategorieLocale($id_locale){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "locale_categorie" . " WHERE " . "ID_Locale" . "='" . $id_locale . "';";
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

	public function deleteOrariLocale($id_locale){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "locale_orari" . " WHERE " . "ID_Locale" . "='" . $id_locale . "';";
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

	public function deleteUtenteLocale($id_locale){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "utenti_locali" . " WHERE " . "ID_Locale" . "='" . $id_locale . "';";
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

	public function deleteUtentiLocali($id_locale, $username){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "utenti_locali" . " WHERE " . "ID_Utente" . "='" . $username . "' AND " . "ID_Locale" . "='" . $id_locale . "';";
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

	public function deleteEventoLocale($id_evento){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "locale_eventi" . " WHERE " . "ID_Evento" . "='" . $id_evento . "';";
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

	public function deleteLocaleEvento($id_locale){
		try {
			$this->database->beginTransaction();
			$query = "DELETE FROM " . "locale_eventi" . " WHERE " . "ID_Locale" . "='" . $id_locale . "';";
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

	/**  Metodo che verifica l'accesso di un utente , controllando che le credenziali (email e password) siano presenti nel db
	 *@param email ,email del utente
	 *@param pass, password dell utente
	 */
	public function loadVerificaAccesso($username, $pass, $class){
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


	public function getRecensioniLocali()
	{
		try {
			$query = "SELECT * FROM recensione INNER JOIN locale ON (locale.nome=recensione.nomelocale AND locale.luogo=recensione.nomelocale)";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($result) == 1) return $result[0];  //rimane solo l'array interno
			else if (count($result) > 1) return $result;  //resituisce array di array
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			return null;
		}
	}

/**   Metodo che restituisce i locali che rispettano alcuni parametri di ricerca ,passati come parametri alla funzione
 * @param nome nome del locale
 * @param citta  città dove è situato il locale
 * @param ?array categorie categorie a cui appartiene il locale
*/
	public function loadMultipleLocale($nome, $citta,$categorie): ?array
	{
		try {
			$query = null;
			$class = "FLocale";
			$param = array($categorie, $nome, $citta);
			for ($i = 0; $i < count($param); $i++) {
				if ($param[$i] != null) {
					switch ($i) {
						case 0:
							if(is_array($categorie)){
								for ($j = 0; $j < count($categorie); $j++){
									if ($query == null)
										$query = "SELECT * FROM " . $class::getTable() . " INNER JOIN Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .$categorie[$j] . "'";
									else
										$query = $query . " INNER JOIN Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .$categorie[$j] ."'";
								}
							}elseif(isset($categorie)){
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " INNER JOIN Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .$categorie . "'";
								else
									$query = $query . " INNER JOIN Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .$categorie ."'";
							}
							break;
						case 1:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " WHERE nome ='" . $nome . "'";
							else
								$query = $query . " AND nome ='" . $nome . "'";
							break;
						case 2:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " INNER JOIN Localizzazione ON  Localizzazione.id=Locale.localizzazione WHERE localizzazione.citta ='" . $citta . "'";
							else
								$query = $query . " INNER JOIN Localizzazione ON  Localizzazione.id=Locale.localizzazione AND localizzazione.citta ='" . $citta . "'";
							break;
					}
				}
			}
			$query = $query . ";";
			//print $query;

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
			//  $this->closeDbConnection();
			return array($result, $num);

		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	/**   Metodo che restituisce gli eventi che rispettano alcuni parametri di ricerca ,passati come parametri alla funzione
	 * @param nomelocale nome del locale
	 * @param nomeevento nome evento
	 * @param citta  città dove è situato il locale
	 * @param data data evento
	 */
	public function loadMultipleEvento($nomelocale,$nomeevento, $citta, $data){
		try{
			$query = null;
			$class = "FEvento";
			$param = array($nomelocale,$nomeevento, $citta, $data);
			for ($i = 0; $i < count($param); $i++) {
				if ($param[$i] != null) {
					switch ($i) {
						case 0:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Locale=Evento.id INNER JOIN Locale ON Locale.nome='". $nomelocale. "'";
							else
								$query = $query . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Locale=Evento.id INNER JOIN Locale ON Locale.nome='".$nomelocale."';";
							break;
							break;
						case 1:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " WHERE nome ='" . $nomeevento . "'";
							else
								$query = $query . " AND nome ='" . $nomeevento . "'";
							break;
						case 2:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=".$class::getTable().id." INNER JOIN Locale ON Locale.id=Locale_Eventi.ID_Locale WHERE localizzazione ='" . $citta . "'";
							else
								$query = $query . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=".$class::getTable().id." INNER JOIN Locale ON Locale.id=Locale_Eventi.ID_Locale WHERE localizzazione ='" . $citta . "'";
							break;
						case 3:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " WHERE data ='" . $data. "'";
							else
								$query = $query . " AND data ='" . $data . "'";
							break;
					}
				}
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
			//  $this->closeDbConnection();
			return array($result, $num);

		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}


	/** Metodo che restituisce le categorie/eventi/orari/immagini che caratterizzano un determinato locale, individuato dal suo id
	 * @param idlocale identificativo del locale
	 * @return info del locale
	 */
	public function loadInfoLocale($class,$field,$idlocale,$foreignkey,$pk){
		try{
			$query = ("SELECT * FROM " . $class::getTable() . " INNER JOIN ".$field." ON ".$field.".".$foreignkey."=".  $class::getTable() .".".$pk." AND ".$field.".ID_Locale=".$idlocale);
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

	/** Metodo che restituisce il locale in cui si svolge un determinato evento, individuato dal suo id
	 * @param idlocale identificativo del locale
	 * @return info del locale
	 */
	public function loadInfoEvento($id){
		try{
			$query = ("SELECT * FROM Locale INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Evento=".$id);
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
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	/**  Metodo che chiude la connesione con il db */
	public function closeDbConnection (){
		static::$_instance = null;
	}

	/**
	 * Funzione utilizzata per ritornare tutte le recensioni presenti sul database
	 * Utilizzata nella pagina admin
	 * @param $query query da eseguire
	 */
	public function getAll($table): ?array
	{
		try {
			$query = "SELECT * FROM ".$table.";";
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
	 * Funzione utilizzata per ritornare tutti gli utenti che verificano determinate caratteristiche date in input
	 * Utilizzata nella pagina admin
	 * @param $campo colonna nel db sul quale viene fatto il controllo
	 * @param $query query da eseguire*/
	public function CercaByKeyword($class,$campo,$input)
	{
		$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $campo . " LIKE '%" . $input . "%';";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();
		if ($num == 0)
			$result = null;
		elseif ($num == 1)
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		else {
			$result = array();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			while ($row = $stmt->fetch())
				$result[] = $row;
		}
		return array($result, $num);
	}



	/**
	 * Funzione utilizzata per ritornare tutti gli utenti che verificano determinate caratteristiche date in input
	 * Utilizzata nella pagina admin
	 * @param $state valore booleano in input che esprime la visibilità o meno di un annuncio
	 * @param $query query da eseguire
	 */
	public function utentiByString ($string)
	{
		$query = "SELECT * FROM utente where  username = '" . $string . "';";

		$stmt = $this->database->prepare($query);
		$stmt->execute();
		$num = $stmt->rowCount();
		if ($num == 0)
			$result = null;
		elseif ($num == 1)
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		else {
			$result = array();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			while ($row = $stmt->fetch())
				$result[] = $row;
		}
		return array($result, $num);
	}

	/**
	 * @return array|void
	 */
	public function getLocaliPerValutazione(){
		try {
			$query = "SELECT locale.id,AVG(recensione.voto) AS ValutazioneMedia FROM locale INNER JOIN recensione ON locale.id = recensione.locale GROUP BY locale.id ORDER BY AVG(recensione.voto) DESC;";
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
			return array($result,$num);
		}catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}


	}

	public function getIdEventoByIdLocale($id_locale){
		try {
			$query = "SELECT ID_Evento FROM locale_eventi WHERE ID_Locale = ".$id_locale.";";
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
		}catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}
	}

	public function getIdLocaleByIdEvento($id_evento){
		try {
			$query = "SELECT ID_Locale FROM locale_eventi WHERE ID_Evento = ".$id_evento.";";
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
		}catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}
	}

	public function getUtentiByState($state)
	{
		try {
			$query = "SELECT * FROM utente WHERE state = ".$state.";";
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
			return array($result,$num);
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
		}
	}

}

?>
