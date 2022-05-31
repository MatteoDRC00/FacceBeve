<?php

    /** La classe orario definisce in base al giorno della settimana l'orario di apertura e l'orario di chiusura del locale, caratterizzato da:
     *  - giorno_settimana: indica il giorno della settimana
     *  - orario_aperuta: indica l'ora di apertura del locale in base al giorno della settimana
     *  - orario_chiusura: indica l'ora di chiusura del locale in base al giorno della settimana
     */
    class EOrario{
		
		$contao = 0;

        private int $codicegiorno;
        private string $giorno_settimana;
        private string $orario_apertura;
        private string $orario_chiusura;

        /**
         * @param string $giorno_settimana
         * @param string $orario_apertura
         * @param string $orario_chiusura
         */
        public function __construct(string $giorno_settimana, string $orario_apertura, string $orario_chiusura)
        {
			$this->codicegiorno = $GLOBALS[$conta];
			$GLOBALS[$conta]=$GLOBALS['contao']+1;
            $this->giorno_settimana = $giorno_settimana;
            $this->orario_apertura = $orario_apertura;
            $this->orario_chiusura = $orario_chiusura;
        }

        /**
         * @return string
         */
        public function getGiornoSettimana(): string
        {
            return $this->giorno_settimana;
        }
		
		/**
         * @return int
         */
        public function getCodice(): int
        {
            return $this->codicegiorno;
        }
		
        /**
         * @param string $giorno_settimana
         */
        public function setGiornoSettimana(string $giorno_settimana): void
        {
            $this->giorno_settimana = $giorno_settimana;
        }

        /**
         * @return string
         */
        public function getOrarioApertura(): string
        {
            return $this->orario_apertura;
        }

        /**
         * @param string $orario_apertura
         */
        public function setOrarioApertura(string $orario_apertura): void
        {
            $this->orario_apertura = $orario_apertura;
        }

        /**
         * @return string
         */
        public function getOrarioChiusura(): string
        {
            return $this->orario_chiusura;
        }

        /**
         * @param string $orario_chiusura
         */
        public function setOrarioChiusura(string $orario_chiusura): void
        {
            $this->orario_chiusura = $orario_chiusura;
        }

        public function __toString(): string
        {
            return $this->giorno_settimana.": ".$this->orario_apertura." - ".$this->orario_chiusura;
        }


    }