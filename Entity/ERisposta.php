<?php
class ERisposta {
    //da aggiustare

    private ERecensione $recensione;
	private EProprietario $proprietario;
    private string $descrizione;

    /**
     * @param ERecensione $recensione
     * @param string $descrizione
	 * @param EProprietario $proprietario
     */
    public function __construct(ERecensione $recensione, string $descrizione, EProprietario $proprietario){
        $this->recensione = $recensione;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
    }
	
	//Metodi GET
	public function  getDescrizione() : String{
		return $descrizione;
	}
	
	public function  getRecensione() : ERecensione{
		return $recensione;
	}
	
	public function getProprietario() : EProprietario{
		return $proprietario;
	}
	
	public function getAutore() : EUtente{
		return $recensione->getUtente();
	}
	//Metodi SET
	public function setDescrizione(String $testo) : void{
		$this.descrizione=$testo;
	}
	
	public function setRecensione(ERecensione $recensione) : void{
		$this.recensione=$recensione;
	}
    
	public function setRecensione(EProprietario $proprietario) : void{
		$this.proprietario=$proprietario;
	}

}
?>