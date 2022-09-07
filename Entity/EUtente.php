<?php

use Cassandra\Date;

/**
 * La classe EUtente contiene tutti gli attributi e metodi base riguardanti gli utenti.
 *  @author Gruppo 8
 *  @package Entity
 */ 
class EUtente {

    private string $password;
    private string $username;
    private string $email;
    private string $nome;
    private string $cognome;
    private array $localipreferiti;
    private string $iscrizione;
    private EImmagine $img_profilo;
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

    /**
     * @return date
     */
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
     * @return EImmagine
     */
    public function getImgProfilo(): EImmagine
    {
        return $this->img_profilo;
    }

    /**
     * @param EImmagine $img_profilo
     */
    public function setImgProfilo(EImmagine $img_profilo): void
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
     * @param array $locale
     */
    public function addLocale($locale): void
    {
        $this->localipreferiti.array_push($locale);
    }



    /**
     * Stampa lo stato dell'utenete
     * @return String
     */
    protected function StaToString () {
        $vis = null;
        if ($this->getState())
            $vis = "visibile";
        else
            $vis = "bannato";
        return $vis;
    }
}
?>