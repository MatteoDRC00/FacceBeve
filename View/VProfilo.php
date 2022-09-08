<?php

class VProfilo{








    /**
     * Restituisce il nome del immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getNewImgProfilo(){
        $nome = $_FILES['img']['name'];
        return $nome;
    }
}