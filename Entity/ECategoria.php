<?php
/** La classe ECategoria caratterizza il tipo di locale con i suoi attributi:
 *  - genere: identifica il tipo di locale
 *  - descrizione: in base al genere specifica le attivita che il locale svolge
 *  @author Gruppo8
 *  @package Entity
 */
class ECategoria{

    private int $id;
    private string $genere;
    private string $descrizione;

    /**
     * @param string $genere
     * @param string $descrizione
     */
    public function __construct(string $genere, string $descrizione){
        $this->id = NULL;
        $this->genere = $genere;
        $this->descrizione = $descrizione;
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
?>