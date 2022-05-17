<?php

class EOrario
{
    private $orarioSettimanale= array('lunedi'=>"", 'martedi'=>"", 'mercoledi'=>"", 'giovedi'=>"", 'venerdi'=>"" ,'sabato'=>"", 'domenica'=>"");



    public function __construct(array $settimana){
        foreach ($this->orarioSettimanale as $orario){
            $this->orarioSettimanale[$orario]=$settimana[$orario];
        }
    }

    /**
     * Passando il giorno della settimana e l'orario relativo al giorno stesso,viene modificato l'orario
     * @param string $giorno
     * @param string $orario
     * @return void
     */
    public function setOra(string $giorno, string $orario): void{
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