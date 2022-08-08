<?php

//if(file_exists('config.php')) require_once 'config.php';

class FDB{

	/** Oggetto PDO che permette la connessione al DBMS
	 * 	@var PDOStatement|PDO
	 */
	private PDOStatement $database;

	/**	Unica instanza della classe
	 * 	@var FDB
	 */
	private static FDB $instance;


	/**
	 * 	Il costruttore è messo privato perché vogliamo un unico oggetto di questa classe
	 */
	private function __construct ()
	{
		try {
			//global $config;
			//$this->database = new PDO ("mysql:dbname=".$config['database'].";host=localhost; charset=utf8;", $config['username'], $config['password']);
			$this->database = new PDO ("mysql:dbname=FacceBeve;host=localhost; charset=utf8;", "root", "");

		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			die;
		}

	}

	/**	Metodo che instanzia un unico oggetto di questa classe richiamando il costruttore se non è stato già istanziato un oggetto
	 * 	@return FDB
	 */
	public static function getInstance ()	{
		if (self::$instance == null) {
			self::$instance = new FDB();
		}
		return self::$instance;
	}

	/**
	 * Metodo che permette di salvare informazioni contenute in un oggetto Entity sul database.
	 * @param class classe da passare
	 * @param obj oggetto da salvare
	 */
	public function store($class, $obj)
	{
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
			$stmt = $this->database->prepare($query); //Prepared Statement
			$class::bind($stmt, $obj);
			$stmt->execute();
			$id = $this->database->lastInsertId();
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
			if (count($result) == 1)
				return $result[0];  //rimane solo l'array interno
			else if (count($result) > 1)
				return $result;  //resituisce array di array
			$this->closeDbConnection();
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			return null;
		}
	}


	public function getidProprietario(string $username){
		try {
			$class = "FProprietario";
			$query = "SELECT id FROM " . $class::getTable() . " WHERE username ='" . $username . "';";
			$stmt = $this->database->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	/**
	 * Metodo che va ad inserire le chiavi esterne in tabelle originate da una relazione molti-a-molti
	 * @param $table Nome della tabella
	 * @param $field1 Nome della prima chiave
	 * @param $field2 Nome della seconda chiave
	 * @param $fk1 Foreign key della prima classe
	 * @param $fk2 Foreign key della seconda classe
	 */
	public function chiaviEsterne($table,$field1,$field2,$fk1,$fk2)
	{
		try {
			$this->database->beginTransaction();
			$query = "INSERT INTO " . $table . " (".$field1.",".$field2.") VALUES (".$fk1.",".$fk2.");";
			$stmt = $this->database->prepare($query); //Prepared Statement
			$stmt->execute();
			$this->database->commit();
			$this->closeDbConnection();

	public function getIdCategoria(string $genere){
		try {
			$class = "FCategoria";
			$query = "SELECT id FROM " . $class::getTable() . " WHERE genere ='" . $genere . "';";
			$stmt = $this->database->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;

		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}


	//public function getidLocalizzazione(string $indirizzo, string $numCivico, string $citta){

	public function getIdLocalizzazione(string $indirizzo, string $numCivico, string $citta){
		try {
			$class = "FLocalizzazione";
			$query = "SELECT id FROM " . $class::getTable() . " WHERE indirizzo ='" . $indirizzo . "' AND numCivico ='" . $numCivico . "' AND citta ='" . $citta . "';";
			$stmt = $this->database->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function getIdLocale(string $nome, string $numtelefono){
		try {
			$class = "FLocale";
			$query = "SELECT id FROM " . $class::getTable() . " WHERE nome ='" . $nome . "' AND numtelefono ='" . $numtelefono . "';";
			$stmt = $this->database->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	public function getIdUtente(string $username){
		try {
			$class = "FUtente";
			$query = "SELECT id FROM " . $class::getTable() . " WHERE username ='" . $username . "';";
			$stmt = $this->database->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->database->rollBack();
			return null;
		}
	}

	/**
	 * Funzione che viene utilizzata per la load quando ci si aspetta che la query produca un solo risultato (esempio load per id).
	 * @param $field campo della tabella  da confrontare
	 * @param $id valore da confrontare
	 * @param $query query da eseguire
	 */
	public function load($class, $field, $id){
		try {
			$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
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

	/** Metodo che permette di eliminare un'istanza di una classe nel db
	 * @param class classe interessata
	 *@param field campo usato per la cancellazione
	 *@param id id usato per la cancellazione
	 */
	public function delete($class, $field, $id)
	{
		try {
			$result = null;
			$this->db->beginTransaction();
			$esiste = $this->exist($class, $field, $id);
			if ($esiste) {
				$query = "DELETE FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
				$stmt = $this->db->prepare($query); //Prepared Statement
				$stmt->execute();
				$this->db->commit();
				$this->closeDbConnection();
				$result = true;
			}
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->db->rollBack();
			//return false;
		}
		return $result;
	}

	/**  Metodo che verifica l'accesso di un utente , controllando che le credenziali (email e password) siano presenti nel db
	 *@param email ,email del utente
	 *@param pass, password dell utente

	public function loadVerificaAccesso ($email, $pass)
	{
		try {
			$query = null;
			$class = "FUtenteloggato";
			$query = "SELECT * FROM " . $class::getTable() . " WHERE email ='" . $email . "' AND password ='" . $pass . "';";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$num = $stmt->rowCount();
			if ($num == 0) {
				$result = null;        //nessuna riga interessata. return null
			} else {                          //nel caso in cui una sola riga fosse interessata
				$result = $stmt->fetch(PDO::FETCH_ASSOC);   //ritorna una sola riga
			}
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->db->rollBack();
			return null;
		}
	}
	*/

	public function getRecensioniLocali()
	{
		try {
			$query = "SELECT * FROM recensione INNER JOIN locale ON (locale.nome == recensione.nomelocale AND locale.luogo==recensione.nomelocale)";
			$stmt = $this->db->prepare($query); //Prepared Statement
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
 * @param categorie categorie a cui appartiene il locale
*/
	public function loadMultipleLocale($nome, $citta, $categorie)
	{
		try {
			$query = null;
			$class = "FLocale";
			$param = array( $categorie, $nome, $citta);

			if(isset($categorie)){
			  $nCategorie = sizeof($categorie);
			}

			//print_r ($param);
			for ($i = 0; $i < count($param); $i++) {
				if ($param[$i] != null) {
					switch ($i) {
						case 0:
							for ($j = 0; $j < nCategorie; $j++){
							   if ($query == null)
								  $query = "SELECT * FROM " . $class::getTable() . " INNER JOIN ON  Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .categorie[j] . "'";
							   else
								  $query = $query . " INNER JOIN ON  Locale_Categorie  ON Locale_Categorie.ID_Categoria='" .categorie[j] ."'";
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
								$query = "SELECT * FROM " . $class::getTable()  . " WHERE localizzazione ='" . $citta . "'";
							else
								$query = $query . " AND localizzazione ='" . $citta . "'";
							break;
					}
				}
			}
			$query = $query . ";";
			//print $query;

			$stmt = $this->db->prepare($query);
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
			$this->db->rollBack();
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

			//print_r ($param);
			for ($i = 0; $i < count($param); $i++) {
				if ($param[$i] != null) {
					switch ($i) {
						case 0:
							if ($query == null)
								$query = "SELECT * FROM " . $class::getTable()  . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Locale='" . $nomelocale . "'";
							else
								$query = $query . " INNER JOIN Locale_Eventi ON Locale_Eventi.ID_Locale='" . $nomelocale . "'";
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
			//print $query;

			$stmt = $this->db->prepare($query);
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
			$this->db->rollBack();
			return null;
		}
	}



	/** Metodo che restituisce le categorie/eventi/orari che caratterizzano un determinato locale, individuato dal suo id
	 * @param idlocale identificativo del locale
	 * @return info del locale
	 */
	public function loadInfoLocale($class,$field,$idlocale){
		try{
			$query = ("SELECT * FROM " . $class::getTable() . " INNER JOIN ".$field." ON ".$field.".ID_Locale". "='" . $idlocale . "';");
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

			return array($result, $num);

		} catch (PDOException $e) {
			echo "Attenzione errore: " . $e->getMessage();
			$this->db->rollBack();
			return null;
		}
	}


	/**  Metodo che chiude la connesione con il db */
	public function closeDbConnection (){
		static::$instance = null;
	}

	/**
	 * Funzione utilizzata per ritornare tutte le recensioni presenti sul database
	 * Utilizzata nella pagina admin
	 * @param $query query da eseguire
	 */
	public function getAllRev(){
		try {
			$query = "SELECT * FROM recensione;";
			$stmt = $this->db->prepare($query);
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

}

?>
