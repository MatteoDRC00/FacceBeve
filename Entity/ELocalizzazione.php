<?php
/** La classe ELocalizzazione caratterizza un luogo fisico di un locale
 *  @author Gruppo8
 *  @package Entity
 */
class ELocalizzazione{

    private int $id;
    private string $indirizzo;
    private string $numCivico;
    private string $citta;
    private string $nazione;
    private int $CAP;

    /**
     * @param string $indirizzo
     * @param string $numCivico
     * @param string $citta
     * @param string $nazione
     * @param int $CAP
     */
    public function __construct(string $indirizzo, string $numCivico, string $citta, string $nazione, int $CAP){
        $this->id = NULL;
        $this->indirizzo = $indirizzo;
        $this->numCivico = $numCivico;
        $this->citta = $citta;
        $this->nazione = $nazione;
        $this->CAP = $CAP;
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
     * @return string
     */
    public function getIndirizzo(): string
    {
        return $this->indirizzo;
    }

     /**
     * @return int
     */
    public function getCodice(): int
    {
        return $this->codiceluogo;
    }

    /**
     * @param int $codice
     */
    public function setCodice(int $codice): void
    {
        $this->codiceluogo=$codice;
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
     * @return string
     */
    public function getNazione(): string
    {
        return $this->nazione;
    }

    /**
     * @param string $nazione
     */
    public function setNazione(string $nazione): void
    {
        $this->nazione = $nazione;
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

    public function __toString(): string
    {
        return $this->indirizzo.", n°".$this->numCivico.", ".$this->citta.", ".$this->CAP.", ".$this->nazione;
    }


}