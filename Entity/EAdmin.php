<?php
/**
 * La classe EAdmin estende la classe EUser, essa contiene tutti le informazioni e metodi riguardanti gli admin. 
 *  @author Gruppo 8
 *  @package Entity
 */ 
class EAdmin {

    private int $id;
    private string $password;
    private string $username;
    private string $email;

    public function __construct(string $username, string $email, string $password ){
        $this->id = NULL;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

//---------------------------------METODI GET------------------------------------------//

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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }



//---------------------------------METODI SET------------------------------------------//

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
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    


}
?>