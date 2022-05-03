<?php
class ERecensione {
	/**
	* Identificativo (da capire come trattare) della singola recensione
	* @AttributeType int
	*/
	private $id;
	/**
	* Didascalia della recensione
	* @AttributeType string
	*/
	private $testo;
	/**
	* Compreso tra 1 e 5
	* @AttributeType float
	*/
	private $voto;
	/**Identificativo del utente che ha scritto la recensione*/
	//private $utente;
	//private $locale;
	
	public function __construct($text,$palle,/*$commentatore,$vittima*/){
		$this->id=rand(0,1000);
		$this->testo=$text;
		$this->voto=$palle;
		/*$this->utente= $commentatore;
		$this->locale= $vittima;*/
	}
}
?>