<?php
/** La classe EOrarioo definisce in base al giorno della settimana l'orario di apertura e l'orario di chiusura del locale, attraverso:
 * * Giorno_settimana: indica il giorno della settimana
 * * Orario_aperuta: indica l'ora di apertura del locale in base al giorno della settimana
 * * Orario_chiusura: indica l'ora di chiusura del locale in base al giorno della settimana
 */
class EOrario implements JsonSerializable {

    private ?int $id;

    /**
     * Giorno della settimana
     * @var string
     */
    private string $giorno_settimana;

    /**
     * Orario di apertura (HH:HH)
     * @var string
     */
    private ?string $orario_apertura;

    /**
     * Orario di chiusura (HH:HH)
     * @var string
     */
    private ?string $orario_chiusura;

    /**
     * @param string $giorno_settimana
     * @param string|null $orario_apertura
     * @param string|null $orario_chiusura
     */
    public function __construct(string $giorno_settimana, ?string $orario_apertura, ?string $orario_chiusura)
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
     * @param string $giorno_settimana
     */
    public function setGiornoSettimana(string $giorno_settimana): void
    {
        $this->giorno_settimana = $giorno_settimana;
    }

    /**
     * @return string|null
     */
    public function getOrarioApertura(): ?string
    {
        return $this->orario_apertura;
    }

    /**
     * @param string|null $orario_apertura
     */
    public function setOrarioApertura(?string $orario_apertura): void
    {
        $this->orario_apertura = $orario_apertura;
    }

    /**
     * @return string|null
     */
    public function getOrarioChiusura(): ?string
    {
        return $this->orario_chiusura;
    }

    /**
     * @param string|null $orario_chiusura
     */
    public function setOrarioChiusura(?string $orario_chiusura): void
    {
        $this->orario_chiusura = $orario_chiusura;
    }



    public function jsonSerialize()
    {
        return
            [
                'is'   => $this->getId(),
                'giorno_settimana' => $this->getGiornoSettimana(),
                'orario_apertura'   => $this->getOrarioApertura(),
                'orario_chiusura'   => $this->getOrarioChiusura()
            ];
    }

    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\nid: ".$this->getId()."\n"."giorno_settimana: ".$this->getGiornoSettimana()."\n"."orario_apertura: ".$this->getOrarioApertura()."\n"."orario_chiusura: ".$this->getOrarioChiusura()."\n";

        return $print;
    }


}