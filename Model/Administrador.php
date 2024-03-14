<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Administrador
 *
 * @author Alex
 */
class Administrador extends Empleat {
    private $llistaAdministrats;
    
    function getLlistaAdministrats() {
        return $this->llistaAdministrats;
    }

    function setLlistaAdministrats($llistaAdministrats) {
        $this->llistaAdministrats = $llistaAdministrats;
    }

    function __construct($llistaAdministrats) {
        parent::__construct();
        $this->llistaAdministrats = $llistaAdministrats;
    }

}
