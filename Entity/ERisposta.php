<?php
class ERisposta implements JsonSerializable {

    private int $id;
    private int $IdRecensione;
	private EProprietario $proprietario;
    private string $descrizione;

    /**
     * @param int $recensione
     * @param string $descrizione
	 * @param EProprietario $proprietario
     */
    public function __construct(int $recensione, string $descrizione, EProprietario $proprietario){
        $this->IdRecensione = $recensione;
        $this->descrizione = $descrizione;
        $this->proprietario = $proprietario;
    }


	//Metodi GET
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

	public function getDescrizione() : String{
		return $this->descrizione;
	}
	
	public function getIdRecensione() : int{
		return $this->IdRecensione;
	}
	
	public function getProprietario() : EProprietario{
		return $this->proprietario;
	}
	


	//Metodi SET
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

	public function setDescrizione(String $testo) : void{
		$this->descrizione=$testo;
	}

	
	public function setIdRecensione(int $recensione) : void{
        $this->IdRecensione=$recensione;
	}
    
	public function setProprietario(EProprietario $proprietario) : void{
        $this->proprietario=$proprietario;
	}

    public function jsonSerialize(): array
    {
        return
            [
                'IdRecensione'   => $this->getIdRecensione(),
                'proprietario' => $this->getProprietario(),
                'descrizione'   => $this->getDescrizione()
            ];
    }


    /**
     * @return $print String
     */
    public function __toString() {
        $print = "\nIdRecensione: ".$this->getIdRecensione()."\n"."proprietario: ".$this->getProprietario()."\n"."descrizione: ".$this->getDescrizione()."\n";

        return $print;
    }


}
?>