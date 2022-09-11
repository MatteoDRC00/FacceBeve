<?php
/**
 * La classe FUtente fornisce query per gli oggetti EUtente
 * @author Gruppo 8
 * @package Foundation
 */
class FLocale {

    /** classe Foundation */
    private static $class="FLocale";

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
        $stmt->bindValue(':visibility',$locale->getVisibility(), PDO::PARAM_INT);
		$stmt->bindValue(':descrizione',$locale->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':proprietario', $locale->getProprietario()->getUsername(), PDO::PARAM_INT);
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
     * @return string
     */
    public static function store(ELocale $locale){
        $id = NULL;
        $db = FDB::getInstance();
        $proprietario = $db->exist("FProprietario", "proprietario", $locale->getProprietario()->getUsername());
        //DA VEDERE $localizzazione = $db->exist("FLocalizzazione", "localizzazione", $locale->getLocalizzazione()->getId());
        if($proprietario && $localizzazione) {
            $id = $db->store(static::getClass() ,$locale);
            //Categorie Locale
            if($locale->getCategoria()!=null){
                foreach($locale->getCategoria() as $cat){
                    $genere = $cat->getGenere();
                    $db->chiaviEsterne("Locale_Categorie","ID_Locale","ID_Categoria",$id,$genere);
                }
            }
            //Orari Locale
            if($locale->getOrario()!=null){
                foreach($locale->getOrario() as $or){
                    $idOrario = $or->getId();
                    $db->chiaviEsterne("Locale_Orari","ID_Locale","ID_Orario",$id,$idOrario);
                }
            }
            //Locale Eventi
            if($locale->getEventiOrganizzati()!=null){
                foreach($locale->getEventiOrganizzati() as $ev){
                    $idEvento = $ev->getId();
                    $db->chiaviEsterne("Locale_Eventi","ID_Locale","ID_Evento",$id,$idEvento);
                }
            }
            //Locale Immag
            if($locale->getImg()!=null){
                foreach($locale->getImg() as $img){
                    $idImg = $img->getId();
                    $db->chiaviEsterne("Locale_Immagini","ID_Locale","ID_Immagine",$id,$idImg);
                }
            }
        }
        //$locale->setId($id);
        return $id;
    }

    /**
     * metodo che permette di cancellare tuple nelle tabelle generate da relazioni N:N
     * @param Object $obj oggetto da cancellare
     * @return void
     */
    public static function deleteEsterne(Object $obj){
        $id = NULL;
        $db = FDB::getInstance();
        //Immagini Locale
        if(get_class($obj)=="ECategoria"){
            $db->delete("Locale_Categorie","ID_Categoria",$obj->getGenere());
        }
    }

    /**
     * metodo che permette di cancellare tuple nelle tabelle generate da relazioni N:N
     * @param Object $obj oggetto da cancellare
     * @return void
     */
    public static function storeEsterne(Object $obj,$id){
        $db = FDB::getInstance();
        //Immagini Locale
        if(get_class($obj)=="ECategoria"){
            $genere = $obj->getGenere();
            $db->chiaviEsterne("Locale_Categorie","ID_Locale","ID_Categoria",$id,$genere);
        }elseif(get_class($obj)=="EImmagine"){
            $idImg = $obj->getId();
            $db->chiaviEsterne("Locale_Immagini","ID_Locale","ID_Immagine",$id,$idImg);
        }elseif(get_class($obj)=="EEvento"){
            $idEvento = $obj->getId();
            $db->chiaviEsterne("Locale_Eventi","ID_Locale","ID_Evento",$id,$idEvento);
        }
    }

