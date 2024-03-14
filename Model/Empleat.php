<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empleat
 *
 * @author Alex
 */
class Empleat {
    private $idEmpleat;
    private $nom;
    private $email;
    private $contrasenya;
    private $rol;
    
    function getIdEmpleat() {
        return $this->idEmpleat;
    }

    function setIdEmpleat($idEmpleat) {
        $this->idEmpleat = $idEmpleat;
    }

    function getNom() {
        return $this->nom;
    }

    function getEmail() {
        return $this->email;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function getRol() {
        return $this->rol;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }
    
    function getContrasenya() {
        return $this->contrasenya;
    }

    function setContrasenya($contrasenya) {
        $this->contrasenya = $contrasenya;
    }

    
    function __construct($idEmpleat, $nom, $email, $contrasenya, $rol) {
        $this->idEmpleat = $idEmpleat;
        $this->nom = $nom;
        $this->email = $email;
        $this->contrasenya = $contrasenya;
        $this->rol = $rol;
    }

}
