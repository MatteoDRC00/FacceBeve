<?php

require_once 'Smarty/libs/Smarty.class.php';

/** La classe USession si occupa di gestire tutte le operazioni legate alla gestione delle sessioni PHP.
 *  @author Gruppo8
 *  @package Foundation/Utility
 */
class USession
{

    /**
     * Costruttore della classe USession. Imposta la durata del cookie a 15 minuti e avvia la sessione.
     */
    public function __construct()
    {
       // session_set_cookie_params(15*60);
        session_start();
    }

    /**
     * Imposta il valore di un elemento dell'array globale $_SESSION identificato dalla chiave
     * @param $chiave mixed
     * @param $valore mixed
     * @return void
     */
    function imposta_valore($chiave, $valore) {
        $_SESSION[$chiave] = $valore;
    }

    /**
     * Va ad eliminare la sessione, rimuovendone ogni traccia.
     * @return void
     */
    function chiudi_sessione() {
        session_unset(); //Dealloca la RAM, i.e., libera tutte le variabili di sessione attualmente registrate.
        session_destroy(); //Distrugge il file sul file system del server,i.e., distrugge tutti i dati associati alla sessione corrente
        setcookie('PHPSESSID',null); //Svuota il cookie su client
    }

    /**
     * Metodo che va a svuotare uno degli elementi del vettore $_SESSION, identificato dalla sua chiave
     * @param $chiave mixed
     * @return void
     */
    function cancella_valore($chiave): void{
        unset($_SESSION[$chiave]);
    }

    /**
     * Metodo utilizzato per accedere all'elemento di $_SESSION identificato dalla propria chiave
     * @param $chiave mixed identifica l'elemento del array
    */
    function leggi_valore($chiave) {
        $value = false;
        if (isset($_SESSION[$chiave])) {
            $value = $_SESSION[$chiave];
        }
        return $value;
    }

    public function isLogged(): bool {
        $identificato = false;
        if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }

}