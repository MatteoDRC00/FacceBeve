<?php
class ERecensione {

    //private static int $contar = 0;

    private int $codicerecensione;
    private EUtente $utente;
	private ELocale $locale;
    private string $titolo;
    private string $descrizione;
    private int $voto;
    private DateTime $data;
	private boolean $segnalata;
	private int $counter;
	/**
	* identificativo univoco della recensione 
    * @AttributeType int
    
    private $id; */

    /**
     * @param EUtente $utente
     * @param string $titolo
     * @param string $descrizione
     * @param int $voto
     * @param DateTime $data
     */
    public function __construct(EUtente $utente, string $titolo, string $descrizione, int $voto, DateTime $data,ELocale $locale){
		//$this->codicerecensione = self::$contar;
       // self::$contar++;
        $this->utente = $utente;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->voto = $voto;
        $this->data = $data;
		$this->locale=$locale;
		$this->segnalata=false;
		$this->counter=0;
    }

    /**
     * @return EUtente
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }
	
	/**
         * @return int
         */
        public function getCodice(): int
        {
            return $this->codicerecensione;
        }

    /**
     * @param EUtente $utente
     */
    public function setUtente(EUtente $utente): void
    {
        $this->utente = $utente;
    }

    /**
     * @return string
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * @param string $titolo
     */
    public function setTitolo(string $titolo): void
    {
        $this->titolo = $titolo;
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
     * @return int
     */
    public function getVoto(): int
    {
        return $this->voto;
    }

    /**
     * @param int $voto
     */
    public function setVoto(int $voto): void
    {
        $this->voto = $voto;
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

    /**
	* @return ELocale $locale
	*/
    public function getLocale() : ELocale
	{
		return $this->locale;
	}

    /**
     * @param ELocale $locale
     */
    public function setLocale(ELocale $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return bool
     */
    public function isSegnalata(): bool
    {
        return $this->segnalata;
    }

    /**
     * @param bool $segnalata
     */
    public function setSegnalata(bool $segnalata): void
    {
        $this->segnalata = $segnalata;
    }

    /**
     * @param int $codice
     */
    public function setCodice(int $codice): void
    {
        $this->codicerecensione = $codice;
    }

    //Gestione segnalazioni a recensione
    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @param int $counter
     */
    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }
	


	// ----------------------------- TOSTRING --------------------------------

	/**
	* @return String Stampa le informazioni relative alla recensione
	 */
	public function __toString() {
		return "TESTO: ".$this->getDescrizione(). " | VALUTAZIONE: ".$this->getVoto()." | SCRITTA DA : ".$this->getUtente(). " | IL: ".$this->getData()." | DATA A: ".$this->getLocale(). "\n";
	}
	
	
	
	

}
?>