<?php


/**
 * La classe FImmagine fornisce query per gli oggetti EImmagine (foto)
 * @author Gruppo 8
 * @package Foundation
 */

class FImmagine
{
    /** nome della classe */
    private static string $class = "FImmagine";
    /** tabella con la quale opera */
    private static $table="Immagine";
    /** valori della tabella */
    private static $values="(:id,:nome,:type,:size,:immagine)";

    /** costruttore */
    public function __construct(){}

    /**
     * Questo metodo lega gli attributi dell'oggetto multimediale da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param EImmagine $md media i cui dati devono essere inseriti nel DB
     */


    public static function bind($stmt, EImmagine $md,$nome_file){
        $path = $_FILES[$nome_file]['tmp_name'];
        $file=fopen($path,'rb') or die ("Attenzione! Impossibile da aprire!");
        $stmt->bindValue(':id',NULL, PDO::PARAM_INT); //l'id � posto a NULL poich� viene dato automaticamente dal DBMS (AUTOINCREMENT_ID)
        $stmt->bindValue(':nome',$md->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':size',$md->getSize(), PDO::PARAM_INT);
        $stmt->bindValue(':type',$md->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':immagine', fread($file,filesize($path)), PDO::PARAM_LOB);
        unset($file);
        unlink($path);
    }

    /**
     * questo metodo restituisce il nome della classe per la costruzione delle Query
     * @return string $class nome della classe
     */
    public static function getClass(){
        return self::$class;
    }

    /**
     *
     * questo metodo restituisce il nome della tabella sul DB per la costruzione delle Query
     * @return string $tables nome della tabella
     */
    public static function getTable(){
        return static::$table;
    }

    /**
     * Metodo che restituisce la stringa dei valori della tabella sul DB per la costruzione delle Query
     * @return string $values valori della tabella
     */
    public static function getValues(){
        return static::$values;
    }

    /**
     * Metodo che permette il salvataggio del media relativo all utente
     * @param object $media
     * @return int $id dell'oggetto salvato
     */
    public static function store(EImmagine $media, $nome_file): int
    {
        $db = FDB::getInstance();
        $id = $db->storeMedia(static::getClass(), $media, $nome_file);
        return $id;
    }

    /**
     * metodo che aggiorna il valore di un attributo della Localizzazione sul DB data la chiave primaria
     * @param EImmagine $img
     * @param string $nome_file
     * @return bool
     */
    public static function update(EImmagine $img,string $nome_file): bool
    {
        $db=FDB::getInstance();
        $result = $db->updateMedia(static::getClass(), $img, $nome_file);
        if($result)
            return true;
        else
            return false;
    }


    /**
     * Metodo che consente la load del media di un locale/evento in base all'id di quest'ultimo
     * @param int $id dell utente
     * @return object $media associato a quell utente
     */
    public static function loadByField($field ,$id)
    {
        $utente = null;
        //$field = "id";
        $db=FDB::getInstance();
        $result=$db->load(static::getClass(), $field, $id);
        //print_r ($result);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);
        if(($result!=null) && ($rows_number == 1)) {
            $img=new EImmagine($result['nome']);
            $img->setType($result['type']);
            $img->setData($result['immagine']);
            $img->setSize($result['size']);
            $img->setId($result['id']);
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $img = array();
                for($i=0; $i<count($result); $i++){
                    $img=new EImmagine($result[$i]['nome']);
                    $img[$i]->setType($result[$i]['type']);
                    $img[$i]->setSize($result[$i]['size']);
                    $img[$i]->setData($result[$i]['immagine']);
                    $img[$i]->setId($result[$i]['id']);
                }
            }
        }
        return $img;
    }

    /**
     * Metodo che verifica se esiste un media con un dato valore in uno dei campi
     * @param $id valore da usare come ricerca
     * @param $field campo da usare come ricerca
     * @return true se esiste il mezzo, altrimenti false
     */
    public static function exist($field, $id){
        $db=FDB::getInstance();
        $result=$db->exist(static::getClass(), $field, $id);
        if($result!=null)
            return true;
        else
            return false;
    }


    /**
     * Metodo che permette la cancellazione del media di un utente in base all id(del media)
     * @param int $id del media (dell utente)
     * @return bool
     */
    public static function delete($field, $id){
        $db=FDB::getInstance();
        $db->delete(static::getClass(), $field, $id);
    }

    /**
     * Permette la load dal database
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $orario
     */
    public static function loadByLocale($id){
        $img = null;
        $db=FDB::getInstance();
        $result=$db->loadInfoLocale(static::getClass(),"Locale_Immagini",$id);
        $rows_number = $result->rowCount();    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $img=new EImmagine($result['nome'],$result['size'],$result['type'],$result['immagine']); //Carica un Orario dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $utente = array();
                for($i=0; $i<count($result); $i++){
                    $img[]=new EImmagine($result[$i]['nome'],$result[$i]['size'],$result[$i]['type'],$result[$i]['immagine']);
                }
            }
        }
        return $img;
    }
}

?>

