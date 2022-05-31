<?php
    //Da aggiustare...
    class FRecensione{

        /** nome della classe */
        private static $class = "FRecensione";
        /** tabella con la quale opera */
        private static $table = "Recensione";
        /** valori della tabella */
        private static $values="(:codicerecensione,:titolo,:descrizione,:voto,:data,:segnalato,:counter,:utente,:locale)";
        /** costruttore */
        public function __construct() {

        }

        /**
         * Questo metodo lega gli attributi della Recensione da inserire con i parametri della INSERT
         * @param PDOStatement $stmt
         * @param ERecensione $rec Recensione in cui i dati devono essere inseriti nel DB
         */
        public static function bind(PDOStatement $stmt, ERecensione $recensione) {
            $stmt->bindValue(':codicerecensione',$recensione->getCodice() PDO::PARAM_INT);
            $stmt->bindValue(':titolo',$recensione->getTitolo(),PDO::PARAM_STR);
            $stmt->bindValue(':descrizione',$recensione->getDescrizione(),PDO::PARAM_STR);
            $stmt->bindValue(':voto',$recensione->getVoto(),PDO::PARAM_INT);
            $stmt->bindValue(':data',$recensione->getData());
            $stmt->bindValue(':segnalato',$recensione->getSegnalato(),PDO::PARAM_BOOL);
            $stmt->bindValue(':counter',$recensione->getCounter(),PDO::PARAM_INT);
            $stmt->bindValue(':utente',$recensione->getUtente());
            $stmt->bindValue(':locale',$recensione->getLocale());
        }

        /**
         * Questo metodo restituisce il nome della classe per la costruzione delle Query
         * @return string $class nome della classe
         */
        public static function getClass(){
            return self::$class;
        }

        /**
         * Questo metodo restituisce il nome della tabella per la costruzione delle Query
         * @return string $table nome della tabella
         */
        public static function getTable(){
            return self::$table;
        }

        /**
         * Questo metodo restituisce l'insieme dei valori per la costruzione delle Query
         * @return string $values nomi delle colonne della tabella
         */
        public static function getValues(){
            return self::$values;
        }

        /**
         * Permette la load sul db
         * @param $id campo da confrontare per trovare l'oggetto
         * @return object $rec Recensione
         */
        public static function loadByField($field, $id) {
            $rec = null;
            $db = FDatabase::getInstance();
            $result = $db->loadDB(static::getClass(), $field, $id);
            $rows_number = $db->interestedRows(static::getClass(), $field, $id);
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
         * Metodo che permette di salvare una Recensione
         * @param $rec Recensione da salvare
         * @return $id della Recensione salvata
         */
        public static function store(ERecensione $rec) {
            $db = FDatabase::getInstance();
            $id = $db->storeDB(static::getClass(), $rec);
            if($id)
                return $id;
            else
                return null;
        }

        /**
         * Funzione che permette di verificare se esiste una Recensione nel database
         * @param  $id valore della riga di cui si vuol verificare l'esistenza
         * @param  string $field colonna su ci eseguire la verifica
         * @return bool $ris
         */
        public static function exist($field, $id) {
            $ris = false;
            $db = FDatabase::getInstance();
            $result = $db->existDB(static::getClass(), $field, $id);
            if($result!=null)
                $ris = true;
            return $ris;
        }

        /**
         * Permette la delete sul db in base all'id
         * @param int l'id dell'oggetto da eliminare dal db
         * @return bool
         */
        public static function delete($field, $id) {
            $db = FDatabase::getInstance();
            $result = $db->deleteDB(static::getClass(), $field, $id);
            if($result)
                return true;
            else
                return false;
        }

        /**
         * Ritorna tutte le recensioni presenti sul db
         * @return object $rec Recensione
         */
        public static function loadAll() {
            $rec = null;
            $db = FDatabase::getInstance();
            list ($result, $rows_number)=$db->getAllRev();
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
         *
         * @param $parola valore da ricercare all'interno del campo text
         * @return object $rec Recensione
         */
        public static function loadByParola($parola) {
            $rec = null;
            $db = FDatabase::getInstance();
            list ($result, $rows_number)=$db->ricercaParola($parola, static::getClass(), "text");
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


    }