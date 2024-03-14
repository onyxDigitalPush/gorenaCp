<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require_once('vendor/autoload.php');
include 'Conexion.php';


class AdminApiImpl implements AdminApi {
    private $db;
    private $KeyCrypt ;

    function getDb() {
        return $this->db;
    }

    function setDb($db) {
        $this->db = $db;
    }

    function __construct() {
        //$this->db = new GestorPersistenciaMySQLImpl("localhost","controlpres","lenovo","4lzCw66_"); //4lzCw66_
        $this->db = new GestorPersistenciaMySQLImpl();
        $this->KeyCrypt = "EnCrYpPasSw0Rd";
    }

    public function actualitzaCampTaula($taula, $camp, $idreg, $valor) {
        $sql = 'update '.$taula.' set '.$camp.'=("'.$valor.'") where id'.$taula.' = '.$idreg.'';
        $this->getDb()->executarSentencia($sql);
    }

    public function getCampPerIdCampTaula($taula,$idtaula,$camp){
        $res = "";
        if(!empty($idtaula)){
            $rs = $this->getDb()->executarConsulta('select '.$camp.' from '.$taula.' where id'.$taula.'='.$idtaula);
            foreach($rs as $r) $res = $r[$camp];}
        return $res;
    }

    public function __($ididioma,$text) {
        if(($ididioma!="")&&($ididioma!=1)){
            if(!empty($this->getDb()->executarConsulta('select * from idioma where ididioma = "'.$ididioma.'"')))
            {
                $sql = 'select traduccio from diccionari as d join enunciat as e on e.idenunciat = d.idenunciat where d.ididioma = "'.$ididioma.'" and e.text like "'.$text.'"';
                $traduccio = $this->getDb()->executarConsulta($sql);
                if(!empty($traduccio)) foreach($traduccio as $terme) $text = $terme["traduccio"];
            }
        }
        return $text;
    }

    public function getIdioma($id) {
        $ididioma=0;
        $idempresa=0;
        $idlanguser=$this->getDb()->executarConsulta('select ididiomadef from empleat where idempleat = "'.$id.'"');
        foreach($idlanguser as $idllengua) $ididioma=$idllengua["ididiomadef"];
        if(($ididioma==0)||($ididioma==null))
        {
            $idlangemp=$this->getDb()->executarConsulta('select es.ididiomadef from empresa as es join empleat as et on et.idempresa = es.idempresa where et.idempleat = "'.$id.'"');
            foreach($idlangemp as $idlangue) $ididioma=$idlangue["ididiomadef"];
        }
        return $ididioma;
    }

    public function mostraEnunciatsWeb() {
        return $this->getDb()->executarConsulta("select * from enunciat order by text");
    }

    public function getTraduccioPerIdEnunciat($idenunciat,$ididioma) {
        $traduccio = $this->getDb()->executarConsulta('select traduccio from diccionari as d join enunciat as e on e.idenunciat = d.idenunciat where e.idenunciat = "'.$idenunciat.'" and d.ididioma = "'.$ididioma.'"');
        $text = "";
        foreach($traduccio as $trad) $text = $trad["traduccio"];
        return $text;
    }

    public function afegeixTraduccio($idenunciat, $ididioma, $traduccio) {
        if(!empty($this->getDb()->executarConsulta('select * from diccionari where idenunciat = "'.$idenunciat.'" and ididioma = "'.$ididioma.'"')))
            $sql = 'update diccionari set traduccio=("'.$traduccio.'") where idenunciat = "'.$idenunciat.'" and ididioma = "'.$ididioma.'"';
        else $sql = 'insert into diccionari (idenunciat,ididioma,traduccio) values ('.$idenunciat.','.$ididioma.',"'.$traduccio.'")';
        $this->getDb()->executarSentencia($sql);
    }

    public function nouEnunciat($text) {
        $this->getDb()->executarSentencia('insert into enunciat (text) values ("'.$text.'")');
    }

    public function getEnunciatPerTraduccio($traduccio)
    {
        $enunciat = $this->getDb()->executarConsulta('select text from enunciat as e join diccionari as d on e.idenunciat = d.idenunciat where d.traduccio = "'.$traduccio.'"');
        $text = "";
        foreach($enunciat as $enun) $text = $enun["text"];
        return $text;
    }

    public function seleccionaIdiomesWeb() {
        return $this->getDb()->executarConsulta('select * from idioma where global=1');
    }

    // PERSONES
    public function mostraNomsDpt($empresa) {
        $sql = 'SELECT nom, iddepartament FROM departament WHERE idempresa like "'.$empresa.'" order by nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraRols($empresa,$master) {
        $sql = 'SELECT * FROM rol WHERE idempresa like "'.$empresa.'" and esmaster <= "'.$master.'" order by nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraRolsEmpleat($empresa) {
        $sql = 'SELECT * FROM rol WHERE idempresa like "'.$empresa.'" and esempleat = 1 order by nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraNomEmpPerId($id) {
        $sql = 'select * from empleat where idempleat like "'.$id.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"]." ".$row["cognom1"]." ".$row["cognom2"];
        return $res;
    }

    public function mostraNomEmpPerCodi($id) {
        $gotid = $this->mostraIdEmpPerIdentificador($id);
        $sql = 'select * from empleat where idempleat='.$gotid;
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"]." ".$row["cognom1"]." ".$row["cognom2"];
        return $res;
    }

    public function mostraNomDptPerIdEmp($id) {
        $sql = 'select nom from departament as d join pertany as p on p.id_dep = d.iddepartament where p.id_emp like "'.$id.'" and p.actiu = 1';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"];
        return $res;
    }

    public function mostraNomRolPerIdEmp($id) {
        $sql = 'select nom from rol as r join assignat as a on a.id_rol = r.idrol where a.id_emp like "'.$id.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"];
        return $res;
    }

    public function mostraRespEmp($empresa) {
        $sql = 'SELECT distinct e.idempleat, e.cognom1, e.cognom2, e.nom FROM empleat as e join assignat as a on a.id_emp = e.idempleat join rol as r on r.idrol = a.id_rol WHERE e.idempresa like "'.$empresa.'" and r.esadmin = 1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraIdEmpPerIdentificador($identificador) {
        $id = "";
        if($identificador!=""){
            $sql = 'select idempleat from empleat where idtargeta like "'.$identificador.'" or dni like "'.$identificador.'"';
            $rs = $this->getDb()->executarConsulta($sql);
            foreach ($rs as $emp) $id = $emp["idempleat"];
        }
        return $id;
    }

    public function seleccionaEmpPerId($id) {
        $sql = 'select * from empleat where idempleat like "'.$id.'" order by cognom1, cognom2, nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerDpt($dpt) {
        $sql = 'select distinct e.idempleat, e.cognom1, e.cognom2, e.nom, d.nom as Departament, e.email from empleat as e join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep WHERE d.nom like "'.$dpt.'" and p.actiu=1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerRol($rol) {
        $sql = 'select distinct e.idempleat, e.cognom1, e.cognom2, e.nom, r.nom as Rol, e.email from empleat as e join assignat as a on a.id_emp = e.idempleat join rol as r on r.idRol = a.id_rol WHERE r.nom like "'.$rol.'" and a.actiu=1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerDptRol($dpt, $rol) {
        $sql = 'select distinct e.idempleat, e.cognom1, e.cognom2, e.nom, r.nom as Rol, d.nom as Departament, d.ambit as Ambit, e.email from empleat as e join pertany as p on p.id_emp = e.idEmpleat join departament as d on d.idDepartament = p.id_dep join assignat as a on a.id_emp = e.idEmpleat join rol as r on r.idRol = a.id_rol WHERE d.nom like "'.$dpt.'" and r.nom like "'.$rol.'" order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTotsEmp($idempresa) {
        $sql = 'select * from empleat where idempresa='.$idempresa.' order by cognom1, cognom2, nom';//group by Identificador';
        return $this->getDb()->executarConsulta($sql);
    }


    public function getTreballadorsIdEmpresa($idempresa)
    {
        $sql = 'select idempleat from empleat where idempresa=' . $idempresa . ' order by cognom1, cognom2, nom'; //group by Identificador';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getTreballadorsIdEmpresaActius($idempresa)
    {
        $sql = 'select idempleat from empleat where idempresa=' . $idempresa . ' and enplantilla=1 order by cognom1, cognom2, nom'; //group by Identificador';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getTreballadorsIdEmpresaMarcatge($year, $month)
    {
        $sql = 'SELECT id_emp, id_tipus, entsort, datahora, observacions
        FROM marcatges
        WHERE YEAR(datahora) = ' . $year . ' AND MONTH(datahora) = ' . $month . '
        GROUP BY id_emp
        HAVING COUNT(*) > 0
        ';
        return $this->getDb()->executarConsulta($sql);

    }








    public function mostraAnysMarcatges() {
        $sql = 'SELECT distinct year(datahora) as anys FROM marcatges order by anys';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraAnysMarcatgesPerId($id) {
        $sql = 'SELECT distinct year(datahora) as anys FROM marcatges where id_emp like "'.$id.'" order by anys';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraAnysMarcatgesPerDpt($dpt) {
        $sql = 'SELECT distinct year(datahora) as anys FROM marcatges as m join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where d.nom like "'.$dpt.'" order by anys';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraMesosMarcatgesPerAny($any) {
        $sql = 'SELECT distinct month(datahora) as mesos FROM marcatges where year(datahora) like "'.$any.'" order by mesos';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraMesosMarcatgesPerIdAny($id, $any) {
        $sql = 'SELECT distinct month(datahora) as mesos FROM marcatges where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" order by mesos';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraMesosMarcatgesPerDptAny($dpt,$any)
    {
        $sql = 'SELECT distinct month(datahora) as mesos FROM marcatges as m join pertany as p on p.id_emp = m.id_emp join departament as d on d.idDepartament = p.id_dep where d.nom like "'.$dpt.'" and year(datahora) like "'.$any.'" order by mesos';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraMesSegonsSetmana($id, $any, $setmana) {
        $sql = 'SELECT distinct month(datahora) as mesos from marcatges where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" and week(datahora) like "'.$setmana.'" order by mesos';
        return $this->getDb()->executarSentencia($sql);
    }

    public function mostraSetmanesMarcatgesPerAny($any) {
        $sql = 'SELECT distinct week(datahora) as setmanes FROM marcatges where year(datahora) like "'.$any.'" order by setmanes';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraSetmanesMarcatgesPerAnyMes($any, $mes) {
        $sql = 'SELECT distinct week(datahora) as setmanes FROM marcatges where year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" order by setmanes';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraSetmanesMarcatgesPerIdAny($id, $any) {
        $sql = 'SELECT distinct week(datahora) as setmanes FROM marcatges where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" order by setmanes';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraSetmanesMarcatgesPerIdAnyMes($id, $any, $mes) {
        $sql = 'SELECT distinct week(datahora) as setmanes FROM marcatges where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" order by setmanes';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesPerId($id) {
        $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" order by datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesPerIdDia($id,$data) {
        try{
            $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions, ipadress, utm_x, utm_y, poblacio, regio, pais as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" and DATE(datahora)="'.$data.'" order by datahora';
            $rs = $this->getDb()->executarConsulta($sql);
            return $rs;
        }catch(PDOException $ex){echo $ex->getMessage();}
    }

    public function seleccionaMarcatgesPerIdAny($id, $any) {
        $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" order by datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesPerIdAnyMes($id, $any, $mes) {
        $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" order by datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesPerIdAnySetmana($id, $any, $setmana) {
        $setmanaseg = $setmana+1;
        $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" and year(datahora) like "'.$any.'" and (((week(datahora) like "'.$setmana.'") and (weekday(datahora) <> 6))||((week(datahora) like "'.$setmanaseg.'") and (weekday(datahora) like 6))) order by datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesPerIdAnyMesSetmana($id, $any, $mes, $setmana) {
        $sqlsetmana = "";
        if($setmana!=-1){
            $setmanaseg = $setmana+1;
            $sqlsetmana = 'and (((week(datahora) like "'.$setmana.'") and (weekday(datahora) <> 6))||((week(datahora) like "'.$setmanaseg.'") and (weekday(datahora) like 6)))';
        }
        $sqlmes = "";
        if($mes!=0){
            $sqlmes = 'and month(datahora) like "'.$mes.'"';
        }
        $sqlany = "";
        if($any!=0){
            $sqlany = 'and year(datahora) like "'.$any.'"';
        }
        $sql = 'select idmarcatges, entsort, id_tipus, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusactivitat as t on t.idtipusactivitat = m.id_tipus where id_emp like "'.$id.'" '.$sqlany.' '.$sqlmes.' '.$sqlsetmana.' order by datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function automarcatges($idempresa){
        $res = "";
        $rsautomar = $this->getDb()->executarConsulta('select idempleat from empleat where idempresa='.$idempresa.' and automarc=1');
        foreach($rsautomar as $r){
            $id = $r["idempleat"];
            $res.=$id." ";
            $data = "";
            //cercar darrera data amb marcatges d'entrada FET
            $rsume = $this->getDb()->executarConsulta('select max(datahora) as ume from marcatges where id_emp='.$id.' and entsort=0');
            $d1 = 0;
            if(!empty($rsume)) {
                foreach($rsume as $d) {$data = $d["ume"]; if($d1==0){$res.="(".$d["ume"].") ,";}$d1++;}
                $data = date('Y-m-d',strtotime($data." + 1 days"));
            }
            //si no hi ha marcatges, cercar la primera data de l'horari assignat actualment PENDENT
            if($data==""){
                $rspda = $this->getDb()->executarConsulta('select datainici from quadrant where actiu=1 and idEmpleat='.$id);
                $d2 = 0;
                foreach($rspda as $p) {$data = $p["datainici"]; if($d2==0) {$res.="(".$p["datainici"].") ,";}$d2++;}
            }
            while(strtotime($data)<=strtotime('today')){
                $this->insereixMarcatgesDataTornId($id,$data,1);
                $data = date('Y-m-d',strtotime($data." + 1 days"));
            }
        }
        //$_SESSION["dataautomarc"] = date('Y-m-d',strtotime('today'));
        return $res;
    }

    public function carregaInicial($idempresa){
        session_start();
        $_SESSION["arrpers"] = $this->carregaPersones($idempresa);
        $_SESSION["arrttfrac"] = $this->carregaTipustorns($idempresa);
        $_SESSION["arrh7d"] = $this->carregaHoraris7d($idempresa);  // FER SERVIR AQUESTS ARRAYS DE SESSIÓ AMB ELS TORNS DE 7 DIES PER A TROBAR LES HORES TEÒRIQUES
        $_SESSION["arrt7d"] = $this->carregaTorns7d($idempresa);
    }

    public function carregaPersones($idempresa){
        $sqlpers = 'select e.idempleat as idempleat, e.cognom1 as cognom1, e.cognom2 as cognom2, e.nom as nomempl, e.dni as dni, e.idsubempresa as idsubempresa, ro.nom as nomrol, e.enplantilla as enplantilla, e.datacessat as datacessat '
            . 'from empleat as e join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol '//.$sqljoinrol.' '.$sqljoindpt.' '
            . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 order by e.cognom1, e.cognom2, e.nom';//'.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0)))
        $persones = $this->getDb()->executarConsulta($sqlpers);//
        $arrpers = [];
        foreach($persones as $p){
            $chrpers = array_fill(0,9,0);
            $chrpers[0] = $p["idempleat"];
            $chrpers[1] = $p["cognom1"];
            $chrpers[2] = $p["cognom2"];
            $chrpers[3] = $p["nomempl"];//nomempl
            $chrpers[4] = $p["dni"];
            $chrpers[5] = $p["idsubempresa"];
            $chrpers[6] = $p["nomrol"];
            $chrpers[7] = $p["enplantilla"];
            $chrpers[8] = $p["datacessat"];
            $arrpers[] = $chrpers;
        }
        return $arrpers;
    }

    public function carregaTipustorns($idempresa){
        $arrttfrac = [];//Array que guardi la taula de tipus de torn, classificada per matí tarda i nit.
        $rstt = $this->getDb()->executarConsulta('select idtipustorn as idt, tf.mati as mt, tf.tarda as td, tf.nit as nt, tt.colortxt as colortxt, tt.colorbckg as colorbckg, tt.abrv as abrv, tt.nom as nom, tt.horaentrada as horaentrada, tt.horasortida as horasortida, tt.horestreball as horestreball from tipustorn as tt join tornfrac as tf on tt.torn = tf.idtornfrac');
        foreach($rstt as $tpt){$ttfrac = array_fill(0,11,0);$ttfrac[0]=$tpt["idt"];$ttfrac[1]=$tpt["mt"];$ttfrac[2]=$tpt["td"];$ttfrac[3]=$tpt["nt"];$ttfrac[4]=$tpt["colortxt"];$ttfrac[5]=$tpt["colorbckg"];$ttfrac[6]=$tpt["abrv"];$ttfrac[7]=$tpt["nom"];$ttfrac[8]=$tpt["horaentrada"];$ttfrac[9]=$tpt["horasortida"];$ttfrac[10]=$tpt["horestreball"];$arrttfrac[]=$ttfrac;}
        return $arrttfrac;
    }

    public function carregaHoraris7d($idempresa){
        $arrh7d = [];
        $rsh7d = $this->getDb()->executarConsulta('select * from horaris where idempresa='.$idempresa.' and ((obsolet=0) or (obsolet is null))');
        foreach($rsh7d as $h){
            $chrh7d = array_fill(0,4,0);
            $chrh7d[0] = $t["idhoraris"];
            $chrh7d[1] = $t["nom"];
            $chrh7d[2] = $t["horesetmana"];
            $chrh7d[3] = $t["descripcio"];
            $arrh7d[] = $chrh7d;
        }
        return $arrh7d;
    }

    public function carregaTorns7d($idempresa){
        $arrt7d = [];
        $rst7d = $this->getDb()->executarConsulta('select * from torn as t join horaris as h on h.idhoraris = t.idhorari where h.idempresa='.$idempresa.' and t.laborable=1');
        foreach($rst7d as $t){
            $chrt7d = array_fill(0,6,0);
            $chrt7d[0] = $t["idhorari"];
            $chrt7d[1] = $t["diasetmana"];
            $chrt7d[2] = $t["horaentrada"];
            $chrt7d[3] = $t["horasortida"];
            $chrt7d[4] = $t["horestreball"];
            $chrt7d[5] = $t["horespausa"];
            $arrt7d[] = $chrt7d;
        }
        return $arrt7d;
    }




    public function insereixMarcatge($identificador, $tipus, $inout, $datahora, $ipaddress) {
        $idemp = $this->mostraIdEmpPerIdentificador($identificador);
        if(empty($idemp)) $idemp = $identificador;
        $sql = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,ipadress,observacions,datareg) VALUES ('.$idemp.','.$tipus.','.$inout.',"'.$datahora.'","'.$ipaddress.'",'.$tipus.',now())';
        return $this->getDb()->executarSentencia($sql);
    }




    public function insereixMarcatgeComplet($identificador, $tipus, $inout, $datahora, $ipaddress, $utm_x, $utm_y, $poblacio, $regio, $pais) {
        $idemp = $this->mostraIdEmpPerIdentificador($identificador);
        $autosort = $this->getCampPerIdCampTaula("empleat",$idemp,"automarcsort");
        $data = date('Y-m-d',strtotime($datahora));
        $hora = date('H:i',strtotime($datahora));
        $horaent = "";
        $horasort = "";

        if(($autosort==1)&&($inout==1)) {

            if($this->esTornBidata($idemp,$data)==1) {
                $idrot = $this->terotacio($idemp,$data);
                if(!empty($idrot)){
                    $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                    $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                    $horasort = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida");
                }
                else {$torn = $this->getTornPerIdDia($idemp,$data); if(!empty($torn)){$horaent = $torn->getHoraini();$horasort = $torn->getHorafi();} }
                if((strtotime($hora)<=strtotime('23:59'))&&(strtotime($hora)>=strtotime($horaent))) {$data = date('Y-m-d',strtotime($data." + 1 days"));}
                //$datahora = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
            }
            else if($this->esTornBidata($idemp,$data)==0) {
                //Check si el marcatge correspon al torn bidata del dia anterior
                $datatp = date('Y-m-d',strtotime($data." - 1 days"));
                if($this->esTornBidata($idemp,$datatp)==1) {
                    $idrot = $this->terotacio($idemp,$datatp);
                    if(!empty($idrot)){
                        $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                        $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                        $horasort = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida");
                    }
                    else {$torn = $this->getTornPerIdDia($idemp,$datatp); if(!empty($torn)){$horaent = $torn->getHoraini();$horasort = $torn->getHorafi();} }
                    //$datahora = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
                }
                else {
                    //if($horasort!="") $datahora = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
                    $idrot = $this->terotacio($idemp,$data);
                    if(!empty($idrot)){
                        $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                        $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                        $horasort = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida");
                    }
                    else {$torn = $this->getTornPerIdDia($idemp,$data); if(!empty($torn)){$horaent = $torn->getHoraini();$horasort = $torn->getHorafi();} }
                }
            }
            if($horasort!="") {
                $hora = abs(date('H',strtotime($horasort)));
                $mins = abs(date('i',strtotime($horasort)))+random_int(0,5);
                if($mins>59) {$mins-=60;$hora++;}
                if($hora<10) {$hora = "0".$hora;}
                $horasort = $hora.":".$mins.":00";
                $datahora0 = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
                if(((strtotime($datahora)>strtotime($datahora0))&&(strtotime($datahora)<strtotime($datahora0." + 3 hours")))
                    ||
                    ((strtotime($datahora)<strtotime($datahora0))&&(strtotime($datahora)>strtotime($datahora0." - 3 hours"))))
                { $datahora = $datahora0;}
            }
        }
        if(empty($idemp)) $idemp = $identificador;




        include 'Conexion.php';
        // Realizar la consulta a la tabla tipusactivitat
        $result = $conn->query("SELECT idtipusactivitat, descripcio FROM tipusactivitat");

// Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            // Crear el array observacionsOptions
            $observacionsOptions = [];

            // Recorrer los resultados y agregarlos al array observacionsOptions
            while ($row = $result->fetch_assoc()) {
                $observacionsOptions[$row['idtipusactivitat']] = $row['descripcio'];
            }

            // Obtener el valor de observacions según el idtipus
            $observacions = isset($observacionsOptions[$tipus]) ? $observacionsOptions[$tipus] : '';
        } else {
            echo "No se encontraron resultados en la tabla tipusactivitat.";
        }

// Cerrar el resultado de la consulta
        $result->close();




        $observacions = isset($observacionsOptions[$tipus]) ? $observacionsOptions[$tipus] : '';



        $sql = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,ipadress,utm_x,utm_y,poblacio,regio,pais, observacions, datareg) VALUES ('.$idemp.','.$tipus.','.$inout.',"'.$datahora.'","'.$ipaddress.'","'.$utm_x.'","'.$utm_y.'","'.$poblacio.'","'.$regio.'","'.$pais.'","'.$observacions.'",now())';
        return $this->getDb()->executarSentencia($sql);
    }




    public function eliminaMarcajesExistente($id, $dataini, $datafi) {
        $sql = "DELETE FROM marcatges WHERE id_emp = $id AND DATE(datahora) BETWEEN '$dataini' AND '$datafi'";
        $resultado = $this->getDb()->executarSentencia($sql);
        if ($resultado) {
            echo "Se han eliminado los marcajes correctamente.";
        } else {
            echo "No se han eliminado los marcajes.";
        }
    }





    public function insereixMultiMarcatges($id,$dataini,$horaini,$datafi,$horafi,$chkhrqd,$chkhrrd)
    {
        $data = $dataini;
        if($chkhrqd==1){
            while(strtotime($data)<=strtotime($datafi)){
                $this->insereixMarcatgesDataTornId($id,$data,$chkhrrd);
                $data = date('Y-m-d',strtotime($data." + 1 days"));
            }
        }
        else {
            while(strtotime($data)<=strtotime($datafi)){
                $datahoraent = date('Y-m-d H:i:s',strtotime($data." ".$horaini));
                if(($chkhrrd==1)) {
                    $minsless = "";
                    $rndmin = ((random_int(0,10))-5);
                    if($rndmin>0){$minsless = " + ".$rndmin." minutes";}
                    if($rndmin<0){$minsless = " ".$rndmin." minutes";}
                    $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent.$minsless));
                }
                $sqle = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,datareg) VALUES ('.$id.',4,0,"'.$datahoraent.'",now())';
                $this->getDb()->executarSentencia($sqle);
                $datahorasort = date('Y-m-d H:i:s',strtotime($data." ".$horafi));
                if(strtotime($horaini)>strtotime($horafi)) {$datahorasort = date('Y-m-d H:i:s',strtotime($data." ".$horafi." + 1 days"));}
                if(($chkhrrd==1)) {
                    $daymore = "";
                    if(strtotime($horaini)>strtotime($horafi)) $daymore = " + 1 days";
                    $hora = abs(date('H',strtotime($horafi)));
                    $mins = abs(date('i',strtotime($horafi)))+random_int(0,5);
                    if($mins>59) {$mins-=60;$hora++;}
                    if($hora<10) {$hora = "0".$hora;}
                    $horasort = $hora.":".$mins.":00";
                    $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort.$daymore));
                }
                $sqls = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,datareg) VALUES ('.$id.',4,1,"'.$datahorasort.'",now())';
                $this->getDb()->executarSentencia($sqls);
                $data = date('Y-m-d',strtotime($data." + 1 days"));
            }
        }
    }

