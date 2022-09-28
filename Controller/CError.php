<?php


require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CAccesso è utilizzata per la registrazione e l'autenticazione dell'utente/proprietario.
 * @author Gruppo 8
 * @package Controller
 */
class CError
{
    /**
     * @var CError|null
     */
    public static ?CError $instance = null;

    /**
     * Costruttore della classe
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe
     * @return CError|null
     */
    public static function getInstance(): ?CError
    {
        if (!isset(self::$instance)) {
            self::$instance = new CError();
        }
        return self::$instance;
    }

    /**
     * Mostra la pagina di errore
     * @throws SmartyException
     */
    public function mostraPaginaErrore()
    {
        $view = new VError();
        $view->error();
    }
}