<?php

require_once('Smarty/SmartyBC.class.php');

class StartSmarty{
    /**
     * @return Smarty
     */
    static function configuration(): Smarty
    {
        $smarty = new Smarty();
        $smarty->template_dir='Smarty/templates/';
        $smarty->compile_dir='Smarty/templates_c/';
        $smarty->config_dir='Smarty/configs/';
        $smarty->cache_dir='Smarty/cache/';
        return $smarty;
    }
}

