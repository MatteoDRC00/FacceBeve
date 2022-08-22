<?php
/**
 * La classe EProprietario estende la classe EUser, essa contiene tutti gli attributi e metodi base riguardanti i proprietari di locali.
 *  @author Gruppo 8
 *  @package Entity
 */ 
class EProprietario {

    private string $password;
    private string $username;
    private string $email;
    private string $nome;
    private string $cognome;
    private EImmagine $img_profilo;

    public function __construct(string $nome, string $cognome, string $email,string $username, string $password){
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }



//----------------------METODI GET-----------------------------



    /**
     * @return string
     */
    public function getPassword(): string
    {
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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

//----------------------METODI SET-----------------------------

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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



}

?>