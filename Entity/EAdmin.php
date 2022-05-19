<?php
/**
 * La classe EAdmin estende la classe EUser, essa contiene tutti le informazioni e metodi riguardanti gli admin. 
 *  @access public 
 *  @author Gruppo 8
 *  @package Entity
 */ 
    class EAdmin extends EUser {
        //private array $recensionisegnalate;
        public function __construct(){
            parent::__costructor($username,$password);
           // $this->recensionisegnalate = array();
        }

    }
?>