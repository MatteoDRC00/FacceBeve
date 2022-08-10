<?php

/**
 * La classe FCategoria fornisce query per gli oggetti ECategoria
 * @author Gruppo 8
 * @package Foundation
 */
class FCategoria {

    /** classe Foundation */
    private static $class="FCategoria";

	/** tabella con la quale opera nel DB */
    private static $table="Categoria";

    /** valori della tabella nel DB */
    private static $values="(:genere,:descrizione)";

    /** costruttore*/ 
    public function __construct(){}

    /**
     * metodo che lega gli attributi della Categoria da inserire con i parametri della INSERT
     * @param PDOStatement $stmt
     * @param ECategoria $categoria
     * @return void
     */
    public static function bind(PDOStatement $stmt, ECategoria $categoria){
        $stmt->bindValue(':genere', $categoria->getGenere(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione',$categoria->getDescrizione(), PDO::PARAM_STR);
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
     * metodo che permette il salvataggio di una Categoria nel db
     * @param ECategoria $categoria Categoria da salvare
     * @return void
     */
    public static function store(ECategoria $categoria){
        $db = FDB::getInstance();
        $genere = $db->store(static::getClass(), $categoria);
        //$categoria->setId($id);
        return $genere;
    }

    /**
     * metodo che verifica l'esistenza di una Categoria nel DB considerato un attributo
     * @param string $attributo
     * @param string $valore
     * @return bool
     */
    public static function exist(string $attributo,string $valore){
        $db = FDatabase::getInstance();
        $result = $db->exist(static::getClass(), $attributo, $valore);
        if($result!=null)
            return true;
        else
            return false;
    }

    /**
     * Permette la load dal database
     * @param $id campo da confrontare per trovare l'oggetto
     * @return object $categoria
     */
    public static function loadByLocale($id){
        $categoria = null;
        $db=FDB::getInstance();
        $result=$db->loadInfoLocale(static::getClass(),"Locale_Categorie",$id);
        $rows_number = $result->rowCount();    //funzione richiamata,presente in FDB --> restituisce numero di righe interessate dalla query
        if(($result!=null) && ($rows_number == 1)) {
            $categoria=new ECategoria($result['genere'], $result['descrizione']); //Carica una categoria dal database
        }
        else {
            if(($result!=null) && ($rows_number > 1)){
                $categoria = array();
                for($i=0; $i<count($result); $i++){
                    $categoria[]=new ECategoria($result[$i]['genere'], $result[$i]['descrizione']); //Carica un array di oggetti Categoria dal database
                }
            }
        }
        return $categoria;
    }

    /**
     * metodo che aggiorna il valore di un attributo della Categoria sul DB data la chiave primaria
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

}

?>