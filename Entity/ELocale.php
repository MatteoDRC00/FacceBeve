<?php
 public class  ELocale{
     private $nome;
     //private $Proprietario; 
     private $citta;
	 /**Attività associate al locale, inserite durante la creazione del profilo "Locale" e scelte da una lista di predefiniti
	 */
     private $attivita=array();
     private $indirizzo;
	 private $numerotel = "";
	 /**
     * @AssociationType Entity.ERecensione
     * @AssociationMultiplicity 0..*
     */
    private $recensioni = array();
	/**
     * @AssociationType Entity.EEvento
     * @AssociationMultiplicity 0..*
     */
	private $eventi = array();
     //Attributi da completare
     
     public function __construct($nom,$citt,$attivit,$indirizz){
         $this->nome=$nom;
         $this->citta=$citt;
         $this->attivita=$attivit;
         $this->indirizzo=$indirizz;
     }
     
     public function getSbagliato(){  //Come se non esistesse
         return $this->nome+"\n"+$this->citta+"\n"+$this->attivita+"\n"+$this->indirizzo+"\n"+$this->recensioni;
     }
	 
	 public function addRecensione(ERecensione $commento) {
        array_push($this->recensioni, $commento);
    }

     public function getValutazioneMedia() {
        $somma=0;
        $voti=count($this->recensioni);
        if ($voti>1) {
            foreach ($this->recensioni as $commento) {
                $somma+=$commento->voto;
            }
            return $somma/$voti;
        }
        elseif (isset($this->recensioni[0]->voto))
            return $this->recensioni[0]->voto;
        else
            return false;
    }
	
	public function getNumero(){
		return $this->$numerotel;
	}
	
	public function setNumero(String $num){
		$array = (str_replace(",","",$num));
		if(strlen($array)==9){
			$this->numerotel=$num;
		}
	}
	
	/**
     * Restituisce un array di recensioni relative al locale
     *
     * @access public
     * @return array
     * @ReturnType array
     */
    public function getRecensioni() {
        return ($this->recensioni);
	}
	
	/**
     * Restituisce un array relativo agli eventi organizzati dal locale
     *
     * @access public
     * @return array
     * @ReturnType array
     */
	public function getEventi() {
        return ($this->eventi);
	}
 }
?>