    public function insereixMarcatgesDataTornId($idemp,$datahora,$chkhrrd){
        $data = date('Y-m-d',strtotime($datahora));
        $hora = date('H:i',strtotime($datahora));
        $horaent = "";
        $horasort = "";
        $datahoraent = "";
        $datahorasort = "";
        $idrot = "";
        //Buscar torn (rotació o horari(si no cau en festiu segons ubicació)) i capturar les hores d'entrada i sortida)

        if($this->esTornBidata($idemp,$data)==1) {
            $idrot = $this->terotacio($idemp,$data);
            if(!empty($idrot)){
                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                $horasort = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida");
                $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort." + 1 days"));
            }
            else {
                $torn = $this->getTornPerIdDia($idemp,$data);
                if(!empty($torn)){
                    $horaent = $torn->getHoraini();
                    $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                    $horasort = $torn->getHorafi();
                    $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort." + 1 days"));
                }
            }
            //if((strtotime($horasort)>strtotime($horaent))&&(strtotime($hora)>=strtotime($horaent))) {$datahorasort = date('Y-m-d H:i:s',strtotime($datahorasort." + 1 days"));}
            //$datahora = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
        }
        else{
            $idrot = $this->terotacio($idemp,$data);
            if(!empty($idrot)){
                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                $horasort = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida");
                $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
            }
            else {
                $torn = $this->getTornPerIdDia($idemp,$data);
                if(!empty($torn)){
                    $horaent = $torn->getHoraini();
                    $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                    $horasort = $torn->getHorafi();
                    $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort));
                }
            }
        }
        if(($chkhrrd==1)&&((!empty($idrot))||(empty($this->esFestiuPerIdDia($idemp,$data))))) {
            $minsless = "";
            $rndmin = ((random_int(0,10))-5);
            if($rndmin>0){$minsless = " + ".$rndmin." minutes";}
            if($rndmin<0){$minsless = " ".$rndmin." minutes";}
            $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent.$minsless));
            $daymore = "";
            if($this->esTornBidata($idemp,$data)==1) $daymore = " + 1 days";
            $hora = abs(date('H',strtotime($horasort)));
            $mins = abs(date('i',strtotime($horasort)))+random_int(0,5);
            if($mins>59) {$mins-=60;$hora++;}
            if($hora<10) {$hora = "0".$hora;}
            $horasort = $hora.":".$mins.":00";
            $datahorasort = date("Y-m-d H:i:s",strtotime($data." ".$horasort.$daymore));
        }
        if((empty($this->esExcepcioPerIdDia($idemp,$data)))&&((!empty($idrot))||(($this->treballaria($idemp,$data))&&(empty($this->esFestiuPerIdDia($idemp,$data)))))){
            $sqle = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,datareg) VALUES ('.$idemp.',4,0,"'.$datahoraent.'",now())';
            $this->getDb()->executarSentencia($sqle);
            $sqls = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,datareg) VALUES ('.$idemp.',4,1,"'.$datahorasort.'",now())';
            $this->getDb()->executarSentencia($sqls);
        }
    }

    public function insereixPrimerMarcatgeDataTornId($idemp,$datahora)
    {
        $data = date('Y-m-d',strtotime($datahora));
        $hora = date('H:i',strtotime($datahora));
        $horaent = "";
        $datahoraent = "";
        $idrot = "";
        //Buscar torn (rotació o horari(si no cau en festiu segons ubicació)) i capturar les hores d'entrada i sortida)

        if($this->esTornBidata($idemp,$data)==1) {
            $idrot = $this->terotacio($idemp,$data);
            if(!empty($idrot)){
                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
            }
            else {
                $torn = $this->getTornPerIdDia($idemp,$data);
                if(!empty($torn)){
                    $horaent = $torn->getHoraini();
                    $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                }
            }

        }
        else{
            $idrot = $this->terotacio($idemp,$data);
            if(!empty($idrot)){
                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                $horaent = $this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horaentrada");
                $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
            }
            else {
                $torn = $this->getTornPerIdDia($idemp,$data);
                if(!empty($torn)){
                    $horaent = $torn->getHoraini();
                    $datahoraent = date("Y-m-d H:i:s",strtotime($data." ".$horaent));
                }
            }
        }
        if((empty($this->esExcepcioPerIdDia($idemp,$data)))&&((!empty($idrot))||(($this->treballaria($idemp,$data))&&(empty($this->esFestiuPerIdDia($idemp,$data)))))){
            $sqle = 'INSERT INTO marcatges (id_emp,id_tipus,entsort,datahora,datareg) VALUES ('.$idemp.',4,0,"'.$datahoraent.'",now())';
            $this->getDb()->executarSentencia($sqle);
        }
    }

    public function eliminaMarcatgesDataId($idemp,$data)
    {
        $strmcelim = "Idsmarcatges: ";
        $dataant = date('Y-m-d',strtotime($data." - 1 days"));
        $horafiant = "";
        if($this->esTornBidata($idemp,$dataant)==1){
            //Llavors no eliminar els marcatges fins que acabi el torn teòric anterior
            $idrotant = $this->terotacio($idemp,$dataant);
            if(!empty($idrotant)){
                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn");
                $horasortant = date("H:i:s",strtotime($this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida")." + 1 hours" ));
            }
            else {
                $tornant = $this->getTornPerIdDia($idemp,$dataant);
                if(!empty($tornant)){
                    $horasortant = date("H:i:s",strtotime($tornant->getHorafi()." + 1 hours"));
                }
            }
            $rsm = $this->getDb()->executarConsulta('select * from marcatges where id_emp='.$idemp.' and DATE(datahora)="'.$data.'" and TIME(datahora)>="'.$horasortant.'"');
            foreach($rsm as $ma) {
                $this->getDb()->executarSentencia('delete from marcatges where idmarcatges='.$ma["idmarcatges"]); $strmcelim.=",".$ma["idmarcatges"];
            }
        }
        else{
            $rsm = $this->getDb()->executarConsulta('select * from marcatges where id_emp='.$idemp.' and DATE(datahora)="'.$data.'"');
            foreach($rsm as $m) {
                $this->getDb()->executarSentencia('delete from marcatges where idmarcatges='.$m["idmarcatges"]); $strmcelim.=",".$m["idmarcatges"];
            }
        }
        //Si Avui era torn bidata Llavors eliminar també els registres del dia següent fins a la finalització del torn
        if($this->esTornBidata($idemp,$data)==1){
            $datapost = date('Y-m-d',strtotime($data." + 1 days"));
            $idrot = $this->terotacio($idemp,$data);
            if(!empty($idrot)){
                $horasort = date("H:i:s",strtotime($this->getCampPerIdCampTaula("tipustorn",$idtipustorn,"horasortida")." + 1 hours"));
            }
            else {
                $torn = $this->getTornPerIdDia($idemp,$data);
                if(!empty($torn)){
                    $horasort = date("H:i:s",strtotime($torn->getHorafi()." + 1 hours"));
                }
            }
            $rsm = $this->getDb()->executarConsulta('select * from marcatges where id_emp='.$idemp.' and DATE(datahora)="'.$datapost.'" and TIME(datahora)<="'.$horasortant.'"');
            foreach($rsm as $mp) {
                $this->getDb()->executarSentencia('delete from marcatges where idmarcatges='.$mp["idmarcatges"]); $strmcelim.=",".$mp["idmarcatges"];
            }
        }
        return $strmcelim." Fi idsmarcatges.";
    }

    public function insereixMarcatgeObs($identificador,$inout,$tipus,$datahora,$obs) {

        $idemp = $this->mostraIdEmpPerIdentificador($identificador);
        if(empty($idemp)) $idemp = $identificador;
        $sql = 'INSERT INTO marcatges (id_emp,entsort,id_tipus,datahora,observacions,datareg) VALUES ('.$idemp.','.$inout.','.$tipus.', "'.$datahora.'", "'.$obs.'",now())';
        return $this->getDb()->executarSentencia($sql);
    }

    public function editaMarcatgeObs($id,$inout,$tipus,$datahora,$obs) {

        $this->getDb()->executarSentencia('update marcatges set entsort='.$inout.',id_tipus='.$tipus.',datahora="'.$datahora.'",observacions="'.$obs.'" where idmarcatges='.$id);
    }

    public function validaIdEmpMarcatge($codi) {
        $sql = 'select idempleat, nom, cognom1, cognom2 from empleat where enplantilla=1 and ((idtargeta like "'.$codi.'") or (dni like "'.$codi.'"))';
        return $rs = $this->getDb()->executarConsulta($sql);
    }

    public function actualitzaMarcatge($idmarc, $novahora)
    {
        $datahoraantiga = $this->getDb()->executarConsulta('select datahora from marcatges where idmarcatges like"'.$idmarc.'"');
        foreach ($datahoraantiga as $datahoraant) $dataantiga = $datahoraant["datahora"];
        $data = substr($dataantiga,0,11);
        $datahora = $data.$novahora.":00";
        $sql = 'UPDATE marcatges SET datahora=("'.$datahora.'") WHERE idmarcatges="'.$idmarc.'"';

        return $this->getDb()->executarSentencia($sql);
    }

    public function observacionsMarcatge($idmarc, $observ) {
        $sql = 'UPDATE marcatges SET observacions=("'.$observ.'") WHERE idmarcatges="'.$idmarc.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function validaMarcatge($idmarc) {
        $sql = 'UPDATE marcatges SET validat=("1") WHERE idmarcatges="'.$idmarc.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function desValidaMarcatge($idmarc,$weekday) {
        $sql = 'UPDATE marcatges SET validat=("0") WHERE idmarcatges="'.$idmarc.'" and weekday(datahora) like "'.$weekday.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function validaMarcatgesDia($idmarc, $weekday) {
        $sql = 'UPDATE marcatges SET validat=("1") WHERE idmarcatges="'.$idmarc.'" and weekday(datahora) like "'.$weekday.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function eliminaMarcatge($idmarc) {
        $sql = 'delete from marcatges where idmarcatges like "'.$idmarc.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function cessaNoPujats($arrmiss,$data){
        foreach($arrmiss as $m){
            $id = $m[0];
            $datacess = date('Y-m-d',strtotime($data.' - 1 days'));
            $this->getDb()->executarSentencia('update empleat set enplantilla=0,datacessat="'.$datacess.'" where idempleat='.$id);
            $this->getDb()->executarSentencia('update quadrant set datafi="'.$datacess.'",actiu=0 where idEmpleat='.$id.' and actiu=1');//or datafi anterior a datacess
        }
    }

    public function comprovaPujatsActius($arrup,$data,$idemp){
        $idh = 0;
        $rsh = $this->getDb()->executarConsulta('select idhoraris from horaris where idempresa='.$idemp.' and (obsolet=0 or obsolet is null) limit 1');
        foreach($rsh as $h) {$idh = $h["idhoraris"];}
        foreach($arract as $a){
            $id = $a[0];
            $dataac = date('Y-m-d',strtotime($data));
            $rshp = $this->getDb()->executarConsulta('select idquadrant from quadrant where idEmpleat='.$id.' and (actiu=1 or datafi is null) limit 1');
            if(empty($rshp)) {$this->getDb()->executarSentencia('insert into quadrant (idEmpleat,idhorari,datainici,actiu) values ('.$id.','.$idh.',"'.$dataac.'",1)');
                $this->insereixPrimerMarcatgeDataTornId($id,$dataac);}
        }
    }

    public function reactivaPujatsCessats($arract,$data,$idemp){
        $datareac = date('Y-m-d',strtotime($data));
        $idh = 0;
        $rsh = $this->getDb()->executarConsulta('select idhoraris from horaris where idempresa='.$idemp.' and (obsolet=0 or obsolet is null) limit 1');
        foreach($rsh as $h) {$idh = $h["idhoraris"];}
        foreach($arract as $a){
            $id = $a[0];
            $this->getDb()->executarSentencia('update empleat set enplantilla=1,dataultcontrac="'.$datareac.'" where idempleat='.$id);
            $this->getDb()->executarSentencia('insert into quadrant (idEmpleat,idhorari,datainici,actiu) values ('.$id.','.$idh.',"'.$datareac.'",1)');
            $this->insereixPrimerMarcatgeDataTornId($id,$datareac);
        }
    }

    public function altaPujatsNoExistents($arrnew,$data,$idemp){
        $idsubemp = 0;
        $rssbe = $this->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa='.$idemp.' limit 1');
        foreach($rssbe as $s) {$idsubemp = $s["idsubempresa"];}
        $idh = 0;
        $rsh = $this->getDb()->executarConsulta('select idhoraris from horaris where idempresa='.$idemp.' and (obsolet=0 or obsolet is null) limit 1');
        foreach($rsh as $h) {$idh = $h["idhoraris"];}
        $idr = 0;
        $rsr = $this->getDb()->executarConsulta('select idrol from rol where idempresa='.$idemp.' limit 1');
        foreach($rsr as $r) {$idr = $r["idrol"];}
        foreach($arrnew as $n){
            $dataac = date('Y-m-d',strtotime($data));
            $this->getDb()->executarSentencia('insert into empleat (idempresa,idsubempresa,nom,idtargeta,dni,numafiliacio,dataultcontrac,enplantilla,automarc) values ('.$idemp.','.$idsubemp.',"'.$n[0].'","'.strtolower($n[2]).'","'.$n[2].'","'.$n[1].'","'.$dataac.'",1,1)');
            $ide = 0;
            $rse = $this->getDb()->executarConsulta('select idempleat from empleat order by idempleat desc limit 1');
            foreach($rse as $em) {$ide = $em["idempleat"];}
            $this->getDb()->executarSentencia('insert into quadrant (idEmpleat,idhorari,datainici,actiu) values ('.$ide.','.$idh.',"'.$dataac.'",1)');
            $this->getDb()->executarSentencia('insert into assignat (id_emp,id_rol,datainici,actiu) values ('.$ide.','.$idr.',"'.$dataac.'",1)');
            $this->insereixPrimerMarcatgeDataTornId($ide,$dataac);
        }

    }

    public function mostraNomMes($mes) {
        $res = "";
        switch($mes)
        {
            case 1:
                $res = "Gener";
                break;
            case 2:
                $res = "Febrer";
                break;
            case 3:
                $res = "Març";
                break;
            case 4:
                $res = "Abril";
                break;
            case 5:
                $res = "Maig";
                break;
            case 6:
                $res = "Juny";
                break;
            case 7:
                $res = "Juliol";
                break;
            case 8:
                $res = "Agost";
                break;
            case 9:
                $res = "Setembre";
                break;
            case 10:
                $res = "Octubre";
                break;
            case 11:
                $res = "Novembre";
                break;
            case 12:
                $res = "Desembre";
                break;
            default:
                $res = "Tots";
                break;
        }
        return $res;
    }

    public function mostraNomDia($dia) {
        $res = "";
        switch($dia)
        {
            case 1:
                $res = "Dilluns";
                break;
            case 2:
                $res = "Dimarts";
                break;
            case 3:
                $res = "Dimecres";
                break;
            case 4:
                $res = "Dijous";
                break;
            case 5:
                $res = "Divendres";
                break;
            case 6:
                $res = "Dissabte";
                break;
            case 7:
                $res = "Diumenge";
                break;
            case 0:
                $res = "Diumenge";
                break;
            default:
                $res = "Tots";
                break;
        }
        return $res;
    }

    public function mostraEntrades() {
        $sql = 'SELECT * FROM tipusmarcatge where nom like "Entrada%"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraSortides() {
        $sql = 'SELECT * FROM tipusmarcatge where nom like "Sortida%"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraNomEntradaSortidaPerId($id) {
        $sql = 'SELECT Nom FROM tipusmarcatge where id_tipus like "'.$id.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $nom = "";
        foreach($rs as $valor)$nom=$valor["nom"];
        return $nom;
    }

    public function seleccionaMarcatgesTots($empresa) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep WHERE e.idempresa like "'.$empresa.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerDpt($empresa,$dpt) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and d.nom like "'.$dpt.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerAny($empresa,$any) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idEmpleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.idDepartament = p.id_dep where e.idempresa like "'.$empresa.'" and year(datahora) like "'.$any.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerAnyMes($empresa,$any, $mes) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idEmpleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.idDepartament = p.id_dep where e.idempresa like "'.$empresa.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerAnySetmana($empresa,$any,$setmana) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and year(datahora) like "'.$any.'" and week(datahora) like "'.$setmana.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerAnyMesSetmana($empresa,$any, $mes, $setmana) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" and week(datahora) like "'.$setmana.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerDptAny($empresa,$dpt,$any) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and d.nom like "'.$dpt.'" and year(datahora) like "'.$any.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerDptAnyMes($empresa,$dpt,$any,$mes) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and d.nom like "'.$dpt.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerDptAnySetmana($empresa,$dpt,$any,$setmana) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and d.nom like "'.$dpt.'" and year(datahora) like "'.$any.'" and week(datahora) like "'.$setmana.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaMarcatgesTotsPerDptAnyMesSetmana($empresa,$dpt,$any,$mes,$setmana) {
        $sql = 'select idmarcatges, d.nom as Dept, e.idempleat as id, e.cognom1, e.cognom2, e.nom as Nom, t.nom as tipus, datahora, validat, m.observacions as obs from marcatges as m join tipusmarcatge as t on t.id_tipus = m.id_tipus join empleat as e on e.idempleat = m.id_emp join pertany as p on p.id_emp = m.id_emp join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$empresa.'" and d.nom like "'.$dpt.'" and year(datahora) like "'.$any.'" and month(datahora) like "'.$mes.'" and week(datahora) like "'.$setmana.'" order by dept, nom, datahora';
        return $this->getDb()->executarConsulta($sql);
    }

    // HORARIS I TORNS

    public function seleccionaHorarisEmpPerId($id) {
        $sql = 'select idempleat, q.idquadrant, q.idhorari, q.datainici, q.datafi, h.horesetmana, h.nom, q.actiu from quadrant as q join horaris as h on h.idhoraris = q.idhorari where idempleat like "'.$id.'" order by datainici desc';
        $llistaquadrants = $this->getDb()->executarConsulta($sql);
        foreach($llistaquadrants as $quadrant) $this->assignaVigencia($quadrant["idquadrant"],$this->esVigent($quadrant["idquadrant"]));
        return $this->getDb()->executarConsulta($sql);
    }
	 public function seleccionaHorarisEmpPerIdEmpleat($id,$any) {
        $sql = 'select idempleat, q.idquadrant, q.idhorari, q.datainici, q.datafi, h.horesetmana, h.nom, q.actiu from quadrant as q join horaris as h on h.idhoraris = q.idhorari where idempleat like "'.$id.'"  AND YEAR(q.datainici) = '.$any.' order by datainici desc';
        $llistaquadrants = $this->getDb()->executarConsulta($sql);
        //foreach($llistaquadrants as $quadrant) $this->assignaVigencia($quadrant["idquadrant"],$this->esVigent($quadrant["idquadrant"]));
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTornsEmpPerHorari($id,$idhorari) {
        $sql = 'SELECT * FROM torn as t join quadrant as q on q.idhorari = t.idhorari join empleat as e on e.idempleat = q.idempleat where q.idempleat like "'.$id.'" and q.idhorari like "'.$idhorari.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTornsPerHorari($idhorari) {
        $sql = 'SELECT * FROM torn where idhorari = '.$idhorari.'';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTornActualEmpPerId($id) {
        $sql = 'SELECT * FROM torn as t join quadrant as q on q.idhorari = t.idhorari join empleat as e on e.idempleat = q.idempleat where e.idempleat like "'.$id.'" and q.actiu like "1";';
        return $this->getDb()->executarConsulta($sql);
    }

    public function generaTblTipustorn($idemp){
        session_start();
        $lng = $_SESSION["ididioma"];
        $tornstipus = $this->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idemp.' order by nom');
        foreach($tornstipus as $t){
            $tornfrac = $t["torn"];
            if($tornfrac>0) $tornfrac = $this->getCampPerIdCampTaula ("tornfrac",$tornfrac,"nom");
            $btnopt = "";
            if (empty($this->getDb()->executarConsulta('select * from rotacio where idtipustorn='.$t["idtipustorn"]))) {
                $btnDelete = '<button class="btn-red btn-small" onclick="event.cancelBubble=true;confElimTipustorn('.$t["idtipustorn"].','.$idemp.');"><span class="glyphicon glyphicon-remove"></span></button>';
            } else {
                $btnDelete = '';
            }

            $btnEdit = '<button class="btn-next btn-small" onclick="event.cancelBubble=true;editTipustorn('.$t["idtipustorn"].');"><span class="glyphicon glyphicon-pencil"></span></button>';

            echo '<tr style="cursor: pointer; font-weight: bold;" onclick="mostraEditaTipustorn('.$t["idtipustorn"].');" title="'.$this->__($lng,"Click per a editar el Torn").'">'
                . '<td>'.$t["nom"].'</td>'

                . '<td style="background-color: '.$t["colorbckg"].'; color: '.$t["colortxt"].';">'.$t["abrv"].'</td>'

                . '<td style="text-align: center;">'.$tornfrac.'</td>'
                . '<td style="text-align: center;">'.$btnEdit.$btnDelete.'</td>'

                . '</tr>';
        }
    }

    // CÀLCULS

    public function dirsiono($bool) {
        $res = "";
        if($bool=="1")$res = "Sí";
        else $res = "No";
        return $res;
    }

    public function direntsort($bool) {
        $text = "";
        if($bool==0)$text="Entrada";
        else if($bool==1)$text="Sortida";
        return $text;
    }

    public function getNombreNecessaris($idnec,$idtipusnec,$idtornfrac)
    {
        $num = 0;
        $rstn = $this->getDb()->executarConsulta('select * from tornnec where idnecessitat='.$idnec.' and idtipusnec='.$idtipusnec.' and idtornfrac='.$idtornfrac);
        foreach($rstn as $tn){ $num+=$tn["quantitat"]; }
        return $num;
    }

    public function generaTbodyNecessitat($idsubempresa,$idtipusnec,$idtornfrac)
    {
        try{
            $body = "";
            $idnec = 0;
            $rsn = $this->getDb()->executarConsulta('select * from necessitat where idsubempresa='.$idsubempresa.' order by idnecessitat desc limit 1');
            foreach($rsn as $n){$idnec = $n["idnecessitat"];}
            $rstn = $this->getDb()->executarConsulta('select * from tornnec where idnecessitat='.$idnec.' and idtipusnec='.$idtipusnec.' and idtornfrac='.$idtornfrac);
            foreach($rstn as $tn){
                $torn = $this->getCampPerIdCampTaula("tipustorn", $tn["idtipustorn"], "nom");
                $body.='<tr><td>'.$torn.'</td><td>'.$tn["quantitat"].'</td><td><button class="btn btn-danger btn-xs" title="'.$this->__($lng,"Eliminar").'" onclick="eliminaTornnec('.$tn["idtornnec"].');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
            }
            return $body;
        }catch(Exception $ex) {echo $ex->getMessage();}
    }

    public function calculaHoresTreballadesPerIdDia($id, $data) {
        // Metode capturant primer i últim registre del dia i després restant hores especials
        $hores = 0.0;
        $sumahores = 0.0;
        $n=0;
        $horamarc1 = "";
        $horamarc2 = "";
        $entrada = 0;
        $mcs = $this->getMarcatgesPerIdDiaTorn($id, $data);
        foreach($mcs as $mc) {

            if(($n==0)&&($mc->getEntsort()==1)) {}
            else {
                if($mc->getEntsort()==0){$horamarc1=$mc->getDatahora();$entrada=1;}
                else {$horamarc2=$mc->getDatahora();if($entrada==1) {$sumahores+=(((strtotime($horamarc2))-strtotime($horamarc1))/3600);$entrada=0;} }
            }
            $n++;

        }
        //Revisar per si de cas si hi havia torn de nit sense indicar o marcatge suelto de sortida sense aparellar al principi del dia següent (festiu treballat de nit)
        if($entrada==1){
            $dataseg = date('Y-m-d',strtotime($data.' + 1 days'));
            $mcex = $this->getPrimerMarcatgePerIdDia($id, $dataseg);
            foreach($mcex as $mx){ if($mx["entsort"]==1){$sumahores+=(((strtotime($mx["fitx"]))-strtotime($horamarc1))/3600);} }
        }

        $hores = $sumahores;

        $hdesc = $this->seleccionaHoresPausaPerIdDia($id, $data);
        if(($hores>0)) {$hores-=$hdesc;}//if($nummarc<=2)&&($hdesc<=2)&&
        return number_format($hores,2);
    }

    // CONSULTA PER MES
    public function calculaHoresTreballadesPerIdMes($id, $dataini) {
        // Metode capturant primer i últim registre del dia i després restant hores especials
        $arrhfeina = [];
        $hores = 0.0;
        $sumahores = 0.0;
        $n=0;
        $horamarc1 = "";
        $horamarc2 = "";
        $entrada = 0;
        $data1 = $dataini;
        $mcs = $this->getMarcatgesPerIdMesTorn($id, $dataini);
        $diesmes = 0;
        foreach($mcs as $mc) {

            if(($n==0)&&($mc->getEntsort()==1)) {}
            else {
                if($mc->getEntsort()==0){$horamarc1=$mc->getDatahora();$entrada=1;}
                else {$horamarc2=$mc->getDatahora();if($entrada==1) {$sumahores+=(((strtotime($horamarc2))-strtotime($horamarc1))/3600);$entrada=0;} }
            }
            $n++;
            if((strtotime($data1)<strtotime(date('Y-m-d',strtotime($mc->getDatahora()))))&&($entrada==0)){
                $arrhfeina[] = $sumahores;
                $sumahores = 0;
                $data1 = date('Y-m-d',strtotime($mc->getDatahora()));
                $diesmes++;
            }

        }

        $hores = $sumahores;

        $arrdates = $this->seleccionaHoresPausaPerIdMes($id, $dataini);
        for($d=1;$d<=$diesmes;$d++){
            $arrhfeina[$i]-=$arrdates[$i][3];
        }

        return $arrhfeina;
    }

    public function calculaMinutsTreballatsPerIdDia($id, $data) {
        // Metode capturant primer i últim registre del dia i després restant hores especials
        $hores = 0.0;
        $sumahores = 0.0;
        $n=0;
        $horamarc1 = "";
        $horamarc2 = "";
        $entrada = 0;
        $mcs = $this->getMarcatgesPerIdDiaTorn($id, $data);
        foreach($mcs as $mc) {

            if(($n==0)&&($mc->getEntsort()==1)) {}
            else {
                if($mc->getEntsort()==0){$horamarc1=$mc->getDatahora();$entrada=1;}
                else {$horamarc2=$mc->getDatahora();if($entrada==1) {$sumahores+=(((strtotime($horamarc2))-strtotime($horamarc1))/1);$entrada=0;} }
            }
            $n++;

        }
        //Revisar per si de cas si hi havia torn de nit sense indicar o marcatge suelto de sortida sense aparellar al principi del dia següent (festiu treballat de nit)
        if($entrada==1){
            $dataseg = date('Y-m-d',strtotime($data.' + 1 days'));
            $mcex = $this->getPrimerMarcatgePerIdDia($id, $dataseg);
            foreach($mcex as $mx){ if($mx["entsort"]==1){$sumahores+=(((strtotime($mx["fitx"]))-strtotime($horamarc1))/1);} } // 1 (sense fracció per a mantenir els segons) en lloc de 3600 (segons que té una hora)
        }

        $hores = $sumahores;

        $hdesc = $this->seleccionaHoresPausaPerIdDia($id, $data);
        if(($hores>0)) {$hores-=($hdesc*3600);}
        return $hores;
    }

    public function getMarcatgesPerIdDiaTorn($id,$data) {
        $dataant = date('Y-m-d',strtotime($data.' - 1 days'));
        $dataseg = date('Y-m-d',strtotime($data.' + 1 days'));
        $datahora0 = date('Y-m-d H:i:s',strtotime($data." 00:00:00"));
        //Buscar si el torn del dia anterior va ser bidata (hores nocturnes)
        $bidataant = $this->esTornBidata($id,$dataant);
        if($bidataant==1) {
            $idrotant = $this->terotacio($id,$dataant);
            if($idrotant>0) {$datahora0 = date('Y-m-d H:i:s',strtotime($data." ".$this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotant,"idtipustorn"),"horasortida")));}
            else {$tornant = $this->getTornPerIdDia($id, $dataant);
                if(!empty($tornant)) {$datahora0 = date('Y-m-d H:i:s',strtotime($data." ".$tornant->getHoraFi()));}
            }
        }
        $datahora1 = date('Y-m-d H:i:s',strtotime($data." 23:59:59"));
        $bidataact = $this->esTornBidata($id,$data);
        $datahoraini = "";
        $datahorafi = "";
        if($bidataact==1) {
            $idrotact = $this->terotacio($id,$data);
            if($idrotact>0) {
                $datahorafi = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotact,"idtipustorn"),"horasortida");
                $datahora1 = date('Y-m-d H:i:s',strtotime($dataseg." ".$datahorafi." + 1 hour"));
                $datahoraini = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotact,"idtipustorn"),"horaentrada");
            }
            else {$tornact = $this->getTornPerIdDia($id, $data);
                if(!empty($tornact)) {
                    $datahorafi = $tornact->getHoraFi();
                    $datahora1 = date('Y-m-d H:i:s',strtotime($dataseg." ".$datahorafi." + 1 hour"));
                    $datahoraini = $tornact->getHoraIni();
                }
            }

        }
        $marcatges = new ArrayObject();
        $marcat = "";
        //Buscar Marcatges d'entrada des de l'hora de sortida del torn anterior (si no hi ha torn de nit del dia anterior, llavors des de tot el dia actual) fins l'hora de sortida del torn actual
        //Buscar Marcatges de sortida des de l'hora d'entrada del torn actual fins l'hora d'entrada del torn següent (si no hi ha torn següent, tot el dia següent)
        //$sql = 'select datahora, idmarcatges, id_tipus, entsort from marcatges where id_emp like "'.$id.'" and (((datahora between "'.$datahora0.'" and "'.$datahorafi.'") and (entsort=0)) or ((datahora between "'.$datahoraini.'" and "'.$datahora1.'") and (entsort=1))) order by datahora';
        $sql = 'select datahora, idmarcatges, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and (datahora between "'.$datahora0.'" and "'.$datahora1.'") order by datahora';
        try{

            $rsmc = $this->getDb()->executarConsulta($sql);
            foreach($rsmc as $m){

                $marcat = new Marcatge($m["datahora"],$m["id_tipus"],$m["entsort"]);
                $marcatges->append($marcat);
            }
        }catch(PDOException $ex){echo $ex->getMessage();}

        return $marcatges;
    }

    // CONSULTA PER MES
    public function getMarcatgesPerIdMesTorn($id,$dataini) {
        $datahora0 = date('Y-m-d H:i:s',strtotime($dataini." 00:00:00"));
        $mes = date('m',strtotime($dataini));
        $any = date('Y',strtotime($dataini));
        $anyseg = $any;
        $messeg = $mes + 1;
        if($messeg>12){$messeg = 1; $anyseg = $any + 1;}
        $zmesseg = $messeg;
        if($messeg<10){$zmesseg = "0".$messeg;}
        $datahora1 = date('Y-m-d H:i:s',strtotime($anyseg."-".$zmesseg."-01 07:59:59"));//

        $marcatges = new ArrayObject();
        $marcat = "";
        //Buscar Marcatges d'entrada des de l'hora de sortida del torn anterior (si no hi ha torn de nit del dia anterior, llavors des de tot el dia actual) fins l'hora de sortida del torn actual
        //Buscar Marcatges de sortida des de l'hora d'entrada del torn actual fins l'hora d'entrada del torn següent (si no hi ha torn següent, tot el dia següent)
        //$sql = 'select datahora, idmarcatges, id_tipus, entsort from marcatges where id_emp like "'.$id.'" and (((datahora between "'.$datahora0.'" and "'.$datahorafi.'") and (entsort=0)) or ((datahora between "'.$datahoraini.'" and "'.$datahora1.'") and (entsort=1))) order by datahora';
        $sql = 'select datahora, idmarcatges, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and datahora between "'.$datahora0.'" and "'.$datahora1.'" order by datahora';
        try{
            //$sql = 'select datahora, idmarcatges, id_tipus, entsort from marcatges where id_emp like "'.$id.'" and date(datahora)="'.$data.'" order by datahora';
            $rsmc = $this->getDb()->executarConsulta($sql);
            foreach($rsmc as $m){
                //echo $m["datahora"].",".$m["id_tipus"].",".$m["entsort"];
                $marcat = new Marcatge($m["datahora"],$m["id_tipus"],$m["entsort"]);
                $marcatges->append($marcat);
            }
        }catch(PDOException $ex){echo $ex->getMessage();}
        //return $marcat;
        return $marcatges;
    }

    public function getPrimerMarcatgePerIdDia($id, $data) {
        $sql = 'select min(datahora) as fitx, idmarcatges as pmc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" limit 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getUltimMarcatgePerIdDia($id, $data) {
        $sql = 'select max(datahora) as fitx, idmarcatges as umc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" limit 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getPrimerMarcatgeEntradaPerIdDia($id, $data) {
        $sql = 'select min(datahora) as fitx, idmarcatges as pmc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and entsort=0 limit 1';
        return $this->getDb()->executarConsulta($sql);
    }



    public function getObservacionsPorEmpleadoYDia($id, $data) {
        $observacions = array();

        // Realiza la consulta en la base de datos para obtener las observaciones
        $sql = 'SELECT observacions FROM marcatges WHERE id_emp = "'.$id.'" AND DATE(datahora) = "'.$data.'"';
        $params = array(
            'id' => $id,
            'data' => $data
        );
        $result = $this->getDb()->executarConsulta($sql, $params);

        // Recorre los resultados y almacena las observaciones en el array
        foreach ($result as $row) {
            $observacions[] = $row['observacions'];
        }

        return $observacions;
    }



    public function getPrimerMarcatgeSortidaPerIdDia($id, $data) {
        $sql = 'select min(datahora) as fitx, idmarcatges as pmc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and entsort=1 limit 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getUltimMarcatgePerIdEmpleat($idemp, $camp)
    {
        $entsort = "";

        $rs = $this->getDb()->executarConsulta('select ' . $camp . ' from marcatges where datareg = (select max(datareg) from marcatges WHERE id_emp = "' . $idemp . '") limit 1');

        foreach ($rs as $r)
            $entsort = $r[$camp];

        return $entsort;
    }

    public function getUltimMarcatgeEntradaPerIdDia($id, $data) {
        $sql = 'select max(datahora) as fitx, idmarcatges as umc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and entsort=0 limit 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getUltimMarcatgeSortidaPerIdDia($id, $data) {
        $sql = 'select max(datahora) as fitx, idmarcatges as umc, id_tipus, entsort, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and entsort=1 limit 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function getMarcatgeParella($id, $data, $idmarc) {
        $hora = substr($this->getCampPerIdCampTaula("marcatges",$idmarc,"datahora"),11,5);
        $sql = 'select min(datahora) as fitx, id_tipus, entsort, idmarcatges as pmc, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and hour(datahora)>"'.$hora.'" limit 1';//.' order by idmarcatges limit 1'
        return $this->getDb()->executarConsulta($sql);
    }

    public function getObservacionesPerDia($id, $data) {
        $sql = 'SELECT observacions
                FROM marcatges
                WHERE id_emp = :id_empleado
                  AND DATE(datahora) = :fecha
                  AND entsort = 0
                ORDER BY datahora ASC
                LIMIT 1';

        $params = array(
            ':id_empleado' => $id,
            ':fecha' => $data
        );

        $pdo = new PDO('mysql:host=localhost;dbname=frapont_cp', 'proyectos', '4lzCw66_');
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }








    public function getMarcatgeParella2($id, $data, $idmarc) {

        $data1 = date('Y-m-d H:i:s',strtotime($this->getCampPerIdCampTaula("marcatges",$idmarc,"datahora")));
        $data2 = date('Y-m-d H:i:s',strtotime($data1." + 1 days"));
        $sqlhour = "";
        if((strtotime(date('Y-m-d',strtotime($data1))))==(strtotime(date('Y-m-d',strtotime($data2))))) $sqlhour = 'and time(datahora)>"'.date('H:i:s',strtotime($data1)).'"';
        $sql = 'select min(datahora) as fitx, id_tipus, entsort, idmarcatges as pmc, observacions as obs from marcatges where idmarcatges<>'.$idmarc.' '.$sqlhour.' and id_emp like "'.$id.'" and datahora between "'.$data1.'" and "'.$data2.'"';//.' order by idmarcatges limit 1' and hour(datahora)>"'.$hora.'"
        return $this->getDb()->executarConsulta($sql);
    }

    public function getMarcatgeParellaInvers($id, $data, $idmarc) {
        $hora = substr($this->getCampPerIdCampTaula("marcatges",$idmarc,"datahora"),11,5);
        $sql = 'select max(datahora) as fitx, id_tipus, entsort, idmarcatges as pmc, observacions as obs from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'" and idmarcatges<>'.$idmarc.' and entsort=0';
        return $this->getDb()->executarConsulta($sql);
    }


    public function esTornBidata($id,$data){
        $bidata = 0;
        $torn = $this->getTornPerIdDia($id, $data);
        $idrotacio = $this->terotacio($id, $data);
        if(!empty($idrotacio)){
            $horaini = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotacio,"idtipustorn"),"horaentrada");
            $horafi = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotacio,"idtipustorn"),"horasortida");
            if(strtotime($horaini)>strtotime($horafi)) {$bidata = 1;}
        }
        else if(!empty($torn)){
            $horaini = $torn->getHoraini();
            $horafi = $torn->getHorafi();
            if(strtotime($horaini)>strtotime($horafi)) {$bidata = 1;}
        }
        return $bidata;
    }

    public function getFestiuPerEmpresaDia($idempresa,$data){
        $festiu = "";
        $any = abs(date("Y",strtotime($data)));
        $mes = abs(date("m",strtotime($data)));
        $dia = abs(date("d",strtotime($data)));
        $rs = $this->getDb()->executarConsulta('SELECT distinct f.dia, f.mes, f.descripcio as festa, l.nom as lloc FROM festiu as f join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio where l.idempresa like "'.$idempresa.'" and ((year(f.dataany) like "'.$any.'")or(f.anual like 1)) and (((f.dataany) like "'.$data.'")or((f.anual like 1)and(f.mes like "'.$mes.'")and(f.dia like "'.$dia.'")))');
        foreach($rs as $f) {$festiu.= "&NewLine;".$f["lloc"]." (".$f["festa"].")";}
        return $festiu;
    }

    public function esFestiuPerIdDia($id, $data) {
        $any = abs(date("Y",strtotime($data)));
        $mes = abs(date("m",strtotime($data)));
        $dia = abs(date("d",strtotime($data)));

        $sql = 'SELECT distinct f.dia, f.mes, f.descripcio, l.nom 
            FROM festiu as f 
                join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio 
                join situat as s on s.idlocalitzacio = l.idlocalitzacio 
                join empleat as e on e.idEmpleat = s.idempleat 
                join empresa as em on em.idempresa=e.idempresa 
            where e.idEmpleat like "'.$id.'" and ((year(f.dataany) like "'.$any.'")or(f.anual like 1)) and ((year(s.datainici)<="'.$any.'")and((year(s.datafi)>="'.$any.'")or(s.datafi IS NULL))) and ((((month(s.datainici)<=f.mes)||(month(s.datainici)<=month(f.dataany)))and((year(s.datainici)="'.$any.'"))||(year(s.datainici)<"'.$any.'"))) and (((f.dataany) like "'.$data.'")or((f.anual like 1)and(f.mes like "'.$mes.'")and(f.dia like "'.$dia.'"))) and (((((month(s.datafi)>=f.mes)||(month(s.datafi)>=month(f.dataany)))and((year(s.datafi)="'.$any.'"))||(year(s.datafi)>"'.$any.'")))||(s.datafi IS NULL))';// and em.prifestius=1
        return $this->getDb()->executarConsulta($sql);
    }

    public function getDiesFestiusMesPerId($id, $mes, $any) {
        $sql = 'SELECT distinct f.dia as dia FROM festiu as f join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio join situat as s on s.idlocalitzacio = l.idlocalitzacio join empleat as e on e.idEmpleat = s.idempleat join empresa as em on em.idempresa=e.idempresa where e.idEmpleat like "'.$id.'" and ((year(f.dataany) like "'.$any.'")or(f.anual like 1)) and ((year(s.datainici)<="'.$any.'")and((year(s.datafi)>="'.$any.'")or(s.datafi IS NULL))) and ((((month(s.datainici)<=f.mes)||(month(s.datainici)<=month(f.dataany)))and((year(s.datainici)="'.$any.'"))||(year(s.datainici)<"'.$any.'"))) and (((((month(s.datafi)>=f.mes)||(month(s.datafi)>=month(f.dataany)))and((year(s.datafi)="'.$any.'"))||(year(s.datafi)>"'.$any.'")))||(s.datafi IS NULL))';// and em.prifestius=1
        return $this->getDb()->executarConsulta($sql);
    }

    public function getTornPerIdDia($id, $data) {
        $sql = 'select * from torn as t join horaris as h on h.idhoraris = t.idhorari join quadrant as q on q.idhorari = h.idhoraris join empleat as e on q.idempleat = e.idempleat where e.idempleat like "'.$id.'" and t.diasetmana like (weekday("'.$data.'")+1) and ((DATE("'.$data.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$data.'")>=q.datainici)and(q.datafi IS NULL)))';
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $t) {
            $torn = new Torn($t["diasetmana"],$t["horaentrada"],$t["horasortida"],$t["horestreball"],$t["horespausa"],$t["marcautomatic"],$t["marcabans"],$t["laborable"]);
            return $torn;
        }
    }

    public function calculaHoresActivitatsPerIdDiaIdtipusInici($id, $data, $hora) {
        $hores = 0;
        $horai = "";
        $bidata = $this->esTornBidata($id, $data);
        try{
            if($bidata==0){
                $idrot = $this->terotacio($id,$data);
                if($idrot>0){
                    $horai = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horaentrada");
                }
                else {
                    $torn = $this->getTornPerIdDia($id, $data);
                    if(!empty($torn)) {$horai = $torn->getHoraini();}
                }
            }
            $horafinal = strtotime($hora);
            $horainici = strtotime($horai);
            $hores = number_format((float)(($horafinal-$horainici)/3600),2);
            return $hores;
        }catch(Exception $ex){echo $ex->getMessage();}
    }

    public function calculaHoresActivitatsPerInterval($hora1, $hora2) {
        $hores = 0;
        $horafinal = strtotime($hora2);
        $horainici = strtotime($hora1);
        $hores = number_format((float)(($horafinal-$horainici)/3600),2);
        return $hores;
    }

    public function calculaHoresActivitatsPerIdDiaIdtipusFinal($id, $data, $hora) {
        $hores = 0;
        $horaf = "";
        try{
            $idrot = $this->terotacio($id,$data);
            if($idrot>0){
                $horaf = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horasortida");
            }
            else {
                $torn = $this->getTornPerIdDia($id, $data);
                if(!empty($torn)) {$horaf = $torn->getHorafi();}
            }
            $horafinal = strtotime($horaf);
            $horainici = strtotime($hora);
            $hores = number_format((float)(($horafinal-$horainici)/3600),2);
            return $hores;
        }catch(Exception $ex){echo $ex->getMessage();}
    }











    public function seleccionaHoresTeoriquesPerIdDia($id, $data) {

        $teoriques = 0.0;

        if ((empty($this->esFestiuPerIdDia($id, $data))&&(empty($this->esExcepcioPerIdDia($id, $data)))))    {


            $hores = 0.0;
            $idrotacio = $this->terotacio($id,$data);


            if(!empty($idrotacio)) {
                $hores = $this->getCampPerIdCampTaula('tipustorn',$this->getCampPerIdCampTaula('rotacio',$idrotacio,'idtipustorn'),'horestreball');
            }
            else {
                $sql = 'select t.horestreball from torn as t join horaris as h on h.idhoraris = t.idhorari join quadrant as q on q.idhorari = h.idhoraris join empleat as e on q.idempleat = e.idempleat where e.idempleat like "'.$id.'" and t.diasetmana like (weekday("'.$data.'")+1) and ((DATE("'.$data.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$data.'")>=q.datainici)and(q.datafi IS NULL)))';
                $rs = $this->getDb()->executarConsulta($sql);
                foreach ($rs as $valor) {
                    $hores = $valor["horestreball"];
                }
            }

            $teoriques = number_format($hores,2);
        }

        return $teoriques;
    }

    public function treballaria($id, $data) {
        $bool = false;
        $teoriques = 0;
        $sql = 'select t.horestreball 
        from torn as t 
        join horaris as h on h.idhoraris = t.idhorari 
        join quadrant as q on q.idhorari = h.idhoraris 
        join empleat as e on q.idempleat = e.idempleat 
        where e.idempleat like "'.$id.'" and t.diasetmana like (weekday("'.$data.'")+1) and ((DATE("'.$data.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$data.'")>=q.datainici)and(q.datafi IS NULL)))';
        $rs = $this->getDb()->executarConsulta($sql);
        $hores = "";
        foreach ($rs as $valor)
        {
            $hores = $valor["horestreball"];
            $teoriques = number_format((float)$hores,2);
            if($teoriques>0) $bool=true;
        }
        return $bool;
    }

    public function terotacio($id,$data){
        $tt=0;
        $rst = $this->getDb()->executarConsulta('select * from rotacio where idempleat='.$id.' and data=DATE("'.$data.'")');
        foreach($rst as $t) $tt=$t["idrotacio"];
        return $tt;
    }

    public function tetorn($id,$data){
        $b=false;
        $rst = $this->getDb()->executarConsulta('select * from empleat where idempleat='.$id.' and idhorari1 is not null');
        if(!empty($rst)) $b=true;
        return $b;
    }

    public function seleccionaTipusMarcatges() {
        $sql = 'SELECT * FROM tipusmarcatge';
        return $this->getDb()->executarConsulta($sql);
    }

    public function assignaHorariEmpPerPlantilla($id, $idhorari, $datainici, $datafi) {
        $actiu = 1;
        if ($datafi!="")
        {
            if(strtotime($datafi)<strtotime('today UTC+1'))$actiu= 0;
            $sql = 'INSERT INTO quadrant (idempleat, idhorari, datainici, datafi, actiu) VALUES ('.$id.', '.$idhorari.', "'.$datainici.'", "'.$datafi.'", '.$actiu.')';
        }
        else $sql = 'INSERT INTO quadrant (idempleat, idhorari, datainici, actiu) VALUES ('.$id.', '.$idhorari.', "'.$datainici.'", '.$actiu.')';
        return $this->getDb()->executarSentencia($sql);
    }

    public function seleccionaTipusHoraris($idempresa) {
        $sql = 'SELECT * FROM horaris where idempresa="'.$idempresa.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaFestiusEmpPerIdAny($id, $any) {
        $sql = 'SELECT distinct dia, mes, descripcio, l.nom FROM festiu as f join localitzacio as l on f.idlocalitzacio = l.idlocalitzacio join situat as s on s.idlocalitzacio = l.idlocalitzacio join empleat as e on e.idempleat = s.idempleat where e.idempleat like "'.$id.'" and ((year(f.dataany) like "'.$any.'")or(f.anual like 1)) and ((year(s.datainici)<="'.$any.'")and((year(s.datafi)>="'.$any.'")or(s.datafi IS NULL))) and ((((month(s.datainici)<=f.mes)||(month(s.datainici)<=month(f.dataany)))and((year(s.datainici)="'.$any.'"))||(year(s.datainici)<"'.$any.'"))) and (((((month(s.datafi)>=f.mes)||(month(s.datafi)>=month(f.dataany)))and((year(s.datafi)="'.$any.'"))||(year(s.datafi)>"'.$any.'")))||(s.datafi IS NULL)) order by mes, dia';
        return $this->getDb()->executarConsulta($sql);
    }

    // LOGIN SERVICE
    public function validaCredencials($user, $pwd) {
        $sql = 'SELECT idempleat, cognom1, cognom2, nom, idempresa, isEncargado FROM empleat where ((user like "'.$user.'")or(dni like "'.$user.'")) and contrasenya like "'.$pwd.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function validaIniEmpresa($user, $pwd) {
        $sql = 'SELECT * FROM empresa where usuari_inici like "'.$user.'" and contrasenya_inici like "'.$pwd.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function validaIniUsuari($user, $pwd) {
        $sql = 'SELECT * FROM usuari where user like "'.$user.'" and pwd like "'.$pwd.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function esAdmin($id) {
        $sql = 'SELECT * FROM assignat join rol as r on r.idrol = assignat.id_rol where id_emp like '.$id.' and r.esadmin like 1';
        if(!empty($this->getDb()->executarConsulta($sql))) return true;
        else return false;
    }

    public function esMaster($id) {
        $sql = 'SELECT * FROM assignat join rol as r on r.idrol = assignat.id_rol where id_emp like '.$id.' and r.esmaster like 1';
        if(!empty($this->getDb()->executarConsulta($sql))) return true;
        else return false;
    }

    public function esEmpleat($id) {
        $sql = 'SELECT * FROM assignat join rol as r on r.idrol = assignat.id_rol where id_emp like '.$id.' and r.esempleat like 1';
        if(!empty($this->getDb()->executarConsulta($sql))) return true;
        else return false;
    }



    public function esEncargado($id) {
        $sql = 'SELECT * FROM empleat WHERE idempleat = '.$id.' AND isEncargado = 1';
        if(!empty($this->getDb()->executarConsulta($sql))) return true;
        else return false;
    }



    public function esSupervisor($id) {
        $super = 0;
        $rsrol = $this->getDb()->executarConsulta('select id_rol from assignat where id_emp='.$id.' and actiu=1');
        foreach($rsrol as $rl) {if($rl["id_rol"]==13) $super = 1;}
        return $super;
    }

    public function chkExisteixValor($valor,$camp,$taula)
    {
        $res = false;
        $rs = $this->getDb()->executarConsulta('select * from '.$taula.' where '.$camp.' like "'.$valor.'"');
        if(!empty($rs)) $res = true;
        return $res;
    }

    public function navResolver() {
        try{
            if(isset($_SESSION["master"])) include './Pantalles/NavBarMaster.html';
            else if(isset($_SESSION["admin"])) include './Pantalles/NavBarAdmin.html';
            else if (isset($_SESSION["username"])) include './Pantalles/NavBarUser.html';
            else include './Pantalles/NavBarIndex.html';
        }catch(Exception $ex) {echo $ex->getMessage();}
    }

    public function seleccionaTotesUbicacionsEmpPerId($id) {
        $sql = 'select s.idsituat, l.idlocalitzacio, l.nom, s.datainici, s.datafi from localitzacio as l join situat as s on s.idlocalitzacio = l.idlocalitzacio join empleat as e on e.idempleat = s.idempleat where e.idempleat like "'.$id.'" order by l.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaUbicacionsEmpPerIdDia($id,$data) {
        $sql = 'select l.nom, s.idlocalitzacio, s.datainici, s.datafi from localitzacio as l join situat as s on s.idlocalitzacio = l.idlocalitzacio join empleat as e on e.idempleat = s.idempleat where e.idempleat like "'.$id.'" and s.datainici <= DATE("'.$data.'") and ((s.datafi>=DATE("'.$data.'"))||(s.datafi IS NULL)) order by l.nom';
        return $this->getDb()->executarConsulta($sql);
    }


    public function imprimeixMesPerIdAnyMes($id, $any, $mes, $percent, $lng) {
        try{
            $diesbaixa = 0;
            $diesvacances = 0;
            $diespermis = 0;
            $diasvisitamedica = 0;
            $diespersonals = 0;
            $diasvisitamedica = 0;
            $diashospitalizacion = 0;
            $diascambiodomicilio= 0;
            $diasdeberinexcusable = 0;
            $diaspermisonoretribuido = 0;
            $diasmaternidadpaternidad = 0;
            $diasdefuncion = 0;
            $diesespecials = array_fill(0,11,0);
            echo '<section class="" style="width:'.'22'.'%; float:left"><center><label>'.$this->__($lng,$this->mostraNomMes($mes));

            echo '</label><table class="table-bordered table-condensed table-hover">';
            echo '<thead>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DL").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DM").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DC").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DJ").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DV").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DS").'</th>'
                . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DG").'</th>'
                . '</thead><tbody style="background-color: rgba(255, 255, 255, 0.1);">';
            $idempresa = $this->getCampPerIdCampTaula("empleat",$id,"idempresa");
            $diesnat = $this->getCampPerIdCampTaula("empresa",$idempresa,"comptadiesnatvac");
            $prifestius = $this->getCampPerIdCampTaula("empresa",$idempresa,"prifestius");
            $marcafestius = $this->getCampPerIdCampTaula("empresa",$idempresa,"marcafestius");
            $dia = new DateTime();
            $dia->setISODate($any,0);
            $undiames = new DateInterval('P1D');
            while($dia->format('Y')<$any)$dia->add($undiames);
            while($dia->format('m')<$mes)$dia->add($undiames);
            for($j=1;(($j<=6)&&($dia->format('m')==$mes));$j++)
            {
                echo '<tr>';
                for($i=0;$i<=6;$i++)
                {
                    if(($j==1)&&(date('w',strtotime($dia->format('Y-m-d')))==0)&&($i<6)) echo '<td></td>';
                    else if(($j==1)&&(date('w',strtotime($dia->format('Y-m-d')))>$i+1)) echo '<td></td>';
                    else
                    {
                        if(($dia->format('m')==$mes))
                        {
                            $numexcep = 0;
                            $esbaixa = false;
                            $title = "";
                            $style = "";
                            $onclick = "";



                            if (isset($_GET["tipusexcep"])) {
                                $tipusexcep = $_GET["tipusexcep"];



                                $rs = $this->esBaixaPerIdDia($id, $dia->format('Y-m-d'), $tipusexcep);
                                if(!empty($rs)) {$esbaixa = true; $diesbaixa++;
                                    foreach($rs as $excep){$onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';}
                                }  }
                            $festiu = $this->esFestiuPerIdDia($id, $dia->format('Y-m-d'));
                            $tipus = "";
                            $excepcio = $this->esExcepcioPerIdDia($id, $dia->format('Y-m-d'));
                            foreach($excepcio as $excep)
                            {
                                if($numexcep>0)$tipus .= ", ".$excep["nom"];
                                else
                                {
                                    $tipus = $excep["nom"];
                                    $inicial = substr($tipus,0,3);
                                }
                                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                                $numexcep++;
                            }
                            $idrotacio = $this->terotacio($id, $dia->format('Y-m-d'));
                            if($esbaixa) {
                                $title = 'title="'.$this->__($lng,"Baixa").'"';
                                $style = 'style="background-color: rgb(255,128,128); cursor: pointer"';}
                            else if((!empty($festiu))&&($prifestius==1)) {
                                foreach($festiu as $festa) {
                                    $title = 'title="'.$festa["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$festa["nom"].')"';
                                    $style = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';
                                    $onclick = 'onclick="mostraCreaRotacioDia('.$id.",'".$dia->format('Y-m-d')."',".');"';}}
                            else if((!$this->treballaria($id, $dia->format('Y-m-d')))&&(empty($idrotacio))&&((empty($excepcio)||($diesnat==0)))) {
                                $title = 'title="'.$this->__($lng,"No laborable").'"';
                                $style = 'style="background-color: rgb(128,128,128); color: white; cursor: pointer"';
                                $onclick = 'onclick="mostraCreaRotacioDia('.$id.",'".$dia->format('Y-m-d')."',".');"';}
                            else if(!empty($this->esExcepcioPerIdDia($id, $dia->format('Y-m-d'))))
                            {
                                if($numexcep>1) {
                                    $title = 'title="'.$this->__($lng,"Solapament de Períodes").': '.$tipus.'"';
                                    $style = 'style="background-color: rgb(128,0,0); color: yellow; cursor: pointer"';}
                                else {
                                    if($tipus=="Vacaciones")
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(128,255,255); cursor: pointer"';
                                        $diesvacances++;}
                                    else if(($inicial=="Per")||($inicial=="Exc")||($inicial=="Abs"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(128,255,128); cursor: pointer"';
                                        $diespermis++;}
                                    else if(($inicial=="Asu")||($inicial=="Mal"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(255,255,128); cursor: pointer"';
                                        $diespersonals++;}



                                    else if(($inicial=="Vis"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(230,51,255); cursor: pointer"';
                                        $diasvisitamedica++;}

                                    else if(($inicial=="Hos"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(227,134,16); cursor: pointer"';
                                        $diashospitalizacion++;}

                                    else if(($inicial=="Cam"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(218,247,166); cursor: pointer"';
                                        $diascambiodomicilio++;}

                                    else if(($inicial=="Deb"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(66,183,227); cursor: pointer"';
                                        $diasdeberinexcusable++;}

                                    else if(($inicial=="No "))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(227,66,161); cursor: pointer"';
                                        $diaspermisonoretribuido++;}

                                    else if(($inicial=="Mat"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(66,227,198); cursor: pointer"';
                                        $diasmaternidadpaternidad++;}

                                    else if(($inicial=="Def"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(222,188,70); cursor: pointer"';
                                        $diasdefuncion++;}

                                    else if(($inicial=="Baj"))
                                    {$title = 'title="'.$this->__($lng,$tipus).'"';
                                        $style = 'style="background-color: rgb(222,128,128); cursor: pointer"';
                                        $diasdefuncion++;}

                                }
                            }
                            else if(!empty($idrotacio)) {
                                $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrotacio,"idtipustorn");
                                $rst = $this->getDb()->executarConsulta('select * from tipustorn where idtipustorn='.$idtipustorn);
                                foreach($rst as $t) {
                                    $title = 'title="'.$this->__($lng,"Torn").': '.$t["nom"].'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($t["horaentrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($t["horasortida"])).'&#10;'.$this->__($lng,"Hores").': '.$t["horestreball"].'"';
                                    $bckg = $t["colorbckg"];
                                    $color = $t["colortxt"];
                                    $abr = $t["abrv"];
                                    $style = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                    $onclick = 'onclick="mostraEditaRotacioDia('.$idrotacio.');"';
                                }
                            }
                            else {

                                $bckg = "";
                                $color = "";
                                $abr = "";
                                $title = 'title="'.$this->__($lng,"Horari").': '.$this->seleccionaTipusHorariPerIdDia($id,$dia->format('Y-m-d'),$lng).'"';
                                $style = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                $onclick = 'onclick="mostraCreaRotacioDia('.$id.",'".$dia->format('Y-m-d')."',".');"';
                            }
                            //--- Condició extra per a què si és festiu però no prioritari sobre els horaris, es pinti i descrigui igualment, però afegint la info del torn o periode especial
                            if((!empty($festiu))&&($prifestius==0)&&($marcafestius==1)) {
                                foreach($festiu as $festa) {
                                    $len = strlen($title)-7;
                                    $title2 = substr($title,7,($len));
                                    $title = 'title="'.$festa["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$festa["nom"].')&#10;'.$title2.'"';
                                    $style = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';}
                            }
                            echo '<td '.$title.' '.$style.' '.$onclick.'>'.abs($dia->format('d')).'</td>';
                        }
                        $dia->add($undiames);
                    }
                }
                echo '</tr>';
            }
            echo '</tbody>';

            echo '</table></center></section>';

            if ($percent==100) echo '<div class="row"></div>';
            $diesespecials[0]=$diesbaixa;
            $diesespecials[1]=$diesvacances;
            $diesespecials[2]=$diespermis;
            $diesespecials[3]=$diespersonals;
            $diesespecials[4]=$diasvisitamedica;
            $diesespecials[5]=$diashospitalizacion;
            $diesespecials[6]=$diascambiodomicilio;
            $diesespecials[7]=$diasdeberinexcusable;
            $diesespecials[8]=$diaspermisonoretribuido;
            $diesespecials[9]=$diasmaternidadpaternidad;
            $diesespecials[10]=$diasdefuncion;




            return $diesespecials;

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }


    public function seleccionaTipusHorariPerIdDia($id,$data,$lng) {
        $sql = 'select h.nom, t.horaentrada, t.horasortida, t.horestreball 
                from torn as t join horaris as h on h.idhoraris = t.idhorari 
                    join quadrant as q on q.idhorari = h.idhoraris 
                    join empleat as e on q.idempleat = e.idempleat 
                where e.idempleat like "'.$id.'" and t.diasetmana like (weekday("'.$data.'")+1) and ((DATE("'.$data.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$data.'")>=q.datainici)and(q.datafi IS NULL)))';
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $torn) return $torn["nom"].'.'
            . '&#10;'.$this->__($lng,"Entrada").': '.substr($torn["horaentrada"],0,5)
            . '&#10;'.$this->__($lng,"Sortida").': '.substr($torn["horasortida"],0,5)
            . '&#10;'.$this->__($lng,"Hores").': '.$torn["horestreball"];
    }

    public function seleccionaTipusTornPerIdDia($id,$dia,$lng) {
        $idtipustorn = $this->getCampPerIdCampTaula("empleat",$id,"idhorari1");
        $rst = $this->getDb()->executarConsulta('select * from tipustorn where idtipustorn='.$idtipustorn);
        foreach($rst as $t) {
            $title=$this->__($lng,"Torn").': '.$t["nom"].'<br>'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($t["horaentrada"])).'<br>'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($t["horasortida"])).'<br>'.$this->__($lng,"Hores").': '.$t["horestreball"];
            $bckg = $t["colorbckg"];
            $color = $t["colortxt"];
            $abr = $t["abrv"];
        }
        echo '<td title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.';">'.$abr.'</td>';
    }

    public function seleccionaTipusExcepcions() {
        $sql = 'select * from tipusexcep where global = 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEncargadosDep($EmpleadoID) {
        $sql = 'SELECT e.idempleat, e.nom, e.cognom1
        FROM empleat AS e
        JOIN pertany AS p ON p.id_emp = e.idempleat
        WHERE p.actiu = 1 AND e.isEncargado = 1
        ';
        return $this->getDb()->executarConsulta($sql);
    }



    public function seleccionaTotsTipusExcepcions() {
        $sql = 'select * from tipusexcep';
        return $this->getDb()->executarConsulta($sql);
    }




    public function assignaExcepcio($id, $idtipusexcep, $datainici, $datafi) {

        $sql = 'INSERT INTO excepcio (idempleat, idtipusexcep, datainici, datafinal) VALUES ('.$id.', '.$idtipusexcep.', "'.$datainici.'", "'.$datafi.'")';

        return $this->getDb()->executarSentencia($sql);




    }



    public function UpdateStateSolicExcepcion($id, $Obs, $Type,$utm_x,$utm_y) {

        $obsDecode =urldecode($Obs);
        $sql = 'UPDATE excepcio  SET aprobada ='.$Type.' , observacions ="'.$obsDecode.'", dataaprovacio = current_date() WHERE idexcepcio ='.$id;

        $this->getDb()->executarSentencia($sql);

        $idempleat = $this->getCampPerIdCampTaula("excepcio",$id,"idempleat");

        if ( $Type == '1' ) {

            $idtipustorn = $this->getCampPerIdCampTaula("excepcio",$id,"idtipusexcep");

            $isHoraelec = $this->getCampPerIdCampTaula("tipusexcep",$idtipustorn,"HorElectiv");

            if ($isHoraelec) {

                $Dateini = strtotime($this->getCampPerIdCampTaula("excepcio",$id,"datainici"));
                $DateEnd = strtotime($this->getCampPerIdCampTaula("excepcio",$id,"datafinal"));

                $ipaddress = '';
                if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
                else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                else if(getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
                else if(getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
                else if(getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
                else if(getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
                else $ipaddress = 'UNKNOWN';
                $ip=$_SERVER['REMOTE_ADDR'];
                $arrloc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

                $tipos =  $this->mostraTipusActivitats();
                $idTipoNormal= "";
                foreach($tipos as $rs){
                    if ("Normal"==$rs["nom"]) {
                        $idTipoNormal = $rs["idtipusactivitat"];
                        break;
                    }
                }

                $idempresa = $this->getCampPerIdCampTaula("empleat",$idempleat,"idempresa");

                for($i=$Dateini; $i<=$DateEnd; $i+=86400){

                    $dia = date("Y-m-d", $i);;

                    $festiu = $this->esFestiuPerIdDia($idempleat, $dia);
                    $excepcio = $this->esExcepcioPerIdDia($idempleat, $dia);
                    $idrotacio = $this->terotacio($idempleat, $dia);

                    if((!empty($festiu))) {
                        continue;}
                    else if((!$this->treballaria($idempleat, $dia))&&(empty($idrotacio))&&((empty($excepcio)||($diesnat==0)))) {
                        continue;}
                    else if(!empty($idrotacio)) {
                        $idtipustorn = $this->getCampPerIdCampTaula("rotacio",$idrotacio,"idtipustorn");
                        $rst = $this->getDb()->executarConsulta('select * from tipustorn where idtipustorn='.$idtipustorn);
                        foreach($rst as $t) {
                            $buffTextEntrada=  $dia.' '.$t["horaentrada"];
                            $buffTextSalida=  $dia.' '.$t["horasortida"];
                            $Horentrada = strtotime($buffTextEntrada);
                            $HoraSalida = strtotime($buffTextSalida);
                        }
                    }
                    else {
                        $sql = 'select h.nom, t.horaentrada, t.horasortida, t.horestreball from torn as t join horaris as h on h.idhoraris = t.idhorari join quadrant as q on q.idhorari = h.idhoraris join empleat as e on q.idempleat = e.idempleat where e.idempleat like "'.$idempleat.'" and t.diasetmana like (weekday("'.$dia.'")+1) and ((DATE("'.$dia.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$dia.'")>=q.datainici)and(q.datafi IS NULL)))';
                        $rs = $this->getDb()->executarConsulta($sql);
                        foreach($rs as $torn){
                            $buffTextEntrada=  $dia.' '.$torn["horaentrada"];
                            $buffTextSalida=  $dia.' '.$torn["horasortida"];
                            $Horentrada = strtotime($buffTextEntrada);
                            $HoraSalida = strtotime($buffTextSalida);
                            break;
                        }
                    }


                    $data = date('Y-m-d',$Horentrada);
                    $hora = intval(date('H',$Horentrada));
                    $dataahir = date('Y-m-d H:i',$Horentrada-86400);

                    if(
                        ($this->getCampPerIdCampTaula("empresa",$idempresa,"noregmarcsensehorari")==1)
                        &&
                        ($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $data)==0)
                        &&
                        (
                            ($this->esTornBidata($idempleat, $dataahir)==0)
                            ||
                            (($this->esTornBidata($idempleat, $dataahir)==1)&&($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)==0))
                            ||
                            (($this->esTornBidata($idempleat, $dataahir)==1)&&($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)>0)&&($hora>7))
                        )

                    )
                    {

                    }
                    else{

                        $this->insereixMarcatgeComplet($idempleat,$idTipoNormal,1,date('Y-m-d H:i',$Horentrada),$ipaddress,$utm_x,$utm_y,$arrloc['geoplugin_city'],$arrloc['geoplugin_region'],$arrloc['geoplugin_country']);

                    }

                    if (intval(date('H',$Horentrada)) > intval(date('H',$HoraSalida))) {
                        $HoraSalida = $HoraSalida + 86400;
                    }

                    $data = date('Y-m-d',$HoraSalida);
                    $hora = intval(date('H',$HoraSalida));
                    $dataahir = date('Y-m-d H:i',$HoraSalida-86400);


                    if(
                        ($this->getCampPerIdCampTaula("empresa",$idempresa,"noregmarcsensehorari")==1)
                        &&
                        ($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $data)==0)
                        &&
                        (
                            ($this->esTornBidata($idempleat, $dataahir)==0)
                            ||
                            (($this->esTornBidata($idempleat, $dataahir)==1)&&($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)==0))
                            ||
                            (($this->esTornBidata($idempleat, $dataahir)==1)&&($this->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)>0)&&($hora>7))
                        )

                    )
                    {

                    }
                    else{

                        $this->insereixMarcatgeComplet($idempleat,$idTipoNormal,0,date('Y-m-d H:i',$HoraSalida),$ipaddress,$utm_x,$utm_y,$arrloc['geoplugin_city'],$arrloc['geoplugin_region'],$arrloc['geoplugin_country']);

                    }


                }

            }


        }

        $email = $this->getCampPerIdCampTaula("empleat",$idempleat,"email");

        if ($email != ''){

            session_start();

            $lng = $_SESSION["ididioma"];

            if ($Type == '1') {
                $SOLICTSTATE = "ACEPTADA";
            }else {
                $SOLICTSTATE = "DENEGADA";
            }

            $emmpleatFullname = $this->getCampPerIdCampTaula("empleat",$idempleat,"nom")
                ." ".$this->getCampPerIdCampTaula("empleat",$idempleat,"cognom1")
                ." ".$this->getCampPerIdCampTaula("empleat",$idempleat,"cognom2");

            $ASUNT = $SOLICTSTATE." petición de ".$emmpleatFullname." en el portal del empleado.";

            ob_start();
            include 'PHPMailer/RespExcepMSJ.html';
            $MSJ = ob_get_contents();
            ob_end_clean();

            $MSJ = str_replace("%EMPLEATNAME%", $emmpleatFullname , $MSJ);

            $MSJ = str_replace("%EXECPTTYPE%",  $this->__($lng,$this->getCampPerIdCampTaula("tipusexcep",$this->getCampPerIdCampTaula("excepcio",$id,"idtipusexcep"),"nom")) , $MSJ);

            $MSJ = str_replace("%DATEINI%", $this->getCampPerIdCampTaula("excepcio",$id,"datainici") , $MSJ);
            $MSJ = str_replace("%DATEEND%", $this->getCampPerIdCampTaula("excepcio",$id,"datafinal") , $MSJ);
            $MSJ = str_replace("%SOLICTSTATE%", $SOLICTSTATE , $MSJ);

            $this->SendEMAILV1($ASUNT,$MSJ,$email);
        }


        return ;
    }


    public function SendEMAILV1($ASUNT,$MSJ,$EMAIL)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username = 'permisos.frapont@gmail.com'; // Reemplaza esto con tu dirección de correo de Gmail
            $mail->Password = 'rzgqnymkkcouxcfg'; // Reemplaza esto con tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;
            //Recipients
            $mail->setFrom('permisos.frapont@gmail.com', 'Ausencias y Vacaciones');

            $mail->addAddress($EMAIL);               //Name is optional

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $ASUNT;
            $mail->Body    = $MSJ;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo '<script language="javascript">alert("'.$mail->ErrorInfo.'");</script>';
        }
    }


    function encrypt($string) {
        $key = $this->KeyCrypt;
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }











    public function insertMarcatgeOnyx($idemp, $entradamati, $entradatarda, $sortidamati, $sortidatarda, $idempempleadoOnyx, $idempresaOnyx)
    {
        $token = $this->loginOnyx();
        $url = 'http://api.onyxerp.com/index.php/create';
        $data = '{
     "fields":
     [
         {
             "alias":"",
             "apply":"",
             "name":"DocumentoID",
             "type":"number",
             "value":"0"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HorasExtra",
             "type":"text",
             "value":"000000"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HorasNormales",
             "type":"text",
             "value":"00000"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HoraFinTarde",
             "type":"text",
             "value":"' . $sortidatarda . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HoraFinManana",
             "type":"text",
             "value":"' . $sortidamati . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HoraIniManana",
             "type":"text",
             "value":"' . $entradamati . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"HoraIniTarde",
             "type":"text",
             "value":"' . $entradatarda . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"Fecha",
             "type":"text",
             "value":"' . date("Y-m-d H:i:s") . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"CustomerID",
             "type":"number",
             "value":"71"
         },
         {
             "alias":"",
             "apply":"",
             "name":"EmpresaID",
             "type":"number",
             "value":"' . $idempresaOnyx . '"
         },
         {
             "alias":"",
             "apply":"",
             "name":"UsuarioID",
             "type":"number",
             "value":"2"
         },
         {
             "alias":"",
             "apply":"",
             "name":"FechaHoraUsuario",
             "type":"currentdatetime",
             "value":""
         },
         {
             "alias":"",
             "apply":"",
             "name":"EmpleadoID",
             "type":"number",
             "value":"' . $idempempleadoOnyx . '"
         }
     ],
     "table":"ControlPresencia"
 }
 ';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'ctoken: QXppZ3FET1BMUHVRK2VWWVk3clA3TVRXT01DV1FxWERyeFQ2ckRWdjVJcjdFOGlhbjFKTXpPa05VVFJUNWRMUw==',
                'token:' . $token . ' ',
            )
        //'Content-Length: ' . strlen($datastr))
        );

        $server_output = curl_exec($ch);
        $json = json_decode($server_output, true);

        return $json;
    }

    public function loginOnyx()
    {
        $url = 'http://api.onyxerp.com/index.php/login';
        $data = '{
     "username":"FICHAJES",
     "password":"FICHAJES",
     "customerId":281
         }
         ';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'ctoken: QXppZ3FET1BMUHVRK2VWWVk3clA3TVRXT01DV1FxWERyeFQ2ckRWdjVJcjdFOGlhbjFKTXpPa05VVFJUNWRMUw==',
                'token:'
            )
        //'Content-Length: ' . strlen($datastr))
        );

        $server_output = curl_exec($ch);
        $json = json_decode($server_output, true);
        return $json['token'];
    }

    public function updateMarcatgeOnyx($idemp, $entradamati, $entradatarda, $sortidamati, $sortidatarda, $idmarcatge, $idempempleadoOnyx)
    {
        $token = $this->loginOnyx();
        $url = 'http://api.onyxerp.com/index.php/update';
        if (isset($entradamati))
        {
            $data = '{
         "table": "controlpresencia",
         "fields": 
         [
                 
                 {
                         "name": "HoraIniManana",
                         "type": "text",
                         "value": "' . $entradamati . '"
                 },
                 {
                         "name": "Fecha",
                         "type": "datetime",
                         "value": "' . date("Y-m-d H:i:s") . '"
                 }
                 
         ],
         "conditions": 
         [
                 {
                         "field": "ControlPresenciaID",
                         "type": "equal",
                         "value": "' . $idmarcatge . '",
                         "next": "and"
                 },
                 {
                         "field": "EmpleadoID",
                         "type": "equal",
                         "value": "' . $idempempleadoOnyx . '",
                         "next": "and"
                 }
         ]
 }
 ';
        }
        if (isset($entradatarda))
        {
            $data = '{
         "table": "controlpresencia",
         "fields": 
         [
                 
                 {
                         "name": "HoraIniTarde",
                         "type": "text",
                         "value": "' . $entradatarda . '"
                 },
                 {
                         "name": "Fecha",
                         "type": "datetime",
                         "value": "' . date("Y-m-d H:i:s") . '"
                 }
                 
         ],
         "conditions": 
         [
                 {
                         "field": "ControlPresenciaID",
                         "type": "equal",
                         "value": "' . $idmarcatge . '",
                         "next": "and"
                 },
                 {
                          "field": "EmpleadoID",
                         "type": "equal",
                         "value": "' . $idempempleadoOnyx . '",
                         "next": "and"
                 }
         ]
 }
 ';
        }
        if (isset($sortidamati))
        {
            $data = '{
         "table": "controlpresencia",
         "fields": 
         [
                 
                 {
                         "name": "HoraFinManana",
                         "type": "text",
                         "value": "' . $sortidamati . '"
                 },
                 {
                         "name": "Fecha",
                         "type": "datetime",
                         "value": "' . date("Y-m-d H:i:s") . '"
                 }
                 
         ],
         "conditions": 
         [
                 {
                         "field": "ControlPresenciaID",
                         "type": "equal",
                         "value": "' . $idmarcatge . '",
                         "next": "and"
                 },
                 {
                          "field": "EmpleadoID",
                         "type": "equal",
                         "value": "' . $idempempleadoOnyx . '",
                         "next": "and"
                 }
         ]
 }
 ';
        }
        if (isset($sortidatarda))
        {
            $data = '{
         "table": "controlpresencia",
         "fields": 
         [
                 
                 {
                         "name": "HoraFinTarde",
                         "type": "text",
                         "value": "' . $sortidatarda . '"
                 },
                 {
                         "name": "Fecha",
                         "type": "datetime",
                         "value": "' . date("Y-m-d H:i:s") . '"
                 }
                 
         ],
         "conditions": 
         [
                 {
                         "field": "ControlPresenciaID",
                         "type": "equal",
                         "value": "' . $idmarcatge . '",
                         "next": "and"
                 },
                 {
                          "field": "EmpleadoID",
                         "type": "equal",
                         "value": "' . $idempempleadoOnyx . '",
                         "next": "and"
                 }
         ]
 }
 ';
        }


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'ctoken: QXppZ3FET1BMUHVRK2VWWVk3clA3TVRXT01DV1FxWERyeFQ2ckRWdjVJcjdFOGlhbjFKTXpPa05VVFJUNWRMUw==',
                'token:' . $token . ' ',
            )
        //'Content-Length: ' . strlen($datastr))
        );

        $server_output = curl_exec($ch);
        $json = json_decode($server_output, true);

        return $json['success'];
    }
















    public function importEmpleatsOnyx($empleatsArray)
    {
        $cont = 0;


        foreach ($empleatsArray["records"] as $empleatinfo)
        {


            $cont++;

            $empleat = array("idusuarioOnyx" => $empleatinfo["EmpleadoID"], "Nombre" => $empleatinfo["Nombre"], "Dni" => $empleatinfo["Dni"], "idempresaOnyx" => $empleatinfo["EmpresaID"], "Codigo" => $empleatinfo["NumeroTarjeta"], "Baixa" => $empleatinfo["DeBaja"]);

            $sqli = 'insert into empleat_log (idempresa,nom,idtargeta,dni, idempresaOnyx,idusuarioOnyx,baixa,datareg) values (' . $_SESSION["idempresa"] . ',"' . $empleat["Nombre"] . '","' . $empleat["Codigo"] . '","' . $empleat["Dni"] . '",' . $empleat["idempresaOnyx"] . ',' . $empleat["idusuarioOnyx"] . ',' . $empleat["Baixa"] . ',now())';

            $resq = $this->getDb()->executarSentencia($sqli);

            if ($empleat["Baixa"] == 1)
            {
                $sqlu = 'update empleat set enplantilla=0 where idusuarioOnyx=' . $empleat["idusuarioOnyx"] . ';';
                $this->getDb()->executarSentencia($sqlu);
            }
            else if ($empleat["Baixa"] == 0)
            {

                if (!empty($empleat["Dni"]) && !empty($empleat["Codigo"]))
                {
                    $sql = 'select dni,idtargeta,enplantilla from empleat WHERE dni like "' . $empleat["Dni"] . '" OR idtargeta like "' . $empleat['Codigo'] . '" AND idempresa =  "' . $_SESSION["idempresa"] . '"';
                    $results = $this->getDb()->executarConsulta($sql);
                }
                else if (!empty($empleat["Dni"]))
                {
                    $sql = 'select dni,idtargeta,enplantilla from empleat WHERE dni like "' . $empleat["Dni"] . '" AND idempresa =  "' . $_SESSION["idempresa"] . '"';
                    $results = $this->getDb()->executarConsulta($sql);
                }
                else if (!empty($empleat["Codigo"]))
                {
                    $sql = 'select dni,idtargeta,enplantilla from empleat WHERE idtargeta like "' . $empleat["Codigo"] . '" AND idempresa =  "' . $_SESSION["idempresa"] . '"';
                    $results = $this->getDb()->executarConsulta($sql);
                }

                if (!empty($results))
                {

                    if ($results[0]["enplantilla"] == 1)
                    {
                        if ($empleat["Codigo"] != "")
                        {
                            $sqlu = 'update empleat set nom="' . $empleat["Nombre"] . '",idtargeta="' . $empleat["Codigo"] . '",dni="' . $empleat["Dni"] . '",enplantilla=1,updated_at=now()  where idusuarioOnyx=' . $empleat["idusuarioOnyx"] . ';';


                            $this->getDb()->executarSentencia($sqlu);
                        }
                    }
                }
                else
                {

                    $sql = 'insert into empleat (idempresa,nom,idtargeta,dni, idempresaOnyx,idusuarioOnyx,idsubempresa,enplantilla,dataultcontrac) values (' . $_SESSION["idempresa"] . ',"' . $empleat["Nombre"] . '","' . $empleat["Codigo"] . '","' . $empleat["Dni"] . '",' . $empleat["idempresaOnyx"] . ',' . $empleat["idusuarioOnyx"] . ', 12, 1,now() )';
                    $res = $this->getDb()->executarSentencia($sql);

                    /** S'agafa el id del ultim empleat insertat i s'afegeix a la taula assignacio * */
                    $sqls = 'SELECT @@identity AS id';
                    $results = $this->getDb()->executarConsulta($sqls);

                    foreach ($results as $result)
                    {
                        $idempleatInsertat = $result['id'];
                        $sqle = 'insert into assignat (id_emp,id_rol,actiu) values (' . $idempleatInsertat . ', 34, 1)';
                        $ret = $this->getDb()->executarSentencia($sqle);
                        $sqli = 'insert into quadrant (idEmpleat,idhorari,datainici,datafi,actiu) values (' . $idempleatInsertat . ', 1, ' . date("Y-m-d") . ',null ,1)';
                        $rew = $this->getDb()->executarSentenciaOnyx($sqli);
                        $sqlr = 'insert into situat (idempleat,idlocalitzacio,datainici,datafi,actiu) values (' . $idempleatInsertat . ', 1, ' . date("Y-m-d") . ',null ,1)';
                        $rer = $this->getDb()->executarSentenciaOnyx($sqlr);
                    }
                }
            }
        }
    }







    function decrypt($string) {
        $key = $this->KeyCrypt;
        $result = '';
        $string = base64_decode($string);
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }

    public function Solicitexcepci($id, $idtipusexcep, $datainici, $datafi,$file,$idEncargado, $coment_excepcio) {


        $sql = 'INSERT INTO excepcio (idempleat, idtipusexcep, datainici, datafinal, idresp, comentario) VALUES ('.$id.', '.$idtipusexcep.', "'.$datainici.'", "'.$datafi.'", "'.$idEncargado.'", "'.$coment_excepcio.'");';

        $this->getDb()->executarSentencia($sql);

        $rsemp = $this->getDb()->executarConsulta('select max(idexcepcio) as idexcepcio, empleat.nom,cognom1,cognom2,tipusexcep.nom as excepType from excepcio 
                left join empleat on empleat.idempleat = excepcio.idempleat
                left join tipusexcep on tipusexcep.idtipusexcep = excepcio.idtipusexcep 
                    where excepcio.idempleat = "'.$id.'" and excepcio.idtipusexcep = "'.$idtipusexcep.'"  and excepcio.idresp = "'.$idEncargado.'" ');

        $root = $_SERVER["DOCUMENT_ROOT"];

        if (strpos($root,'/') === false) {
            $sep = "\\";
        }else{
            $sep = "/";
        }

        if (count($file) > 0) {

            $micarpeta = $root.$sep.'excepciFiles';
            if (!file_exists($micarpeta)) {
                $response2 = mkdir($micarpeta, 0777, true);
            }

            $pathFoler = $micarpeta.$sep.$rsemp[0]["idexcepcio"];

            if (!file_exists($pathFoler)) {
                $response2 = mkdir($pathFoler, 0777, true);
            }

            for ($i=0; $i < count($file["myFiles"]["tmp_name"]); $i++) {
                $currentLocation = $file["myFiles"]["tmp_name"][$i];
                $newLocation = $pathFoler.$sep.$file["myFiles"]["name"][$i];
                $moved = rename($currentLocation, $newLocation);
            }

        }

        $email = $this->getCampPerIdCampTaula("empleat",$idEncargado,"email");

        if ($email != ''){

            $emmpleatFullname = $rsemp[0]["nom"]." ".$rsemp[0]["cognom1"]." ".$rsemp[0]["cognom2"];
            $email = $this->getCampPerIdCampTaula("empleat",$idEncargado,"email");
            $ASUNT  = "Petición de ".$emmpleatFullname." en el portal del empleado"  ;

            ob_start();
            include 'PHPMailer/SolictExcepMSJ.html';
            $MSJ = ob_get_contents();
            ob_end_clean();

            $MSJ = str_replace("%EMPLEATNAME%", $emmpleatFullname , $MSJ);

            session_start();

            $lng = $_SESSION["ididioma"];

            $MSJ = str_replace("%EXCEPTTYPE%",  $this->__($lng,$rsemp[0]["excepType"]) , $MSJ);

            $parm = $lng."|".$rsemp[0]["idexcepcio"];

            $URLProc = "https://frapont.controlpresencia.online";

            $MSJ = str_replace("%URLOPEN%", $URLProc , $MSJ);

            $this->SendEMAILV1($ASUNT,$MSJ,$email);


        }

    }

    public function ModSolicitexcep($id, $idtipusexcep, $datainici, $datafi,$file,$idEncargado, $coment_excepcio) {

        $sql = 'UPDATE excepcio SET idtipusexcep = '.$idtipusexcep.', datainici = "'.$datainici.'", datafinal = "'.$datafi.'" , idresp = "'.$idEncargado.'", comentario = "'. $coment_excepcio.'" WHERE  idexcepcio = '.$id.';';

        $this->getDb()->executarSentencia($sql);
        $rsemp = $this->getDb()->executarConsulta('select max(idexcepcio) as idexcepcio, empleat.nom,cognom1,cognom2,tipusexcep.nom as excepType from excepcio 
                left join empleat on empleat.idempleat = excepcio.idempleat
                left join tipusexcep on tipusexcep.idtipusexcep = excepcio.idtipusexcep 
                    where excepcio.idempleat = "'.$id.'" and excepcio.idtipusexcep = "'.$idtipusexcep.'"  and excepcio.idresp = "'.$idEncargado.'" ');

        $root = $_SERVER["DOCUMENT_ROOT"];

        if (strpos($root,'/') === false) {
            $sep = "\\";
        }else{
            $sep = "/";
        }

        if (count($file) > 0) {

            $micarpeta = $root.$sep.'excepciFiles';
            if (!file_exists($micarpeta)) {
                $response2 = mkdir($micarpeta, 0777, true);
            }

            $pathFoler = $micarpeta.$sep.$rsemp[0]["idexcepcio"];

            if (!file_exists($pathFoler)) {
                $response2 = mkdir($pathFoler, 0777, true);
            }

            for ($i=0; $i < count($file["myFiles"]["tmp_name"]); $i++) {
                $currentLocation = $file["myFiles"]["tmp_name"][$i];
                $newLocation = $pathFoler.$sep.$file["myFiles"]["name"][$i];
                $moved = rename($currentLocation, $newLocation);
            }

        }

        $email = $this->getCampPerIdCampTaula("empleat",$idEncargado,"email");

        if ($email != ''){

            $emmpleatFullname = $rsemp[0]["nom"]." ".$rsemp[0]["cognom1"]." ".$rsemp[0]["cognom2"];
            $email = $this->getCampPerIdCampTaula("empleat",$idEncargado,"email");
            $ASUNT  = "Petición de ".$emmpleatFullname." en el portal del empleado"  ;

            ob_start();
            include 'PHPMailer/SolictEditMSJ.html';
            $MSJ = ob_get_contents();
            ob_end_clean();

            $MSJ = str_replace("%EMPLEATNAME%", $emmpleatFullname , $MSJ);

            session_start();

            $lng = $_SESSION["ididioma"];

            $MSJ = str_replace("%EXCEPTTYPE%",  $this->__($lng,$rsemp[0]["excepType"]) , $MSJ);

            $parm = $lng."|".$rsemp[0]["idexcepcio"];

            $URLProc = "https://frapont.controlpresencia.online";

            $MSJ = str_replace("%URLOPEN%", $URLProc , $MSJ);

            $this->SendEMAILV1($ASUNT,$MSJ,$email);



        }

    }


    public function seleccionaExcepcionsEmpPerId($id) {
        $sql = '
            select e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal, t.nom, t.r, t.g, t.b
            from excepcio as e 
                join tipusexcep as t 
                    on t.idtipusexcep = e.idtipusexcep 
            where idempleat like "'.$id.'" and ((e.idresp = 0 or  e.idresp is null) or e.aprobada = 1) 
            order by datainici desc
            ';
        return $this->getDb()->executarConsulta($sql);
    }
	 public function seleccionaExcepcionsEmpPerIdHorariEmpleat($id,$any) {
        $sql = '
            select e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal, t.nom, t.r, t.g, t.b
            from excepcio as e 
                join tipusexcep as t 
                    on t.idtipusexcep = e.idtipusexcep 
            where idempleat like "'.$id.'" and ((e.idresp = 0 or  e.idresp is null) or e.aprobada = 1)  AND YEAR(e.datainici) = '.$any.' 
            order by datainici desc
            ';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaSolictExcepcionsEmpPerId($id) {
        $sql = 'select e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal, t.nom, e.aprobada, e.idresp from excepcio as e join tipusexcep as t on t.idtipusexcep = e.idtipusexcep where idempleat like "'.$id.'" and (not(e.idresp = 0 or  e.idresp is null))  order by datainici desc';
        return $this->getDb()->executarConsulta($sql);
    }

    public function esExcepcioPerIdDia($id, $data) {
        $sql = 'SELECT t.nom, t.r, t.g, t.b, e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal FROM excepcio as e JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep where e.idempleat like "'.$id.'" and (e.datainici <= DATE("'.$data.'")) and (e.datafinal >= DATE("'.$data.'")) and ((e.idresp = 0 or  e.idresp is null) or e.aprobada = 1)';
        $rse = $this->getDb()->executarConsulta($sql);
        if((empty($rse))&&(strtotime('today')>=strtotime($data))){
            $rse = $this->getDb()->executarConsulta($sql = 'SELECT t.nom, t.r, t.g, t.b, e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal FROM excepcio as e JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep where e.idtipusexcep = 1 and e.idempleat like "'.$id.'" and (e.datainici <= DATE("'.$data.'")) and ((e.datafinal = DATE("0000-00-00"))or(e.datafinal is null)) and ((e.idresp = 0 or  e.idresp is null) or e.aprobada = 1)');
        }

        return $rse;
    }

    public function esBaixaPerIdDia($id, $data, $tipusexcep) {
        $sql = 'SELECT e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal, t.nom, t.r, t.g, t.b 
        FROM excepcio as e 
        JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep 
        WHERE e.idtipusexcep = '.$tipusexcep.' 
        AND e.idempleat LIKE "'.$id.'" 
        AND (e.datainici <= DATE("'.$data.'")) 
        AND (e.datafinal >= DATE("'.$data.'") 
        AND ((e.idresp = 0 OR e.idresp IS NULL) OR e.aprobada = 1))';

        $rse = $this->getDb()->executarConsulta($sql);
        if((empty($rse))&&(strtotime('today')>=strtotime($data))){
            $rse = $this->getDb()->executarConsulta($sql = 'SELECT e.idexcepcio, e.idtipusexcep, e.datainici, e.datafinal, t.nom, t.r, t.g, t.b FROM excepcio as e JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep where e.idtipusexcep = 1 and e.idempleat like "'.$id.'" and (e.datainici <= DATE("'.$data.'")) and ((e.datafinal = DATE("0000-00-00"))or(e.datafinal is null)) and ((e.idresp = 0 or  e.idresp is null) or e.aprobada = 1)');
        }

        return $rse;
    }

    public function editaExcepcio($idexcep, $noutipus, $novadataini, $novadatafi) {
        $sql = 'UPDATE excepcio SET idtipusexcep=("'.$noutipus.'"),datainici=("'.$novadataini.'"),datafinal=("'.$novadatafi.'") WHERE idexcepcio="'.$idexcep.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function DeleteFile($filepath) {
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    public function eliminaExcepcio($idexcep) {

        $root = $_SERVER["DOCUMENT_ROOT"];

        if (strpos($root, '/') === false) {
            $sep = "\\";
        } else {
            $sep = "/";
        }

        $micarpeta = $root . $sep . 'excepciFiles';
        $pathFoler = $micarpeta . $sep . $idexcep;

        if (file_exists($pathFoler)) {
            $listFiles = array_values(array_diff(scandir($pathFoler), array('..', '.')));

            for ($i = 0; $i < count($listFiles); $i++) {
                unlink($pathFoler . $sep . $listFiles[$i]);
            }

            rmdir($pathFoler);
        }

        $dsn = "mysql:host=localhost;dbname=frapont_cp;charset=utf8";
        $username = "proyectos";
        $password = "4lzCw66_";

        $db = new PDO($dsn, $username, $password);

        // Inicia una transacción
        $db->beginTransaction();

        try {
            // Elimina los comentarios relacionados a la excepción
            $sqlEliminarComentarios = 'DELETE FROM comentario WHERE id_excepcio = "'.$idexcep.'"';
            $db->exec($sqlEliminarComentarios);

            // Elimina la excepción
            $sqlEliminarExcepcion = 'DELETE FROM excepcio WHERE idexcepcio = "'.$idexcep.'"';
            $resultado = $db->exec($sqlEliminarExcepcion);

            // Confirma la transacción si todo ha ido bien
            $db->commit();

            return $resultado;
        } catch (Exception $e) {
            // Si ocurre algún error, realiza un rollback de la transacción
            $db->rollBack();
            throw $e;
        }
    }


    public function assignaActivitat($id, $tipus, $data, $horaini, $horafi) {
        $sql = 'INSERT INTO activitat (idempleat, idtipus, datainici, horainici, horafi) VALUES ('.$id.', '.$tipus.', "'.$data.'", "'.$horaini.'", "'.$horafi.'")';
        return $this->getDb()->executarSentencia($sql);
    }

    public function editaPeriodeHorari($idquadrant, $idhorari, $datainici, $datafi) {
        if($datafi=="") $sql = 'UPDATE quadrant SET idhorari=("'.$idhorari.'"), datainici=("'.$datainici.'"), datafi = NULL WHERE idquadrant = '.$idquadrant.'';
        else $sql = 'UPDATE quadrant SET idhorari=("'.$idhorari.'"), datainici=("'.$datainici.'"), datafi=("'.$datafi.'") WHERE idquadrant like "'.$idquadrant.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function eliminaPeriodeHorari($idquadrant) {
        $sql = 'delete from quadrant where idquadrant like "'.$idquadrant.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function esVigent($idquadrant) {
        $sql = 'SELECT * FROM quadrant where idquadrant like "'.$idquadrant.'"';
        $res = $this->getDb()->executarConsulta($sql);
        $vigent = 0;
        $avui = strtotime("now");
        $dataavui = date("Y-m-d",$avui);
        $datainici = "";
        $datafi = "";
        foreach ($res as $actiu)
        {
            $datainici = $actiu["datainici"];
            $datafi = $actiu["datafi"];
        }
        if(((strtotime($dataavui)>=strtotime($datainici))&&((strtotime($dataavui)<=strtotime($datafi))))||(($datafi=="")&&(strtotime($dataavui)>=strtotime($datainici)))) $vigent=1;//
        return $vigent;
    }

    public function assignaVigencia($idquadrant,$valor) {
        $sql = 'UPDATE quadrant SET actiu=("'.$valor.'") WHERE idquadrant like "'.$idquadrant.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function seleccionaUbicacionsPerIdEmpresa($id) {
        $sql = 'select * from localitzacio where idempresa = "'.$id.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaUbicacionsPerIdEmpresaCap($id) {
        $sql = 'select * from localitzacio where idempresacap = "'.$id.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function assignaUbicacioPersona($id, $idubicacio, $datainici, $datafi) {
        if($datafi=="") $sql = 'INSERT INTO situat (idempleat, idlocalitzacio, datainici) VALUES ('.$id.', '.$idubicacio.', "'.$datainici.'")';
        else $sql = 'INSERT INTO situat (idempleat, idlocalitzacio, datainici, datafi) VALUES ('.$id.', '.$idubicacio.', "'.$datainici.'", "'.$datafi.'")';
        return $this->getDb()->executarSentencia($sql);
    }

    public function editaPeriodeUbicacio($idsituat, $idubicacio, $datainici, $datafi) {
        if($datafi=="") $sql = 'UPDATE situat SET idlocalitzacio=("'.$idubicacio.'"), datainici=("'.$datainici.'"), datafi = NULL WHERE idsituat='.$idsituat;
        else $sql = 'UPDATE situat SET idlocalitzacio=("'.$idubicacio.'"), datainici=("'.$datainici.'"), datafi=("'.$datafi.'") WHERE idsituat='.$idsituat;
        $this->getDb()->executarSentencia($sql);
    }

    public function eliminaPeriodeUbicacio($idsituat) {
        $sql = 'delete from situat where idsituat like "'.$idsituat.'"';
        return $this->getDb()->executarSentencia($sql);
    }

    public function altaPersona($idempresa, $cognom1, $cognom2, $nom, $dni, $datanaix, $numafil, $dpt, $rol, $subemp, $resp) {

        $idtargeta = "";
        if(!empty($dni)) $idtargeta = strtolower($dni);
        $sql = 'INSERT INTO empleat (idempresa, cognom1, cognom2, nom, dni, datanaixement, numafiliacio, dataultcontrac, enplantilla, idsubempresa, idresp, idtargeta) VALUES ('.$idempresa.',"'.$cognom1.'","'.$cognom2.'","'.$nom.'","'.$dni.'","'.$datanaix.'","'.$numafil.'",now(),1,'.$subemp.','.$resp.',"'.$idtargeta.'")';
        $this->getDb()->executarSentencia($sql);
        $sql0 = 'SELECT idempleat from empleat order by idempleat desc limit 1';
        $idarray = $this->getDb()->executarConsulta($sql0);
        $id = 0;
        foreach($idarray as $codi) {$id = $codi["idempleat"];}
        if($dpt>0) $this->getDb()->executarSentencia('INSERT INTO pertany (id_emp, id_dep, datainici, actiu) VALUES ('.$id.','.$dpt.',now(),1)');
        if($rol>0) $this->getDb()->executarSentencia('INSERT INTO assignat (id_emp, id_rol, datainici, actiu) VALUES ('.$id.','.$rol.',now(),1)');
    }

    public function seleccionaEmpPerEmpresa($idsubempresa) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.idsubempresa = "'.$idsubempresa.'" order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerEmpresaActius($idsubempresa) {
        if($idsubempresa == 'Totes') $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.enplantilla = 1 order by e.cognom1, e.cognom2, e.nom';
        else $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.idsubempresa = "'.$idsubempresa.'" and e.enplantilla = 1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerEmpresaActiusPerDpt($idsubempresa, $dpt) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, d.nom as Departament, e.email, e.enplantilla from empleat as e join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep WHERE e.idsubempresa = "'.$idsubempresa.'" and e.enplantilla = 1 and d.nom like "'.$dpt.'" and p.actiu=1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerEmpresaActiusPerDptRol($idsubempresa, $dpt, $rol) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, r.nom as Rol, d.nom as Departament, e.email, e.enplantilla from empleat as e join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep join assignat as a on a.id_emp = e.idempleat join rol as r on r.idrol = a.id_rol WHERE e.idsubempresa = "'.$idsubempresa.'" and e.enplantilla = 1 and d.nom like "'.$dpt.'" and p.actiu=1 and r.nom like "'.$rol.'" and a.actiu=1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerEmpresaActiusPerRol($idsubempresa, $rol) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, r.nom as Rol, e.email, e.enplantilla from empleat as e join assignat as a on a.id_emp = e.idempleat join rol as r on r.idrol = a.id_rol WHERE e.idsubempresa = "'.$idsubempresa.'" and e.enplantilla = 1 and r.nom like "'.$rol.'" and a.actiu=1 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaEmpPerEmpresaCessats($idsubempresa) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.idsubempresa = "'.$idsubempresa.'" and e.enplantilla = 0 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTotsEmpActius($idempresa) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.idempresa='.$idempresa.' and e.enplantilla = 1  order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaTotsEmpCessats($idempresa) {
        $sql = 'select e.idempleat, e.cognom1, e.cognom2, e.nom, e.email, e.enplantilla from empleat as e where e.idempresa='.$idempresa.' and e.enplantilla = 0 order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function altaEmpresa($nom, $cif, $ccc, $centre, $usuari, $pwd, $rutalogo, $logo, $website) {

    }

    public function cessarEmpresa($id) {

    }

    public function cessarPersona($id) {
        $data = date("Y-m-d",strtotime('now'));
        $sql = 'update empleat SET enplantilla=0,datacessat="'.$data.'" where idempleat ='.$id;
        $this->getDb()->executarSentencia($sql);
        $sql1 = 'update quadrant SET actiu=(0), datafi=("'.$data.'") where idempleat='.$id.' and actiu=1';
        $this->getDb()->executarSentencia($sql1);
    }

    public function iniciaEmpresa($id, $pwd) {

    }

    public function changeEncargVal($idempleat,$newVal) {
        $sql = 'UPDATE empleat SET isEncargado = '.$newVal.' WHERE (idempleat = '.$idempleat.')';
        $this->getDb()->executarSentencia($sql);
    }



    public function changeAutoMarcaje($idempleat,$newVal) {
        $sql = 'UPDATE empleat SET isEncargado = '.$newVal.' WHERE (idempleat = '.$idempleat.')';
        $this->getDb()->executarSentencia($sql);
    }


    public function changeHoraElectVal($idtipusexcep,$newVal) {
        $sql = 'UPDATE tipusexcep SET HorElectiv = '.$newVal.' WHERE (idtipusexcep = '.$idtipusexcep.')';
        $this->getDb()->executarSentencia($sql);
    }


    public function reactivarEmpresa($id) {

    }

    public function reactivarPersona($id) {
        $sql = 'update empleat SET enplantilla=(1) where idempleat ='.$id;
        $this->getDb()->executarSentencia($sql);
        $data = date("Y-m-d",strtotime('now'));
        $sql1 = 'update empleat SET dataultcontrac=("'.$data.'") where idempleat='.$id;
        $this->getDb()->executarSentencia($sql1);
    }

    public function seleccionaHorarisActiusEmpresa($id) {
        $sql = 'select * from horaris where idempresa like "'.$id.'" and obsolet = 0';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraNomEmpresa($empresa) {
        $sql = 'select nom from empresa where idempresa like "'.$empresa.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"];
        return $res;
    }

    public function mostraNomSubempresa($subempresa) {
        $sql = 'select nom from subempresa where idsubempresa like "'.$subempresa.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["nom"];
        return $res;
    }

    public function mostraEmpreses() {
        $sql = 'select * from empresa';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraSubempreses($idempresa) {
        $sql = 'select * from subempresa where idempresa='.$idempresa;
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaPersonesPerEmpAnyMes($idempresa, $any, $mes) {
        $sql = 'select * from empleat where idempresa like "'.$idempresa.'" order by cognom1, cognom2, nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaPersonesPerEmpDptAnyMes($idempresa, $dpt, $any, $mes) {
        $sql = 'select distinct e.idempleat, e.nom, e.cognom1, e.cognom2 from empleat as e join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep where e.idempresa like "'.$idempresa.'" and d.nom like "'.$dpt.'" order by e.cognom1, e.cognom2, e.nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaPersonesPerEmpDptTipusexcepAnyMes($idempresa, $dpt, $tipusexcep, $any, $mes) {
        $sql = 'select * from empleat where idempresa like "'.$idempresa.'" order by cognom1, cognom2, nom';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaPersonesPerEmpTipusexcepAnyMes($idempresa, $tipusexcep, $any, $mes) {
        $sql = 'select * from empleat where idempresa like "'.$idempresa.'" order by cognom1, cognom2, nom';
        return $this->getDb()->executarConsulta($sql);
    }



    public function seleccionaTotsEmpleats() {
        $sql = 'SELECT * FROM empleat ORDER BY cognom1, cognom2, nom';
        return $this->getDb()->executarConsulta($sql);
    }







    public function imprimeixTipusDiaPerIdDia($id,$dia,$tipusexcep,$lng) {
        $festiu = $this->esFestiuPerIdDia($id, $dia);
        $disponible=0;
        $especial=0;
        $rota = $this->terotacio($id,$dia);
        session_start();
        $prifestius = $this->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"prifestius");
        $marcafestius = $this->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"marcafestius");

        if(!empty($this->esExcepcioPerIdDia($id, $dia)))
        {
            $numexcep = 0;
            $onclick = "";
            $excepcio = $this->esExcepcioPerIdDia($id, $dia);
            foreach($excepcio as $excep)
            {
                if($numexcep>0)$tipus .= ", ".$excep["nom"];
                $numexcep++;
                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
            }
            if($numexcep>1) echo '<td title="Solapament de Períodes: '.$this->__($lng,$excep["nom"]).'" style="background-color: rgb(128,0,0)"></td>';
            else if ($tipusexcep==$this->__($lng,"Tots")) echo '<td title="'.$this->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
            else if ($tipusexcep==$this->__($lng,$excep["nom"]))
            {
                echo '<td title="'.$this->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                $especial++;
            }
            else echo '<td title="'.$this->__($lng,$excep["nom"]).'" style="border: solid 1px;"></td>';
        }
        // Ara no cal però si es fa la condició anterior, afegir condició per si l'empresa no prioritza els festius a les rotacions ex: &&($prifestius==0)
        else if(!empty($rota)) {
            $title="";
            $bckg = "";
            $color = "";
            $abr = "";
            $tt = $this->getCampPerIdCampTaula("rotacio",$rota,"idtipustorn");
            $rst = $this->getDb()->executarConsulta('select * from tipustorn where idtipustorn='.$tt);
            foreach($rst as $t) {
                $title=''.$this->__($lng,"Torn").': '.$t["nom"].'&NewLine;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($t["horaentrada"])).'&NewLine;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($t["horasortida"])).'&NewLine;'.$this->__($lng,"Hores").': '.$t["horestreball"];
                $bckg = $t["colorbckg"];
                $color = $t["colortxt"];
                $abr = $t["abrv"];
            }
            echo '<td title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
            $disponible++;
        }
        // Afegir condició per si l'empresa prioritza els festius als horaris regulars
        else if(!empty($festiu)) {
            $bckc = "rgb(150,50,50)";
            if($marcafestius==0)$bckc = "gainsboro";
            foreach($festiu as $festa) echo '<td title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$id.",'".$dia."',".');"></td>';
        }
        else if(!$this->treballaria($id, $dia)) {
            echo '<td title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$id.",'".$dia."',".');"></td>';
        }
        // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
        else {echo '<td title="'.$this->__($lng,"Horari").': '.$this->seleccionaTipusHorariPerIdDia($id,$dia,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$id.",'".$dia."',".');">'.substr($this->getCampPerIdCampTaula("empleat",$id,"nom"),0,1).'</td>'; $disponible++;}

        return $disponible;
    }

    public function getFracTornDiaPerIdDia($id,$dia,$tipusexcep,$lng,$frac) {
        $festiu = $this->esFestiuPerIdDia($id, $dia);
        $disponible=0;
        $especial=0;
        $rota = $this->terotacio($id,$dia);
        $tf = 0;
        if(!empty($this->esExcepcioPerIdDia($id, $dia))) {}
        else if(!empty($rota)) {
            $tt = $this->getCampPerIdCampTaula("rotacio",$rota,"idtipustorn");
            $tf = $this->getCampPerIdCampTaula("tipustorn",$tt,"torn");
            switch($frac){
                case 1:
                    $mati = $this->getCampPerIdCampTaula("tornfrac",$tf,"mati");
                    if($mati==1) $disponible++;
                    break;
                case 2:
                    $tarda = $this->getCampPerIdCampTaula("tornfrac",$tf,"tarda");
                    if($tarda==1) $disponible++;
                    break;
                case 3:
                    $nit = $this->getCampPerIdCampTaula("tornfrac",$tf,"nit");
                    if($nit==1) $disponible++;
                    break;
            }
        }
        return $disponible;
    }

    public function getTitolRotacio($rotacio){
        $titol = $this->__($lng,"Horari").$t["nom"].'&#13'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($t["horaentrada"])).'&#13'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($t["horasortida"])).'&#13'.$this->__($lng,"Hores").': '.$t["horestreball"];

    }
    public function getRutaLogo($idempresa){
        $sql = 'select ruta_logo from empresa where idempresa='.$idempresa;
        $ruta = "";
        $path = $this->getDb()->executarConsulta($sql);
        foreach($path as $carpeta)$ruta = $carpeta["ruta_logo"];
        return $ruta;
    }

    public function mostraAnysContractePerId($id) {
        $anys = [];
        $anyzero = $this->getDb()->executarConsulta('SELECT min(year(data)) as any FROM rotacio where idempleat='.$id);
        if(empty($anyzero)) $anyzero = $this->getDb()->executarConsulta('SELECT min(year(datainici)) as any FROM quadrant where idempleat='.$id);

        foreach($anyzero as $any) $anys[0]=$any["any"];
        $anyact = date('Y',strtotime('now'));
        for($i=$anys[0]+1;$i<=$anyact;$i++) $anys[]=($i);
        return $anys;
    }

    public function getWebSite($idempresa) {
        $sql = 'select website from empresa where idempresa like "'.$idempresa.'"';
        $url = "";
        $website = $this->getDb()->executarConsulta($sql);
        foreach($website as $adreca)$url = $adreca["website"];
        return $url;
    }

    public function getExcepColors($tipusexcep) {
        $sql = 'select r, g, b from tipusexcep where nom like "'.$tipusexcep.'"';
        $colors = $this->getDb()->executarConsulta($sql);
        $rgb = array_fill(0,3,0);
        foreach ($colors as $codi)
        {
            $rgb[0]=$codi["r"];
            $rgb[1]=$codi["g"];
            $rgb[2]=$codi["b"];
        }
        return $rgb;
    }

    public function creaNouHorari($idempresa, $nomhorari, $torns) {
        $sql1 = 'insert into horaris (idempresa, nom, obsolet) values ("'.$idempresa.'","'.$nomhorari.'",0)';
        $this->getDb()->executarSentencia($sql1);
        $sql2 = 'select idhoraris from horaris order by idhoraris desc limit 1';
        $idhorari = 0;
        $horessetm = 0;
        $codi = $this->getDb()->executarConsulta($sql2);
        foreach($codi as $numero) $idhorari = $numero["idhoraris"];
        foreach($torns as $dia) {$this->getDb()->executarSentencia('insert into torn (idhorari,diasetmana,horaentrada,horasortida,horestreball,horespausa,marcautomatic,marcabans,laborable) values ('.$idhorari.','.$dia->getDiasetm().',"'.$dia->getHoraini().'","'.$dia->getHorafi().'","'.$dia->getHtreb().'","'.$dia->getHdesc().'",'.$dia->getAutomarc().','.$dia->getMarcabans().','.$dia->getLaborable().')');
            $horessetm += $dia->getHtreb();}
        $this->getDb()->executarSentencia('update horaris set horesetmana=("'.$horessetm.'") where idhoraris = '.$idhorari);
    }

    public function editaHorari($idhorari,$nomhorari,$torns) {
        $horessetm = 0;
        foreach($torns as $dia) {$this->getDb()->executarSentencia('update torn set horaentrada="'.$dia->getHoraini().'",horasortida="'.$dia->getHorafi().'",horestreball="'.$dia->getHtreb().'",horespausa="'.$dia->getHdesc().'",marcautomatic='.$dia->getAutomarc().',marcabans='.$dia->getMarcabans().',laborable='.$dia->getLaborable().' where idhorari='.$idhorari.' and diasetmana='.$dia->getDiasetm());
            $horessetm += $dia->getHtreb();}
        $this->getDb()->executarSentencia('update horaris set nom="'.$nomhorari.'",horesetmana=("'.$horessetm.'") where idhoraris = '.$idhorari);
    }

    public function seleccionaTotsFestius() {
        $sql = 'select * from festiu';
        return $this->getDb()->executarConsulta($sql);
    }

    public function seleccionaFestiusPerUbicacio($idubicacio) {
        $sql = 'select * from festiu where idlocalitzacio = "'.$idubicacio.'" order by mes, dia';
        return $this->getDb()->executarConsulta($sql);
    }

    public function creaNovaUbicacio($idempresa, $nomubicacio, $fushorari, $pais, $regio, $ciutat) {
        $sql = 'insert into localitzacio (nom,ciutat,regio,pais,fushorari,idempresa) values ("'.$nomubicacio.'",'.$ciutat.','.$regio.','.$pais.',"'.$fushorari.'",'.$idempresa.')';
        $this->getDb()->executarSentencia($sql);
    }

    public function afegeixFestiuUbicacio($idubicacio, $dia, $mes, $dataany, $anual, $desc) {
        if($dataany=="")$sql = 'insert into festiu (idlocalitzacio,dia,mes,anual,descripcio) values ("'.$idubicacio.'","'.$dia.'","'.$mes.'","'.$anual.'","'.$desc.'")';
        else {
            $dia = date('d',strtotime($dataany));
            $mes = date('m',strtotime($dataany));
            $sql = 'insert into festiu (idlocalitzacio,dia,mes,dataany,anual,descripcio) values ("'.$idubicacio.'","'.$dia.'","'.$mes.'","'.$dataany.'","'.$anual.'","'.$desc.'")';
        }
        $this->getDb()->executarSentencia($sql);
    }

    public function eliminaFestiuUbicacio($idfestiu) {
        $sql = 'delete from festiu where idfestiu = "'.$idfestiu.'"';
        $this->getDb()->executarSentencia($sql);
    }

    public function mostraNomExcep($idexcep) {
        $sql = 'select nom from tipusexcep where idtipusexcep = "'.$idexcep.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $nom = "";
        foreach($rs as $name) $nom = $name["nom"];
        return $nom;
    }



    public function verNomExcep() {
        {
            $sql = 'SELECT nom FROM tipusexcep';
            $rs = $this->getDb()->executarConsulta($sql);
            $noms = array();
            foreach ($rs as $row) {
                $noms[] = $row["nom"];
            }
            return $noms;
        }
    }



    public function seleccionaHoresPausaPerIdDia($id, $data) {
        $horespausa = 0.0;
        $idrotacio = $this->terotacio($id, $data);
        if(!empty($idrotacio)) $horespausa = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula('rotacio',$idrotacio,"idtipustorn"),"horespausa");
        else if (empty($this->esFestiuPerIdDia($id, $data)))    {
            $sql = 'select t.horespausa from torn as t join horaris as h on h.idhoraris = t.idhorari join quadrant as q on q.idhorari = h.idhoraris join empleat as e on q.idEmpleat = e.idempleat where e.idempleat like "'.$id.'" and t.diasetmana like (weekday("'.$data.'")+1) and ((DATE("'.$data.'") BETWEEN q.datainici AND q.datafi)||((DATE("'.$data.'")>=q.datainici)and(q.datafi IS NULL)))';
            $rs = $this->getDb()->executarConsulta($sql);
            $hores = "";
            foreach ($rs as $valor) $hores = $valor["horespausa"];
            $horespausa = $hores;
        }
        return $horespausa;
    }

    public function seleccionaHoresPausaPerIdMes($id, $data) {
        try{
            $horespausa = 0.0;
            $arrdates = [];
            $diafi = 0;
            $datafi = $data;
            session_start();
            $idempresa = $_SESSION["idempresa"];
            // ARRAY AMB TOTES LES ROTACIONS DEL MES I DINS UNA CLASSE/ARRAY AMB DATA I HORES PAUSA, A SUPERPOSAR AMB UN ARRAY AMB EL TORN QUE CORRESPON PER DATA
            $mes = date('m',strtotime($data));
            $any = date('Y',strtotime($data));
            $zmes = "";
            $messeg = "";
            if($mes<10){$zmes = "0".$messeg;}

            for($diafi=0;date('m',strtotime($datafi))==$mes;$diafi++){
                $arrdthrdia = array_fill(0,5,0);

                $arrdthrdia[0]=$datafi;
                $arrdthrdia[4]=date('w',strtotime($datafi));
                $arrdates[]=$arrdthrdia;
                $anyseg = date('Y',strtotime($datafi));

                $datafi = date('Y-m-d',strtotime($datafi." + 1 days"));
            }
            $datafi = date('Y-m-d H:i:s',strtotime($anyseg."-".$zmes."-".$diafi));
            //OBTENIR LES LÍNIES DE LA TAULA QUADRANTS QUE APLIQUIN AL MES SELECCIONAT (ENTRE LES DATES D'INICI I FINAL) A PARTIR D'AQUI CREAR ARRAY AMB CADA DIA QUIN IDHORARI CORRESPON
            $arrqm = [];
            $rsq = $this->getDb()->executarConsulta('select * from quadrant where idempleat = '.$id.' and datainici <= "'.$datafi.'" and (datafi >= "'.$data.'" or datafi is null)');
            foreach($rsq as $q){
                $chrarrqm = array_fill(0,3,0);
                $chrarrqm[0] = $q["idhorari"];
                $chrarrqm[1] = $q["datainici"];
                $chrarrqm[2] = $q["datafi"];
                $arrqm[] = $chrarrqm;
            }
            // Primera passada per a assignar el id de l'horari que correspongui a cada un dels dies del mes
            for($i=1;$i<=$diafi;$i++){
                $strdata = strtotime($arrdates[$i-1][0]);
                foreach($arrqm as $qm){
                    if((($strdata<=strtotime($qm[2]))||(empty($qm[2])))&&($strdata>=strtotime($qm[1])))
                    {
                        $arrdates[$i-1][1]="horari";
                        $arrdates[$i-1][2]=$qm[0];
                    }
                }
            }
            // Segona passada per a assignar les hores que corresponguin segons aquest horari per a cada dia, buscant el torn
            $arrt7d = $_SESSION["arrt7d"];
            for($i=1;$i<=$diafi;$i++){
                $w = $arrdates[$i-1][4];
                if($w==0){$w=7;}
                if($arrdates[$i-1][1]=="horari"){
                    foreach($arrt7d as $t7){
                        if(($arrdates[$i-1][2]==$t7[0])&&($w==$t7[1])){
                            $arrdates[$i-1][3]=$t7[5];
                        }
                    }
                }
            }
            // (Tercera?) Passada per a treure les hores de pausa dels dies festius, si tenen preferencia sobre els horaris
            if($this->getCampPerIdCampTaula("empresa",$idempresa,"prifestius")==1){
                $rsfest = $this->getDiesFestiusMesPerId($id, $mes, $any);
                foreach($rsfest as $f){
                    $arrdates[$f["dia"]-1][1]="festiu";
                    $arrdates[$f["dia"]-1][2]=0;
                }
            }
            // (Quarta?) Passada per a assignar les hores que corresponguin si hi ha torn de rotació assignat per a aquell dia (que sempre passa per sobre d'un festiu)
            $rsrot = $this->getDb()->executarConsulta('select r.data as dia, t.horespausa as hores from rotacio as r join tipustorn as t on t.idtipustorn = r.idtipustorn where r.idempleat='.$id.' and r.data between date("'.$data.'") and date("'.$datafi.'")');
            foreach($rsrot as $rt){
                $diarot = date('d',strtotime($rt["dia"]));
                $arrdates[$diarot-1][1]="rotacio";
                $arrdates[$diarot-1][3]=$rt["hores"];
            }
            //OBTENIR LES LÍNIES DE LA TAULA EXCEPCIO QUE APLIQUIN AL MES SELECCIONAT (ENTRE LES DATES D'INICI I FINAL) A PARTIR D'AQUI MODIFICAR ARRAY TREIENT LES HORES ELS DIES AMB EXCEPCIO
            $arrexm = [];
            $rse = $this->getDb()->executarConsulta('select * from excepcio where idempleat = '.$id.' and datainici <= "'.$datafi.'" and (datafinal >= "'.$data.'" or datafinal is null)');
            foreach($rse as $e){
                $chrarrexm = array_fill(0,3,0);
                $chrarrexm[0] = $e["idtipusexcep"];
                $chrarrexm[1] = $e["datainici"];
                $chrarrexm[2] = $e["datafinal"];
                $arrexm[] = $chrarrexm;
            }
            // Passada per a treure les hores els dies del mes amb excepcio
            for($i=1;$i<=$diafi;$i++){
                $strdata = strtotime($arrdates[$i-1][0]);
                foreach($arrexm as $ex){
                    if((($strdata<=strtotime($ex[2]))||(empty($ex[2])))&&($strdata>=strtotime($ex[1])))
                    {
                        $arrdates[$i-1][1]="excepcio";
                        $arrdates[$i-1][2]=0;
                    }
                }
            }

            return $arrdates;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function mostraNomUbicacio($idubicacio) {
        $sql = 'select nom from localitzacio where idlocalitzacio = "'.$idubicacio.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $nom = "";
        foreach($rs as $name) $nom = $name["nom"];
        return $nom;
    }

    public function crearDepartament($nom, $idempresa, $ambit) {
        $sql = 'insert into departament (nom,idempresa,ambit,actiu) values ("'.$nom.'",'.$idempresa.',"'.$ambit.'",1)';
        $this->getDb()->executarSentencia($sql);
    }

    public function crearRol($nom, $idempresa, $empleat, $admin, $master) {
        $sql = 'insert into rol (nom,idempresa,esempleat,esadmin,esmaster,actiu) values ("'.$nom.'",'.$idempresa.','.$empleat.','.$admin.','.$master.',1)';
        $this->getDb()->executarSentencia($sql);
    }

    public function esDepartamentAsg($iddpt) {

    }

    public function esRolAsg($idrol) {

    }

    public function cessaDepartament($iddpt) {

    }

    public function cessaRol($idrol) {

    }

    public function eliminaDepartament($iddpt) {

    }

    public function eliminaRol($idrol) {

    }

    public function mostraIdiomesEmp($idempresa) {
        $sql = 'select * from idioma as i join multiidioma as m on m.ididioma = i.ididioma where m.idempresa = "'.$idempresa.'"';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraTotsIdiomes() {
        $sql = 'select * from idioma';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraIdiomesGlobals() {
        $sql = 'select * from idioma where global = 1';
        return $this->getDb()->executarConsulta($sql);
    }

    public function mostraIdEmpresaPerIdEmpleat($idempl) {
        $sql = 'select idempresa from empleat where idempleat = "'.$idempl.'"';
        $id = $this->getDb()->executarConsulta($sql);
        $idempresa = 0;
        foreach ($id as $codi) $idempresa = $codi["idempresa"];
        return $idempresa;
    }

    public function mostraNomHorariPerIdhorari($idhorari) {
        $sql = 'select nom from horaris where idhoraris = '.$idhorari;
        $horari = $this->getDb()->executarConsulta($sql);
        $nomhorari = "";
        foreach ($horari as $codi) $nomhorari = $codi["nom"];
        return $nomhorari;
    }

    public function assignaDepartament($idempl, $iddpt) {
        $dataavui = date("Y-m-d",strtotime("now"));
        $this->getDb()->executarSentencia('UPDATE pertany SET datafi=("'.$dataavui.'"), actiu=0 where id_emp = "'.$idempl.'" and actiu = 1');
        $this->getDb()->executarSentencia('INSERT INTO pertany (id_emp, id_dep, datainici, actiu) VALUES ('.$idempl.','.$iddpt.',"'.$dataavui.'",1)');
    }

    public function assignaRol($idempl, $idrol) {
        $dataavui = date("Y-m-d",strtotime("now"));
        $this->getDb()->executarSentencia('UPDATE assignat SET datafi=("'.$dataavui.'"), actiu=0 where id_emp = "'.$idempl.'" and actiu = 1');
        $this->getDb()->executarSentencia('INSERT INTO assignat (id_emp, id_rol, datainici, actiu) VALUES ('.$idempl.','.$idrol.',"'.$dataavui.'",1)');
    }

    public function tePassword($idempl) {
        $sql = 'SELECT contrasenya FROM empleat where idempleat = "'.$idempl.'" and (contrasenya is null or contrasenya = "")';
        if(!empty($this->getDb()->executarConsulta($sql))) return true;
        else return false;
    }

    public function mostraTipusActivitats() {
        return $this->getDb()->executarConsulta('select * from tipusactivitat');
    }

    public function mostraTipusActivitatsGlobals() {
        return $this->getDb()->executarConsulta('select * from tipusactivitat where global=1');
    }

    public function mostraTipusActivitatsPerEmpresa($idempresa) {
        return $this->getDb()->executarConsulta('select * from tipusactivitat as t join realitza as r on t.idtipusactivitat = r.idtipusactivitat where r.idempresa = '.$idempresa.'');
    }

    public function mostraTipusActivitatsEspecialsPerEmpresa($idempresa) {
        return $this->getDb()->executarConsulta('select * from tipusactivitat as t join realitza as r on t.idtipusactivitat = r.idtipusactivitat where r.idempresa = '.$idempresa.' and t.nom<>"Normal"');
    }

    public function teMenuActivitats($idempresa) {
        $sql = 'select menuentsort from empresa where idempresa = '.$idempresa;
        $temenu = false;
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $chk) if($chk["menuentsort"]==1) $temenu = true;
        return $temenu;
    }

    public function getLogoIn($idempresa, $idrealitza) {
        $ruta = "";
        $path = $this->getDb()->executarConsulta('select ruta_logo_ent from realitza where idrealitza = '.$idrealitza.'');
        foreach($path as $text) $ruta=$text["ruta_logo_ent"];
        return $ruta;
    }

    public function getLogoOut($idempresa, $idrealitza) {
        $ruta = "";
        $path = $this->getDb()->executarConsulta('select ruta_logo_sort from realitza where idrealitza = '.$idrealitza.'');
        foreach($path as $text) $ruta=$text["ruta_logo_sort"];
        return $ruta;
    }

    public function getEmpSex($idempl) {
        $rs = $this->getDb()->executarConsulta('select sexe from empleat where idempleat = '.$idempl);
        $sex = "";
        foreach($rs as $dada)$sex = $dada["sexe"];
        return $sex;
    }

    public function welcome($sexemp) {
        $welcome = "";
        if($sexemp=="h")$welcome="Benvingut";
        else if($sexemp=="d")$welcome="Benvinguda";
        else $welcome="Benvingut/da";
        return $welcome;
    }

    public function getLogoidRealitza($idempresa, $pos) {
        $idconcepte = 0;
        $rs = $this->getDb()->executarConsulta('select idconcepte'.$pos.' from empresa where idempresa = '.$idempresa.'');
        foreach($rs as $id)$idconcepte=$id["idconcepte".$pos];
        return $idconcepte;
    }

    public function getNomidRealitza($idrealitza) {
        $nom = "";
        $rs = $this->getDb()->executarConsulta('select nom from tipusactivitat as t join realitza as r on r.idtipusactivitat = t.idtipusactivitat where r.idrealitza = '.$idrealitza);
        foreach($rs as $name)$nom=$name["nom"];
        return $nom;
    }

    public function getNomidTipusActivitat($idtipusactivitat) {
        $nom = "";
        $rs = $this->getDb()->executarConsulta('select nom from tipusactivitat  where idtipusactivitat = '.$idtipusactivitat);
        foreach($rs as $name)$nom=$name["nom"];
        return $nom;
    }

    public function getidActivitatidRealitza($idempresa,$pos) {
        $idconcepte = 0;
        $rs = $this->getDb()->executarConsulta('select idconcepte'.$pos.' from empresa where idempresa = '.$idempresa.'');
        foreach($rs as $id)$idconcepte=$id["idconcepte".$pos];
        $idactivitat = $this->getCampPerIdCampTaula("realitza",$idconcepte,"idtipusactivitat");
        return $idactivitat;
    }

    public function getDescidActivitat($idrealitza) {
        $desc = "";
        $rs = $this->getDb()->executarConsulta('select t.descripcio from tipusactivitat as t join realitza as r on r.idtipusactivitat = t.idtipusactivitat where r.idrealitza = '.$idrealitza);
        foreach($rs as $d)$desc = $d["descripcio"];
        return $desc;
    }

    public function teEdicioConceptes($idempresa) {
        $sql = 'select editconcepts from empresa where idempresa = '.$idempresa;
        $editconcepts = false;
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $chk) if($chk["editconcepts"]==1) $editconcepts = true;
        return $editconcepts;
    }

    public function teEdicioIcones($idempresa) {
        $sql = 'select editiconlogo from empresa where idempresa = '.$idempresa;
        $editiconlogo = false;
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $chk) if($chk["editiconlogo"]==1) $editiconlogo = true;
        return $editiconlogo;
    }

    public function teEdicioIdioma($idempresa) {
        $sql = 'select editselflang from empresa where idempresa = '.$idempresa;
        $editselflang = false;
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $chk) if($chk["editselflang"]==1) $editselflang = true;
        return $editselflang;
    }

    public function teEdicioPropia($idempresa) {
        $sql = 'select editselfprof from empresa where idempresa = '.$idempresa;
        $editselfprof = false;
        $rs = $this->getDb()->executarConsulta($sql);
        foreach($rs as $chk) if($chk["editselfprof"]==1) $editselfprof = true;
        return $editselfprof;
    }

    public function mostraNomPerIdTaula($id, $taula) {
        $rs = $this->getDb()->executarConsulta('select nom from '.$taula.' where id'.$taula.' = '.$id);
        $nom = "";
        foreach($rs as $r) $nom=$r["nom"];
        return $nom;
    }

    public function mostraSetmanesMesAny($any, $mes) {
        $setm = [];

        $m = $mes;
        if($mes<10) $m = "0".$mes;

        $primerdiames = date('Y-m-d',strtotime($any."-".$m."-01"));
        $setm1 = date('W',strtotime($primerdiames));
        $ultimdiames = date('Y-m-d',strtotime($any.'-'.$m.'-28'));
        while(date('m',strtotime($ultimdiames))==$mes) {$ultimdiames = date('Y-m-d',strtotime($ultimdiames." + 1 days"));}
        $ultimdiames = date('Y-m-d',strtotime($ultimdiames." - 1 days"));
        $setmf = date('W',strtotime($ultimdiames));
        if($setmf<$setm1) $setmf = 53;
        for($i=$setm1;$i<=$setmf;$i++)
        {
            $setm[]=$i;
        }
        return $setm;
    }


    public function imprimeixHoraPerIdDiaHora($id, $dia, $hora, $lng) {
        try{
            $disp = 0;
            $sql = 'select * from activitat where idempleat = '.$id.' and datainici = "'.$dia.'" and hour(horainici)<="'.$hora.'" and time(horafi)>="'.$hora.':01"';//'';
            $rs = $this->getDb()->executarConsulta($sql);
            $horafinal = "";
            $horainici = "";
            $horafiant = "";
            $nolab = 0;
            $idactiv = 0;
            $tipus = "";
            $horaini = "";
            $horafi = "";
            $bckcol = "";
            $abrv = "";
            $title = "";

            $bidata = $this->esTornBidata($id,$dia);

            $diaant = date('Y-m-d',strtotime($dia." - 1 days"));
            $bidataant = $this->esTornBidata($id,$diaant);
            if($bidataant==1){
                $idrotant = $this->terotacio($id,$diaant);
                if($idrotant>0) {
                    $horafiant = number_format((float) date('H',strtotime($this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotant,"idtipustorn"),"horasortida"))));
                    $abrv = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotant,"idtipustorn"),"abrv");
                    $title = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotant,"idtipustorn"),"horaentrada")." a ".$this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrotant,"idtipustorn"),"horasortida");
                }
                else {
                    $tornant = $this->getTornPerIdDia($id, $diaant);
                    if(!empty($tornant))
                    {
                        $horafiant = number_format((float) substr($tornant->getHorafi(),0,2),0);
                        $abrv = $tornant->getDiasetm();
                        $title = $tornant->getHoraini()." a ".$tornant->getHorafi();
                    }
                }
            }
            $idrot = $this->terotacio($id,$dia);
            if($idrot>0) {
                $horafinal = number_format((float) date('H',strtotime($this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horasortida"))));
                $horainici = number_format((float) date('H',strtotime($this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horaentrada"))));
                $abrv = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"abrv");
                $nolab = 1;
                $title = $this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horaentrada")." a ".$this->getCampPerIdCampTaula("tipustorn",$this->getCampPerIdCampTaula("rotacio",$idrot,"idtipustorn"),"horasortida");
            }
            else {
                $torn = $this->getTornPerIdDia($id, $dia);
                if(!empty($torn))
                {
                    $horafinal = number_format((float) substr($torn->getHorafi(),0,2),0);
                    $horainici = number_format((float) substr($torn->getHoraini(),0,2),0);
                    $abrv = $torn->getDiasetm();
                    $title = $torn->getHoraini()." a ".$torn->getHorafi();
                    $nolab = 1;
                }
                else{
                    if(($bidataant==1)&&($hora<abs($horafiant))) {echo '<td class="long" style="font-size: 10px; line-height: 15px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;" title="'.$title.'">'.substr($this->getCampPerIdCampTaula("empleat",$id,"nom"),0,1).'</td>'; $disp=1;}
                    else {echo '<td class="long" style="height: 25px; margin: 0; border: 1px solid white; white-space: nowrap; border-top-width: 0px;background-color: grey" title="Dia no laborable"></td>';   }
                }
            }

            if((($horafinal!="")&&($horainici!=""))){
                foreach($rs as $r)
                { $idactiv=$r["idactivitat"];$tipus=$r["idtipus"];$horaini=substr($r["horainici"],0,5);$horafi=substr($r["horafi"],0,5);
                    switch($tipus){case 5: $bckcol = "rgb(255,128,128);"; break; case 6: $bckcol = "rgb(255,255,128);"; break; case 7: $bckcol = "rgb(128,255,128);"; break; }
                }
                if($tipus<>0) echo '<td class="long" style="height: 25px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px; cursor: pointer; background-color: '.$bckcol.'"'
                    . ' onclick="confElimActiv('.$idactiv.','."'".$this->__($lng,$this->getDescidActivitat($tipus))."'".','."'".$this->mostraNomEmpPerId($id)."'".');"'
                    . ' title="'.$this->__($lng,$this->getDescidActivitat($tipus)).'&#10;De '.$horaini.' a '.$horafi.'&#10;'.$this->__($lng,"Click per a Eliminar").'"></td>';
                else{
                    if(
                        (($bidata==0)&&($bidataant==0)&&(($hora<$horainici)||($hora>=$horafinal)))
                        ||
                        (($bidata==1)&&($bidataant==0)&&(($hora<$horainici)))
                        ||
                        (($bidata==0)&&($bidataant==1)&&(($hora>abs($horafiant-1)))&&((($hora<$horainici))||(($hora>=$horafinal))))
                        ||
                        (($bidata==1)&&($bidataant==1)&&(($hora>abs($horafiant-1)))&&(($hora<$horainici)))
                    )
                    {echo '<td class="long" style="height: 25px; margin: 0; border: 1px solid white; white-space: nowrap; border-top-width: 0px;background-color: grey" title="Hora no laborable"></td>';}
                    else {echo '<td class="long" style="font-size: 10px; line-height: 15px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;" title="'.$title.'">'.substr($this->getCampPerIdCampTaula("empleat",$id,"nom"),0,1).'</td>'; $disp=1;}
                }
            }
            return $disp;
        }catch(Exception $ex){echo $ex->getMessage();}
    }

    public function eliminaActivitat($idact) {
        $sql = 'delete from activitat where idactivitat = '.$idact;
        $this->getDb()->executarSentencia($sql);
    }

    public function getAmbitDptActiuPerId($id) {
        $sql = 'select ambit from departament as d join pertany as p on p.id_dep = d.iddepartament where p.id_emp = '.$id.' and p.actiu = 1';
        $rs = $this->getDb()->executarConsulta($sql);
        $ambit = "";
        foreach ($rs as $a) $ambit = $a["ambit"];
        return $ambit;
    }

    public function getNomDptActiuPerId($id) {
        $sql = 'select nom from departament as d join pertany as p on p.id_dep = d.iddepartament where p.id_emp = '.$id.' and p.actiu = 1';
        $rs = $this->getDb()->executarConsulta($sql);
        $nom = "";
        foreach ($rs as $a) $nom = $a["nom"];
        return $nom;
    }

    public function getRolActiuPerId($id) {
        $sql = 'select nom from rol as r join assignat as a on a.id_rol = r.idrol where a.id_emp = '.$id.' and a.actiu = 1';
        $rs = $this->getDb()->executarConsulta($sql);
        $nom = "";
        foreach ($rs as $a) $nom = $a["nom"];
        return $nom;
    }

    public function getUbicacionsPerId($id) {
        $today = date('Y-m-d',strtotime('today'));
        $sql = 'select u.nom as nom from situat as s join localitzacio as u on u.idlocalitzacio = s.idlocalitzacio where s.idempleat = '.$id.' and date(s.datainici)<="'.$today.'" and ((s.datafi is null) or (date(datafi)>="'.$today.'"))';
        $rs = $this->getDb()->executarConsulta($sql);
        $ubic = "";
        $i = 0;
        foreach ($rs as $u) {
            if($i>0) $ubic.=", ";
            $ubic.= $u["nom"];
            $i++;
        }
        return $ubic;
    }

    public function dirSexeLletra($lletra) {
        $sexe = "";
        if($lletra=="h") $sexe="Home";
        if($lletra=="d") $sexe="Dona";
        return $sexe;
    }

    public function getEmpAfil($idemp) {
        $sql = 'select numafiliacio from empleat where idempleat like "'.$idemp.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["numafiliacio"];
        return $res;
    }

    public function getEmpDni($idemp) {
        $sql = 'select dni from empleat where idempleat like "'.$idemp.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["dni"];
        return $res;
    }

    public function mostraCTreballEmpresa($empresa) {
        $sql = 'select centre_treball from empresa where idempresa like "'.$empresa.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["centre_treball"];
        return $res;
    }

    public function mostraCccEmpresa($empresa) {
        $sql = 'select ccc from empresa where idempresa like "'.$empresa.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["ccc"];
        return $res;
    }

    public function mostraCifEmpresa($empresa) {
        $sql = 'select cif from empresa where idempresa like "'.$empresa.'"';
        $rs = $this->getDb()->executarConsulta($sql);
        $res = "";
        foreach($rs as $row) $res = $row["cif"];
        return $res;
    }

    public function calculaHoresActivitatPerIdDiaIdtipus($id, $data, $idactiv) {
        $hores = 0;
        $marcatgesdia = $this->seleccionaMarcatgesPerIdDia($id, $data);
        $llistamarcdia = new ArrayObject();
        $nummarcdia = 0;
        foreach ($marcatgesdia as $rg)
        {
            $marcatge = new Marcatge(substr($rg["datahora"],11,5), $rg["id_tipus"], $rg["entsort"]);
            $llistamarcdia->append($marcatge);
            $nummarcdia++;
        }
        for ($a=0;$a<$nummarcdia;$a++)
        {
            if(($llistamarcdia[$a]->getIdtipus()==$idactiv))
            {
                if(($a==0))
                {
                    $hores+= $this->calculaHoresActivitatsPerIdDiaIdtipusInici($id, $data, $llistamarcdia[$a]->getHora());
                }
                else if(($a>0)&&($llistamarcdia[$a]->getEntsort()==0))
                {
                    $hores+= $this->calculaHoresActivitatsPerInterval($llistamarcdia[$a-1]->getHora(),$llistamarcdia[$a]->getHora());
                }
                else if($a==($nummarcdia-1))
                {
                    $hores+= $this->calculaHoresActivitatsPerIdDiaIdtipusFinal($id, $data, $llistamarcdia[$a]->getHora());
                }
            }
        }
        return $hores;
    }

    public function calculaHoresActivitatsAdescomptarPerIdDia($id, $data) {
        $hores = 0;
        $marcatgesdia = $this->seleccionaMarcatgesPerIdDia($id, $data);
        $llistamarcdia = new ArrayObject();
        $nummarcdia = 0;
        foreach ($marcatgesdia as $rg)
        {
            $marcatge = new Marcatge(substr($rg["datahora"],11,5), $rg["id_tipus"], $rg["entsort"]);
            $llistamarcdia->append($marcatge);
            $nummarcdia++;
        }
        for ($a=0;$a<$nummarcdia;$a++)
        {
            if(($llistamarcdia[$a]->getIdtipus()<>4))
            {
                if(($a>0)&&($llistamarcdia[$a]->getEntsort()==0))
                {
                    $hores+= $this->calculaHoresActivitatsPerInterval($llistamarcdia[$a-1]->getHora(),$llistamarcdia[$a]->getHora());
                }
            }
        }
        return $hores;
    }

    public function calculaDiesEspecialsPerIdMesAnyIdExcep($idemp, $mes, $any, $tipusexcep) {
        $diesespecials = 0;
        $undiames = new DateInterval('P1D');
        $m = "";
        if($mes<10) $m = "0".$mes;
        else $m = $mes;
        $primerdiames = new DateTime($any.'-'.$m.'-01');
        for($i=0;((date("m",strtotime($primerdiames->format('Y-m-d')))==$mes));$i++)//$i<31
        {
            if(!empty($this->esBaixaPerIdDia($idemp, $primerdiames->format("Y-m-d"),$tipusexcep)))$diesespecials++;
            $primerdiames->add($undiames);
        }
        return $diesespecials;
    }

    public function selectPrimerMarcatgeActiu($idemp)
    {
        $sql = 'SELECT primermarcatge from empresa WHERE idempresa=?';
        $parameters = array($idemp);


        $res = $this->getDb()->executarConsultaParametrizada($sql, $parameters);


        return $res[0]["primermarcatge"];

    }

       public function seleccionaHoresTeoriques($id, $any) {

        $hours_date = [];

        $year = $any;
        //HORAS TEORICAS TOTALES, SIN DESCONTAR LOS FESTIVOS Y LAS EXCEPCIONES
        $sql = "
        SELECT r.data as data, tt.horestreball as hours
        FROM rotacio AS r
            LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
        WHERE r.idempleat = $id AND YEAR(r.data) = $year
        ";
        $rs = $this->getDb()->executarConsulta($sql);
        foreach ($rs as $valor) {
            $hours_date[] = [
                $valor["data"] => $valor["hours"]
            ];
        }

        //SI DE ROTACIO NO TRAE HORAS SIGNIFICA QUE LOS DIAS NO ESTAN EN ROTACIO Y TIPUSTORN SINO QUE ESTAN EN TORN Y HORARIS
        if (empty($hours_date)) {

            $sql = "
            select t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.diasetmana as week_day
            from torn as t
                join horaris as h on h.idhoraris = t.idhorari
                join quadrant as q on q.idhorari = h.idhoraris
                join empleat as e on q.idempleat = e.idempleat
            where e.idempleat = $id and (($year BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL))
            ";

            $rs = $this->getDb()->executarConsulta($sql);

            //SI EL EMPLEADO NO TIENE HORARIO ENTRADA O SALIDA DEFINIDO
            if($rs[0]['end_day'] === null)
            {
                //DIAS
                if (date('L', strtotime("$year-01-01"))) $daysInYear = 366; // Año bisiesto
                else $daysInYear = 365; // Año no bisiesto

                for ($day = 0; $day <= $daysInYear - 1; $day++) {
                    $date = date("Y-m-d", strtotime("$year-01-01 +$day days"));


                    // Verifica si el día es sábado (6) o domingo (0)
                    /*
                     VALORES RETORNADOS POR EL METODO
                    0: Domingo
                    1: Lunes
                    2: Martes
                    3: Miércoles
                    4: Jueves
                    5: Viernes
                    6: Sábado
                     */

                    // Verifica si el día es sábado (6) o domingo (0)
                    $dayOfWeek = date('w', strtotime($date));
                    //LA BASE DE DATOS TIENE LOS VALORES ASI:
                    /*
                     1:lunes
                     2:martes
                     3:miercoles
                     4:jueves
                     5:viernes
                     6:sabado
                     7:domingo
                    ENTONCES CAMBIAMOS DEL METODO EL VALOR DE 0 DOMINGO A 7 DOMINGO DE LA BASE DE DATOS PARA COMPARAR BIEN
                     */

                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                    {
                        if ($value['week_day'] == $dayOfWeek) {
                            //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                            if ($value['hours'] != 0) {
                                $hours_date[] = [$date => $value['hours']];
                            }
                        }
                    }
                }


                // SI TIENE HORARIO ENTRADA Y SALIDA DEFINIDA SI
            } else {

                //INTERVALO DE DIAS
                $torn_days_interval = [];
                $torn_days_interval = [
                    'start_day' => $rs[0]["start_day"],
                    'end_day' => $rs[0]["end_day"]
                ];

                //SACO TODOS LOS DIAS TORN SE DE SUS INTERVALOS RECORRIENDOLO CON WHILE
                $current_date = strtotime($torn_days_interval['start_day']);
                $end_date_timestamp = strtotime($torn_days_interval['end_day']);

                $torn_days = [];
                while ($current_date <= $end_date_timestamp) {
                    $torn_days[] = date('Y-m-d', $current_date);
                    $current_date = strtotime('+1 day', $current_date);
                }

                //TOMO LOS VALORES DE SOLO ESTE AÑO
                $torn_days_year = [];
                foreach ($torn_days as $torn_day)
                {
                    $day_array = date_parse($torn_day);
                    if ($day_array['year'] == $year) $torn_days_year[] = $torn_day;
                }

                foreach ($torn_days_year as $day) {
                    //SACO EL DIA DE LA SEMANA DE DAY
                    $dayOfWeek = date('w', strtotime($day));
                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                        if ($value['week_day'] == $dayOfWeek) {

                            if ($value['hours'] != 0 && $day !== null) {
                                $hours_date[] = [$day => $value['hours']];
                            } else {
                                $hours_date[] = [$day => 0];
                            }
                        }

                }

            }

        }

        //SACO DIAS FESTIVOS Y DESPUES VERIFICO LOS DIAS QUE HAY EN HORAS TEORICAS Y HAGO VALOR 0 EN ESOS DIAS
        //DESCUENTO LOS DIAS FESTIVOS, BUSCANDO EL DIA FESTIVO Y DEJANDOLO EN 0
        $sql_holiday = "
            SELECT f.dataany as days
            FROM festiu AS f
                join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio
                join situat as s on s.idlocalitzacio = l.idlocalitzacio
                join empleat as e on e.idEmpleat = s.idempleat
            where YEAR(f.dataany) = $year AND YEAR(s.datainici) = $year AND YEAR(s.datafi) = $year
        ";
        $holiday_days = [];
        $rs_holiday = $this->getDb()->executarConsulta($sql_holiday);
        foreach ($rs_holiday as $valor) $holiday_days[] = $valor["days"];

        //HAGO VALOR A 0 LAS HORAS DE ESTAS FECHAS FESTIVOS
        foreach ($holiday_days as $holiday_day)
        {
            $nuevo_valor = 0;
            foreach ($hours_date as &$item)
            {
                // Verificar si la fecha existe en el arreglo actual
                if (isset($item[$holiday_day])) {
                    $item[$holiday_day] = $nuevo_valor;
                }
            }
        }


        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
            SELECT e.datainici as start_day, e.datafinal as end_day
            FROM excepcio as e
                JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
            WHERE e.idempleat = $id AND YEAR(e.datainici) = $year AND YEAR(e.datafinal) = $year AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)      
        ";

        $exception_days_interval = [];
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);

        foreach ($rs_exception as $valor) $exception_days_interval[] = ['start_day' => $valor["start_day"], 'end_day' => $valor["end_day"]];

        $exception_days = [];

        //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
        foreach ($exception_days_interval as $e_d_i)
        {
            $current_date = strtotime($e_d_i['start_day']);
            $end_date_timestamp = strtotime($e_d_i['end_day']);

            if ($e_d_i['start_day'] !== $e_d_i['end_day'])
            {
                while ($current_date <= $end_date_timestamp) {
                    $exception_days[] = date('Y-m-d', $current_date);
                    $current_date = strtotime('+1 day', $current_date);
                }
            } else {
                $exception_days[] = $e_d_i['start_day'];
            }
        }

        //YA TENIENDO LOS DIAS EXPCECION, ENTONCES LOS BUSCO EN LAS HORAS Y LE APLICO VALOR DE 0
        foreach ($exception_days as $exception_day)
        {
            $new_value = 0;
            foreach ($hours_date as &$item)
            {
                // Verificar si la fecha existe en el arreglo actual
                if (isset($item[$exception_day])) {
                    $item[$exception_day] = $new_value;
                }
            }
        }

        $horesteoany = array_reduce($hours_date, function($carry, $item) {
            $carry += array_sum($item);
            return $carry;
        }, 0);

        return $horesteoany;

    }

    public function monthlyEmployeeCalendar($id, $any, $mes, $percent, $lng) {

        $special_days = [];

        //ME TRAIGO LOS PREFESITUS Y LOS MARCAFESTIUS PARA DETERMINAR LOS FESTIVOS PRIORITARIOS DE LA EMPRESA Y CONFIGURACIONES ADICIONALES
        $idempresa = $this->getCampPerIdCampTaula("empleat",$id,"idempresa");
        $prifestius_marcafestius = [];
        $sql_company = "
        SELECT prifestius, marcafestius
        FROM empresa
        WHERE idempresa = $idempresa
        ";
        $rs_company = $this->getDb()->executarConsulta($sql_company);

        foreach ($rs_company as $valor)
        {
            $prifestius = $valor['prifestius'];
            $marcafestius = $valor['marcafestius'];
        }

        //TRAIGO TODOS LOS DIAS DEL AÑO
        $year = $any; // Cambia el año según sea necesario
        if (date('L', strtotime("$year-01-01"))) $daysInYear = 366; // Año bisiesto
        else $daysInYear = 365; // Año no bisiesto
        $daysOfYear = [];
        for ($day = 0; $day <= $daysInYear - 1; $day++) {
            $date = date("Y-m-d", strtotime("$year-01-01 +$day days"));
            $daysOfYear[] = [
                'day' => $date,
                'shift' => '',
                'start_time' => '',
                'end_time' => '',
                'title' => 'title="'.$this->__($lng,"No laborable").'"',
                'style' => 'style="background-color: rgb(128,128,128); color: white; cursor: pointer"',
                'onclick' => 'onclick="mostraCreaRotacioDia('.$id.",'".$date."',".');"',
                'type_exception' => '',
                'rgb' => ''
            ];
        }


        // Ahora, $datesArray contiene todas las fechas del año especificado, incluyendo años bisiestos

        //TRAIGO LOS DIAS QUE DEBE TRABAJAR EL EMPLEADO (ROTACIO) CON SU RESPECTIVO HORARIO
        $sql = "
    SELECT r.idrotacio as idrotacio, r.data as data, tt.nom as nom, tt.horaentrada as horaEntrada, tt.horasortida as horaSalida, tt.horestreball, tt.colorbckg as colorbckg, tt.colortxt as colortxt, tt.abrv as abrv 
    FROM rotacio AS r
        LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
    WHERE r.idempleat = $id AND YEAR(r.data) = $any
    ORDER BY r.data
    ";

        $rs = $this->getDb()->executarConsulta($sql);
        // AGREGO LAS PROPIEDADES DE DIAS DE TRABAJO A LOS DIAS DEL AÑO
        foreach ($rs as $valor) {
            foreach ($daysOfYear as &$item)
            {
                if ($valor["data"] === $item["day"])
                {
                    $bckg = $valor["colorbckg"];
                    $color = $valor["colortxt"];
                    $abr = $valor["abrv"];

                    $item['shift'] = $valor["nom"];
                    $item["start_time"] = $valor["horaEntrada"];
                    $item["end_time"] = $valor["horaSalida"];
                    $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$valor["nom"].'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($valor["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($valor["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$valor["horestreball"].'"';;
                    $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                    $item["onclick"] = 'onclick="mostraEditaRotacioDia('.$valor['idrotacio'].');"';
                    $item['type_exception'] = '';
                    $item['rgb'] = '';
                }
            }
        }

        if (empty($rs))
        {
            $sql = "
            select h.nom as nom_h, t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.horaentrada as horaEntrada, t.horasortida as horaSalida, t.diasetmana as week_day
            from torn as t
                join horaris as h on h.idhoraris = t.idhorari
                join quadrant as q on q.idhorari = h.idhoraris
            where idempleat = $id and (($year BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL))
            ";

            $rs = $this->getDb()->executarConsulta($sql);
            //SI EL EMPLEADO NO TIENE HORARIO ENTRADA O SALIDA DEFINIDO
            if($rs[0]['end_day'] === null)
            {
                foreach ($daysOfYear as &$item)
                {

                    // Verifica si el día es sábado (6) o domingo (0)
                    /*
                     VALORES RETORNADOS POR EL METODO
                    0: Domingo
                    1: Lunes
                    2: Martes
                    3: Miércoles
                    4: Jueves
                    5: Viernes
                    6: Sábado
                     */
                    $dayOfWeek = date('w', strtotime($item['day']));

                    //LA BASE DE DATOS TIENE LOS VALORES ASI:
                    /*
                     1:lunes
                     2:martes
                     3:miercoles
                     4:jueves
                     5:viernes
                     6:sabado
                     7:domingo
                    ENTONCES CAMBIAMOS DEL METODO EL VALOR DE 0 DOMINGO A 7 DOMINGO DE LA BASE DE DATOS PARA COMPARAR BIEN
                     */
                    if($dayOfWeek == 0) $dayOfWeek = 7;

                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                    {
                        if ($value['week_day'] == $dayOfWeek)
                        {
                            //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                            if ($value['hours'] != 0)
                            {

                                $bckg = '';
                                $color = '';
                                $abr = '';

                                $item['shift'] = $this->__($lng,"Horari");
                                $item["start_time"] = $value["horaEntrada"];
                                $item["end_time"] = $value["horaSalida"];
                                $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$this->__($lng,"Horari").'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($value["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($value["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$value["hours"].'"';;
                                $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                $item["onclick"] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                                $item['type_exception'] = '';
                                $item['rgb'] = '';
                            }

                        }
                    }
                }
                // SI TIENE HORARIO ENTRADA Y SALIDA DEFINIDA SI
            }
            else {
                //INTERVALO DE DIAS
                $torn_days_interval = [];


                //SOLO GUARDA PRIMER ELEMENTO  ** ASI FUNCIONABA  **
                
                
                /*
                $torn_days_interval = [
                    'start_day' => $rs[0]["start_day"],
                    'end_day' => $rs[0]["end_day"]
                ];*/


                // EN ESTE MOMENTO TRAIAMOS SOLO EL PRIMER HORARIO
                // AHORA VAMOS  A NECESITAR CARGAR TODOS LOS HORARIOS
                // ULTIMO  HORARIO SOBREESCRIBE DIAS REPETIDOS CON DEL RESTO DE HORARIOS

                //UNIQUES HORARIS
                $sql_uniques = "
                select 	
                MAX(idquadrant), t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.horaentrada as horaEntrada, t.horasortida as horaSalida, t.diasetmana as week_day
                from torn as t
                    join horaris as h on h.idhoraris = t.idhorari
                    join quadrant as q on q.idhorari = h.idhoraris
                where idempleat = $id and (($year BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL))
                GROUP BY(idquadrant)
                ";
    
                $rs_uniques = $this->getDb()->executarConsulta($sql_uniques);
                foreach($rs_uniques as $item) $torn_days_interval[] = ['start_day' => $item["start_day"], 'end_day' => $item["end_day"]];   
                


                $torn_days = [];
                foreach($torn_days_interval as $item)
                {

                    //SACO TODOS LOS DIAS TORN SE DE SUS INTERVALOS RECORRIENDOLO CON WHILE
                    $current_date = strtotime($item['start_day']);
                    $end_date_timestamp = strtotime($item['end_day']);
                
                    while ($current_date <= $end_date_timestamp) {
                        $torn_days[] = date('Y-m-d', $current_date);
                        $current_date = strtotime('+1 day', $current_date);
                    }

                }

                //TOMO LOS VALORES DE SOLO ESTE AÑO
                $torn_days_year = [];
                foreach ($torn_days as $torn_day)
                {

                    $day_array = date_parse($torn_day);
                    if ($day_array['year'] == $year) $torn_days_year[] = $torn_day;

                }                



                foreach ($daysOfYear as &$item) {

                    foreach ($torn_days_year as $day) {

                        //SACO EL DIA DE LA SEMANA DE DAY
                        $dayOfWeek = date('w', strtotime($day));


                        //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                        foreach ($rs as $value) 


                            //VERIFICA
                            //1. QUE SEA EL MISMO DIA DE LA SEMANA (PARA PINTAR LAS HORAS A TRABAJAR Y EL HORARIO)
                            //2. VERIFICA QUE ESE DIA SI SE TRABAJE O SEA QUE LAS HORAS A TRABAJAR NO SEAN 0. (CASO COMUN SABADO Y DOMINGO)
                            // 3. QUE EL DIA DEL ARRAY CALENDARIO SEA IGUAL AL DIA DEL HORARIO QUE VIENE

                            if ($value['week_day'] == $dayOfWeek) {
                                if ($value['hours'] != 0) {
                                    
                                    if ($item['day'] == $day)
                                    {

                                        if ( (strtotime($day) >= strtotime($value['start_day'])) && (strtotime($day) <= strtotime($value['end_day'])) ) {
                                        
                                            $title = $value['nom_h'];
                                            //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                                            $bckg = '';
                                            $color = '';
                                            $abr = '';

                                            $item['shift'] = $this->__($lng,"Horari");
                                            $item["start_time"] = $value["horaEntrada"];
                                            $item["end_time"] = $value["horaSalida"];
                                            $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$this->__($lng,$title).'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($value["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($value["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$value["hours"].'"';;
                                            $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                            $item["onclick"] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                                            $item['type_exception'] = '';
                                            $item['rgb'] = '';

                                        }
                                    }
                                }
                            }



                    }


                }

            }
        }


        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
        SELECT e.datainici as start_day, e.datafinal as end_day, t.nom as nom, t.r as r, t.g as g, t.b as b, t.idtipusexcep as idtipusexcep, e.idexcepcio as idexcepcio 
        FROM excepcio as e
            JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
        WHERE e.idempleat = $id AND YEAR(e.datainici) = $any AND YEAR(e.datafinal) = $any AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)
        ";
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);



        $uniques_excepcio = [];
        if (!empty($rs_exception))
        {
            $exception_days_interval = [];

            foreach ($rs_exception as $valor) {

                $array_rgb = [ $valor["r"], $valor["g"], $valor["b"] ];
                $rgb = implode(',', $array_rgb);

                $exception_days_interval[] = [
                    'start_day' => $valor["start_day"],
                    'end_day' => $valor["end_day"],
                    'type_exception' => $valor["nom"],
                    'rgb' => $rgb,
                    'idtipusexcep' => $valor['idtipusexcep'],
                    'idexcepcio' => $valor['idexcepcio']
                ];

            }
            $exception_days = [];
            //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
            foreach ($exception_days_interval as $e_d_i)
            {
                $current_date = strtotime($e_d_i['start_day']);
                $end_date_timestamp = strtotime($e_d_i['end_day']);

                if ($e_d_i['start_day'] !== $e_d_i['end_day'])
                {
                    while ($current_date <= $end_date_timestamp) {
                        $exception_days[] = [
                            'day' => date('Y-m-d', $current_date),
                            'type_exception' => $e_d_i["type_exception"],
                            'rgb' => $e_d_i["rgb"],
                            'idtipusexcep' => $e_d_i['idtipusexcep'],
                            'idexcepcio' => $e_d_i['idexcepcio'],
                            'start_day' => $e_d_i["start_day"],
                            'end_day' => $e_d_i["end_day"],
                        ];
                        $current_date = strtotime('+1 day', $current_date);
                    }
                } else {
                    $exception_days[] = [
                        'day' => $e_d_i['start_day'],
                        'type_exception' => $e_d_i["type_exception"],
                        'rgb' => $e_d_i["rgb"],
                        'idtipusexcep' => $e_d_i['idtipusexcep'],
                        'idexcepcio' => $e_d_i['idexcepcio'],
                        'start_day' => $e_d_i["start_day"],
                        'end_day' => $e_d_i["end_day"],
                    ];
                }
            }


            //YA TENIENDO LOS DIAS EXPCECION, ENTONCES LOS BUSCO EN LAS HORAS Y LE APLICO VALOR DE 0

            foreach ($exception_days as $exception_day)
            {
                foreach ($daysOfYear as &$item)
                {
                    if ($item['day'] === $exception_day['day']) {
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] =  'title="'.$this->__($lng, $exception_day['type_exception']).'"';
                        $item['style'] = ' style="background-color: rgb('.$exception_day['rgb'].'); cursor: pointer;" ';
                        $item['onclick'] = 'onclick="mostraExcep('.$exception_day["idexcepcio"].','.$exception_day["idtipusexcep"].",'".$exception_day["start_day"]."','".$exception_day["end_day"]."'".');"';
                        $item['type_exception'] = $exception_day['type_exception'];
                        $item['rgb'] = $exception_day['rgb'];
                        $item['idtipusexcep'] = $exception_day['idtipusexcep'];
                        $item['idexcepcio'] = $exception_day['idexcepcio'];
                    }
                }




                // CUENTO LOS DIAS EXCEPCION POR TIPO, PRIMERO CREO LOS UNIQUES
                // Determinar el semestre al que pertenece el día de excepción
                $exception_date = strtotime($exception_day['day']);
                $semester = (date('n', $exception_date) <= 6) ? 1 : 2;
                $idtipusexcep = $exception_day["idtipusexcep"];
                if(!isset($uniques_excepcio['idtipusexcep'])) $uniques_excepcio[$idtipusexcep] = [
                    'type_excepcio' => $exception_day['type_exception'],
                    'rgb' => $exception_day['rgb'],
                    'count_days' => 0,
                    'semester1' => 0,
                    'semester2' => 0
                ];
            }

            //cantidad dias excepcion por tipo, total y por semestre.
            foreach ($uniques_excepcio as $key_u => $unique_excepcio)
            {
                foreach ($exception_days as $exception_day)
                {
                    if ($key_u == $exception_day["idtipusexcep"])
                    {
                        // Determinar el semestre al que pertenece el día de excepción
                        $exception_date = strtotime($exception_day['day']);
                        $semester = (date('n', $exception_date) <= 6) ? 1 : 2;

                        if ($semester == 1) $uniques_excepcio[$key_u]['semester1'] = $uniques_excepcio[$key_u]['semester1'] + 1;
                        if ($semester == 2) $uniques_excepcio[$key_u]['semester2'] = $uniques_excepcio[$key_u]['semester2'] + 1;
                        $uniques_excepcio[$key_u]['count_days'] = $uniques_excepcio[$key_u]['count_days'] + 1;

                    }
                }
            }

        }

        //TRAIGO DIAS FESTIVOS Y DESPUES VERIFICO LOS DIAS QUE HAY EN HORAS TEORICAS
        $sql_holiday = "
                SELECT f.dataany as days, l.nom as nom, f.descripcio as descripcio, l.idlocalitzacio, f.idlocalitzacio,s.idlocalitzacio,e.idEmpleat, s.idempleat
        FROM festiu AS f
            join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio
            join situat as s on s.idlocalitzacio = l.idlocalitzacio
            join empleat as e on e.idEmpleat = s.idempleat
            
            WHERE  e.idEmpleat = $id  ;       
        ";

             $rs_holiday = $this->getDb()->executarConsulta($sql_holiday);                         
        //CAMBIO VALORES DE TITLE, STYLE DE LAS FECHAS FESTIVOS
        if((!empty($rs_holiday))&&($prifestius==1))
        {


            foreach ($rs_holiday as $valor)
            {
                

                foreach ($daysOfYear as &$item)
                {
					
					
					$dateHoliday = date('m-d' , strtotime($valor["days"]));
                    $dateCalendari = date('m-d' , strtotime($item['day']));


$nombre = $valor["nom"];
$partes = explode(" ", $nombre);

// $partes[0] contendrá la primera parte, $partes[1] contendrá la segunda parte


$anyActual = date("Y");


                    if ($dateHoliday === $dateCalendari && $any == $anyActual  ) {
                      
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] = 'title="'.$valor["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$valor["nom"].')"';
                        $item['style'] = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';
                        $item['onclick'] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                        $item['type_exception'] = '';
                        $item['rgb'] = '';
                    }
                }
            }
        }


        //si es festivo pero no prioritario sobre los horarios, se pinte y describa de todas formas, añadiendo la información del turno o período especial.
        if((!empty($rs_holiday))&&($prifestius==0)&&($marcafestius==1))
        {
            foreach ($rs_holiday as $valor)
            {
                foreach ($daysOfYear as &$item)
                {

                    $len = strlen($title)-7;
                    $title2 = substr($title,7,($len));
                    $title = 'title="'.$valor["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$valor["nom"].')&#10;'.$title2.'"';

                    if ($item['day'] === $valor["days"]) {
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] = 'title_dia_festivo_condional';
                        $item['style'] = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';
                        $item['onclick'] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';;
                        $item['type_exception'] = '';
                        $item['rgb'] = '';
                    }
                }
            }
        }

        //SEPARAMOS LOS DIAS POR MES
        $months = []; // Un array para almacenar los días por mes
        foreach ($daysOfYear as $day) {
            $date = new DateTime($day['day']);
            //$month = $date->format('Y-m'); // Obtener el año y mes
            $monthNumber = $date->format('n'); // Obtiene el número del mes

            // Si el mes no existe en el array, crea uno nuevo
            if (!isset($months[$monthNumber])) $months[$monthNumber] = array();

            // Agrega el día al mes correspondiente
            $months[$monthNumber][] = $day;
        }

        $data = [
            'months' => $months,
            'exception_days' => $uniques_excepcio,
        ];

        return $data;
    }

    public function paintCalendarMonth ($key, $month, $lng) {

        echo '<section class="" style="width:'.'22'.'%; float:left"><center><label>'.$this->__($lng,$this->mostraNomMes($key));

        echo '</label><table class="table-bordered table-condensed table-hover">';
        echo '<thead>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DL").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DM").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;">'.$this->__($lng,"DC").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DJ").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DV").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DS").'</th>'
            . '<th style="font-size: 10px; background-color: #d1ffff; color: black;"">'.$this->__($lng,"DG").'</th>'
            . '</thead><tbody style="background-color: rgba(255, 255, 255, 0.1);">';

        // Inicializar variables para rastrear los días de la semana
        $currentDayOfWeek = 1; // Empieza en el primer día de la semana (DL)

        foreach ($month as $day) {
            $date = new DateTime($day['day']);
            $dayOfWeek = $date->format('N'); // Obtiene el número del día de la semana (1=Lunes, 7=Domingo)
            $month_day = date('d', strtotime($day['day']));


            // Rellena los días de la semana que faltan antes de este día
            while ($currentDayOfWeek < $dayOfWeek) {
                echo '<td></td>';
                $currentDayOfWeek++;
            }

            // Agrega el día actual a la tabla
            echo '<td '.$day['title'].' '.$day['style'].' '.$day['onclick'].'>' . $month_day . '</td>';
            //echo '<td '.$title.' '.$style.' '.$onclick.'>'.abs($dia->format('d')).'</td>';

            // Si es el último día de la semana (DG), cierra la fila de la tabla
            if ($currentDayOfWeek == 7) {
                echo '</tr><tr>'; // Cierra la fila actual y comienza una nueva
                $currentDayOfWeek = 1; // Reinicia el contador para el nuevo mes
            } else {
                $currentDayOfWeek++;
            }
        }

        // Rellena los días restantes de la semana con celdas vacías si es necesario
        while ($currentDayOfWeek <= 7) {
            echo '<td></td>';
            $currentDayOfWeek++;
        }

        // Cierra la tabla HTML al final del mes
        echo '</tr></tbody></table></section>';
    }

    public function monthlyEmployeeCalendarMonth($id, $any, $month, $lng) {

        $special_days = [];

        //ME TRAIGO LOS PREFESITUS Y LOS MARCAFESTIUS PARA DETERMINAR LOS FESTIVOS PRIORITARIOS DE LA EMPRESA Y CONFIGURACIONES ADICIONALES
        $idempresa = $this->getCampPerIdCampTaula("empleat",$id,"idempresa");
        $prifestius_marcafestius = [];
        $sql_company = "SELECT prifestius, marcafestius FROM empresa WHERE idempresa = $idempresa";
        $rs_company = $this->getDb()->executarConsulta($sql_company);

        foreach ($rs_company as $valor)
        {
            $prifestius = $valor['prifestius'];
            $marcafestius = $valor['marcafestius'];
        }

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $any);
        $daysOfMonth = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = date("Y-m-d", strtotime("$any-$month-$day"));
            $daysOfMonth[] = [
                'day' => $date,
                'shift' => '',
                'start_time' => '',
                'end_time' => '',
                'title' => 'title="'.$this->__($lng,"No laborable").'"',
                'style' => 'style="background-color: rgb(128,128,128); color: white; cursor: pointer"',
                'onclick' => 'onclick="mostraCreaRotacioDia('.$id.",'".$date."',".');"',
                'type_exception' => '',
                'rgb' => ''
            ];
        }

        // Ahora, $datesArray contiene todas las fechas del mes especificado, incluyendo años bisiestos

        //TRAIGO LOS DIAS QUE DEBE TRABAJAR EL EMPLEADO (ROTACIO) CON SU RESPECTIVO HORARIO
        $sql = "
            SELECT r.idrotacio as idrotacio, r.data as data, tt.nom as nom, tt.horaentrada as horaEntrada, tt.horasortida as horaSalida, tt.horestreball, tt.colorbckg as colorbckg, tt.colortxt as colortxt, tt.abrv as abrv 
            FROM rotacio AS r
                LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
            WHERE r.idempleat = $id AND YEAR(r.data) = $any AND MONTH(r.data) = $month
            ORDER BY r.data
            ";

        $rs = $this->getDb()->executarConsulta($sql);
        // AGREGO LAS PROPIEDADES DE DIAS DE TRABAJO A LOS DIAS DEL AÑO
        foreach ($rs as $valor) {
            foreach ($daysOfMonth as &$item)
            {
                if ($valor["data"] === $item["day"])
                {
                    $bckg = $valor["colorbckg"];
                    $color = $valor["colortxt"];
                    $abr = $valor["abrv"];

                    $item['shift'] = $valor["nom"];
                    $item["start_time"] = $valor["horaEntrada"];
                    $item["end_time"] = $valor["horaSalida"];
                    $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$valor["nom"].'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($valor["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($valor["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$valor["horestreball"].'"';;
                    $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                    $item["onclick"] = 'onclick="mostraEditaRotacioDia('.$valor['idrotacio'].');"';
                    $item['type_exception'] = '';
                    $item['rgb'] = '';
                }
            }
        }


        if (empty($rs))
        {
            $sql = "
            select t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.horaentrada as horaEntrada, t.horasortida as horaSalida, t.diasetmana as week_day
            from torn as t
                join horaris as h on h.idhoraris = t.idhorari
                join quadrant as q on q.idhorari = h.idhoraris
                join empleat as e on q.idempleat = e.idempleat
            where e.idempleat = $id and (($any BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL)) AND q.actiu = 1
            ";

            $rs = $this->getDb()->executarConsulta($sql);
            //SI EL EMPLEADO NO TIENE HORARIO ENTRADA O SALIDA DEFINIDO
            if($rs[0]['end_day'] === null)
            {
                foreach ($daysOfMonth as &$item)
                {

                    // Verifica si el día es sábado (6) o domingo (0)
                    /*
                     VALORES RETORNADOS POR EL METODO
                    0: Domingo
                    1: Lunes
                    2: Martes
                    3: Miércoles
                    4: Jueves
                    5: Viernes
                    6: Sábado
                     */
                    $dayOfWeek = date('w', strtotime($item['day']));

                    //LA BASE DE DATOS TIENE LOS VALORES ASI:
                    /*
                     1:lunes
                     2:martes
                     3:miercoles
                     4:jueves
                     5:viernes
                     6:sabado
                     7:domingo
                    ENTONCES CAMBIAMOS DEL METODO EL VALOR DE 0 DOMINGO A 7 DOMINGO DE LA BASE DE DATOS PARA COMPARAR BIEN
                     */
                    if($dayOfWeek == 0) $dayOfWeek = 7;

                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                    {
                        if ($value['week_day'] == $dayOfWeek)
                        {
                            //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                            if ($value['hours'] != 0)
                            {

                                $bckg = '';
                                $color = '';
                                $abr = '';

                                $item['shift'] = $this->__($lng,"Horari");
                                $item["start_time"] = $value["horaEntrada"];
                                $item["end_time"] = $value["horaSalida"];
                                $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$this->__($lng,"Horari").'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($value["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($value["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$value["hours"].'"';;
                                $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                $item["onclick"] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                                $item['type_exception'] = '';
                                $item['rgb'] = '';
                            }

                        }
                    }
                }
                // SI TIENE HORARIO ENTRADA Y SALIDA DEFINIDA SI
            }
            else {
                //INTERVALO DE DIAS
                $torn_days_interval = [];
                $torn_days_interval = [
                    'start_day' => $rs[0]["start_day"],
                    'end_day' => $rs[0]["end_day"]
                ];
                //SACO TODOS LOS DIAS TORN SE DE SUS INTERVALOS RECORRIENDOLO CON WHILE
                $current_date = strtotime($torn_days_interval['start_day']);
                $end_date_timestamp = strtotime($torn_days_interval['end_day']);
                $torn_days = [];
                while ($current_date <= $end_date_timestamp) {
                    $torn_days[] = date('Y-m-d', $current_date);
                    $current_date = strtotime('+1 day', $current_date);
                }
                //TOMO LOS VALORES DE SOLO ESTE AÑO
                $torn_days_year = [];
                foreach ($torn_days as $torn_day)
                {
                    $day_array = date_parse($torn_day);
                    if ($day_array['year'] == $any) $torn_days_year[] = $torn_day;
                }
                //TOMO LOS VALORES DE SOLO ESTE MES
                $torn_days_month = [];
                foreach ($torn_days_year as $torn_day)
                {
                    $day_array = date_parse($torn_day);
                    if ($day_array['month'] == $month) $torn_days_month[] = $torn_day;
                }


                foreach ($daysOfMonth as &$item) {

                    foreach ($torn_days_month as $day) {
                        //SACO EL DIA DE LA SEMANA DE DAY
                        $dayOfWeek = date('w', strtotime($day));
                        //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                        foreach ($rs as $value)
                            if ($value['week_day'] == $dayOfWeek) {
                                if ($value['hours'] != 0) {
                                    if ($item['day'] == $day)
                                    {
                                        //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                                        $bckg = '';
                                        $color = '';
                                        $abr = '';

                                        $item['shift'] = $this->__($lng,"Horari");
                                        $item["start_time"] = $value["horaEntrada"];
                                        $item["end_time"] = $value["horaSalida"];
                                        $item["title"] = 'title="'.$this->__($lng,"Torn").': '.$this->__($lng,"Horari").'&#10;'.$this->__($lng,"Entrada").': '.date('H:i',strtotime($value["horaEntrada"])).'&#10;'.$this->__($lng,"Sortida").': '.date('H:i',strtotime($value["horaSalida"])).'&#10;'.$this->__($lng,"Hores").': '.$value["hours"].'"';;
                                        $item["style"] = 'style="background-color: '.$bckg.'; color: '.$color.'; cursor: pointer"';
                                        $item["onclick"] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                                        $item['type_exception'] = '';
                                        $item['rgb'] = '';
                                    }
                                }
                            }
                    }

                }

            }
        }



        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
        SELECT e.datainici as start_day, e.datafinal as end_day, t.nom as nom, t.r as r, t.g as g, t.b as b, t.idtipusexcep as idtipusexcep, e.idexcepcio as idexcepcio 
        FROM excepcio as e
            JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
        WHERE e.idempleat = $id AND YEAR(e.datainici) = $any AND MONTH(e.datainici) = $month AND YEAR(e.datafinal) = $any AND MONTH(e.datafinal) = $month AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)
        ";
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);

        if (!empty($rs_exception))
        {
            $exception_days_interval = [];

            foreach ($rs_exception as $valor) {

                $array_rgb = [ $valor["r"], $valor["g"], $valor["b"] ];
                $rgb = implode(',', $array_rgb);

                $exception_days_interval[] = [
                    'start_day' => $valor["start_day"],
                    'end_day' => $valor["end_day"],
                    'type_exception' => $valor["nom"],
                    'rgb' => $rgb,
                    'idtipusexcep' => $valor['idtipusexcep'],
                    'idexcepcio' => $valor['idexcepcio']
                ];
            }
            $exception_days = [];
            //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
            foreach ($exception_days_interval as $e_d_i)
            {
                $current_date = strtotime($e_d_i['start_day']);
                $end_date_timestamp = strtotime($e_d_i['end_day']);

                if ($e_d_i['start_day'] !== $e_d_i['end_day'])
                {
                    while ($current_date <= $end_date_timestamp) {
                        $exception_days[] = [
                            'day' => date('Y-m-d', $current_date),
                            'type_exception' => $e_d_i["type_exception"],
                            'rgb' => $e_d_i["rgb"],
                            'idtipusexcep' => $e_d_i['idtipusexcep'],
                            'idexcepcio' => $e_d_i['idexcepcio'],
                            'start_day' => $e_d_i["start_day"],
                            'end_day' => $e_d_i["end_day"],
                        ];
                        $current_date = strtotime('+1 day', $current_date);
                    }
                } else {
                    $exception_days[] = [
                        'day' => $e_d_i['start_day'],
                        'type_exception' => $e_d_i["type_exception"],
                        'rgb' => $e_d_i["rgb"],
                        'idtipusexcep' => $e_d_i['idtipusexcep'],
                        'idexcepcio' => $e_d_i['idexcepcio'],
                        'start_day' => $e_d_i["start_day"],
                        'end_day' => $e_d_i["end_day"],
                    ];
                }
            }

            foreach ($exception_days as $exception_day)
            {
                foreach ($daysOfMonth as &$item)
                {
                    if ($item['day'] === $exception_day['day']) {
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] =  'title="'.$this->__($lng, $exception_day['type_exception']).'"';
                        $item['style'] = ' style="background-color: rgb('.$exception_day['rgb'].'); cursor: pointer;" ';
                        $item['onclick'] = 'onclick="mostraExcep('.$exception_day["idexcepcio"].','.$exception_day["idtipusexcep"].",'".$exception_day["start_day"]."','".$exception_day["end_day"]."'".');"';
                        $item['type_exception'] = $exception_day['type_exception'];
                        $item['rgb'] = $exception_day['rgb'];
                        $item['idtipusexcep'] = $exception_day['idtipusexcep'];
                        $item['idexcepcio'] = $exception_day['idexcepcio'];
                    }
                }
            }
        }

        //TRAIGO DIAS FESTIVOS Y DESPUES VERIFICO LOS DIAS QUE HAY EN HORAS TEORICAS
        $sql_holiday = "
        SELECT f.dataany as days, l.nom as nom, f.descripcio as descripcio
        FROM festiu AS f
            join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio
            join situat as s on s.idlocalitzacio = l.idlocalitzacio
            join empleat as e on e.idEmpleat = s.idempleat
        
        ";
        $rs_holiday = $this->getDb()->executarConsulta($sql_holiday);
        //CAMBIO VALORES DE TITLE, STYLE DE LAS FECHAS FESTIVOS
        if((!empty($rs_holiday))&&($prifestius==1))
        {
            foreach ($rs_holiday as $valor)
            {
                foreach ($daysOfMonth as &$item)
                {
					//CONVERTIMOS LA FECHA TRAIDA DE LA BASE DE DATOS A FORMATO D-M
					$dateHoliday = date('m-d' , strtotime($valor["days"]));
                    $dateCalendari = date('m-d' , strtotime($item['day']));
                    if ($dateHoliday === $dateCalendari) {
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] = 'title="'.$valor["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$valor["nom"].')"';
                        $item['style'] = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';
                        $item['onclick'] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';
                        $item['type_exception'] = '';
                        $item['rgb'] = '';
                    }
                }
            }
        }

        //si es festivo pero no prioritario sobre los horarios, se pinte y describa de todas formas, añadiendo la información del turno o período especial.
        if((!empty($rs_holiday))&&($prifestius==0)&&($marcafestius==1))
        {
            foreach ($rs_holiday as $valor)
            {
                foreach ($daysOfMonth as &$item)
                {

                    $len = strlen($title)-7;
                    $title2 = substr($title,7,($len));
                    $title = 'title="'.$valor["descripcio"].' ('.$this->__($lng,"Festiu a").' '.$valor["nom"].')&#10;'.$title2.'"';

                    if ($item['day'] === $valor["days"]) {
                        $item['shift'] = '';
                        $item["start_time"] = '';
                        $item["end_time"] = '';
                        $item['title'] = 'title_dia_festivo_condional';
                        $item['style'] = 'style="background-color: rgb(150,75,75); color: white; cursor: pointer"';
                        $item['onclick'] = 'onclick="mostraCreaRotacioDia('.$id.",'".$item['day']."',".');"';;
                        $item['type_exception'] = '';
                        $item['rgb'] = '';
                    }
                }
            }
        }

        return $daysOfMonth;

    }

    public function seleccionaHoresTeoriquesMonth($id, $month) {
        $hours_date = [];

        $year = date("Y");
        //HORAS TEORICAS TOTALES, SIN DESCONTAR LOS FESTIVOS Y LAS EXCEPCIONES
        $sql = "
        SELECT r.data as data, tt.horestreball as hours
        FROM rotacio AS r
            LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
        WHERE r.idempleat = $id AND YEAR(r.data) = $year AND MONTH(r.data) = $month
        ";
        $rs = $this->getDb()->executarConsulta($sql);
        foreach ($rs as $valor) {
            $hours_date[] = [
                $valor["data"] => $valor["hours"]
            ];
        }


        if (empty($hours_date)) {

            $sql = "
            select t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.diasetmana as week_day
            from torn as t
                join horaris as h on h.idhoraris = t.idhorari
                join quadrant as q on q.idhorari = h.idhoraris
                join empleat as e on q.idempleat = e.idempleat
            where e.idempleat = $id and (($year BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL)) AND q.actiu = 1
            ";

            $rs = $this->getDb()->executarConsulta($sql);

            //SI EL EMPLEADO NO TIENE HORARIO ENTRADA O SALIDA DEFINIDO
            if($rs[0]['end_day'] === null)
            {

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = date("Y-m-d", strtotime("$year-$month-$day"));

                    // Verifica si el día es sábado (6) o domingo (0)
                    /*
                     VALORES RETORNADOS POR EL METODO
                    0: Domingo
                    1: Lunes
                    2: Martes
                    3: Miércoles
                    4: Jueves
                    5: Viernes
                    6: Sábado
                     */

                    // Verifica si el día es sábado (6) o domingo (0)
                    $dayOfWeek = date('w', strtotime($date));
                    //LA BASE DE DATOS TIENE LOS VALORES ASI:
                    /*
                     1:lunes
                     2:martes
                     3:miercoles
                     4:jueves
                     5:viernes
                     6:sabado
                     7:domingo
                    ENTONCES CAMBIAMOS DEL METODO EL VALOR DE 0 DOMINGO A 7 DOMINGO DE LA BASE DE DATOS PARA COMPARAR BIEN
                     */

                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                    {
                        if ($value['week_day'] == $dayOfWeek) {
                            //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                            if ($value['hours'] != 0) {
                                $hours_date[] = [$date => $value['hours']];
                            }
                        }
                    }
                }
                // SI TIENE HORARIO ENTRADA Y SALIDA DEFINIDA SI
            }
            else {

                //INTERVALO DE DIAS
                $torn_days_interval = [];
                $torn_days_interval = [
                    'start_day' => $rs[0]["start_day"],
                    'end_day' => $rs[0]["end_day"]
                ];

                //SACO TODOS LOS DIAS TORN SE DE SUS INTERVALOS RECORRIENDOLO CON WHILE
                $current_date = strtotime($torn_days_interval['start_day']);
                $end_date_timestamp = strtotime($torn_days_interval['end_day']);

                $torn_days = [];
                while ($current_date <= $end_date_timestamp) {
                    $torn_days[] = date('Y-m-d', $current_date);
                    $current_date = strtotime('+1 day', $current_date);
                }

                //TOMO LOS VALORES DE SOLO ESTE AÑO
                $torn_days_year = [];
                foreach ($torn_days as $torn_day)
                {
                    $day_array = date_parse($torn_day);
                    if ($day_array['year'] == $year) $torn_days_year[] = $torn_day;
                }
                //TOMO LOS VALORES DE SOLO ESTE MES
                $torn_days_month = [];
                foreach ($torn_days_year as $torn_day)
                {
                    $day_array = date_parse($torn_day);
                    if ($day_array['month'] == $month) $torn_days_month[] = $torn_day;
                }

                foreach ($torn_days_month as $day) {
                    //SACO EL DIA DE LA SEMANA DE DAY
                    $dayOfWeek = date('w', strtotime($day));
                    //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
                    foreach ($rs as $value)
                        if ($value['week_day'] == $dayOfWeek) {

                            if ($value['hours'] != 0 && $day !== null) {
                                $hours_date[] = [$day => $value['hours']];
                            } else {
                                $hours_date[] = [$day => 0];
                            }
                        }

                }

            }

        }


        //SACO DIAS FESTIVOS Y DESPUES VERIFICO LOS DIAS QUE HAY EN HORAS TEORICAS Y HAGO VALOR 0 EN ESOS DIAS
        //DESCUENTO LOS DIAS FESTIVOS, BUSCANDO EL DIA FESTIVO Y DEJANDOLO EN 0
        $sql_holiday = "
            SELECT f.dataany as days
            FROM festiu AS f
                join localitzacio as l on l.idlocalitzacio = f.idlocalitzacio
                join situat as s on s.idlocalitzacio = l.idlocalitzacio
                join empleat as e on e.idEmpleat = s.idempleat
            where e.idEmpleat = $id AND YEAR(f.dataany) = $year AND MONTH(f.dataany) = $month AND YEAR(s.datainici) = $year AND MONTH(s.datainici) AND YEAR(s.datafi) = $year AND MONTH(s.datafi)
        ";
        $holiday_days = [];
        $rs_holiday = $this->getDb()->executarConsulta($sql_holiday);
        foreach ($rs_holiday as $valor)
        {
            $holiday_days[] = $valor["days"];
        }

        //HAGO VALOR A 0 LAS HORAS DE ESTAS FECHAS FESTIVOS
        foreach ($holiday_days as $holiday_day)
        {
            $nuevo_valor = 0;
            foreach ($hours_date as &$item)
            {
                // Verificar si la fecha existe en el arreglo actual
                if (isset($item[$holiday_day])) {
                    $item[$holiday_day] = $nuevo_valor;
                }
            }
        }

        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
            SELECT e.datainici as start_day, e.datafinal as end_day
            FROM excepcio as e
                JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
            WHERE e.idempleat = $id AND YEAR(e.datainici) = $year AND MONTH(e.datainici) = $month AND YEAR(e.datafinal) = $year AND MONTH(e.datafinal) = $month AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)      
        ";

        $exception_days_interval = [];
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);

        foreach ($rs_exception as $valor)
        {
            $exception_days_interval[] = ['start_day' => $valor["start_day"], 'end_day' => $valor["end_day"]];
        }

        $exception_days = [];

        //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
        foreach ($exception_days_interval as $e_d_i)
        {
            $current_date = strtotime($e_d_i['start_day']);
            $end_date_timestamp = strtotime($e_d_i['end_day']);

            if ($e_d_i['start_day'] !== $e_d_i['end_day'])
            {
                while ($current_date <= $end_date_timestamp) {
                    $exception_days[] = date('Y-m-d', $current_date);
                    $current_date = strtotime('+1 day', $current_date);
                }
            } else {
                $exception_days[] = $e_d_i['start_day'];
            }
        }

        //YA TENIENDO LOS DIAS EXPCECION, ENTONCES LOS BUSCO EN LAS HORAS Y LE APLICO VALOR DE 0
        foreach ($exception_days as $exception_day)
        {
            $new_value = 0;
            foreach ($hours_date as &$item)
            {
                // Verificar si la fecha existe en el arreglo actual
                if (isset($item[$exception_day])) {
                    $item[$exception_day] = $new_value;
                }
            }
        }

        $horesteoMonth = array_reduce($hours_date, function($carry, $item) {
            $carry += array_sum($item);
            return $carry;
        }, 0);

        return $horesteoMonth;
    }

    public function seeException ($idexcep, $idtipusexcep) {

        $sql = "
        SELECT e.idempleat, e.aprobada, e.comentario, e.observacions, te.nom, e.dataaprovacio
        FROM excepcio as e
            JOIN tipusexcep as te ON e.idtipusexcep = te.idtipusexcep
        WHERE e.idexcepcio = $idexcep AND te.idtipusexcep = $idtipusexcep
        ";

        $rs = $this->getDb()->executarConsulta($sql);

        $exception = [];
        if (!empty($rs))
        {
            foreach ($rs as $value)
            {
                $exception = [
                    'id_employee' => $value['idempleat'],
                    'nom' => $value['nom'],
                    'comment' => $value['comentario'],
                    'observations' => $value['observacions'],
                    'approved' => $value['aprobada'],
                    'date_approved' => $value['dataaprovacio']
                ];
            }
        }

        return $exception;
    }

    public function days_vacation ($id)
    {
        $year = date("Y");
        $before_year = $year - 1;

        $sql = "
        SELECT total_dias 
        FROM vacances 
        WHERE idempleat = $id AND any = $year 
        ";
        $rs = $this->getDb()->executarConsulta($sql);

        $sql_before_year = "
        SELECT total_dias 
        FROM vacances 
        WHERE idempleat = $id AND any = $before_year
        ";
        $rs_before_year = $this->getDb()->executarConsulta($sql_before_year);

        $days_vacation = [];

        if (!empty($rs))
        {
            foreach ($rs as $value)
            {
                $days_vacation[$year] = $value['total_dias'];
            }
        } else {
            $days_vacation[$year] = 0;
        }


        if (!empty($rs_before_year))
        {
            foreach ($rs_before_year as $value)
            {
                $days_vacation[$before_year] = $value['total_dias'];
            }
        } else {
            $days_vacation[$before_year] = 0;
        }


        return $days_vacation;
    }

    public function days_exception ($id, $any)
    {
        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
        SELECT e.datainici as start_day, e.datafinal as end_day, t.nom as nom, t.r as r, t.g as g, t.b as b, t.idtipusexcep as idtipusexcep, e.idexcepcio as idexcepcio 
        FROM excepcio as e
            JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
        WHERE e.idempleat = $id AND YEAR(e.datainici) = $any AND YEAR(e.datafinal) = $any AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)
        ";
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);

        if (!empty($rs_exception))
        {
            $exception_days_interval = [];

            foreach ($rs_exception as $valor) {

                $array_rgb = [ $valor["r"], $valor["g"], $valor["b"] ];
                $rgb = implode(',', $array_rgb);

                $exception_days_interval[] = [
                    'start_day' => $valor["start_day"],
                    'end_day' => $valor["end_day"],
                    'type_exception' => $valor["nom"],
                    'rgb' => $rgb,
                    'idtipusexcep' => $valor['idtipusexcep'],
                    'idexcepcio' => $valor['idexcepcio']
                ];
            }
            $exception_days = [];
            //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
            foreach ($exception_days_interval as $e_d_i)
            {
                $current_date = strtotime($e_d_i['start_day']);
                $end_date_timestamp = strtotime($e_d_i['end_day']);

                if ($e_d_i['start_day'] !== $e_d_i['end_day'])
                {
                    while ($current_date <= $end_date_timestamp) {
                        $exception_days[] = [
                            'day' => date('Y-m-d', $current_date),
                            'type_exception' => $e_d_i["type_exception"],
                            'rgb' => $e_d_i["rgb"],
                            'idtipusexcep' => $e_d_i['idtipusexcep'],
                            'idexcepcio' => $e_d_i['idexcepcio'],
                            'start_day' => $e_d_i["start_day"],
                            'end_day' => $e_d_i["end_day"],
                        ];
                        $current_date = strtotime('+1 day', $current_date);
                    }
                } else {
                    $exception_days[] = [
                        'day' => $e_d_i['start_day'],
                        'type_exception' => $e_d_i["type_exception"],
                        'rgb' => $e_d_i["rgb"],
                        'idtipusexcep' => $e_d_i['idtipusexcep'],
                        'idexcepcio' => $e_d_i['idexcepcio'],
                        'start_day' => $e_d_i["start_day"],
                        'end_day' => $e_d_i["end_day"],
                    ];
                }
            }
            //YA TENIENDO LOS DIAS EXPCECION, ENTONCES LOS BUSCO EN LAS HORAS Y LE APLICO VALOR DE 0

            $uniques_excepcio = [];

            foreach ($exception_days as $exception_day)
            {

                // CUENTO LOS DIAS EXCEPCION POR TIPO, PRIMERO CREO LOS UNIQUES
                // Determinar el semestre al que pertenece el día de excepción
                $exception_date = strtotime($exception_day['day']);
                $semester = (date('n', $exception_date) <= 6) ? 1 : 2;
                $idtipusexcep = $exception_day["idtipusexcep"];
                if(!isset($uniques_excepcio['idtipusexcep'])) $uniques_excepcio[$idtipusexcep] = [
                    'type_excepcio' => $exception_day['type_exception'],
                    'rgb' => $exception_day['rgb'],
                    'count_days' => 0,
                    'semester1' => 0,
                    'semester2' => 0
                ];
            }

            //cantidad dias excepcion por tipo, total y por semestre.
            foreach ($uniques_excepcio as $key_u => $unique_excepcio)
            {
                foreach ($exception_days as $exception_day)
                {
                    if ($key_u == $exception_day["idtipusexcep"])
                    {
                        // Determinar el semestre al que pertenece el día de excepción
                        $exception_date = strtotime($exception_day['day']);
                        $semester = (date('n', $exception_date) <= 6) ? 1 : 2;

                        if ($semester == 1) $uniques_excepcio[$key_u]['semester1'] = $uniques_excepcio[$key_u]['semester1'] + 1;
                        if ($semester == 2) $uniques_excepcio[$key_u]['semester2'] = $uniques_excepcio[$key_u]['semester2'] + 1;
                        $uniques_excepcio[$key_u]['count_days'] = $uniques_excepcio[$key_u]['count_days'] + 1;

                    }
                }
            }
        }

        return $uniques_excepcio;
    }

    public function days_vacation_used ($id, $today)
    {
        //TRAIGO LOS DIAS EXCEPCION
        $sql = "
        SELECT e.datainici as start_day, e.datafinal as end_day, t.nom as nom, t.r as r, t.g as g, t.b as b, t.idtipusexcep as idtipusexcep, e.idexcepcio as idexcepcio
        FROM excepcio as e
         JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
        WHERE LOWER(nom) LIKE 'vac%' AND e.idempleat = $id AND (DATE(e.datainici) > $today OR DATE(e.datafinal) > $today) AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1)
        ";
        $rs = $this->getDb()->executarConsulta($sql);

        if (!empty($rs))
        {
            $vacation_days_interval = [];

            foreach ($rs as $valor) {

                $array_rgb = [ $valor["r"], $valor["g"], $valor["b"] ];
                $rgb = implode(',', $array_rgb);

                $vacation_days_interval[] = [
                    'start_day' => $valor["start_day"],
                    'end_day' => $valor["end_day"],
                    'idtipusexcep' => $valor["idtipusexcep"]
                ];
            }
            $exception_days = [];
            //SACO TODOS LOS DIAS DE EXCEPCION, O SE DE SUS INTERVALOS
            foreach ($vacation_days_interval as $e_d_i)
            {
                $current_date = strtotime($e_d_i['start_day']);
                $end_date_timestamp = strtotime($e_d_i['end_day']);

                $today = strtotime($today);

                if ($e_d_i['start_day'] !== $e_d_i['end_day'])
                {

                    while ($current_date <= $end_date_timestamp) {
                        if ($current_date > $today  && !$this->isDayAlreadyAdded($exception_days, date('Y-m-d', $current_date))) {
                            $exception_days[] = [
                                'day' => date('Y-m-d', $current_date),
                                'idtipusexcep' => $e_d_i["idtipusexcep"],
                                'start_day' => $e_d_i["start_day"],
                                'end_day' => $e_d_i["end_day"],
                            ];
                        }
                        $current_date = strtotime('+1 day', $current_date);
                    }

                } else {

                    if ($current_date > $today  && $this->isDayAlreadyAdded($exception_days, date('Y-m-d', $current_date))) {
                        $exception_days[] = [
                            'day' => $e_d_i['start_day'],
                            'idtipusexcep' => $e_d_i["idtipusexcep"],
                            'start_day' => $e_d_i["start_day"],
                            'end_day' => $e_d_i["end_day"],
                        ];
                    }

                }
            }
            //YA TENIENDO LOS DIAS EXPCECION, ENTONCES LOS BUSCO EN LAS HORAS Y LE APLICO VALOR DE 0
            $uniques_excepcio = [];

            foreach ($exception_days as $exception_day)
            {
                // CUENTO LOS DIAS EXCEPCION POR TIPO, PRIMERO CREO LOS UNIQUES
                // Determinar el semestre al que pertenece el día de excepción
                $exception_date = strtotime($exception_day['day']);
                $semester = (date('n', $exception_date) <= 6) ? 1 : 2;
                $idtipusexcep = $exception_day["idtipusexcep"];
                if(!isset($uniques_excepcio['idtipusexcep'])) $uniques_excepcio[$idtipusexcep] = [
                    'count_days' => 0,
                    'semester1' => 0,
                    'semester2' => 0
                ];
            }

            //cantidad dias excepcion por tipo, total y por semestre.
            foreach ($uniques_excepcio as $key_u => $unique_excepcio)
            {
                foreach ($exception_days as $exception_day)
                {
                    if ($key_u == $exception_day["idtipusexcep"])
                    {
                        // Determinar el semestre al que pertenece el día de excepción
                        $exception_date = strtotime($exception_day['day']);
                        $semester = (date('n', $exception_date) <= 6) ? 1 : 2;

                        if ($semester == 1) $uniques_excepcio[$key_u]['semester1'] = $uniques_excepcio[$key_u]['semester1'] + 1;
                        if ($semester == 2) $uniques_excepcio[$key_u]['semester2'] = $uniques_excepcio[$key_u]['semester2'] + 1;
                        $uniques_excepcio[$key_u]['count_days'] = $uniques_excepcio[$key_u]['count_days'] + 1;

                    }
                }
            }
        }

        return $uniques_excepcio;

    }
    // Función para verificar si un día ya está en el array
    private function isDayAlreadyAdded($array, $day) {
        foreach ($array as $item) {
            if ($item['day'] === $day) {
                return true;
            }
        }
        return false;
    }

    public function dataSpecialPeriodsReport ($idsubemp, $dpt, $tipusexcep, $idempresa, $mes, $any)
    {

        //CABECERA DE LA TABLA Y TOMA DE LOS AÑOS Y MESES PARA CONTAR LOS DIAS POR ESTOS PERIODOS
        $periods = [];
        $periods[] = ['year' => $any, 'month' => $mes];

        for ($i = 1; $i < 12; $i++) {
            $mes--;
            if ($mes == 0) {
                $mes = 12;
                $any--;
            }
            $periods[] = ['year' => $any, 'month' => $mes];
        }

        //CREO CABECERA
        $header = [];
        $header[] = "Persona \ Mes";
        foreach ($periods as $period) $header[] = $period['year'] .'/' .$period['month'];
        $header[] = "Total Dies";


        //SI NO VIENE NINGUN TIPO DE EXCEPCION RETORNA UN ARRAY VACIO
        if ($tipusexcep == "Tots") return ['employees_periods' => [], 'header' => $header];

        /*
         4 IF
        PRIMERO: SI EMPRESA SI DEPARTAMENTO
        SEGUNDO: SI EMPRESA NO DEPARTAMENTO
        TERCERO: NO EMPRESA SI DEPARTAMENTO
        CUARTO: NO EMPRESA NO DEPARTAMENTO
         */

        //PRIMERO TRAEMOS LA DATA CON LOS PARAMETROS ID EMPRESA Y ID DEPARTAMENTO VALIDANDO PRIMERO SI ESTAL LOS ELEMENTOS
        $persones = [];

        if ($idsubemp != "Totes" && $dpt != "Tots") {
            $sql = 'SELECT DISTINCT e.idempleat, e.nom, e.cognom1, e.cognom2 
                    FROM empleat AS e 
                        JOIN pertany AS p ON p.id_emp = e.idempleat 
                        JOIN departament AS d ON d.iddepartament = p.id_dep 
                    WHERE e.idempresa = "'.$idempresa.'" AND e.idsubempresa = '.$idsubemp.' AND d.nom = "'.$dpt.'" ORDER BY e.cognom1, e.cognom2, e.nom';
            $persones = $this->getDb()->executarConsulta($sql);
        }

        if ($idsubemp != "Totes" && $dpt == "Tots") {
            $sql = 'SELECT * 
                    FROM empleat 
                    WHERE idempresa = "'.$idempresa.'" AND idsubempresa = '.$idsubemp.' ORDER BY cognom1, cognom2, nom';
            $persones = $this->getDb()->executarConsulta($sql);
        }

        if ($idsubemp == "Totes" && $dpt != "Tots") {
            $sql = 'SELECT DISTINCT e.idempleat, e.nom, e.cognom1, e.cognom2 
                    FROM empleat AS e 
                        JOIN pertany AS p ON p.id_emp = e.idempleat 
                        JOIN departament AS d ON d.iddepartament = p.id_dep 
                    WHERE d.nom = "'.$dpt.'" ORDER BY e.cognom1, e.cognom2, e.nom';
            $persones = $this->getDb()->executarConsulta($sql);
        }

        if ($idsubemp == "Totes" && $dpt == "Tots") {
            $sql = 'SELECT e.idempleat, e.nom, e.cognom1, e.cognom2 
                    FROM empleat AS e
                    ORDER BY cognom1, cognom2, nom';
            $persones = $this->getDb()->executarConsulta($sql);
        }

        //TRAIGO LOS DIAS EXCEPCION
        $sql_exception = "
        SELECT e.idempleat, e.datainici as start_day, e.datafinal as end_day
        FROM excepcio as e
            JOIN tipusexcep as t ON t.idtipusexcep = e.idtipusexcep
        WHERE t.idtipusexcep = $tipusexcep AND ((e.idresp = 0 OR  e.idresp IS NULL) OR e.aprobada = 1) 
        ";
        $rs_exception = $this->getDb()->executarConsulta($sql_exception);


        //JUNTO EMPLEADOS CON SUS DIAS DE EXCEPCION

        $employees_exception = [];

        foreach ($persones as $persone)
        {

            $employee_exception = [];

            foreach ($rs_exception as $exception)
            {
                if ($exception['idempleat'] === $persone['idempleat'])
                {
                    $employee_exception[] = [
                        'idempleat' => $persone['idempleat'],
                        'nom' => $persone['nom'],
                        'cognom1' => $persone['cognom1'],
                        'cognom2' => $persone['cognom2'],
                        'start_day' => $exception['start_day'],
                        'end_day' => $exception['end_day']
                    ];
                }
            }

            if (empty($employee_exception))
            {
                $employee_exception[] = [
                    'idempleat' => $persone['idempleat'],
                    'nom' => $persone['nom'],
                    'cognom1' => $persone['cognom1'],
                    'cognom2' => $persone['cognom2'],
                    'start_day' => 0,
                    'end_day' => 0
                ];
            }

            $employees_exception[] = $employee_exception;
        }

        // TENEMOS TODOS LOS EMPLEADOS CON LOS INTERVALOS DIAS DEL TIPO DE EXCEPCION AHORA VAMOS A SACAR LOS DIAS DE LOS INTERVARLOS

        $employee_exception_days = [];

        foreach ($employees_exception as $value)
        {
            foreach ($value as $item)
            {

                $current_date = strtotime($item['start_day']);
                $end_date_timestamp = strtotime($item['end_day']);

                if ($item['start_day'] !== $item['end_day'])
                {
                    while ($current_date <= $end_date_timestamp) {
                        $employee_exception_days[] = [
                            'idempleat' => $item['idempleat'],
                            'nom' => $item['nom'],
                            'cognom1' => $item['cognom1'],
                            'cognom2' => $item['cognom2'],
                            'day' => date('Y-m-d', $current_date),
                        ];
                        $current_date = strtotime('+1 day', $current_date);
                    }
                }  else {
                    $employee_exception_days[] = [
                        'idempleat' => $item['idempleat'],
                        'nom' => $item['nom'],
                        'cognom1' => $item['cognom1'],
                        'cognom2' => $item['cognom2'],
                        'day' => $item['start_day'],
                    ];
                }
            }
        }


        //YA SEPARADA POR DIAS AHORA LA SEPARO POR EMPLEADO
        $data_employee = [];
        foreach ($employee_exception_days as $item)
        {
            $idempleat = $item['idempleat'];
            if (!isset($data_employee[$idempleat])) $data_employee[$idempleat] = [];

            $data_employee[$idempleat][] = [
                'idempleat' => $item['idempleat'],
                'nom' => $item['nom'],
                'cognom1' => $item['cognom1'],
                'cognom2' => $item['cognom2'],
                'day' => $item['day']
            ];

        }


        $employees_periods = [];

        //AHORA SACO LOS DIAS POR MES. POR EMPLEADO
        foreach ($data_employee as $employee)
        {

            $employee_periods = [];
            //CREO A LA LA PERSONA
            $employee_periods['Persona/Mes'] = $employee[0]['cognom2'] .' ' .$employee[0]['cognom2'] .', ' .$employee[0]['nom'];


            foreach ($employee as $value)
            {


                //CONTAR POR AÑO Y POR MES
                foreach ($periods as $period)
                {

                    //SACO LOS MESES Y EL AÑO DEL DIA
                    $date = $value['day'];
                    $date = date_parse($date);

                    $month_value = $date['month'];
                    $year_value = $date['year'];

                    //SI TIENE LOS DIAS SE LOS ASIGNAMOS
                    if ($year_value == $period['year'] && $month_value == $period['month'])
                    {

                        //CREO SUS 12 PERIODOS ESPECIALES
                        $employee_periods[ $period['month'] .'/' .$period['year'] ][] = 1;


                    }

                    //CREO SUS 12 PERIODOS ESPECIALES
                    if(!isset($employee_periods[ $period['month'] .'/' .$period['year'] ])) {
                        $employee_periods[ $period['month'] .'/' .$period['year'] ][] = 0;
                    }

                }


            }

            //SUMA DE LOS DIAS POR MES
            foreach ($employee_periods as $key => $employee_period)
            {
                if ($key !== 'Persona/Mes') $employee_periods[$key] = array_sum($employee_period);
            }

            // CUANTO TODOS LOS DIAS DEL AÑO Y LOS GUARDO EN LA 13AVA COLUMNA DIES
            $count_months = array_slice($employee_periods, 1);
            $employee_periods['Total_Dies'] = array_sum($count_months);

            $employees_periods[] = $employee_periods;
        }

        $data = [
            'employees_periods' => $employees_periods,
            'header' => $header
        ];
        return $data;
    }

    public function getHolidays ()
    {
        return $rs = $this->getDb()->executarConsulta("SELECT idfestiu as id_holiday, descripcio as description FROM festiu");
    }
	
	    public function dataDeleteHoliday ($id)
    {
        return $rs = $this->getDb()->executarConsulta("SELECT idfestiu as id_holiday, descripcio as description FROM festiu WHERE idfestiu = $id");
    }
	
    public function deleteException ($id_exception)
    {
        $this->getDb()->executarConsulta("DELETE FROM excepcio WHERE idexcepcio = $id_exception");
    }

    public function editException ($idexcep, $noutipus, $novadataini, $novadatafi) {
        $sql = 'UPDATE excepcio SET idtipusexcep=("'.$noutipus.'"),datainici=("'.$novadataini.'"),datafinal=("'.$novadatafi.'") WHERE idexcepcio="'.$idexcep.'"';
        return $this->getDb()->executarConsulta($sql);
    }
	 public function seeHourTeorique ($id, $any, $month)
    {
        //TRAIGO LOS DIAS QUE DEBE TRABAJAR EL EMPLEADO (ROTACIO) CON SU RESPECTIVO HORARIO
        $sql = "
        SELECT r.data, tt.horestreball
        FROM rotacio AS r
            LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
        WHERE r.idempleat = $id AND YEAR(r.data) = $any AND MONTH(r.data) = $month
        ORDER BY r.data
        ";
        $rs = $this->getDb()->executarConsulta($sql);

        if (!empty($rs)) return $rs;

        //SI NO ESTA EN TORN ENTONCES ESTA EN HORARIOS

        $sql_horaris = "
            select t.horestreball as hours, q.datainici as start_day, q.datafi as end_day, t.diasetmana as week_day
            from torn as t
                join horaris as h on h.idhoraris = t.idhorari
                join quadrant as q on q.idhorari = h.idhoraris
                join empleat as e on q.idempleat = e.idempleat
            where e.idempleat = $id and (($any BETWEEN YEAR(q.datainici) AND YEAR(q.datafi) )||( YEAR(q.datainici)>=0 and q.datafi IS NULL))
            ";

        $rs_horaris = $this->getDb()->executarConsulta($sql_horaris);

        $hours_date = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $any);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = date("Y-m-d", strtotime("$any-$month-$day"));
            // Verifica si el día es sábado (6) o domingo (0)
            /*
             VALORES RETORNADOS POR EL METODO
            0: Domingo
            1: Lunes
            2: Martes
            3: Miércoles
            4: Jueves
            5: Viernes
            6: Sábado
             */

            // Verifica si el día es sábado (6) o domingo (0)
            $dayOfWeek = date('w', strtotime($date));
            //LA BASE DE DATOS TIENE LOS VALORES ASI:
            /*
             1:lunes
             2:martes
             3:miercoles
             4:jueves
             5:viernes
             6:sabado
             7:domingo
            ENTONCES CAMBIAMOS DEL METODO EL VALOR DE 0 DOMINGO A 7 DOMINGO DE LA BASE DE DATOS PARA COMPARAR BIEN
             */

            //RECORRO EL ARRAY DE TORNOS QUE VIENEN 7, BUSCO EL DIA DE LA SEMANA Y LE ASIGNO ESOS VALORES
            foreach ($rs_horaris as $value)
            {
                //NO HACEMOS NADA SI LOS DIAS SON EL 6 O EL 7
                if ($value['week_day'] == $dayOfWeek && $value['hours'] != 0) $hours_date[] = ['data' => $date, 'horestreball' => $value['hours']];
            }

        }
        // echo '<pre>';
        // print_r($hours_date);
        return $hours_date;

    }
    

    public function decimalsToTimeFormat ($decimals)
    {
        $decimals = floatval($decimals);
        $hours = floor($decimals);
        $minutes = ($decimals - $hours) * 60;
        return sprintf("%02d:%02d", $hours, $minutes);
    }

}