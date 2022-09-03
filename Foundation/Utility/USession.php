<?php
require('Smarty/Smarty.class.php');
/** La classe USession si occupa di gestire tutte le operazioni legate alla gestione delle sessioni PHP.
 *  @author Gruppo8
 *  @package Foundation/Utility
 */
class USession
{
    /**
     * La variabile statica privata che conterrà l'istanza univoca
     * della classe.
     */
    private static USession $instance;

    /**
     * Il costruttore della classe USession, si occupa d'inizializzare la sessione per l'utente.
    */
    public function __construct() {
        session_start();
    }

    /**
     * Imposta il valore di un elemento dell'array globale $_SESSION identificato dalla chiave
     * @param $chiave Identifica l'elemento nell'array associativo, i.e., l'utente/proprietario/admin
     * @param $valore Generalmente un oggetto dopo aver subito il serialize()
     */
    function imposta_valore($chiave,$valore) {
        $_SESSION[$chiave]=$valore;
    }

    /**
     * Va ad eliminare la sessione, rimuovendo ogni traccia.
     */
    function chiudi_sessione() {
        session_start();
        session_unset(); //Dealloca la RAM, i.e., libera tutte le variabili di sessione attualmente registrate.
        session_destroy(); //Distrugge il file sul file system del server,i.e., distrugge tutti i dati associati alla sessione corrente
        setcookie('PHPSESSID',''); //Svuota il cookie su client
    }

     /**
      * Metodo che va a svuotare uno degli elementi del vettore $_SESSION, identificato dalla sua chiave
      * @param $chiave identifica l'elemento del array
     */
    function cancella_valore($chiave) {
        unset($_SESSION[$chiave]);
    }

    /**
     * Metodo utilizzato per accedere all'elemento di $_SESSION identificato dalla propria chiave
     * @param $chiave identifica l'elemento del array
    */
    function leggi_valore($chiave) {
        return $_SESSION[$chiave] ?? false;
    }

    /**
     * Funzione con il compito di restituire la singola istanza della classe
     * @return l'istanza della classe USession
    */
    public static function getInstance(): USession{
        if ( !(self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}