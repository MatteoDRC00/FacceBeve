<?php

    /** 
     * @param apri --> array associativo che associa ad ogni giorno della settimana un orario
	 * @param chiudi --> array associativo che associa ad ogni giorno della settimana un orario
	 * I due array che vengono passati vengono poi, per ogni giorno della settimana, uniti per ottenere l'associazione giorno => [Apertura; Chiusura] 
     */
    class EOrario
    {
        private $orarioSettimanale= array('lunedi'=>"", 'martedi'=>"", 'mercoledi'=>"", 'giovedi'=>"", 'venerdi'=>"" ,'sabato'=>"", 'domenica'=>"");
        public function __construct(array $apri, array $chiudi){
            foreach ($this->orarioSettimanale as $orario){
				$tmp = [$apri[$orario],$chiudi[$orario]];
                $this->orarioSettimanale[$orario]= $tmp;
            }
        }

        /**
         * Passando il giorno della settimana e l'orario relativo al giorno stesso,viene modificato l'orario
         * @param string $giorno
         * @param string $orario
         * @return void
         */
        public function setOrario(string $giorno, string $orario): void{
            $this->orarioSettimanale[$giorno]=$orario;
        }
		
		/**
         * Passando il giorno della settimana e l'orario relativo al giorno stesso,viene modificato l'orario
         * @param string $giorno
         * @param string $orario
         * @return void
         */
        public function setOrario(string $giorno, string $orario): void{
            $this->orarioSettimanale[$giorno]=$orario;
        }

        /**
         * @return string[]
         */
        public function getOrarioSettimanale(): array
        {
            return $this->orarioSettimanale;
        }



    }