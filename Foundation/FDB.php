<?php

	//if(file_exists('config.php')) require_once 'config.php';

	/** DIZIONARIO

	1) beginTransaction(); toglie l'autocommit. le modifiche effettuate al database attraverso l'oggetto PDO non sono rese effettive finche' non si chiude la transazione chiamando PDO::commit(). return bool

	2) prepare($query); prepara l'istruzione SQL per essere eseguita dal metodo PDO::execute(). return PDOStatement

	3) $class::bind($stmt,$obj); serve per filtrare automaticamente le stringhe da passare alla query

	4) execute(); esegue l'istruzione preparata. return bool

	5) db->lastInsertId(); ritorna l'id dell'ultima riga inserita nel database. return string

	6) $this->db->commit(); rende effettiva una transaction, rimettendo il database sulla modalità autocommit fino alla prossima chiamata PDO::beginTransaction(). return bool

	7)closeDbConnection();  metodo implementato, non PDO. chiude la connessione col db.

	8) rollBack(); si usa in caso di errore; azzera tutto ciò che era stato effettuato senza successo, riportando lo stato al precedente beginTransaction(). return bool

	9) rowCount(); ritorna il numero delle righe interessate dalla precedente operazione di DELETE, INSERT o UPDATE. return int

	10) fetch(); ritorna una riga dall'insieme di risultati. Il parametro PDO::FETCH_ASSOC dice a PDO di ritornare il risultato come un array associativo (prossima riga).

	11) PDO::FETCH_ASSOC - ritorna un array indicizzato dal NOME delle colonne che vengono ritornate nell'elenco dei risultati

	12) setFetchMode(); Imposta la modalità di default per quell'istruzione

	13) fetchAll(); ritorna un array con le rimanenti righe della lista dei risultati. Ogni array rappresenta una riga.

	*/

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
				$this->db->beginTransaction();
				$query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
				$stmt = $this->db->prepare($query); //Prepared Statement
				$class::bind($stmt, $obj);
				$stmt->execute();
				$id = $this->db->lastInsertId();
				$this->db->commit();
				$this->closeDbConnection();
				return $id;
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return null;
			}
		}

		/**
		 * Funzione che viene utilizzata per la load quando ci si aspetta che la query produca un solo risultato (esempio load per id).
		 *
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
	  /** Metodo che restituisce il numero di righe interessate dalla query
	  * @param class classe interessata
	  *@param field campo usato per la ricerca
	  *@param id ,id usato per la ricerca
	  */
		public function interestedRows ($class, $field, $id){
			try {
				$this->db->beginTransaction();
				$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
				$stmt = $this->db->prepare($query); //Prepared Statement
				$stmt->execute();
				$num = $stmt->rowCount();
				$this->closeDbConnection();
				return $num;
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return null;
			}
		}
	/** Metodo che permette di eliminare un'istanza di una classe nel db
	 * @param class classe interessata
	 *@param field campo usato per la cancellazione
	 *@param id ,id usato per la cancellazione
	 */
		public function delete($class, $field, $id)
		{
			try {
				$result = null;
				$this->db->beginTransaction();
				$esiste = $this->existDB($class, $field, $id);
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
	/**  Metodo che permette di aggiornare il valore di un attributo passato come parametro
	 *@param class ,classe interessata
	 *@param field campo da aggiornare
	 *@param newvalue nuovo valore da inserire
	 *@param pk chiave primaria della classe interessata
	 */
		public function update($class, $field, $newvalue, $pk, $id)
		{
			try {
				$this->db->beginTransaction();
				$query = "UPDATE " . $class::getTable() . " SET " . $field . "='" . $newvalue . "' WHERE " . $pk . "='" . $id . "';";
				$stmt = $this->db->prepare($query); //Prepared Statement
				$stmt->execute();
				$this->db->commit();
				$this->closeDbConnection();
				return true;
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return false;
			}
		}

	/**  Metodo che ritorna tutti gli attributi di un'istanza dando come parametro di ricerca il valore di un attributo
	 *passato come parametro
	 * @param class ,nome della classe
	 * @field campo della classe
	 * @id ,id della classe
	 */
		public function exist($class, $field, $id)
		{
			try {
				$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "'";
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

	/**   Metodo che restituisce gli annunci che rispettano alcuni parametri di ricerca ,passati come parametri alla funzione
	 * @param luogo 1 città di partenza
	 * @param luogo 2  città di arrivo
	 * @param data1 data ritiro
	 * @param data2 data consegna
	 * @param dim dimensione
	 * @param peso peso del pacco

		public function loadMultipleAnnuncio ($luogo1, $luogo2, $data1, $data2, $dim, $peso)
		{
			try {
				$query = null;
				$class = "FAnnuncio";
				$param = array($luogo1, $luogo2, $data1, $data2, $dim, $peso);
				//print_r ($param);
				for ($i = 0; $i < count($param); $i++) {
					if ($param[$i] != null) {
						switch ($i) {
							case 0:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE departure ='" . $luogo1 . "'";
								else
									$query = $query . " AND departure ='" . $luogo1 . "'";
								break;
							case 1:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE arrival ='" . $luogo2 . "'";
								else
									$query = $query . " AND arrival ='" . $luogo2 . "'";
								break;
							case 2:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE departureDate ='" . $data1 . "'";
								else
									$query = $query . " AND departureDate ='" . $data1 . "'";
								break;
							case 3:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE arrivalDate ='" . $data2 . "'";
								else
									$query = $query . " AND arrivalDate ='" . $data2 . "'";
								break;
							case 4:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE space ='" . $dim . "'";
								else
									$query = $query . " AND space ='" . $dim . "'";
								break;
							case 5:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable() . " WHERE weight ='" . $peso . "'";
								else
									$query = $query . " AND weight ='" . $peso . "'";
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
		} */

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
		} */
	/**  Metodo che chiude la connesione con il db */
		public function closeDbConnection (){
			static::$instance = null;
		}


		/**
		 * Funzione utilizzata per ritornare solamente gli annunci riguardanti un trasporto.
		 * Gli annunci di trasporti hanno la data di partenza sempre diversa dal valore nullo.
		 * @param $query query da eseguire

		public function loadTrasporti ()
		{
			try {
				// $this->db->beginTransaction();
				$query = "SELECT * FROM annuncio WHERE departureDate <> '0000-00-00'";
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
				return $result;
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return null;
			} */

		/**
		 * Funzione utilizzata per ritornare i soli annunci (attivi e inattivi) che contengono una parola inserita dall'admin.
		 * @param  $input stringa inserita nel campo ricerca dall'admin
		 * @param $query query da eseguire
		 * @param input ,parola data in input
		 * @param class, classe interessata
		 * @param campo, campo dove cercare la parola

		public function ricercaParola ($input, $class, $campo)
		{
			try {
				// $this->db->beginTransaction();
				$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $campo . " LIKE '%" . $input . "%';";
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
		} */


		/**
		 * Funzione utilizzata per ritornare i soli nomi delle città inserite nel database.
		 * @param $input stringa inserita nel campo ricerca dall'admin
		 * @param $query query da eseguire
		 * @param input, luogo da cercare

		public function ricercaLuogo ($input)
		{
			try {
				// $this->db->beginTransaction();
				$query = "SELECT name FROM luogo WHERE name ='" . $input . "';";
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
				//return $result;
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return null;
			}
		} */


		/**
		 * Funzione utilizzata per ritornare gli utenti attivi e bannati.
		 * Utilizzata nella pagina admin
		 * @param $state booleano che permette di ritornare distintamente utenti attivi/bannati
		 * @param $query query da eseguire

		public function getUtenti ($state)
		{
			try {
				// $this->db->beginTransaction();
				$query = "SELECT * FROM utenteLoggato WHERE  state = " . $state . " AND email <> 'admin@admin.com';";
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
		} */

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

	/** Metodo che aggiunge una nuova possibile tappa nel db,inizializzando prima una connessione con lo stesso per poi chiuderla
	 * @param ad , fk annuncio
	 * @param place ,fk del luogo

		public function insertTappa ($ad, $place)
		{
			try {
				$this->db->beginTransaction();
				$id = $this->db->query("INSERT INTO tappa (ad, place) VALUES('$ad','$place')");
				$this->db->commit();
				$this->closeDbConnection();
				return $id;

			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
				$this->db->rollBack();
				return null;
			}
		}
		*/
	/** Metodo che carica la chat tra due utenti,identificati dal sistema con le proprie email
	 *@param email ,email del primo utente
	 *@param email2 ,email del secondo utente

		public function loadChats ($email, $email2)
		{
			try {
				$query = null;
				if (!$email2)
					$query = "SELECT * FROM messaggio WHERE sender ='" . $email . "' OR recipient ='" . $email . "';";
				else
					$query = "SELECT * FROM messaggio WHERE (sender ='" . $email . "' OR recipient ='" . $email . "') and id IN
								(SELECT id FROM messaggio where (sender ='" . $email2 . "' OR recipient ='" . $email2 . "'));";
				//print ($query);
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
				//print_r ($result);
				//print($num);
				return array($result, $num);
			} catch (PDOException $e) {
				echo "Attenzione errore: " . $e->getMessage();
			}
		} */

	/**  Metodo chr permette il salvataggio du un media di un oggetto passato come parametro alla funzione
	 *@param $class, classe di cui si vuole salvare il media
	 * @param obj oggetto interessato
	 * @nome_file, nome del media da salvare

		public function storeMedia ($class , $obj,$nome_file) {
			try {
				$this->db->beginTransaction();
				$query = "INSERT INTO ".$class::getTable()." VALUES ".$class::getValues();
				$stmt = $this->db->prepare($query);
				$class::bind($stmt,$obj,$nome_file);
				$stmt->execute();
				$id=$this->db->lastInsertId();
				$this->db->commit();
				$this->closeDbConnection();
				return $id;
			}
			catch(PDOException $e) {
				echo "Attenzione errore: ".$e->getMessage();
				$this->db->rollBack();
				return null;
			}
		} */

	}

	?>
