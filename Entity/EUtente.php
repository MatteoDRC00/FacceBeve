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
     * Lista 
     * @var
     */
    private array $localipreferiti;
    private ?string $iscrizione = null;
    private ?EImmagine $img_profilo = null;
    private bool $state;


    /**
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
        $this->localipreferiti = array();
        $this->state = true;
    }

    public function Iscrizione(){
        $this->iscrizione = (string) date("d/m/Y");
    }


//----------------------METODI GET-----------------------------

    /**
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

     /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * @return array
     */
    public function getLocalipreferiti(): array
    {
        return $this->localipreferiti;
    }


    public function getIscrizione()
    {
        return $this->iscrizione;
    }

    /**
     * @return bool
     */
    public function getState(): bool
    {
        return $this->state;
    }




    //-----------------------------METODI SET-----------------------------

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome(string $cognome): void
    {
        $this->cognome = $cognome;
    }

    /**
     * @return EImmagine|null
     */
    public function getImgProfilo(): ?EImmagine
    {
        return $this->img_profilo;
    }

    /**
     * @param EImmagine|null $img_profilo
     */
    public function setImgProfilo(?EImmagine $img_profilo): void
    {
        $this->img_profilo = $img_profilo;
    }



    /**
     * Metodo che va a modificare lo stato di un utente(bannato/attivo)
     * @param bool $state
     */
    public function setState($state): void
    {
        $this->state=$state;
    }

    /**
     * @param string|null $iscrizione
     */
    public function setIscrizione(?string $iscrizione): void
    {
        $this->iscrizione = $iscrizione;
    }


    public function jsonSerialize()
    {
        return
            [
                'password'   => $this->getPassword(),
                'username' => $this->getUsername(),
                'email'   => $this->getEmail(),
                'nome'   => $this->getNome(),
                'cognome'   => $this->getCognome(),
                'localipreferiti'   => $this->getLocalipreferiti(),
                'iscrizione'   => $this->getIscrizione(),
                'img_profilo'   => $this->getImgProfilo(),
                'state' =>$this->getState()
            ];
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