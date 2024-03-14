<?php
interface AdminApi {
    //Sessió
    public function iniciaEmpresa($id,$pwd);
    public function validaCredencials($user,$pwd);
    public function validaIniEmpresa($user, $pwd);
    public function navResolver();
    public function getIdioma($id);
    public function __($ididioma,$text);
    public function nouEnunciat($text);
    public function mostraEnunciatsWeb();
    public function seleccionaIdiomesWeb();
    public function getTraduccioPerIdEnunciat($idenunciat,$ididioma);
    public function afegeixTraduccio($idenunciat,$ididioma,$traduccio);
    public function getEnunciatPerTraduccio($traduccio);
    public function mostraTipusActivitats();
    public function mostraTipusActivitatsGlobals();
    public function mostraTipusActivitatsPerEmpresa($idempresa);
    public function mostraTipusActivitatsEspecialsPerEmpresa($idempresa);
    public function teMenuActivitats($idempresa);
    public function teEdicioPropia($idempresa);
    public function teEdicioIcones($idempresa);
    public function teEdicioConceptes($idempresa);
    public function teEdicioIdioma($idempresa);
    public function getLogoIn($idempresa,$idrealitza);
    public function getLogoOut($idempresa,$idrealitza);
    public function getLogoidRealitza($idempresa,$pos);
    public function getNomidRealitza($idrealitza);
    public function getNomidTipusActivitat($idtipusactivitat);
    public function getDescidActivitat($idrealitza);
    
    
    
    //Obtenció dades
    public function getCampPerIdCampTaula($taula,$idtaula,$camp);
    public function mostraNomPerIdTaula($id,$taula);
    public function mostraNomEmpresa($empresa);
    public function mostraCifEmpresa($empresa);
    public function mostraCccEmpresa($empresa);
    public function mostraCTreballEmpresa($empresa);
    public function mostraEmpreses();
    public function mostraNomsDpt($empresa);
    public function mostraRols($empresa,$master);
    public function mostraRespEmp($empresa);
    public function mostraNomEmpPerId($id);
    public function mostraNomEmpPerCodi($id);
    public function mostraNomDptPerIdEmp($id);
    public function mostraNomRolPerIdEmp($id);
    public function mostraIdEmpPerIdentificador($identificador);
    public function mostraNomExcep($idexcep);
    public function mostraNomUbicacio($idubicacio);
    public function mostraEntrades();
    public function mostraSortides();
    public function mostraNomEntradaSortidaPerId($id);
    public function mostraNomMes($mes);
    public function mostraNomDia($dia);
    public function dirsiono($bool);
    public function direntsort($bool);
    public function getRutaLogo($idempresa);
    public function getWebSite($idempresa); 
    public function getExcepColors($tipusexcep);
    public function getEmpDni($idemp);
    public function getEmpAfil($idemp);
    public function getEmpSex($idempl);
    public function dirSexeLletra($lletra);
    public function welcome($sexemp);
    public function mostraTotsIdiomes();
    public function mostraIdiomesGlobals();
    public function mostraIdiomesEmp($idempresa);
    public function mostraIdEmpresaPerIdEmpleat($idempl);
    public function mostraNomHorariPerIdhorari($idhorari);
    public function seleccionaTotsTipusExcepcions();
    public function seleccionaTotsFestius();
        
    //Comprovacions
    public function esAdmin($id);
    public function esMaster($id);
    public function esEncargado($id);
    public function esEmpleat($id);
    public function esSupervisor($id);
    public function esFestiuPerIdDia($id,$data);
    public function esExcepcioPerIdDia($id,$data);
    public function esBaixaPerIdDia($id, $data, $tipusexcep);
    public function treballaria($id, $data);
    public function chkExisteixValor($valor,$camp,$taula);
    public function esTornBidata($id,$data);
    
    //Administració
    public function altaEmpresa($nom,$cif,$ccc,$centre,$usuari,$pwd,$rutalogo,$logo,$website);
    public function cessarEmpresa($id);
    public function reactivarEmpresa($id);
    public function altaPersona($idempresa, $cognom1, $cognom2, $nom, $dni, $datanaix, $numafil, $dpt, $rol, $idemp, $resp);
    public function cessarPersona($id);
    public function reactivarPersona($id);
    public function crearDepartament($nom,$idempresa,$ambit);
    public function assignaDepartament($idempl,$iddpt);
    public function esDepartamentAsg($iddpt);
    public function cessaDepartament($iddpt);
    public function eliminaDepartament($iddpt);
    public function crearRol($nom,$idempresa,$empleat,$admin,$master);
    public function assignaRol($idempl,$idrol);
    public function esRolAsg($idrol);
    public function cessaRol($idrol);
    public function eliminaRol($idrol);
    public function actualitzaCampTaula($taula,$camp,$idreg,$valor);
    public function tePassword($idempl);
    
    //Gestió Persones
    
