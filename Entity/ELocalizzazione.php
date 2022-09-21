<?php

/** La classe ELocalizzazione caratterizza un luogo fisico di un locale attraverso:
 * * Id: identificativo della localizzazione
 * * Indirizzo: identifica l'indirizzo
 * * NumCivico: identifica il numero civico
 * * Citta: identifica la città
 * * CAP: identifica il CAP
 * @author Gruppo8
 * @package Entity
 */
class ELocalizzazione implements JsonSerializable
{

    private ?int $id;
    private string $indirizzo;
    private string $numCivico;
    private string $citta;
    private int $CAP;

    /**
     * Costruttore della classe
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
     * Restituisce l'Id della localizzazione che lo identifica sul db
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Imposta/Modifica l'id della localizzazione
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Restituisce l'indirizzo della localizzazione
     * @return string
     */
    public function getIndirizzo(): string
    {
        return $this->indirizzo;
    }


    /**
     * Imposta/Modifica l'indirizzo della localizzazione
     * @param string $indirizzo
     */
    public function setIndirizzo(string $indirizzo): void
    {
        $this->indirizzo = $indirizzo;
    }

    /**
     * Restituisce il numero civico della localizzazione
     * @return string
     */
    public function getNumCivico(): string
    {
        return $this->numCivico;
    }

    /**
     *  Imposta/Modifica il numero civico della localizzazione
     * @param string $numCivico
     */
    public function setNumCivico(string $numCivico): void
    {
        $this->numCivico = $numCivico;
    }

    /**
     * Restituisce la citta' in cui risiede il locale
     * @return string
     */
    public function getCitta(): string
    {
        return $this->citta;
    }

    /**
     * Imposta/Modifica la citta' della localizzazione
     * @param string $citta
     */
    public function setCitta(string $citta): void
    {
        $this->citta = $citta;
    }

    /**
     * Restituisce il CAP della localizzazione
     * @return int
     */
    public function getCAP(): int
    {
        return $this->CAP;
    }

    /**
     * Imposta/Modifica il CAP della localizzazione
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
                'codiceluogo' => $this->getCodice(),
                'indirizzo' => $this->getIndirizzo(),
                'numCivico' => $this->getNumCivico(),
                'citta' => $this->getCitta(),
                'nazione' => $this->getNazione(),
                'cap' => $this->getCAP()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString()
    {
        $print = "\ncodiceluogo: " . $this->getId() . "\n" . "indirizzo: " . $this->getIndirizzo() . "\n" . "numCivico: " . $this->getNumCivico() . "\n" . "citta: " . $this->getCitta() . "\n" . "CAP: " . $this->getCAP() . "\n";

        return $print;
    }

}