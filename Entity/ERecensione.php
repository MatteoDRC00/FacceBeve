<?php
class ERecensione {

    private EUtente $utente;
    private string $titolo;
    private string $descrizione;
    private int $voto;
    private DateTime $data;

    /**
     * @param EUserRegistrato $utente
     * @param string $titolo
     * @param string $descrizione
     * @param int $voto
     * @param DateTime $data
     */
    public function __construct(EUtente $utente, string $titolo, string $descrizione, int $voto, DateTime $data)
    {
        $this->utente = $utente;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->voto = $voto;
        $this->data = $data;
    }

    /**
     * @return EUserRegistrato
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    /**
     * @param EUserRegistrato $utente
     */
    public function setUtente(EUtente $utente): void
    {
        $this->utente = $utente;
    }

    /**
     * @return string
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * @param string $titolo
     */
    public function setTitolo(string $titolo): void
    {
        $this->titolo = $titolo;
    }

    /**
     * @return string
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione(string $descrizione): void
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return int
     */
    public function getVoto(): int
    {
        return $this->voto;
    }

    /**
     * @param int $voto
     */
    public function setVoto(int $voto): void
    {
        $this->voto = $voto;
    }

    /**
     * @return DateTime
     */
    public function getData(): DateTime
    {
        return $this->data;
    }

    /**
     * @param DateTime $data
     */
    public function setData(DateTime $data): void
    {
        $this->data = $data;
    }


    


}
?>