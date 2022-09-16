<?php

    /** La classe ELocalizzazione caratterizza un luogo fisico di un locale attraverso:
     *  - indirizzo: identifica l'indirizzo
     *  - numCivico: identifica il numero civico
     *  - citta: identifica la città
     *  - CAP: identifica il CAP
     *  @author Gruppo8
     *  @package Entity
     */
    class ELocalizzazione implements JsonSerializable {

        private ?int $id;
        private string $indirizzo;
        private string $numCivico;
        private string $citta;
        private int $CAP;

        /**
         * @param string $indirizzo
         * @param string $numCivico
         * @param string $citta
         * @param int $CAP
         */
        public function __construct(string $indirizzo, string $numCivico, string $citta, int $CAP)
        {
            $this->id = null;
            $this->indirizzo = $indirizzo;
            $this->numCivico = $numCivico;
            $this->citta = $citta;
            $this->CAP = $CAP;
        }

        /**
         * @return string
         */
        public function getIndirizzo(): string
        {
            return $this->indirizzo;
        }

        /**
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * @param int|null $id
         */
        public function setId(?int $id): void
        {
            $this->id = $id;
        }



        /**
         * @param string $indirizzo
         */
        public function setIndirizzo(string $indirizzo): void
        {
            $this->indirizzo = $indirizzo;
        }

        /**
         * @return string
         */
        public function getNumCivico(): string
        {
            return $this->numCivico;
        }

        /**
         * @param string $numCivico
         */
        public function setNumCivico(string $numCivico): void
        {
            $this->numCivico = $numCivico;
        }

        /**
         * @return string
         */
        public function getCitta(): string
        {
            return $this->citta;
        }

        /**
         * @param string $citta
         */
        public function setCitta(string $citta): void
        {
            $this->citta = $citta;
        }

        /**
         * @return int
         */
        public function getCAP(): int
        {
            return $this->CAP;
        }

        /**
         * @param int $CAP
         */
        public function setCAP(int $CAP): void
        {
            $this->CAP = $CAP;
        }





        public function jsonSerialize()
        {
            return
                [
                    'codiceluogo'   => $this->getCodice(),
                    'indirizzo' => $this->getIndirizzo(),
                    'numCivico'   => $this->getNumCivico(),
                    'citta'   => $this->getCitta(),
                    'nazione'   => $this->getNazione(),
                    'cap'   => $this->getCAP()
                ];
        }


        /**
         * @return $print String
         */
        public function __toString() {
            $print = "\ncodiceluogo: ".$this->getId()."\n"."indirizzo: ".$this->getIndirizzo()."\n"."numCivico: ".$this->getNumCivico()."\n"."citta: ".$this->getCitta()."\n"."CAP: ".$this->getCAP()."\n";

            return $print;
        }

    }