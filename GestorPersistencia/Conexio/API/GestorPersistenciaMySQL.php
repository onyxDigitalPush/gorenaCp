<?php


/**
 *
 * @author usuario1
 */
interface GestorPersistenciaMySQL {
    public function obrirConnexio();
    public function executarSentencia($sql);
    public function executarConsulta($sql);
    public function tancarConnexio();
}
