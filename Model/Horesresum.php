<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Horesresum
 *
 * @author Marc
 */
class Horesresum {
    private $concepte;
    private $hores;
    private $htotals;
    
    function getConcepte() {
        return $this->concepte;
    }

    function getHores($i) {
        return $this->hores[$i];
    }

    function getHtotals() {
        for($i=0;$i<7;$i++) $this->htotals+=$this->getHores($i);
        return $this->htotals;
    }

    function setHores($i,$hores) {
        $this->hores[$i] = $hores;
    }

    function __construct($concepte) {
        $this->concepte = $concepte;
        $this->hores = array_fill(0,7,0);
        $this->htotals = 0;
    }
}