    public function changeEncargVal($idempleat,$newVal);
    public function changeHoraElectVal($idtipusexcep,$newVal);
    public function getRolActiuPerId($id);
    public function getNomDptActiuPerId($id);
    public function getAmbitDptActiuPerId($id);
    public function getUbicacionsPerId($id);
    public function seleccionaTotsEmp($idempresa);
    public function seleccionaTotsEmpActius($idempresa);
    public function seleccionaTotsEmpCessats($idempresa);
    public function seleccionaEmpPerEmpresa($idsubempresa);
    public function seleccionaEmpPerEmpresaActius($idsubempresa);
    public function seleccionaEmpPerEmpresaActiusPerDpt($idsubempresa,$dpt);
    public function seleccionaEmpPerEmpresaActiusPerRol($idsubempresa,$rol);
    public function seleccionaEmpPerEmpresaActiusPerDptRol($idsubempresa,$dpt,$rol);
    public function seleccionaEmpPerEmpresaCessats($idsubempresa);
    public function seleccionaEmpPerDpt($dpt);
    public function seleccionaEmpPerRol($rol);
    public function seleccionaEmpPerDptRol($dpt,$rol);
    public function seleccionaEmpPerId($id);
    
    //Horaris i Torns
    
    //Obtenció
    public function seleccionaHorarisActiusEmpresa($id);
    public function seleccionaTotesUbicacionsEmpPerId($id);
    public function seleccionaUbicacionsPerIdEmpresa($id);
    public function seleccionaUbicacionsEmpPerIdDia($id,$data);
    public function seleccionaTipusHoraris($idempresa);
    public function seleccionaTipusExcepcions();
    public function seleccionaEncargadosDep($idEmpleado);
    public function seleccionaHorarisEmpPerId($id);
    public function seleccionaExcepcionsEmpPerId($id);
    public function seleccionaSolictExcepcionsEmpPerId($id);
    public function seleccionaTornActualEmpPerId($id);
    public function seleccionaTornsEmpPerHorari($id,$idhorari);
    public function seleccionaTornsPerHorari($idhorari);
    public function seleccionaTipusHorariPerIdDia($id,$data,$lng);
    public function seleccionaFestiusEmpPerIdAny($id,$any);
    public function seleccionaFestiusPerUbicacio($idubicacio);
    public function seleccionaPersonesPerEmpAnyMes($idempresa,$any,$mes);
    public function seleccionaPersonesPerEmpTipusexcepAnyMes($idempresa,$tipusexcep,$any,$mes);
    public function seleccionaPersonesPerEmpDptAnyMes($idempresa,$dpt,$any,$mes);
    public function seleccionaPersonesPerEmpDptTipusexcepAnyMes($idempresa,$dpt,$tipusexcep,$any,$mes);
    public function getTornPerIdDia($id,$data);
    
    //Assignacions
    public function creaNouHorari($idempresa,$nomhorari,$torns);
    public function editaHorari($idhorari,$nomhorari,$torns);
    public function creaNovaUbicacio($idempresa,$nomubicacio,$fushorari,$pais,$regio,$ciutat);
    public function afegeixFestiuUbicacio($idubicacio,$dia,$mes,$dataany,$anual,$desc);
    public function eliminaFestiuUbicacio($idfestiu);
    public function assignaUbicacioPersona($id,$idubicacio, $datainici, $datafi);
    public function editaPeriodeUbicacio($idsituat,$idubicacio, $datainici, $datafi);
    public function eliminaPeriodeUbicacio($idsituat);
    public function assignaHorariEmpPerPlantilla($id,$idhorari, $datainici, $datafi);
    public function editaPeriodeHorari($id,$idhorari, $datainici, $datafi);
    public function eliminaPeriodeHorari($idquadrant);
    public function esVigent($idquadrant);
    public function assignaVigencia($idquadrant,$valor);
    public function assignaExcepcio($id,$idtipusexcep, $datainici, $datafi);
    public function UpdateStateSolicExcepcion($id,$Obs, $Type,$utm_x,$utm_y);
    public function SendEMAILV1($ASUNT,$MSJ,$EMAIL);
    public function editaExcepcio($idexcep,$noutipus,$novadataini,$novadatafi);
    public function eliminaExcepcio($idexcep);
    public function DeleteFile($idexcep);
    public function assignaActivitat($id,$tipus,$data,$horaini,$horafi);
    public function eliminaActivitat($idact);
    //MARCATGES

    //Gestió Marcatges

