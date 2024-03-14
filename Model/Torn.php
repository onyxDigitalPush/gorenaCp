<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Torn
 *
 * @author Alex
 */
class Torn {
    private $diasetm;
    private $horaini;
    private $horafi;
    private $htreb;
    private $hdesc;
    private $automarc;
    private $marcabans;
    private $laborable;
    
    function getDiasetm() {
        return $this->diasetm;
    }

    function getHoraini() {
        return $this->horaini;
    }

    function getHorafi() {
        return $this->horafi;
    }

    function getHtreb() {
        return $this->htreb;
    }

    function getHdesc() {
        return $this->hdesc;
    }

    function getAutomarc() {
        return $this->automarc;
    }

    function getMarcabans() {
        return $this->marcabans;
    }

    function setDiasetm($diasetm) {
        $this->diasetm = $diasetm;
    }

    function setHoraini($horaini) {
        $this->horaini = $horaini;
    }

    function setHorafi($horafi) {
        $this->horafi = $horafi;
    }

    function setHtreb($htreb) {
        $this->htreb = $htreb;
    }

    function setHdesc($hdesc) {
        $this->hdesc = $hdesc;
    }

    function setAutomarc($automarc) {
        $this->automarc = $automarc;
    }

    function setMarcabans($marcabans) {
        $this->marcabans = $marcabans;
    }
    function getLaborable() {
        return $this->laborable;
    }

    function setLaborable($laborable) {
        $this->laborable = $laborable;
    }

        function __construct($diasetm, $horaini, $horafi, $htreb, $hdesc, $automarc, $marcabans, $laborable) {
        $this->diasetm = $diasetm;
        $this->horaini = $horaini;
        $this->horafi = $horafi;
        $this->htreb = $htreb;
        $this->hdesc = $hdesc;
        $this->automarc = $automarc;
        $this->marcabans = $marcabans;
        $this->laborable = $laborable;
    }

}
