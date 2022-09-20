<?php

/**
 * La classe EProprietario contiene tutti gli attributi e metodi base riguardanti i proprietari di locali attraverso:
 * * Id: identificativo dell'immagine
 * * Nome: identifica il nome del proprietario
 * * Cognome: identifica il cognome del proprietario
 * * Email: identifica l'email del proprietario
 * * Username: identifica l'username utilizzata dal Proprietario in fase di login
 * * Password: identifica la password utilizzata dal Proprietario in fase di login
 * * Img_Profilo: identifica l'immagine di profilo del Proprietario
 * @author Gruppo 8
 * @package Entity
 */
class EProprietario implements JsonSerializable
{

    /**
     * Password del Proprietario, per l'identificazione
     * @var string
     */
    private string $password;

    /**
     * Username del Proprietario, per l'identificazione
     * @var string
     */
    private string $username;

    /**
     * Email del Proprietario
     * @var string
     */
    private string $email;

    /**
     * Nome del Proprietario
     * @var string
     */
    private string $nome;

    /**
     * Cognome del Proprietario
     * @var string
     */
    private string $cognome;

    /**
     * Immagine del profilo del Proprietario
     * @var EImmagine|null
     */
    private ?EImmagine $img_profilo = null;

    public function __construct(string $nome, string $cognome, string $email, string $username, string $password)
    {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }



//----------------------METODI GET-----------------------------

    /**
     * Restituisce la password del Proprietario
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Restituisce l'email del Proprietario
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Restituisce il nome del Proprietario
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Restituisce il cognome del Proprietario
     * @return string
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * Restituisce l'username del Proprietario
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Restituisce l'immagine di profilo del Proprietario
     * @return EImmagine|null
     */
    public function getImgProfilo(): ?EImmagine
    {
        return $this->img_profilo;
    }

//----------------------METODI SET-----------------------------

    /**
     * Imposta/Modifica la password del Proprietario
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Imposta/Modifica l'email del Proprietario
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Imposta/Modifica il nome del Proprietario
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * Imposta/Modifica il cognome del Proprietario
     * @param string $cognome
     */
    public function setCognome(string $cognome): void
    {
        $this->cognome = $cognome;
    }

    /**
     * Imposta/Modifica l'username del Proprietario
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Imposta/Modifica l'immagine di profilo del Proprietario
     * @param EImmagine|null $img_profilo
     */
    public function setImgProfilo(?EImmagine $img_profilo): void
    {
        $this->img_profilo = $img_profilo;
    }


    public function jsonSerialize()
    {
        return
            [
                'password' => $this->getPassword(),
                'username' => $this->getUsername(),
                'email' => $this->getEmail(),
                'nome' => $this->getNome(),
                'cognome' => $this->getCognome(),
                'img_profilo' => $this->getImgProfilo()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString()
    {
        $print = "\npassword: " . $this->getPassword() . "\n" . "username: " . $this->getUsername() . "\n" . "email: " . $this->getEmail() . "\n" . "nome: " . $this->getNome() . "\n" . "cognome: " . $this->getCognome() . "\n" . "img_profilo: " . $this->getImgProfilo() . "\n";

        return $print;
    }

}

?>