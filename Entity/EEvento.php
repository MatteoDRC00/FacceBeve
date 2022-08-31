<?php
/** La classe EEvento rapprensenta un evento organizzato da un locale ed è caratterizzato da:
 *  - nome: identifica il nome (titolo) dell'evento
 *  - tipo: identifica il tipo di evento
 *  - descrizione: aumenta le informazioni sull'evento
 *  - data: indentifica la data in cui si terrà l'evento
 *  @author Gruppo8
 *  @package Entity
 */
class EEvento implements JsonSerializable{

    private int $id;
    private string $nome;
    private string $descrizione;
    private DateTime $data;


    /**
     * @param string $nome
     * @param string $descrizione
     * @param DateTime $data
     */
    public function __construct(string $nome, string $descrizione, DateTime $data){
        $this->id = NULL;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->data = $data;
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

    /**
     * @return DateTime
     */
    public function getData(): DateTime
    {
        return $this->data;
    }

    /**
     * @param DateTime $data
     */
    public function setData(DateTime $data): void
    {
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'nome' => $this->getNome(),
                'descrizione'   => $this->getNumTelefono(),
                'data'  =>$this->getData()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\nid: ".$this->getId()."\n"."nome: ".$this->Nome()."\n"."descrizione: ".$this->getDescrizione()."\n"."data: ".$this->getData()."\n";

        return $print;
    }


}