<?php
/**
 * La classe EAdmin estende la classe EUser, essa contiene tutti le informazioni e metodi riguardanti gli admin. 
 *  @author Gruppo 8
 *  @package Entity
 */ 
    class EAdmin extends EUser {

        private string $email;

        public function __construct(string $username, string $email, string $password ){
            parent::__costructor($username,$password);
            $this->email = $email;
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * @param string $email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }


    }
?>