<?php

/**
 * La classe EImmagine definisce le immagini per Utenti, Proprietari, Locali ed Eventi attraverso:
 * * Id: Identificativo dell'immagine
 * * Nome: nome dell'immagine
 * * Immagine: dati binari codificati in base64 dell'immagine
 * * Type: MIME type dell'immagine
 * * Size: dimensione immagine
 * @author Gruppo 8
 * @package Entity
 */
class EImmagine
{

    /**
     * Id dell'immagine che la caratterizza sul db
     * @var string|null
     */
    private ?string $id = null;

    /**
     * Nome dell'immagine
     * @var string
     */
    private string $nome;

    /**
     * Dimensione dell'immagine
     * @var string
     */
    private string $size;

    /**
     * Tipo di immagine
     * @var string
     */
    private string $type;

    /**
     * File dell'immagine
     * @var string
     */
    private string $immagine;

    /**
     * Costruttore della classe
     * @param string $nome
     * @param string $size
     * @param string $type
     * @param string $immagine
     */
    public function __construct(string $nome, string $size, string $type, string $immagine)
    {
        $this->nome = $nome;
        $this->size = $size;
        $this->type = $type;
        $this->immagine = $immagine;
    }


    /**
     * Restituisce il nome dell'immagine
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta/Modifica il nome dell'immagine
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * Restituisce la dimensione dell'immagine
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * Imposta/Modifica la dimensione dell'immagine
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * Restituisce l'id dell'immagine
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Imposta/Modifica l'id dell'immagine
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }


    /**
     * Restituisce il tipo dell'immagine
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Imposta/Modifica il tipo dell'immagine
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Restituisce il file dell'immagine
     * @return string
     */
    public function getImmagine(): string
    {
        return $this->immagine;
    }

    /**
     * Imposta/Modifica il file dell'immagine
     * @param string $immagine
     */
    public function setImmagine(string $immagine): void
    {
        $this->immagine = $immagine;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "\nome: " . $this->getNome() . "\n" . "size: " . $this->getSize() . "\n" . "type: " . $this->getType() . "\n" . "immagine: " . $this->getImmagine() . "\n";
    }

}