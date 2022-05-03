<?php
    /**
     *
     */
    class EUserRegistrato extends EUser {

        private string $email;
        private string $password;
        private string $nome;
        private string $cognome;
        private string $username;
        private array $mierecensioni;


        public function __construct(string $nome, string $cognome, string $username, string $email, string $password)
        {
            parent::__costructor();
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->mierecensioni = array();
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
         * @return array
         */
        public function getMierecensioni(): array
        {
            return $this->mierecensioni;
        }

        /**
         * @param array $mierecensioni
         */
        public function addRecensione(string $recensione): void
        {
            $this->mierecensioni.array_push($recensione);
        }



    }
?>