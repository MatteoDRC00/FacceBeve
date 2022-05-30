<?php
class ERecensione {

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
		return $locale;
	}

    /**
     * @param ELocale $locale
     */
    public function setLocale(ELocale $locale): void
    {
        $this->locale = $locale;
    }
	
	/**
	* @return boolean $segnalato
	*/
	public function getSegnalato() : boolean{
		return $segnalata;
	}
	
	/**
     * @param boolean $segnalata
     */
    public function setSegnalato(boolean $segnalato): void
    {
        $this->segnalata = $segnalato;
    
	
	/**
	* @return int $counter
	*/
	public function getNsegnalazioni() : int{
		return $counter;
	}
	
	/**
     * @param int $counter
     */
    public function setNsegnalazioni(int $counter): void
    {
        $this->counter = $counter;
    }
	
	// ----------------------------- TOSTRING --------------------------------

	/**
	* @return String Stampa le informazioni relative alla recensione
	 */
	public function __toString() {
		$stampa = /*"ID: ".$this->getId(). " */ | TESTO: ".$this->getDescrizione(). " | VALUTAZIONE: ".$this->getVoto()." | SCRITTA DA : ".$this->getUtente(). " | IL: ".$this->getData()." | DATA A: ".$this->getLocale(). "\n";
		return $stampa;
	}
	
	
	
	

}
?>