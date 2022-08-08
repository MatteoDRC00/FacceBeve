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
        $stmt->bindValue(':id',$locale->getId(), PDO::PARAM_INT); //l'id è posto a NULL poichè viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome', $locale->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':numtelefono',$locale->getNumTelefono(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione',$locale->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $locale->getProprietario()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':localizzazione', $locale->getLocalizzazione()->getId(), PDO::PARAM_INT);
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
        $idProprietario = $db->getIdProprietario($locale->getProprietario()->getUsername());
        $idLocalizzazione = $db->getIdLocalizzazione($locale->getLocalizzazione()->getIndirizzo(),$locale->getLocalizzazione()->getNumCivico(),$locale->getLocalizzazione()->getCitta());
        $idLocale = $db->store(static::getClass() ,$locale);
        static::update("proprietario",$idProprietario,"id",$idLocale);
        static::update("localizzazione",$idLocalizzazione,"id",$idLocale);
        //Categorie Locale
        if($locale->getCategoria()!=null){
            foreach($locale->getCategoria() as $cat){
                $idCat = $cat->getGenere();
                $db->chiaviEsterne("Locale_Categorie","ID_Locale","ID_Categoria",$idLocale,$idCat);
            }
        }
        //Orari Locale
        if($locale->getOrario()!=null){
            foreach($locale->getOrario() as $or){
                $idOrario = $or->getCodiceOrario(); //Ipotetico
                $db->chiaviEsterne("Locale_Categorie","ID_Locale","ID_Categoria",$idLocale,$idOrario);
            }
        }
        //Locale Eventi
        if($locale->getEventiOrganizzati()!=null){
            foreach($locale->getEventiOrganizzati() as $ev){
                $idEvento = $ev->getCodiceEvento(); //Ipotetico
                $db->chiaviEsterne("Locale_Categorie","ID_Locale","ID_Categoria",$idLocale,$idEvento);
            }
        }
    }


    /**
    * Permette la load dal database
    * @param $id campo da confrontare per trovare l'oggetto
    * @return object $locale
    */
    public static function loadByField($field, $id){ //es: ricerca i locali di Pescara DA MODIFICARE
        $locale = null;
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $proprietario = FProprietario::loadByField("id" , $result["proprietario"]);
            $categorie = FCategoria::loadByLocale($result["id"]);
            $localizzazione = FLocalizzazione::loadByField("id" , $result["localizzazione"]);
            $eventi = FEvento::loadByLocale($result["id"]);
            $orari = FOrario::loadByLocale($result["id"]);
            $locale=new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario ,$categorie, $localizzazione ,$eventi,$orari); //Carica un Locale dal database
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
                    //$locale[$i]->setIdAd($result[$i]['id']); //Carica un array di oggetti Locale dal database
                }
            }
        }
        return $locale;
    }

    /**
     * metodo che verifica l'esistenza di un Locale nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * metodo che aggiorna il valore di un attributo del Locale sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db=FDatabase::getInstance();
        $result = $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
        if($result)
            return true;
        else
            return false;
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

    public static function loadByKeyword($parola) {  //DA MODIFICARE
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

