<?php

require_once 'utility/autoload.php';
/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */
class FUtente{

    /** classe Foundation */
    private static $class="FUtente";

	/** tabella con la quale opera nel DB */
    private static $table="Utente";

    /** valori della tabella nel DB */
    private static  $values="(:username,:nome,:cognome,:email,:password,:dataIscrizione,:idImg,:state)";

    /** costruttore */
    public function __construct(){

    }

    /**
    * metodo che lega gli attributi dell'Utente da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EUtente $utente
    */
    public static function bind(PDOStatement $stmt, EUtente $utente){
        $stmt->bindValue(':username', $utente->getUsername(), PDO::PARAM_STR);
		$stmt->bindValue(':nome',$utente->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':cognome',$utente->getCognome(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $utente->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $utente->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':idImg', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':dataIscrizione', $utente->getIscrizione());
        $stmt->bindValue(':state', $utente->getState(), PDO::PARAM_BOOL);
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
     * metodo che permette il salvataggio una Utente nel db
     * @param EUtente $utente Utente da salvare
     * @return string
     */
    public static function store(EUtente $utente){
        $db = FDB::getInstance();
        $id = $db->store(static::getClass() ,$utente);
        //Utenti Locali
        if($utente->getLocalipreferiti()!=null){
            foreach($utente->getLocalipreferiti() as $pref){
                $idLoc = $pref->getId();
                $db->chiaviEsterne("Utenti_Locali","ID_Locale","ID_Utente",$id,$idLoc);
            }
        }
        return $id;
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
     * metodo che verifica l'esistenza di un Utente nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo dell'Utente sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDB::getInstance();
        $result = $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
        if($result)
            return true;
        else
            return false;
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db=FDB::getInstance();
        $result = $db->delete(static::getClass(), $attributo, $valore);
        if($result)
            return true;
        else
            return false;
    }
	
    /**  Metodo che permette il caricamento del login di un utente,passati la sua email e la sua password
    * @param user mail dell utente
    * @param pass password ell utente
    */
	public static function loadLogin ($user, $pass) {
		$utente = null;
		$db=FDB::getInstance();
		$result=$db->loadVerificaAccesso($user, $pass);
		if (isset($result)){
			$ute = FUtente::loadByField("username" , $result["username"]);
			$pro = FProprietario::loadByField("username" , $result["username"]);
			$admin = static::loadByField("username", $result["username"]);
			if ($ute)
				$utente = $ute;
			elseif ($pro)
				$utente = $pro;
			elseif ($admin)
                $utente = $admin;
		}
		return $utente;
	}


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
     */
    public static function loadUtentiByString($string){
        $utente = null;
        $toSearch = null;
        $db=FDB::getInstance();
        list ($result, $rows_number)=$db->utentiByString($string);
        if(($result!=null) && ($rows_number == 1)) {
            $utente=new EUtente($result['password'],$result['nome'],$result['cognome'],$result['username'],$result['state']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $utente[]=new EUtente($result[$i]['password'],$result[$i]['nome'],$result[$i]['cognome'],$result[$i]['username'],$result[$i]['state']);
                }
            }
        }
        return $utente;
    }
    

}

?>