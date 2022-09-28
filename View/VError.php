<?php
/**
 * Class VError si occupa di gestire la visualizzazione della pagina di errore rispetto all' azione vietata
 */
class VError
{
    /**
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * @return void
     * @throws SmartyException
     */
    public function error()
    {
        $this->smarty->display('error.tpl');

    }

}