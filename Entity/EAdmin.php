<?php

/**
 * La classe EAdmin contiene le informazioni e metodi riguardanti gli admin:
 * * Username: identifica l'username utilizzata dal Admin in fase di login
 * * Password: identifica la password utilizzata dal Admin in fase di login
 * * Email: identifica l'email del Admin
 * @author Gruppo 8
 * @package Entity
 */
class EAdmin
{

    /**
     * Password dell'admin, per l'identificazione
     * @var string
     */
    private string $password;

    /**
     * Username dell'admin, per l'identificazione
     * @var string
     */
    private string $username;

    /**
     * Email dell'admin, per l'identificazione
     * @var string
     */
    private string $email;

    /**
     * Costruttore della classe
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Restituisce la password dell'Admin
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Imposta/Modifica la password dell'Admin
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Restituisce l'username dell'Admin
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Imposta/Modifica l'username dell'Admin
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Restituisce l'email dell'Admin
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Imposta/Modifica l'email dell'Admin
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "\nusername: " . $this->getUsername() . "\n" . "email: " . $this->getEmail() . "\n" . "password: " . $this->getPassword() . "\n";
    }
}