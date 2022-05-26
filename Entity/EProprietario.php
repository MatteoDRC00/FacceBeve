<?php
/**
 * La classe EProprietario estende la classe EUser, essa contiene tutti gli attributi e metodi base riguardanti i proprietari di locali. 
 * Gli attributi che la descrivono sono:
 * - name: nome del proprietario;
 * - cognome: cognome del proprietario;
 * - email: email proprietario; 
 *  @access public 
 *  @author Gruppo 8
 *  @package Entity
 */ 
    class EProprietario extends EUser {

        private string $email;
        private string $nome;
        private string $cognome;


        public function __construct(string $nome, string $cognome, string $email){
            parent::__costructor($username,$password;);
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->locali = array();
        }

        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
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

        /**
         * @return string
         */
        public function getNome(): string
        {
            return $this->nome;
        }

        /**
         * @param string $nome
         */
        public function setNome(string $nome): void
        {
            $this->nome = $nome;
        }

        /**
         * @return string
         */
        public function getCognome(): string
        {
            return $this->cognome;
        }

        /**
         * @param string $cognome
         */
        public function setCognome(string $cognome): void
        {
            $this->cognome = $cognome;
        }

        /**
         * @return string
         */
        public function getUsername(): string
        {
            return $this->username;
        }

        /**
         * @param string $username
         */
        public function setUsername(string $username): void
        {
            $this->username = $username;
        }
/**
        
        public function GetLocaliGestiti(): array
        {
            return $this->mierecensioni;
        }
		*/
		
		/**
        public function GetLocale($nome){
			$Y = 0;
			foreach($locali as $X){
				if($X::==$nome)
					$Y=$X;;
			} 
			return $Y;
        } */

/**
       
        public function AddLocaleGestito($locale): void
        {
            $this->mierecensioni.array_push($locale);
        }
        
		*/


    }
?>