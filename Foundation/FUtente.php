<?php

/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */

class FUtente{
    /** classe foundation */
    private static $class="FUtente";
	/** tabella con la quale opera */          
    private static $table="utente";
    /** valori della tabella */
    private static $values="(:username,:nome,:cognome,:email,:password,:dataIscrizione)";

    /** costruttore*/ 
    public function __construct(){}

    /**
    * Questo metodo lega gli attributi dell'Utente da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EUtente $utente Utente i cui i dati devono essere inseriti nel DB
    */
    public static function bind($stmt, EUtente $utente){
        $stmt->bindValue(':username', $utente->getUsername(), PDO::PARAM_STR); 
		$stmt->bindValue(':nome',$utente->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':cognome',$utente->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $utente->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $utente->getPassword(), PDO::PARAM_STR); 
        $stmt->bindValue(':dataIscrizione', $utente->getData(), PDO::PARAM_BOOL);
    }

    /**
    * questo metodo restituisce il nome della classe per la costruzione delle Query
    * @return string $class nome della classe
    */
    public static function getClass(){
        return self::$class;
    }

    /**
    * questo metodo restituisce il nome della tabella per la costruzione delle Query
    * @return string $table nome della tabella
    */
    public static function getTable(){
        return self::$table;
    }

    /**
    * questo metodo restituisce l'insieme dei valori per la costruzione delle Query
    * @return string $values nomi delle colonne della tabella
    */
    public static function getValues(){
        return self::$values;
    }

    /**
    * Metodo che permette la store di un Utente
    * @param $utente Utenteloggato da salvare
    */
    public static function store($utente){
        $db=FDB::getInstance();
        $id=$db->store(static::getClass() ,$utente);
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
            $utente=new EUtente($result['username'],$result['nome'],$result['cognome'], $result['email'], $result['password'],$result['dataIscrizione']); //Carica un Utente dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
        	    for($i=0; $i<count($result); $i++){
                    $utente[]=new EUtente($result[$i]['username'],$result[$i]['nome'],$result[$i]['cognome'], $result[$i]['email'], $result[$i]['password'],$result[$i]['dataIscrizione']); //Carica un array di oggetti Utente dal database
                }
            }
        }
        return $utente;
    }

    /**
    * Funzione che permette di verificare se esiste un Utente nel database
    * @param  $id valore della riga di cui si vuol verificare l'esistenza
    * @param  string $field colonna su ci eseguire la verifica
    * @return bool $ris
    */
    public static function exist($field, $id){
        $db=FDB::getInstance();
        $result=$db->exist(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB -->  ritorna tutti gli attributi di un'istanza dando come parametro di ricerca il valore di un attributo
        if($result!=null)
            return true;
        else
            return false;
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