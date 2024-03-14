<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marcatge
 *
 * @author Alex
 */
class Marcatge {
    private $datahora;
    private $idtipus;
    private $entsort;

    function getDatahora() {
        return $this->datahora;
    }

    function getIdtipus() {
        return $this->idtipus;
    }

    function getEntsort() {
        return $this->entsort;
    }

    function __construct($datahora, $idtipus, $entsort) {
        $this->datahora = $datahora;
        $this->idtipus = $idtipus;
        $this->entsort = $entsort;
    }
    
    function __toString() {
        $ent = "Entrada";
        $tip = "Normal";
        if($this->entsort==1) {$ent = "Sortida";}
        if($this->idtipus<>4) {$tip = "Especial";}
        echo date('d/m/Y H:i',strtotime($this->datahora))." ".$ent." ".$tip."<br>";
    }

}
