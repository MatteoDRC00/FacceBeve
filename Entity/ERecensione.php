<?php

/** La classe ERecensione caratterizza una recensione di un locale attraverso:
 * * Id: identificativo della recensione
 * * Titolo: identifica il titolo della recensione
 * * Descrizione: identifica il testo della recensione
 * * Utente: identifica l'autore della recensione
 * * Locale: identifica il locale su cui viene scritta la recensione
 * * Voto: identifica il voto dato al locale dal singolo utente
 * * Data: identifica il momento in cui è stat scritta la recensione
 * * Segnalata: indica lo stato della recensione, i.e., se essa è stata segnalata o meno
 * @author Gruppo8
 * @package Entity
 */
class ERecensione implements JsonSerializable {

    /**
     * Id della recensione che lo identifica sul db
     * @var int|null
     */
    private ?int $id;

    /**
     * Utente autore della recensione
     * @var EUtente
     */
    private EUtente $utente;

    /**
     * Locale cui viene scritta la recensione
     * @var ELocale
     */
	private ELocale $locale;

    /**
     * Titolo della recensione
     * @var string
     */
    private string $titolo;

    /**
     * Testo della recensione
     * @var string
     */
    private string $descrizione;

    /**
     * Voto nella recensione
     * @var float
     */
    private float $voto;

    /**
     * Data in cui viene scritta/pubblicata la recensione
     * @var string
     */
    private string $data;

    /**
     * Stato della recensione, se segnalata o meno
     * @var bool
     */
	private bool $segnalata;

    /**
     * Costruttore della classe
     * @param EUtente $utente
     * @param string $titolo
     * @param string $descrizione
     * @param float $voto
     * @param string $data
     * @param ELocale $locale
     */
    public function __construct(EUtente $utente, string $titolo, string $descrizione, float $voto, string $data,ELocale $locale){
        $this->id = NULL;
        $this->utente = $utente;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->voto = $voto;
        $this->data = $data;
		$this->locale=$locale;
		$this->segnalata=false;
    }

    /**
     * Restituisce l'id della recensione
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Imposta/Modifica l'id della recensione
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    /**
     * Restituisce l'autore della recensione
     * @return EUtente
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }


    /**
     * Imposta/Modifica l'autore della recensione
     * @param EUtente $utente
     */
    public function setUtente(EUtente $utente): void
    {
        $this->utente = $utente;
    }

    /**
     * Restituisce il titolo della recensione
     * @return string
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * Imposta/Modifica il titolo della recensione
     * @param string $titolo
     */
    public function setTitolo(string $titolo): void
    {
        $this->titolo = $titolo;
    }

    /**
     * Restituisce il testo/descrizione della recensione
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta/Modifica il testo/descrizione della recensione
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Restituisce il voto della recensione
     * @return float
     */
    public function getVoto(): float
    {
        return $this->voto;
    }

    /**
     * Imposta/Modifica il voto della recensione
     * @param float $voto
     */
    public function setVoto(float $voto): void
    {
        $this->voto = $voto;
    }

    /**
     * Restituisce la data di pubblicazione della recensione
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Imposta/Modifica la data di pubblicazione della recensione
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * Restituisce il locale relativo alla recensione
	* @return ELocale $locale
	*/
    public function getLocale() : ELocale
	{
		return $this->locale;
	}

    /**
     * Imposta/Modifica il locale relativo alla recensione
     * @param ELocale $locale
     */
    public function setLocale(ELocale $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * Restituisce lo stato della recensione
     * @return bool
     */
    public function isSegnalata(): bool
    {
        return $this->segnalata;
    }

    /**
     * Imposta/Modifica lo stato della recensione
     * @param bool $segnalata
     */
    public function setSegnala(bool $segnalata): void
    {
        $this->segnalata = $segnalata;
    }

    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'utente' => $this->getUtente(),
                'locale'   => $this->getLocale(),
                'descrizione'   => $this->getDescrizione(),
                'titolo'   => $this->getTitolo(),
                'voto'   => $this->getVoto(),
                'data'   => $this->getData(),
                'segnalata'   => $this->isSegnalata()
            ];
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