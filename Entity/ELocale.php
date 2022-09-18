<?php

/** La classe ELocale caratterizza un singolo locale
 *  @author Gruppo8
 *  @package Entity
 */
class ELocale{

    /**
     *
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $nome;

    /**
     * @var string
     */
    private string $descrizione;

    /**
     * @var string
     */
    private string $num_telefono;

    /**
     * @var EProprietario
     */
    private EProprietario $proprietario;

    /**
     * @var array|null
     */
    private ?array $categoria;

    /**
     * @var ELocalizzazione
     */
    private ELocalizzazione $localizzazione;

    /**
     * @var array|null
     */
    private ?array $eventi_organizzati;

    /**
     * @var array|null
     */
    private ?array $orario;

    /**
     * @var EImmagine|null
     */
    private ?EImmagine $img;

    /**
     * @param string $nome
     * @param string $descrizione
     * @param string $num_telefono
     * @param EProprietario $proprietario
     * @param ELocalizzazione $localizzazione
     */
    public function __construct(string $nome, string $descrizione, string $num_telefono, EProprietario $proprietario, ELocalizzazione $localizzazione){
        $this->id = NULL;
        $this->nome = $nome;
        $this->num_telefono = $num_telefono;
        $this->descrizione = $descrizione;
        $this->proprietario = $proprietario;
        $this->categoria = null;
        $this->localizzazione = $localizzazione;
        $this->eventi_organizzati = null;
        $this->orario = null;
        $this->img = null;
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
     * @return string
     */
    public function getNumTelefono(): string
    {
    return $this->num_telefono;
    }

    /**
     * @param string $num_telefono
     */
    public function setNumTelefono(string $num_telefono): void
    {
        $this->num_telefono = $num_telefono;
    }

    /**
     * @return EProprietario
     */
    public function getProprietario(): EProprietario
    {
        return $this->proprietario;
    }

    /**
     * @param EProprietario $proprietario
     */
    public function setProprietario(EProprietario $proprietario): void
    {
        $this->proprietario = $proprietario;
    }

    /**
     * @return array|null
     */
    public function getCategoria(): ?array
    {
        return $this->categoria;
    }

    /**
     * @param array|null $categoria
     */
    public function setCategoria(?array $categoria): void
    {
        $this->categoria = $categoria;
    }

    /**
     * @return ELocalizzazione
     */
    public function getLocalizzazione(): ELocalizzazione
    {
        return $this->localizzazione;
    }

    /**
     * @param ELocalizzazione $localizzazione
     */
    public function setLocalizzazione(ELocalizzazione $localizzazione): void
    {
        $this->localizzazione = $localizzazione;
    }

    /**
     * @return array|null
     */
    public function getEventiOrganizzati(): ?array
    {
        return $this->eventi_organizzati;
    }

    /**
     * @param array|null $eventi_organizzati
     */
    public function setEventiOrganizzati(?array $eventi_organizzati): void
    {
        $this->eventi_organizzati = $eventi_organizzati;
    }

    /**
     * @return array|null
     */
    public function getOrario(): ?array
    {
        return $this->orario;
    }

    /**
     * @param array|null $orario
     */
    public function setOrario(?array $orario): void
    {
        $this->orario = $orario;
    }

    /**
     * @return EImmagine|null
     */
    public function getImg(): ?EImmagine
    {
        return $this->img;
    }

    /**
     * @param EImmagine|null $img
     * @return void
     */
    public function setImg(?EImmagine $img): void
    {
        $this->img = $img;
    }

   /* public function addImg(EImmagine $img): void
    {
        $this->img[] = $img;
    }*/


    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->getId(),
                'nome' => $this->getNome(),
                'numTelefono'   => $this->getNumTelefono(),
                'descrizione'   => $this->getDescrizione(),
                'proprietario'   => $this->getProprietario(),
                'categoria'   => $this->getCategoria(),
                'localizzazione'   => $this->getLocalizzazione(),
                'eventi'   => $this->getEventiOrganizzati(),
                'orario'   => $this->getOrario(),
                'visibility'  => $this->getVisibility(),
                'img'   => $this->getImg()
            ];
    }

    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\nid: ".$this->getId()."\n"."nome: ".$this->Nome()."\n"."numero di telefono: ".$this->getNumTelefono()."\n"."proprietario: ".$this->getProprietario()->getUsername()."\n"."descrizione: ".$this->getDescrizione()."\n"."categoria: ".$this->getCategoria()."\n"."Luogo: ".$this->getLocalizzazione()->getCodice()."\n"."Eventi: ".$this->getEventiOrganizzati()."\n"."Orario: ".$this->getOrario()."\n"."Visibilità: ".$this->getVisibility()."\n"."Img: ".$this->getImg()."\n";

        return $print;
    }

}
?>