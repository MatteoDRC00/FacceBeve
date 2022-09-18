<?php

/** La classe EEvento rapprensenta un evento organizzato da un locale
 *  @author Gruppo8
 *  @package Entity
 */
class EEvento{

    /**
     * Id dell'evento che lo caratterizza sul db
     * @var int|null
     */
    private ?int $id;

    /**
     * Nome del locale
     * @var string
     */
    private string $nome;

    /**
     * Descrizione del locale/Informazioni sul locale
     * @var string
     */
    private string $descrizione;

    /**
     * Data dell'evento
     * @var string
     */
    private string $data;

    /**
     * Immagine di locandina dell'evento
     * @var EImmagine
     */
    private EImmagine $img;


    /**
     * Costruttore della classe
     * @param string $nome
     * @param string $descrizione
     * @param string $data
     */
    public function __construct(string $nome, string $descrizione, string $data){
        $this->id = NULL;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->data = $data;
    }

    /**
     * Restituisce l'Id dell'evento
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Imposta/Modifica l'Id dell'evento
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Restituisce il nome dell'evento
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta/Modifica il nome dell'evento
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * Restituisce la descrizione dell'evento
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta/Modifica la descrizione dell'evento
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Restituisce la data dell'evento
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Imposta/Modifica la data dell'evento
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * Restituisce l'immagine di locandina dell'evento
     * @return EImmagine
     */
    public function getImg(): EImmagine
    {
        return $this->img;
    }

    /**
     * Imposta/Modifica l'immagine di locandina dell'evento
     * @param EImmagine $img
     */
    public function setImg(EImmagine $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function __toString() {
        return "\nid: ".$this->getId()."\n"."nome: ".$this->Nome()."\n"."descrizione: ".$this->getDescrizione()."\n"."data: ".$this->getData()."\n";
    }


}