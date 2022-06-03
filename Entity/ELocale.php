<?php

    /** La classe ELocale raggruppa tutti gli attributi che caratterizzano un singolo locale:
     *  - nome: identifica il nome del locale
     *  - descrizione: identifica le informazioni generali sul locale
     *  - num_telefono: identifica il numero di telefono
     *  - valutazione_media: indentifica il voto medio delle recensioni del locale
     *  - proprietario: indentifica il proprietario del locale
     *  - categoria: identifica la categoria del locale, cioè il tipo
     *  - localizzazione: identifica la posizione geografica in cui si trova il locale
     *  - eventi_organizzati: è l'insieme degli eventi organizzati dal locale
     *  - orario_apertura: indica gli orari in cui il locale è aperto in base al giorno della settimana
     *  @author Gruppo8
     *  @package Entity
     */

    class  ELocale{

        private string $nome;
        private string $descrizione;
        private string $num_telefono;
        private EProprietario $proprietario;
        private ECategoria $categoria;
        private ELocalizzazione $localizzazione;
        private $eventi_organizzati = array();
        private $orario = array();

        /**
         * @param string $nome
         * @param string $descrizione
         * @param string $num_telefono
         * @param EProprietario $proprietario
         * @param ECategoria $categoria
         * @param ELocalizzazione $localizzazione
         * @param array $eventi_organizzati
         * @param array $orario
         */
        public function __construct(string $nome, string $descrizione, string $num_telefono, EProprietario $proprietario, ECategoria $categoria, ELocalizzazione $localizzazione, array $eventi_organizzati, EOrario $orario)
        {
            $this->nome = $nome;
            $this->descrizione = $descrizione;
            $this->num_telefono = $num_telefono;
            $this->proprietario = $proprietario;
            $this->categoria = $categoria;
            $this->localizzazione = $localizzazione;
            $this->eventi_organizzati = $eventi_organizzati;
            $this->orario = $orario;
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
         * @return string
         */
        public function getNumTelefono(): string
        {
            return $this->num_telefono;
        }

        /**
         * @param string $num_telefono
         */
        public function setNumTelefono(string $num_telefono): void
        {
            $this->num_telefono = $num_telefono;
        }

        /**
         * @return EProprietario
         */
        public function getProprietario(): EProprietario
        {
            return $this->proprietario;
        }

        /**
         * @param EProprietario $proprietario
         */
        public function setProprietario(EProprietario $proprietario): void
        {
            $this->proprietario = $proprietario;
        }

        /**
         * @return ECategoria
         */
        public function getCategoria(): ECategoria
        {
            return $this->categoria;
        }

        /**
         * @param ECategoria $categoria
         */
        public function setCategoria(ECategoria $categoria): void
        {
            $this->categoria = $categoria;
        }

        /**
         * @return ELocalizzazione
         */
        public function getLocalizzazione(): ELocalizzazione
        {
            return $this->localizzazione;
        }

        /**
         * @param ELocalizzazione $localizzazione
         */
        public function setLocalizzazione(ELocalizzazione $localizzazione): void
        {
            $this->localizzazione = $localizzazione;
        }

        /**
         * @return array
         */
        public function getEventiOrganizzati(): array
        {
            return $this->eventi_organizzati;
        }

        /**
         * @param array $eventi_organizzati
         */
        public function setEventiOrganizzati(array $eventi_organizzati): void
        {
            $this->eventi_organizzati = $eventi_organizzati;
        }

        /**
         * @return array|EOrario
         */
        public function getOrario()
        {
            return $this->orario;
        }

        /**
         * @param array|EOrario $orario
         */
        public function setOrario($orario): void
        {
            $this->orario = $orario;
        }


    }
?>