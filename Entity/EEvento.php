<?php

    /** La classe EEvento rapprensenta un evento organizzato da un locale ed è caratterizzato da:
     *  - nome: identifica il nome (titolo) dell'evento
     *  - tipo: identifica il tipo di evento
     *  - descrizione: aumenta le informazioni sull'evento
     *  - data: indentifica la data in cui si terrà l'evento
     *  @author Gruppo8
     *  @package Entity
     */
    class EEvento
    {
        private string $nome;
        private string $tipo;
        private string $descrizione;
        private DateTime $data;



        /**
         * @param string $nome
         * @param string $tipo
         * @param string $descrizione
         * @param DateTime $data
         */
        public function __construct(string $nome, string $tipo, string $descrizione, DateTime $data)
        {
            $this->nome = $nome;
            $this->tipo = $tipo;
            $this->descrizione = $descrizione;
            $this->data = $data;
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
        public function getTipo(): string
        {
            return $this->tipo;
        }

        /**
         * @param string $tipo
         */
        public function setTipo(string $tipo): void
        {
            $this->tipo = $tipo;
        }

        /**
         * @return string
         */
        public function getDescrizione(): string
        {
            return $this->descrizione;
        }

        /**
         * @param string $descrizione
         */
        public function setDescrizione(string $descrizione): void
        {
            $this->descrizione = $descrizione;
        }

        /**
         * @return DateTime
         */
        public function getData(): DateTime
        {
            return $this->data;
        }

        /**
         * @param DateTime $data
         */
        public function setData(DateTime $data): void
        {
            $this->data = $data;
        }


    }