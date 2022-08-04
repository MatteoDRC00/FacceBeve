<?php

/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */
class FLocale {

    /** classe Foundation */
    private static $class="FUtente";

	/** tabella con la quale opera nel DB */
    private static $table="Locale";

    /** valori della tabella nel DB */
    private static $values="(:id,:nome,:numtelefono,:descrizione,:proprietario,:localizzazione)";

    /** costruttore */
    public function __construct(){

    }

    /**
     * metodo che lega gli attributi del Locale da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ELocale $locale
     * @return void
     */
    public static function bind(PDOStatement $stmt, ELocale $locale){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome', $locale->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':numtelefono',$locale->getNumTelefono(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione',$locale->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $locale->getProprietario()->getUsername(), PDO::PARAM_STR); //CI VUOLE L'ID
        $stmt->bindValue(':localizzazione', $locale->getLocalizzazione()->getCodice(), PDO::PARAM_STR); //CI VUOLE L'ID
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
     * metodo che permette il salvataggio di un Locale nel db
     * @param ELocale $locale Locale da salvare
     * @return void
     */
    public static function store(ELocale $locale){
        $db=FDB::getInstance();
        $db->store(static::getClass() ,$locale);
    }


    /**
    * Permette la load dal database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $locale
    */
    public static function loadByField($field, $id){ //es: ricerca i locali di Pescara
        $locale = null;
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $locale=new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $result['proprietario'], $result['categoria'], $result['localizzazione']); //Carica un Locale dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $locale = array();
        	    for($i=0; $i<count($result); $i++){
                    $locale[]=new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $result[$i]['proprietario'], $result[$i]['categoria'], $result[$i]['localizzazione']); //Carica un array di oggetti Locale dal database
                }
            }
        }
        return $locale;
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
	* @param pk chiave primaria della classe interessata
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
            $rece = array();
            if($result["nomelocale"]==$nomelocal && $result["luogolocale"]==$luogo)
               $rece[] = FRecensione::loadByField("codicerecensione" , $result["codicerecensione"]);
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


     /** Metodo che permette di caricare un locale che ha determinati parametri, i quali vengono passati in input da una form */
     public static function loadByForm ($part1, $part2, $part3) {
        $locale = null;
        $db=FDatabase::getInstance();
        list ($result, $rows_number)=$db->loadMultipleLocale($part1, $part2, $part3);
        //print_r ($result);
        //print $rows_number;
        if(($result!=null) && ($rows_number == 1)) {
            $proprietario = FProprietario::loadByField("id" , $result["proprietario"]);
            $categorie = FCategoria::loadByLocale($result["id"]);
            $localizzazione = FLocalizzazione::loadByField("id" , $result["localizzazione"]);
            $eventi = FEvento::loadByLocale($result["id"]);
            $orari = FOrario::loadByLocale($result["id"]);
            $locale=new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario ,$categorie, $localizzazione ,$eventi,$orari);
            // $locale->setId($result['id']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $locale = array();
                $proprietario = array();
                $categorie = array();
                $localizzazione = array();
                $eventi = array();
                $orari = array();
                for($i=0; $i<count($result); $i++){
                    $proprietario[] = FProprietario::loadByField("id" , $result[$i]["proprietario"]);
                    $categorie[] = FCategoria::loadByLocale($result[$i]["id"]);
                    $localizzazione[] = FLocalizzazione::loadByField("id" , $result[$i]["localizzazione"]);
                    $eventi[] = FEvento::loadByLocale($result[$i]["id"]);
                    $orari[] = FOrario::loadByLocale($result[$i]["id"]);
                    $locale[]=new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $proprietario[$i] ,$categorie[$i], $localizzazione[$i] ,$eventi[$i], $orari[$i]);
                  //  $locale[$i]->setIdAd($result[$i]['id']);
                }
            }
        }
        return $locale;
    }

}
?>

