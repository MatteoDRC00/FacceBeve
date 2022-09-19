<?php
/**
 * La classe FEvento fornisce query per gli oggetti EEvento
 * @author Gruppo8
 * @package Foundation
 */
class FEvento {

    /** classe Foundation */
    private static $class="FEvento";

    /** tabella con la quale opera nel DB */
    private static $table="Evento";

    /** valori della tabella nel DB */
    private static $values="(:id,:nome,:descrizione,:data,:idImg)";

    public function __construct(){

    }

    /**
     * metodo che lega gli attributi dell'Evento da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EEvento $evento
     * @return void
     */
    public static function bind(PDOStatement $stmt, EEvento $evento){
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $evento->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $evento->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':data', $evento->getData());
        if($evento->getImg() != null)
            $stmt->bindValue(':idImg', $evento->getImg()->getId());
        else
            $stmt->bindValue(':idImg', null);
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
     * @param EEvento $evento
     * @return false|string|null
     */
    public static function store(EEvento $evento){
        $db = FDB::getInstance();
        return $db->store(self::getClass(), $evento);
    }

    /**
     * metodo che verifica l'esistenza di un Evento nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore) {
        $db = FDB::getInstance();
        return $db->exist(static::getClass(), $attributo, $valore);
    }

    /**
     * metodo che aggiorna il valore di un attributo dell'Evento sul DB data la chiave primaria
     * @param string $attributo
     * @param string $newvalue
     * @param string $attributo_pk
     * @param string $value_pk
     * @return bool
     */
    public static function update(string $attributo, string $newvalue, string $attributo_pk, string $value_pk){
        $db = FDB::getInstance();
        return $db->update(static::getClass(), $attributo, $newvalue, $attributo_pk, $value_pk);
    }

    /**
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function delete(string $attributo, string $valore){
        $db=FDB::getInstance();
        return $db->delete(static::getClass(), $attributo, $valore);
    }

    public static function loadByField($field, $value){
        $evento = array();
        $db = FDB::getInstance();
        list($result,$num) = $db->load(static::getClass(), $field, $value);
        if(($result!=null) && ($num == 1)) {
            $immagine = FImmagine::loadByField("id",$result['idImg']);
            $evento[0] = new EEvento($result['nome'], $result['descrizione'], $result['data']); //Carica un evento dal database
            $evento[0]->setImg($immagine);
            $evento[0]->setId($result['id']);
        } else {
            if(($result!=null) && ($num > 1)){
                for($i=0; $i<count($result); $i++){
                    $immagine = FImmagine::loadByField("id",$result[$i]['idImg']);
                    $evento[$i] = new EEvento($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['data']); //Carica un array di oggetti Evento dal database
                    $evento[$i]->setImg($immagine);
                    $evento[$i]->setId($result['id']);
                }
            }
        }
        return $evento;
    }

    /**
     * @param $id
     * @return array
     */
    public static function loadByLocale($id){
        $evento = array();
        $db = FDB::getInstance();
        list($result,$num) = $db->loadInfoLocale(static::getClass(),"Locale_Eventi",$id,"ID_Evento","id");
        if(($result!=null) && ($num == 1)) {
            $immagine = FImmagine::loadByField("id",$result['idImg']);
            $evento[0] = new EEvento($result['nome'], $result['descrizione'], $result['data']); //Carica un evento dal database
            $evento[0]->setImg($immagine);
            $evento[0]->setId($result['id']);
        }
        else {
            if(($result!=null) && ($num > 1)){
                for($i=0; $i<count($result); $i++){
                    $immagine = FImmagine::loadByField("id",$result[$i]['idImg']);
                    $evento[$i] = new EEvento($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['data']); //Carica un array di oggetti Evento dal database
                    $evento[$i]->setImg($immagine);
                    $evento[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $evento;
    }


    /**
     * @param $username
     * @return array
     */
    public static function loadByUtente($username){
        $evento = array();
        $db = FDB::getInstance();
        list($result,$num) = $db->loadEventiUtente(static::getClass(),static::getTable().id,$username);
        if(($result!=null) && ($num == 1)) {
            $immagine = FImmagine::loadByField("id",$result['idImg']);
            $evento[0] = new EEvento($result['nome'], $result['descrizione'], $result['data']); //Carica un evento dal database
            $evento[0]->setImg($immagine);
            $evento[0]->setId($result['id']);
        }
        else {
            if(($result!=null) && ($num > 1)){
                for($i=0; $i<count($result); $i++){
                    $immagine = FImmagine::loadByField("id",$result[$i]['idImg']);
                    $evento[$i] = new EEvento($result[$i]['nome'], $result[$i]['descrizione'], $result[$i]['data']); //Carica un array di oggetti Evento dal database
                    $evento[$i]->setImg($immagine);
                    $evento[$i]->setId($result['id']);
                }
            }
        }
        return $evento;
    }




    /** Metodo che permette di caricare un evento che ha determinati parametri, i quali vengono passati in input da una form */
    public static function loadByForm($part1, $part2,$part3,$part4) {
        $evento = array();
        $locale = array();
        $db = FDB::getInstance();
        list($result,$num) = $db->loadMultipleEvento($part1, $part2, $part3, $part4);
        if(($result != null) && ($num == 1)) {
            $id_locale = $db->loadLocaleByEvento($result["id"]);
            $locale[0] = FLocale::loadByField("id", $id_locale);
            $evento[0] = new EEvento($result["nome"],$result["descrizione"],$result["data"]);
            $evento[0]->setImg(FImmagine::loadByField('id', $result['idImg']));
            $evento[0]->setId($result["id"]);
        }
        else {
            if(($result!=null) && ($num> 1)){
                for($i=0; $i<count($result); $i++){
                    $id_locale = $db->loadLocaleByEvento($result["id"]);
                    $locale[$i] = FLocale::loadByField("id", $id_locale);
                    $evento[$i] = new EEvento($result[$i]["nome"],$result[$i]["descrizione"],$result[$i]["data"]);
                    $evento[$i]->setImg(FImmagine::loadByField('id', $result[$i]['idImg']));
                    $evento[$i]->setId($result[$i]["id"]);
                }
            }
        }
        return array($evento,$locale);
    }

    /**
     * metodo che permette di salvare le immagini di un evento nel db
     * @param EEVento $evento di cui si vuole salvare le img
     * @return void
     */
    public static function addImmagine(EEvento $evento){
        $id = NULL;
        $db = FDB::getInstance();
        //Immagini Evento
        if($evento->getImmagini()!=null){
            foreach($evento->getImmagini() as $img){
                $idImg = $img->getId();
                $db->chiaviEsterne("Evento_Immagini","ID_Evento","ID_Immagine",$id,$idImg);
            }
        }
    }

    /**
     * metodo che permette di cancellare tuple nelle tabelle generate da relazioni N:N
     * @param Object $obj oggetto da cancellare
     * @return void
     */
    public static function deleteEsterne(Object $obj){;
        $db = FDB::getInstance();
        if(get_class($obj)=="EImmagine") {
            $db->delete("Evento_Immagini", "ID_Immagine", $obj->getId());
        }
    }

    /**
     * metodo che permette di cancellare tuple nelle tabelle generate da relazioni N:N
     * @param Object $obj oggetto da cancellare
     * @return void
     */
    public static function storeEsterne(Object $obj,$id){
        $db = FDB::getInstance();
        if(get_class($obj)=="EImmagine"){
            $idImg = $obj->getId();
            $db->chiaviEsterne("Evento_Immagini","ID_Evento","ID_Immagine",$id,$idImg);
        }
    }




}