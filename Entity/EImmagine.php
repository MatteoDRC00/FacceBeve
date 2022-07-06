<?php

class EImmagine{
    /**
     * Nome del media
     * @AttributeType string
     */
    private string $nome;
    /**
     * Dati del media
     * @AttributeType string
     */
    private string $size;
    /**
     * Tipo del media
     * @AttributeType string
     */
    private string $type;
    /**
     * Media in binario
     * @AttributeType blob
     */
    private blob $immagine;

    /**
     * @param string $nome
     * @param string $size
     * @param string $type
     * @param blob $immagine
     */
    public function __construct(string $nome, string $size, string $type, blob $immagine)
    {
        $this->nome = $nome;
        $this->size = $size;
        $this->type = $type;
        $this->immagine = $immagine;
    }


    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return blob
     */
    public function getImmagine(): blob
    {
        return $this->immagine;
    }

    /**
     * @param blob $immagine
     */
    public function setImmagine(blob $immagine): void
    {
        $this->immagine = $immagine;
    }



}