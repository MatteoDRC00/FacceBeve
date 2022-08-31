<?php
class ERisposta implements JsonSerializable {

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
        $this->descrizione = $descrizione;
        $this->proprietario = $proprietario;
    }
	
	//Metodi GET
	public function getDescrizione($descrizione) : String{
		return $this->descrizione;
	}
	
	public function getRecensione() : ERecensione{
		return $this->recensione;
	}
	
	public function getProprietario() : EProprietario{
		return $this->proprietario;
	}
	


	//Metodi SET
	public function setDescrizione(String $testo) : void{
		$this->descrizione=$testo;
	}

	
	public function setRecensione(ERecensione $recensione) : void{
        $this->recensione=$recensione;
	}
    
	public function setProprietario(EProprietario $proprietario) : void{
        $this->proprietario=$proprietario;
	}

    public function jsonSerialize()
    {
        return
            [
                'recensione'   => $this->getRecensione(),
                'proprietario' => $this->getProprietario(),
                'descrizione'   => $this->getDescrizione()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\nrecensione: ".$this->getRecensione()."\n"."proprietario: ".$this->getProprietario()."\n"."descrizione: ".$this->getDescrizione()."\n";

        return $print;
    }


}
?>