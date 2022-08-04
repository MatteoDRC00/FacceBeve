<?php

/**
 * La classe FProprietario fornisce query per gli oggetti EProprietario
 * @author Gruppo 8
 * @package Foundation
 */
class FProprietario{

    /** classe Foundation */
    private static $class="FProprietario";

	/** tabella con la quale opera nel DB */
    private static $table="Proprietario";

    /** valori della tabella nel DB */
    private static $values="(:id,:username,:nome,:cognome,:email,:password)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi del Proprietario da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EProprietario $proprietario
    */
    public static function bind(PDOStatement $stmt, EProprietario $proprietario){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':username', $proprietario->getUsername(), PDO::PARAM_STR); 
		$stmt->bindValue(':nome',$proprietario->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':cognome',$proprietario->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $proprietario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $proprietario->getPassword(), PDO::PARAM_STR); 
    }

    /**
    * metodo che restituisce il nome della classe per la costruzione delle query
    * @return string $class Nome della classe
    */
    public static function getClass(){
        return self::$class;
    }

    /**
    * metodo che restituisce il nome della tabella per la costruzione delle query
    * @return string $table Nome della tabella
    */
    public static function getTable(){
        return self::$table;
    }

    /**
    * metodo che restituisce l'insieme dei valori per la costruzione delle query
    * @return string $values Nomi delle colonne della tabella
    */
    public static function getValues(){
        return self::$values;
    }

    /**
     * metodo che permette il salvataggio di un Proprietario nel db
     * @param EProprietario $proprietario Proprietario da salvare
     * @return void
     */
    public static function store(EProprietario $proprietario){
        $db=FDB::getInstance();
        $db->store(static::getClass() ,$proprietario);
    }


    /**
    * Permette la load sul database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $utente Utente
    */
    public static function loadByField($field, $id){
        $utente = null;
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $proprietario=new EProprietario($result['username'],$result['nome'],$result['cognome'], $result['email'], $result['password']); //Carica un Proprietario dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
                    $proprietario[]=new EProprietario($result[$i]['username'],$result[$i]['nome'],$result[$i]['cognome'], $result[$i]['email'], $result[$i]['password']); //Carica un array di oggetti Proprietario dal database
                }
            }
        }
        return $proprietario;
    }

    /**
     * metodo che verifica l'esistenza di un Proprietario nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $ris = false;
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            $ris = true;
        return $ris;
    }

    /**
    * Metodo che aggiorna i campi di un Utente
    * @param $id valore della primary key da usare come riferimento per la riga
    * @param $newvalue nuovo valore da assegnare
    * @param $field campo in cui si vuo modificare il valore
	*@param pk chiave primaria della classe interessata
    * @return true se esiste il mezzo, altrimenti false
    */
    public static function update($field, $newvalue, $pk, $id){
        $db=FDB::getInstance();
        $result = $db->update(static::getClass(), $field, $newvalue, $pk, $id); //funzione richiamata,presente in FDB -->  Aggiorna una riga nel db che fa match con il campo id
        if($result) return true;
        else return false;
    }

    /**
    * Permette la delete sul db in base all'id
    * @param int l'id dell'oggetto da eliminare dal db
    * @return bool
    */
     public static function delete($field, $id){
      $db=FDB::getInstance();
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata,presente in FDatabase
      if($result) return true;
        else return false;
    }
	
    /**  Metodo che permette il caricamento del login di un utente,passati la sua email e la sua password
    * @param user mail dell utente
    * @param pass password ell utente
    
	public static function loadLogin ($user, $pass) {
		$utente = null;
		$db=FDatabase::getInstance();
		$result=$db->loadVerificaAccesso($user, $pass);
		if (isset($result)){
			$tra = FTrasportatore::loadByField("emailUtente" , $result["email"]);
			$cli = FCliente::loadByField("emailUtente" , $result["email"]);
			$admin = static::loadByField("email", $result["email"]);
			if ($tra)
				$utente = $tra;
			elseif ($cli)
				$utente = $cli;
			elseif ($admin)
                $utente = $admin;
		}
		return $utente;
	} */


    /**
     * Metodo che permette di ritornare tutti gli utenti presenti sul db, in base al loro stato.
     * @param $state valore dello stato
     * @return object $utente Utente
     
	 PROBABILMENTE NEL NOSTRO CASO INUTILE
	 
    public static function loadUtenti($state){
        $utente = null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->getUtenti($state);
        if(($result!=null) && ($rows_number == 1)) {
            $utente=new EUtente($result['username'],$result['nome'],$result['cognome'], $result['email'], $result['password'],$result['dataIscrizione']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $utente[]=new EUtente($result[$i]['username'],$result[$i]['nome'],$result[$i]['cognome'], $result[$i]['email'], $result[$i]['password'],$result[$i]['dataIscrizione']);
                }
            }
        }
        return $utente;
    } */


    /**
     *Metodo che  permette di ritornare gli utenti del db, filtrandoli per nome, cognome
     * @param $string valore inserito nella barra di ricerca dell'admin
     * @return object $utente Utente
	 
	 FORSE NON CI SERVE
     
    public static function loadUtentiByString($string){
        $utente = null;
        $toSearch = null;
        $pieces = explode(" ", $string);
        $lastElement = end($pieces);
        if ($pieces[0] == $lastElement) {
            $toSearch = 'nome';
        }
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->utentiByString($pieces, $toSearch);
        if(($result!=null) && ($rows_number == 1)) {
            $utente=new EUtenteloggato($result['name'],$result['surname'], $result['email'], $result['password'],$result['state']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $utente[]=new EUtenteloggato($result[$i]['name'],$result[$i]['surname'], $result[$i]['email'], $result[$i]['password'],$result[$i]['state']);
                }
            }
        }
        return $utente;
    } */
    

}

?>