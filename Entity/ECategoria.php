<?php

/**
 * La classe ECategoria caratterizza il tipo di locale
 *  @author Gruppo8
 *  @package Entity
 */
class ECategoria{

    /**
     * Identifica il tipo di locale
     * @var string
     */
    private string $genere;

    /**
     * Descrive il genere, con relative informazioni
     * @var string|null
     */
    private ?string $descrizione;

    /**
     * Costruttore della classe
     * @param string $genere
     * @param string|null $descrizione
     */
    public function __construct(string $genere, ?string $descrizione){
        $this->genere = $genere;
        $this->descrizione = $descrizione;
    }


    /**
     * Restituisce il genere di categoria
     * @return string
     */
    public function getGenere(): string
    {
        return $this->genere;
    }

    /**
     * Imposta/Modifica il genere di categoria
     * @param string $genere
     */
    public function setGenere(string $genere): void
    {
        $this->genere = $genere;
    }

    /**
     * Restituisce la descrizione del genere di categoria
     * @return string|null
     */
    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    /**
     * Imposta/Modifica la descrizione del genere di categoria
     * @param string|null $descrizione
     */
    public function setDescrizione(?string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return string
     */
    public function __toString() {
        return "\ngenere: ".$this->getGenere()."\n"."descrizione: ".$this->getDescrizione()."\n";
    }


}