    /**
     * Permette la load dal database
     * @param $field
     * @param $id
     * @return array|ELocale
     */
    public static function loadByField($field, $id){
        //$locale = null;
        $db = FDB::getInstance();
        return $db->load(static::getClass(), $field, $id);
        /*$rows_number = $db->interestedRows(static::getClass(), $field, $id);    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $proprietario = FProprietario::loadByField("id" , $result["proprietario"]);
            $categorie = FCategoria::loadByLocale($result["id"]);
            $localizzazione = FLocalizzazione::loadByField("id" , $result["localizzazione"]);
            $eventi = FEvento::loadByLocale($result["id"]);
            $orari = FOrario::loadByLocale($result["id"]);
            $immagini = FImmagine::loadByLocale($result["id"]);
            $locale=new ELocale($result['nome'], $result['descrizione'], $result['numtelefono'], $proprietario ,$categorie, $localizzazione ,$eventi,$orari); //Carica un Locale dal database
            $locale->setVisibility($result['visibility']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $locale = array();
                $proprietario = array();
                $categorie = array();
                $localizzazione = array();
                $eventi = array();
                $immagini = array();
                $orari = array();
        	    for($i=0; $i<count($result); $i++){
                    $proprietario[] = FProprietario::loadByField("id" , $result[$i]["proprietario"]);
                    $categorie[] = FCategoria::loadByLocale($result[$i]["id"]);
                    $localizzazione[] = FLocalizzazione::loadByField("id" , $result[$i]["localizzazione"]);
                    $eventi[] = FEvento::loadByLocale($result[$i]["id"]);
                    $orari[] = FOrario::loadByLocale($result[$i]["id"]);
                    $immagini[] = FImmagine::loadByLocale($result[$i]["id"]);
                    $locale[]=new ELocale($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['numtelefono'], $proprietario[$i] ,$categorie[$i], $localizzazione[$i] ,$eventi[$i], $orari[$i]);
                    //$locale[$i]->setIdAd($result[$i]['id']); //Carica un array di oggetti Locale dal DB
                    $locale[$i]->setVisibility($result[$i]['visibility']); //?
                }
            }
        }
        return $locale;*/
    }

    /**
     * metodo che verifica l'esistenza di un Locale nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore): bool
    {
        $db = FDB::getInstance();
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
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk): bool
    {
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
    public static function delete(string $attributo, string $valore): bool
    {
        $db=FDB::getInstance();
        $result = $db->delete(static::getClass(), $attributo, $valore);
        if($result)
            return true;
        else
            return false;
    }

    /**
     * Funzione con il compito di caricare le recensioni di un locale, obsoleto.

    public static function recensioniLocale() {
        $db = FDB::getInstance();
        $result = $db->getRecensioniLocali();
        //$rows_number = $result->rowCount();
        if (($result!=null) && ($rows_number == 1)){
            $rece = array();
            if($result["nomelocale"]==$nomelocal && $result["luogolocale"]==$luogo)
               $rece[] = FRecensione::loadByField("codicerecensione" , $result["codicerecensione"]);
        }
        return $rece;
    }*/

     /** Metodo che permette di caricare un locale che ha determinati parametri, i quali vengono passati in input da una form */
     public static function loadByForm ($part1, $part2, $part3) {
        $locale = null;
        $db=FDB::getInstance();
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

    /** Metodo che recupera dal db tutte le istanze che contengono il parametro passato in inpu
     * @param $parola input ricevuto
     */
    public static function loadByParola($parola){
        $annuncio = null;
        $intermedia = null;
        $tappa = null;
        $db=FDB::getInstance();
        list ($result, $rows_number)=$db->CercaByKeyword($parola, static::getClass(), "descrizione");
        if(($result!=null) && ($rows_number == 1)) {
            $luogo = FLocalizzazione::loadByField("id" , $result["localizzazione"]);
            $proprietario = FProprietario::loadByField("id" , $result["proprietario"]);
            $categoria = FCategoria::loadByLocale($result["id"]);
            $orario = FOrario::loadByLocale($result["id"]);
            $eventi = FEvento::loadByLocale($result["id"]);

            $locale = new ELocale($result['nome'],$result['descrizione'],$result['numtelefono'],$proprietario,$categoria,$luogo,$eventi,$orario);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $luogo = array();
                $proprietario = array();
                $categoria = array();
                $orario = array();
                $eventi = array();
                $locale = array();
                for($i=0; $i<count($result); $i++){
                    $luogo[] = FLocalizzazione::loadByField("id" , $result[$i]["localizzazione"]);
                    $proprietario[] = FProprietario::loadByField("id" , $result[$i]["proprietario"]);
                    $categoria[] = FCategoria::loadByLocale($result[$i]["id"]);
                    $orario[] = FOrario::loadByLocale($result[$i]["id"]);
                    $eventi[] = FEvento::loadByLocale($result[$i]["id"]);
                    $locale[] = new ELocale($result[$i]['nome'],$result[$i]['descrizione'],$result[$i]['numtelefono'],$proprietario[$i],$categoria[$i],$luogo[$i],$eventi[$i],$orario[$i]);
                    $locale[$i]->setId($result[$i]['id']);

                }
            }
        }
        return $locale;
    }


    public static function getTopLocali(){
        $db = FDB::getInstance();
        return $db->getLocaliPerValutazione();
    }


}
?>

