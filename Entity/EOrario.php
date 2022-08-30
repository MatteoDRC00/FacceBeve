<?php
/** La classe orario definisce in base al giorno della settimana l'orario di apertura e l'orario di chiusura del locale, caratterizzato da:
 *  - giorno_settimana: indica il giorno della settimana
 *  - orario_aperuta: indica l'ora di apertura del locale in base al giorno della settimana
 *  - orario_chiusura: indica l'ora di chiusura del locale in base al giorno della settimana
 */
class EOrario{

    private int $id;
    private string $giorno_settimana;
    private string $orario_apertura;
    private string $orario_chiusura;

    /**
     * @param string $giorno_settimana
     * @param string $orario_apertura
     * @param string $orario_chiusura
     */
    public function __construct(string $giorno_settimana, string $orario_apertura, string $orario_chiusura)
    {
        $this->id = NULL;
        $this->giorno_settimana = $giorno_settimana;
        $this->orario_apertura = $orario_apertura;
        $this->orario_chiusura = $orario_chiusura;
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
    public function getGiornoSettimana(): string
    {
        return $this->giorno_settimana;
    }

    /**
     * @return int
     */
    public function getCodice(): int
    {
        return $this->codicegiorno;
    }

    /**
     * @return int
     */
    public function setCodice(int $codice): void
    {
        $this->codicegiorno=$codice;
    }

    /**
     * @param string $giorno_settimana
     */
    public function setGiornoSettimana(string $giorno_settimana): void
    {
        $this->giorno_settimana = $giorno_settimana;
    }

    /**
     * @return string
     */
    public function getOrarioApertura(): string
    {
        return $this->orario_apertura;
    }

    /**
     * Metodo che imposta l'orario di apertura del locale in un dato giorno, se viene passato un valore nullo allora il locale sarà chiuso;
     * Quindi apertura : Chiusi
     * @param string $orario_apertura
     */
    public function setOrarioApertura(string $orario_apertura): void
    {
        if(isset($orario_apertura))
            $this->orario_apertura = $orario_apertura;
        else
            $this->orario_apertura = "Chiusi";
    }

    /**
     * Metodo che imposta l'orario di chiusura del locale in un dato giorno, se viene passato un valore nullo allora il locale sarà chiuso;
     * Quindi apertura : stringa vuota(già l'apertura  ci dice che è chiuso)
     * @return string
     */
    public function getOrarioChiusura(): string
    {
        return $this->orario_chiusura;
    }

    /**
     * @param string $orario_chiusura
     */
    public function setOrarioChiusura(string $orario_chiusura): void
    {
        $this->orario_chiusura = $orario_chiusura;
        if(isset($orario_chiusura))
            $this->orario_chiusura = $orario_chiusura;
        else
            $this->orario_chiusura = "";
    }

    public function __toString(): string
    {
        return $this->giorno_settimana.": ".$this->orario_apertura." - ".$this->orario_chiusura;
    }


}