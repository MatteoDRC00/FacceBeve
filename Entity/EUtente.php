<?php

/**
 * La classe EUtente contiene tutti gli attributi e metodi base riguardanti gli utenti attraverso:
 * * Nome: identifica il nome del proprietario
 * * Cognome: identifica il cognome del proprietario
 * * Email: identifica l'email del proprietario
 * * Username: identifica l'username utilizzata dal Proprietario in fase di login
 * * Password: identifica la password utilizzata dal Proprietario in fase di login
 * * Img_Profilo: identifica l'immagine di profilo del Proprietario
 * * Iscrizione: indica la data d'iscrizione al sito da parte dell'utente
 * * State: indica se l'utente è bannato o meno, i.e., se può o meno scrivere recensioni
 *  @author Gruppo 8
 *  @package Entity
 */ 
class EUtente {


    /**
     * Password del Utente, per l'identificazione
     * @var string
     */
    private string $password;

    /**
     * Username del Utente, per l'identificazione
     * @var string
     */
    private string $username;

    /**
     * Email del Utente
     * @var string
     */
    private string $email;

    /**
     * Nome del Utente
     * @var string
     */
    private string $nome;

    /**
     * Cognome del Utente
     * @var string
     */
    private string $cognome;

    /**
     * Lista dei locali salvati dal Utente
     * @var array ELocale
     */
    private array $localipreferiti;

    /**
     * Data in cui l'Utente si è iscritto al sito
     * @var string
     */
    private ?string $iscrizione = null;

    /**
     * Immagine del profilo del Utente
     * @var EImmagine|null
     */
    private ?EImmagine $img_profilo;

    /**
     * Stato del Utente(Bannato/Attivo)
    */
    private bool $state;


    /**
     * Costruttore della classe
     * @param string $password
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     */
    public function __construct(string $password, string $nome, string $cognome, string $username, string $email){
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->img_profilo = null;
        $this->localipreferiti = array();
        $this->state = true;
    }

    public function Iscrizione(){
        $this->iscrizione = (string) date("d/m/Y");
    }


//----------------------METODI GET-----------------------------

    /**
     * Restituisce l'username del Utente
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Restituisce la password del Utente
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Restituisce l'email del Utente
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Restituisce il nome del Utente
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Restituisce il cognome del Utente
     * @return string
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * Restituisce la lista dei locali preferiti del Utente
     * @return array ELocale
     */
    public function getLocalipreferiti(): array
    {
        return $this->localipreferiti;
    }

    /**
     * Restituisce la data d'iscrizione al sito del Utente
     * @return string
     */
    public function getIscrizione(): ?string
    {
        return $this->iscrizione;
    }

    /**
     * Restituisce lo stato sul sito del Utente(Bannato/Attivo)
     * @return string
     */
    public function getState(): bool
    {
        return $this->state;
    }

    /**
     * Restituisce l'immagine di profilo del Utente
     * @return EImmagine|null
     */
    /**
     * @return EImmagine|null
     */
    public function getImgProfilo(): ?EImmagine
    {
        return $this->img_profilo;
    }




    //-----------------------------METODI SET-----------------------------

    /**
     * Imposta/Modifica la password del Utente
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Imposta/Modifica l'email del Utente
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Imposta/Modifica il nome del Utente
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * Imposta/Modifica il cognome del Utente
     * @param string $cognome
     */
    public function setCognome(string $cognome): void
    {
        $this->cognome = $cognome;
    }

    /**
     * Imposta/Modifica l'username del Utente
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Imposta/Modifica l'immagine di profilo del Utente
     * @param EImmagine|null $img_profilo
     */
    public function setImgProfilo(?EImmagine $img_profilo): void
    {
        $this->img_profilo = $img_profilo;
    }


    /**
     * Metodo che va a modificare lo stato del Utente(Bannato/Attivo)
     * @param bool $state
     */
    public function setState(bool $state): void
    {
        $this->state=$state;
    }

    /**
     * Metodo che va a modificare la data d'iscrizione al sito del Utente(Bannato/Attivo)
     * @param string|null $iscrizione
     */
    public function setIscrizione(?string $iscrizione): void
    {
        $this->iscrizione = $iscrizione;
    }


    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\npassword: ".$this->getPassword()."\n"."username: ".$this->getUsername()."\n"."email: ".$this->getEmail()."\n"."nome: ".$this->getNome()."\n"."cognome: ".$this->getCognome()."\n"."localipreferiti: ".$this->getLocalipreferiti()."\n"."iscrizione: ".$this->getIscrizione()."\n"."stato: ".$this->StaToString()."\n";
        return $print;
    }


//-----------------------------Altri Metodi-----------------------------
    /**
     * @param ELocale $locale
     */
    public function addLocale($locale): void
    {
        $this->localipreferiti.array_push($locale);
    }

    /**
     * @param ELocale $locale
     */
    public function deleteLocale($locale): void
    {
        for($i = 0; $i<count($this->localipreferiti); $i++){
            if($this->localipreferiti[$i] == $locale){
                unset($this->localipreferiti[$i]);
            }
        }
    }

    /**
     * Stampa lo stato dell'utente
     * @return String
     */
    protected function StaToString ()
    {
        $vis = null;
        if ($this->getState())
            $vis = "visibile";
        else
            $vis = "bannato";
        return $vis;
    }

}
?>