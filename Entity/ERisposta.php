<?php

/** La classe ERisposta caratterizza una risposta a una recensione attraverso:
 * * Id: identificativo della risposta
 * * Descrizione: identifica il testo della recensione
 * * IdRecensione: identifica l'id della recensione a cui si ha risposto
 * * Proprietario: identifica il proprietario del locale che risponde alla recensione
 * @author Gruppo8
 * @package Entity
 */
class ERisposta implements JsonSerializable
{

    /**
     * Id della risposta che lo identifica sul db
     * @var int|null
     */
    private int $id;

    /**
     * Id della recensione a cui si sta rispondendo
     * @var int|null
     */
    private int $IdRecensione;

    /**
     * Proprietario del locale, che ha scritto la risposta
     * @var EProprietario
     */
    private EProprietario $proprietario;

    /**
     * Testo della risposta
     * @var string
     */
    private string $descrizione;

    /**
     * Costruttore della classe
     * @param int $recensione
     * @param string $descrizione
     * @param EProprietario $proprietario
     */
    public function __construct(int $recensione, string $descrizione, EProprietario $proprietario)
    {
        $this->IdRecensione = $recensione;
        $this->descrizione = $descrizione;
        $this->proprietario = $proprietario;
    }


    //Metodi GET

    /**
     * Restituisce l'id della risposta
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Restituisce la descrizione della risposta
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Restituisce l'id della recensione
     * @return int
     */
    public function getIdRecensione(): int
    {
        return $this->IdRecensione;
    }

    /**
     * Restituisce l'autore della risposta
     * @return EProprietario
     */
    public function getProprietario(): EProprietario
    {
        return $this->proprietario;
    }



    //Metodi SET

    /**
     * Imposta/Modifica l'id della risposta
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Imposta/Modifica la descrizione/testo della risposta
     * @param int $id
     */
    public function setDescrizione(string $testo): void
    {
        $this->descrizione = $testo;
    }

    /**
     * Imposta/Modifica l'id della recensione
     * @param int $recensione
     */
    public function setIdRecensione(int $recensione): void
    {
        $this->IdRecensione = $recensione;
    }

    /**
     * Imposta/Modifica l'autore della risposta
     * @param int $id
     */
    public function setProprietario(EProprietario $proprietario): void
    {
        $this->proprietario = $proprietario;
    }

    public function jsonSerialize(): array
    {
        return
            [
                'IdRecensione' => $this->getIdRecensione(),
                'proprietario' => $this->getProprietario(),
                'descrizione' => $this->getDescrizione()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString()
    {
        $print = "\nIdRecensione: " . $this->getIdRecensione() . "\n" . "proprietario: " . $this->getProprietario() . "\n" . "descrizione: " . $this->getDescrizione() . "\n";

        return $print;
    }


}

?>