    public function automarcatges($idempresa);
    public function validaIdEmpMarcatge($codi);
    public function insereixMarcatge($idemp,$tipus,$inout,$datahora,$ipaddress);
    public function insereixMarcatgeObs($identificador,$inout,$tipus, $datahora, $obs);
    public function actualitzaMarcatge($idmarc,$novahora);
    public function observacionsMarcatge($idmarc,$observ);
    public function validaMarcatge($idmarc);
    public function desValidaMarcatge($idmarc,$weekday);
    public function validaMarcatgesDia($idmarc,$weekday);
    public function eliminaMarcatge($idmarc);
    public function insereixMultiMarcatges($id,$dataini,$horaini,$datafi,$horafi,$chkhrqd,$chkhrrd);
    public function insereixMarcatgesDataTornId($id,$data,$chkhrrd);
    public function eliminaMarcatgesDataId($idemp,$data);
    
    //Filtres
    public function mostraAnysContractePerId($id);
    public function mostraAnysMarcatges();
    public function mostraAnysMarcatgesPerId($id);
    public function mostraAnysMarcatgesPerDpt($dpt);
    public function mostraMesosMarcatgesPerAny($any);
    public function mostraMesosMarcatgesPerIdAny($id,$any);
    public function mostraMesosMarcatgesPerDptAny($dpt,$any);
    public function mostraMesSegonsSetmana($id,$any,$setmana);
    public function mostraSetmanesMarcatgesPerAny($any);
    public function mostraSetmanesMarcatgesPerAnyMes($any,$mes);
    public function mostraSetmanesMarcatgesPerIdAny($id,$any);
    public function mostraSetmanesMarcatgesPerIdAnyMes($id,$any,$mes);
    public function mostraSetmanesMesAny($any,$mes);
    
    //Contingut
    public function seleccionaTipusMarcatges();
    public function seleccionaMarcatgesPerId($id);
    public function seleccionaMarcatgesPerIdDia($id,$data);
    public function seleccionaMarcatgesPerIdAny($id,$any);
    public function seleccionaMarcatgesPerIdAnyMes($id,$any,$mes);
    public function seleccionaMarcatgesPerIdAnySetmana($id,$any,$setmana);
    public function seleccionaMarcatgesPerIdAnyMesSetmana($id,$any,$mes,$setmana);
    public function seleccionaMarcatgesTots($empresa);
    public function seleccionaMarcatgesTotsPerDpt($empresa,$dpt);
    public function seleccionaMarcatgesTotsPerAny($empresa,$any);
    public function seleccionaMarcatgesTotsPerAnyMes($empresa,$any,$mes);
    public function seleccionaMarcatgesTotsPerAnySetmana($empresa,$any,$setmana);
    public function seleccionaMarcatgesTotsPerAnyMesSetmana($empresa,$any,$mes,$setmana);
    public function seleccionaMarcatgesTotsPerDptAny($empresa,$dpt,$any);
    public function seleccionaMarcatgesTotsPerDptAnyMes($empresa,$dpt,$any,$mes);
    public function seleccionaMarcatgesTotsPerDptAnySetmana($empresa,$dpt,$any,$setmana);
    public function seleccionaMarcatgesTotsPerDptAnyMesSetmana($empresa,$dpt,$any,$mes,$setmana);
    public function getMarcatgesPerIdDiaTorn($id,$data);
    
    //Càlculs
    public function calculaHoresTreballadesPerIdDia($id,$data);
    public function getPrimerMarcatgePerIdDia($id,$data);
    public function getUltimMarcatgePerIdDia($id,$data);
    public function getPrimerMarcatgeEntradaPerIdDia($id, $data);
    public function getPrimerMarcatgeSortidaPerIdDia($id, $data);
    public function getUltimMarcatgeEntradaPerIdDia($id, $data);
    public function getUltimMarcatgeSortidaPerIdDia($id, $data);
    public function getMarcatgeParella($id,$data,$hora);
    public function getMarcatgeParellaInvers($id,$data,$hora);
    public function getFestiuPerEmpresaDia($idempresa,$data);
    public function seleccionaHoresTeoriquesPerIdDia($id,$data);
    public function seleccionaHoresPausaPerIdDia($id,$data);
    public function calculaHoresActivitatsPerIdDiaIdtipusInici($id,$data,$hora);
    public function calculaHoresActivitatsPerInterval($hora1, $hora2);
    public function calculaHoresActivitatsPerIdDiaIdtipusFinal($id,$data,$hora);
    public function calculaHoresActivitatPerIdDiaIdtipus($id,$data,$idactiv);
    public function calculaHoresActivitatsAdescomptarPerIdDia($id, $data);
    public function calculaDiesEspecialsPerIdMesAnyIdExcep($idemp,$mes,$any,$idtipusexcep);
    public function getNombreNecessaris($idnec,$idtipusnec,$idtornfrac);
    
    //Impressions
    public function imprimeixMesPerIdAnyMes($id,$any,$mes,$percent,$lng);
    public function imprimeixTipusDiaPerIdDia($id,$dia,$tipusexcep,$lng);
    public function imprimeixHoraPerIdDiaHora($id,$dia,$hora,$lng);
    public function generaTblTipustorn($idemp);
    public function generaTbodyNecessitat($idempresa,$idtipusnec,$idtornfrac);
}
