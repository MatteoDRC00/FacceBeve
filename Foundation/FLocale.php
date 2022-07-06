<?php

/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */

class FLocale{
    /** classe foundation */
    private static $class="FUtente";
	/** tabella con la quale opera */          
    private static $table="utente";
    /** valori della tabella */
    private static $values="(:nome,:numtelefono,:descrizione,:proprietario,:categoria,:localizzazione)";

    /** costruttore*/ 
    public function __construct(){}

    /**
    * Questo metodo lega gli attributi dell'Utente da inserire con i parametri della INSERT
    * @param PDOStatement $stmt
    * @param EUtente $utente Utente i cui i dati devono essere inseriti nel DB
    */
    public static function bind($stmt, ELocale $locale){
        $stmt->bindValue(':nome', $locale->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':numtelefono',$locale->getNumTelefono(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione',$locale->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $locale->getProprietario()->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $locale->getCategoria(), PDO::PARAM_INT);
        $stmt->bindValue(':localizzazione', $locale->getLocalizzazione()->getCodice(), PDO::PARAM_STR);
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
    * @param $locale Locale da salvare
    */
    public static function store($locale){
        $db=FDB::getInstance();
        $id=$db->store(static::getClass() ,$locale);
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
      $result = $db->delete(static::getClass(), $field, $id);   //funzione richiamata, presente in FDatabase
      if($result) return true;
        else return false;
    }

    public static function RecensioniLocale ($nomelocal,$luogo) {
        $db=FDB::getInstance();
        $result = $db->getRecensioniLocali();
        //$rows_number = $result->rowCount();
        if (($result!=null)/* && ($rows_number == 1)*/){
            if($result["nomelocale"]==$nomelocal && $result["luogolocale"]==$luogo)
            $rece = FRecensione::loadByField("codicerecensione" , $result["codicerecensione"]);
        }
        return $rece;
    }

    /**
     *
     * @param $parola valore da ricercare all'interno del campo text
     * @return object $rec Recensione
     */
    public static function loadByKeyword($parola) {
        $loc = null;
        $db = FDB::getInstance();
        list ($result, $rows_number)=$db->CercaByKeyword(static::getClass(), "campo",$parola);
        if(($result != null) && ($rows_number == 1)) {
            $rec = new ERecensione($result['text'],$result['mark'],$result['emailClient'],$result['emailConveyor']);
            $rec->setId($result['id']);
        }
        else {
            if(($result != null) && ($rows_number > 1)){
                $rec = array();
                for($i = 0; $i < count($result); $i++){
                    $rec[] = new ERecensione($result[$i]['text'], $result[$i]['mark'],$result[$i]['emailClient'], $result[$i]['emailConveyor']);
                    $rec[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $rec;
    }


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