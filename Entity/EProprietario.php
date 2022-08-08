<?php
/**
 * La classe EProprietario estende la classe EUser, essa contiene tutti gli attributi e metodi base riguardanti i proprietari di locali. 
 * Gli attributi che la descrivono sono:
 * - name: nome del proprietario;
 * - cognome: cognome del proprietario;
 * - email: email proprietario; 
 *  @access public 
 *  @author Gruppo 8
 *  @package Entity
 */ 
class EProprietario {

    private int $id;
    private string $password;
    private string $username;
    private string $email;
    private string $nome;
    private string $cognome;

    public function __construct(string $nome, string $cognome, string $email,string $username, string $password){
        $this->id = NULL;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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

}

?>