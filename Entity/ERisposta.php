<?php
class ERisposta {
    //da aggiustare

    private EUtente $utente;
	private EProprietario $proprietario;
    private string $descrizione;

    /**
     * @param EUtente $utente
     * @param string $descrizione
	 * @param
     */
    public function __construct(ERecensione $recensione, string $descrizione,EProprietario $proprietario)
    {
        $this->utente = $utente;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
    }

    

}
?>