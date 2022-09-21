<?php

/** La classe ELocale caratterizza un locale attraverso:
 * * Id: identificativo del locale
 * * Nome: identifica il nome del locale
 * * Descrizione: identifica la descrizione del locale/cosa si fa/storia del locale
 * * NumTelefono: identifica il numero di telefono del locale
 * * Proprietario: identifica l'account proprietario che gestisce il locale
 * * Categoria: identifica la/e categoria/e associata/e al locale
 * * Localizzazione: identifica il luogo in cui risiede il locale
 * * Eventi Organizzati: identifica gli eventi organizzati dal locale
 * * Orario: identifica l'orario settimanale del locale
 * * Immagine: identifica la foto/le foto del locale
 * @author Gruppo8
 * @package Entity
 */
class ELocale
{

    /**
     * Id del locale che lo identifica sul db
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
     * Numero di telefono del locale
     * @var string
     */
    private string $num_telefono;

    /**
     * Proprietario del locale, i.e., utente che ne gestisce il profilo, anch'egli presente sul sito
     * @var EProprietario
     */
    private EProprietario $proprietario;

    /**
     * Categorie che caratterizzano il locale
     * @var array|null
     */
    private ?array $categoria;

    /**
     * Indirizzo del locale -> utilizzato poi per rimandare al indirizzo del locale per avere informazione sul come raggiungerlo
     * @var ELocalizzazione
     */
    private ELocalizzazione $localizzazione;

    /**
     * Array degli eventi organizzati dal locale
     * @var array|null
     */
    private ?array $eventi_organizzati;

    /**
     * Orario settimanale del locale
     * @var array|null
     */
    private ?array $orario;

    /**
     * Img del locale
     * @var EImmagine|null
     */
    private ?EImmagine $img;

    /**
     * Costruttore della classe
     * @param string $nome
     * @param string $descrizione
     * @param string $num_telefono
     * @param EProprietario $proprietario
     * @param ELocalizzazione $localizzazione
     */
    public function __construct(string $nome, string $descrizione, string $num_telefono, EProprietario $proprietario, ELocalizzazione $localizzazione)
    {
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
     *  Restituisce l'Id del locale
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Imposta/Modifica l'Id del locale
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Restituisce il nome del locale
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta/Modifica il nome del locale
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * Restituisce la descrizione del locale
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta/Modifica la descrizione del locale
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     *  Restituisce il numero di telefono del locale
     * @return string
     */
    public function getNumTelefono(): string
    {
        return $this->num_telefono;
    }

    /**
     * Imposta/Modifica la numero di telefono del locale
     * @param string $num_telefono
     */
    public function setNumTelefono(string $num_telefono): void
    {
        $this->num_telefono = $num_telefono;
    }

    /**
     *  Restituisce il proprietario del locale
     * @return EProprietario
     */
    public function getProprietario(): EProprietario
    {
        return $this->proprietario;
    }

    /**
     * Imposta/Modifica il proprietario del locale
     * @param EProprietario $proprietario
     */
    public function setProprietario(EProprietario $proprietario): void
    {
        $this->proprietario = $proprietario;
    }

    /**
     *  Restituisce la/e categoria/e del locale
     * @return array|null
     */
    public function getCategoria(): ?array
    {
        return $this->categoria;
    }

    /**
     * Imposta/Modifica la/e categoria/e del locale
     * @param array|null $categoria
     */
    public function setCategoria(?array $categoria): void
    {
        $this->categoria = $categoria;
    }

    /**
     * Restituisce la localizzazione del locale
     * @return ELocalizzazione
     */
    public function getLocalizzazione(): ELocalizzazione
    {
        return $this->localizzazione;
    }

    /**
     * Imposta/Modifica la localizzazione del locale
     * @param ELocalizzazione $localizzazione
     */
    public function setLocalizzazione(ELocalizzazione $localizzazione): void
    {
        $this->localizzazione = $localizzazione;
    }

    /**
     * Restituisce gli eventi organizzati dal locale
     * @return array|null
     */
    public function getEventiOrganizzati(): ?array
    {
        return $this->eventi_organizzati;
    }

    /**
     * Imposta/Modifica gli eventi organizzati dal locale
     * @param array|null $eventi_organizzati
     */
    public function setEventiOrganizzati(?array $eventi_organizzati): void
    {
        $this->eventi_organizzati = $eventi_organizzati;
    }

    /**
     * Restituisce l'orario del locale
     * @return array|null
     */
    public function getOrario(): ?array
    {
        return $this->orario;
    }

    /**
     * Imposta/Modifica l'orario del locale
     * @param array|null $orario
     */
    public function setOrario(?array $orario): void
    {
        $this->orario = $orario;
    }

    /**
     * Restituisce l'immagine del locale
     * @return EImmagine|null
     */
    public function getImg(): ?EImmagine
    {
        return $this->img;
    }

    /**
     * Imposta/Modifica l'immagine del locale
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
                'id' => $this->getId(),
                'nome' => $this->getNome(),
                'numTelefono' => $this->getNumTelefono(),
                'descrizione' => $this->getDescrizione(),
                'proprietario' => $this->getProprietario(),
                'categoria' => $this->getCategoria(),
                'localizzazione' => $this->getLocalizzazione(),
                'eventi' => $this->getEventiOrganizzati(),
                'orario' => $this->getOrario(),
                'visibility' => $this->getVisibility(),
                'img' => $this->getImg()
            ];
    }

    /**
     * @return $print String
     */
    public function __toString()
    {
        $print = "\nid: " . $this->getId() . "\n" . "nome: " . $this->Nome() . "\n" . "numero di telefono: " . $this->getNumTelefono() . "\n" . "proprietario: " . $this->getProprietario()->getUsername() . "\n" . "descrizione: " . $this->getDescrizione() . "\n" . "categoria: " . $this->getCategoria() . "\n" . "Luogo: " . $this->getLocalizzazione()->getCodice() . "\n" . "Eventi: " . $this->getEventiOrganizzati() . "\n" . "Orario: " . $this->getOrario() . "\n" . "Visibilità: " . $this->getVisibility() . "\n" . "Img: " . $this->getImg() . "\n";

        return $print;
    }

}

?>