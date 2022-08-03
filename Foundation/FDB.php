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
									$query = $query . " AND l.nome ='" . $nome . "'";
								break;
							case 2:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable()  . " WHERE localizzazione ='" . $citta . "'";
								else
									$query = $query . " AND l.localizzazione ='" . $citta . "'";
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

		/**   Metodo che restituisce i locali che rispettano alcuni parametri di ricerca ,passati come parametri alla funzione
		 * @param nomelocale nome del locale
		 * @param nomeevento nome evento
		 * @param citta  città dove è situato il locale
		 * @param data data evento
		 */
		public function loadMultipleEvento($nomelocale,$nomeevento $citta, $data)
		{
			try {
				$query = null;
				$class = "FEvento";
				$param = array( $nomelocale,$nomeevento $citta, $data);

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
									$query = $query . " AND l.nome ='" . $nome . "'";
								break;
							case 2:
								if ($query == null)
									$query = "SELECT * FROM " . $class::getTable()  . " WHERE localizzazione ='" . $citta . "'";
								else
									$query = $query . " AND l.localizzazione ='" . $citta . "'";
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
