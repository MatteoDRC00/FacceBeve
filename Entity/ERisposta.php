<?php
class ERisposta {

    private int $id;
    private ERecensione $recensione;
	private EProprietario $proprietario;
    private string $descrizione;

    /**
     * @param ERecensione $recensione
     * @param string $descrizione
	 * @param EProprietario $proprietario
     */
    public function __construct(ERecensione $recensione, string $descrizione, EProprietario $proprietario){
        $this->id = NULL;
        $this->recensione = $recensione;
        $this->descrizione = $descrizione;
        $this->proprietario = $proprietario;
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

}
?>