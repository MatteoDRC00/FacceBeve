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
    private date $iscrizione;


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
        $this->iscrizione = date("d.m.y");
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
    public function getIscrizione(): date
    {
        return $this->iscrizione;
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


//-----------------------------Altri Metodi-----------------------------
    /**
     * @param array $locale
     */
    public function addLocale($locale): void
    {
        $this->localipreferiti.array_push($locale);
    }



}
?>