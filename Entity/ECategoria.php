<?php
/** La classe ECategoria caratterizza il tipo di locale con i suoi attributi:
 *  - genere: identifica il tipo di locale
 *  - descrizione: in base al genere specifica le attivita che il locale svolge
 *  @author Gruppo8
 *  @package Entity
 */
class ECategoria implements JsonSerializable{

    private string $genere;
    private ?string $descrizione;

    /**
     * @param string $genere
     * @param string $descrizione
     */
    public function __construct(string $genere, ?string $descrizione){
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

    public function jsonSerialize()
    {
        return
            [
                'genere'   => $this->getGenere(),
                'descrizione' => $this->getDescrizione(),

            ];
    }



    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\ngenere: ".$this->getGenere()."\n"."descrizione: ".$this->getDescrizione()."\n";

        return $print;
    }


}
?>