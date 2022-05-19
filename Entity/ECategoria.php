<?php

/**
 *
 */
class ECategoria{
    private string $genere;
    private string $descrizione;

    /**
     * @param string $genere
     * @param string $descrizione
     */
    public function __construct(string $genere, string $descrizione)
    {
        $this->genere = $genere;
        $this->descrizione = $descrizione;
    }

    /**
     * @return string
     */
    public function getGenere(): string
    {
        return $this->genere;
    }

    /**
     * @param string $genere
     */
    public function setGenere(string $genere): void
    {
        $this->genere = $genere;
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




}
