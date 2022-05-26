<?php
/**
 * La classe EUtente estende la classe EUser, essa contiene tutti gli attributi e metodi base riguardanti gli utenti. 
 * Gli attributi che la descrivono sono:
 * - name: nome dell'utente;
 * - cognome: cognome dell'utente;
 * - email: email utente; 
 * - mierecensione: le recensioni scritte dall'utente;
 * - iscrizione: data prima iscrizione di tale utente;
 * - localiprefe: locali preferiti dell'utente.
 *  @access public 
 *  @author Gruppo 8
 *  @package Entity
 */ 
    class EUtente extends EUser {

        private string $email;
        private string $nome;
        private string $cognome;
        private array $mierecensioni;
		private array $localipreferiti;
		private date $iscrizione;


        public function __construct(string $nome, string $cognome, string $username, string $email, date $prima){
            parent::__costructor($username,$password);
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->email = $email;
            $this->mierecensioni = array();
			$this->localipreferiti = array();
			$this->iscrizione = $prima;
        }

//----------------------METODI GET-----------------------------

        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }
		
		/**
         * @return string
         */
        public function getNome(): string
        {
            return $this->nome;
        }
		
		/**
         * @return string
         */
        public function getCognome(): string
        {
            return $this->cognome;
        }
		
        /*		
        public function getUsername(): string
        {
            parent::getUsername();
        }
		
		public function getPassword(){
			parent::getPassword();
		}*/
		
		/**
         * @return array
         */
        public function getMierecensioni(): array
        {
            return $this->mierecensioni;
        }
		
		//-----------------------------METODI SET-----------------------------
		
        /**
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        /**
         * @param string $email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }      

        /**
         * @param string $nome
         */
        public function setNome(string $nome): void
        {
            $this->nome = $nome;
        }

        /**
         * @param string $cognome
         */
        public function setCognome(string $cognome): void
        {
            $this->cognome = $cognome;
        } 

        /*
        public function setUsername(string $username): void
        {
            parent::setUsername($username);
        }
		
		public function setPassword(string $password): void
        {
            parent::setPassword($password);
        }*/

 //-----------------------------Altri Metodi-----------------------------

        /**
         * @param array $mierecensioni
         */
        public function addRecensione($recensione): void
        {
            $this->mierecensioni.array_push($recensione);
        }
		
		/**
         * @param array $locale
         */
        public function addRecensione($locale): void
        {
            $this->localipreferiti.array_push($locale);
        }



    }
?>