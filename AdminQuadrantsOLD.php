<!DOCTYPE html>
<html>
    <head>
        <?php 
        session_start();
        include './Pantalles/HeadGeneric.html'; 
        include 'autoloader.php';
        $dto = new AdminApiImpl();
       
        ?>
        <script>
        function assignaExcep(id,idtipus,dataini,datafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
        function mostraPeuNecess()
        {
            if(document.getElementById("peunec").style.display === 'none'){
                document.getElementById("peunec").style.display = 'table-footer-group';
                document.getElementById("peudispm").style.display = 'table-row';
                document.getElementById("peudispt").style.display = 'table-row';
                document.getElementById("peudispn").style.display = 'table-row';                
                document.getElementById("peudispmt").style.display = 'table-row';
                document.getElementById("tauladisp").style.display = 'block';
            }
            else{
                document.getElementById("peunec").style.display = 'none';
                document.getElementById("peudispm").style.display = 'none';
                document.getElementById("peudispt").style.display = 'none';
                document.getElementById("peudispn").style.display = 'none';
                document.getElementById("peudispmt").style.display = 'none';
                document.getElementById("tauladisp").style.display = 'none';
            }
        }
    </script>
    </head>
    
    <body style="display: table; position: absolute; top: 0px; bottom: 62px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden">    
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
        <div class="modal fade" id="modLoad" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgLoad" style="font-size: 28px">Subiendo...</label><br>
                                    
                </div>
              </div>
            </div>                
            </center>
        </div>        
        <div class="modal fade" id="modConsole" role="dialog">
                <center>
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-body">
                        <label id="msgConsole" style="font-size: 28px"></label><br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                    </div>
                  </div>
                </div>                
                </center>
        </div>
        <div style="width: 100%; color: white; background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); position: absolute; top: 0px; height: 62px; margin-bottom: 0">
    <?php $dto->navResolver();?>
    </div>
    <div id="content" style="display: table-row; width: 100%; float: right; text-align: center; position: absolute; top: 62px; bottom: 0px; overflow-x: hidden; overflow-y: auto; margin-top: 0px; background-color: white; background-size: cover">
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = $_SESSION["idempresa"];
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
        $mes = $_GET["mes"];
        if(!isset($_GET["dpt"]))$_GET["dpt"]="Tots";
        $dpt = $_GET["dpt"];
        if(!isset($_GET["rol"]))$_GET["rol"]="Tots";
        $rol = $_GET["rol"];
        $idsubempdef = 0;
        $rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa='.$idempresa.' limit 1');
        foreach($rssbe as $se) {$idsubempdef = $se["idsubempresa"];}
        if(!isset($_GET["idsubemp"])){
            if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
            else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
            else $_GET["idsubemp"]=$idsubempdef;
        }        
        $idsubemp = $_GET["idsubemp"];
        $_SESSION["filtidsubempq"] = $idsubemp;
        
        if(!isset($_GET["tipusexcep"]))$tipusexcep="Tots";        
        else if($_GET["tipusexcep"]!="Tots")$tipusexcep = $dto->mostraNomExcep($_GET["tipusexcep"]);
        else $tipusexcep=$_GET["tipusexcep"];
        $anys = $dto->mostraAnysMarcatges();
        ?>
    <center>
        <br>
        <div class="row">
            <div class="col-lg-12 well">
                <div class="col-lg-3">
                    <h3 class="etiq"><?php echo $dto->__($lng,"Quadrant Mensual"); ?> <button class="btn btn-info" onclick="mostraNouPeriodeQuadrant(<?php echo $any.",".$mes.",'".$dpt."','".$rol."','".$idsubemp."',".$idempresa;?>);" title="<?php echo $dto->__($lng,"Introduir període especial per a una persona del quadrant");?>"><span class="glyphicon glyphicon-plus"></span> </button>
                    <button class="btn btn-warning" onclick="mostraCarregaQuadrantMes(<?php echo $any.",".$mes.",".$idsubemp;?>);" title="<?php echo $dto->__($lng,"Importar Quadrant via Excel");?>"><span class="glyphicon glyphicon-import"></span></button></h3>
                </div>
                <div class="col-lg-2">
                    <form method="GET" action="AdminQuadrants.php">
                        <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                    <?php
                        echo '<select name="idsubemp" onchange="this.form.submit();">
                        <option hidden selected value="'.$idsubemp.'">';
                        if($idsubemp=="Totes") echo $dto->__($lng,$idsubemp);
                        else echo $dto->mostraNomSubempresa($idsubemp);
                        echo '</option><option value="Totes">'.$dto->__($lng,"Totes").'</option>';                        
                        $resemp = $dto->mostraSubempreses($idempresa);
                        foreach ($resemp as $emp)
                        {
                        echo '<option value="'.$emp["idsubempresa"].'">'.$emp["nom"].'</option>';
                        }                        
                        echo '</select>';
                    ?>
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-1"><form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
                    <select name="dpt" onchange="this.form.submit();">
                    <option hidden selected value><?php echo $dto->__($lng,$dpt); ?></option>
                    <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                    <?php
                        $resdpt = $dto->mostraNomsDpt($idempresa);
                        foreach ($resdpt as $deptm)
                        {
                            echo '<option value="'.$deptm["nom"].'">'.$deptm["nom"].'</option>';
                        }
                    ?>                                  
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <form action="AdminQuadrants.php" method="GET">
                        <label><?php echo $dto->__($lng,"Perfil"); ?>:</label><br>
                        <select name="rol" onchange="this.form.submit();">
                            <option hidden selected value><?php echo $dto->__($lng,$rol); ?></option>
                            <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                            <?php
                                $resrol = $dto->mostraRolsEmpleat($idempresa);
                                foreach ($resrol as $rl)
                                {
                                echo '<option value="'.$rl["nom"].'">'.$rl["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <!--div class="col-lg-2">
                    <form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Tipus"); ?>:</label><br>
                    <select name="tipusexcep" onchange="this.form.submit();">
                    <option hidden selected value><?php echo $dto->__($lng,$tipusexcep); ?></option>
                    <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select>
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div-->
                <div class="col-lg-1"><form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
                    <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                    <?php
                    $toyear = date('Y',strtotime('today'));
                    for($year=2017;$year<=($toyear+1);$year++)
                   
                    {
                        echo '<option value:"'.$year.'">'.$year.'</option>';
                    }
                    
                    ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-1"><form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Mes");?>:</label><br>
                    <select name="mes" id="LlistaMesos" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                    <?php
                    for($month=1;$month<=12;$month++)
                    {
                        echo '<option value="'.$month.'">'.$dto->__($lng,$dto->mostraNomMes($month)).'</option>';//
                    }
                    ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success btn-lg" onclick="taulaAExcel('tblquadrant','<?php echo $dto->__($lng,$dto->mostraNomMes($mes));?>','<?php echo $dto->__($lng,"Quadrant")." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?>');" title="<?php echo $dto->__($lng,"Exportar a Excel");?>"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <button class="btn btn-primary btn-lg" onclick="printElem('tblquadrant');" title="<?php echo $dto->__($lng,"Imprimir"); ?>"><span class="glyphicon glyphicon-print"></span></button>
                </div>
            </div>
        </div>
        <!br>
        <div class="row" style="padding-left: 10px; padding-right: 10px">
            <div class="col-lg-12 container well" id="tblquadrant">
                
                <?php
                    $diesmes = 0;
                    $dia = new DateTime(); 
                    $dia->setISODate($any,0);
                    $undiames = new DateInterval('P1D');
                    while($dia->format('Y')<$any)$dia->add($undiames);
                    while($dia->format('m')<$mes)$dia->add($undiames);
                    for($i=1;(($dia->format('m')==$mes));$i++){$dia->add($undiames);$diesmes++;}
                    $mesant = $mes-1;
                    $anyant = $any;
                    if($mesant<1){$mesant = 12;$anyant=$any-1;}
                    $messeg = $mes+1;
                    $anyseg = $any;
                    if($messeg>12){$messeg=1;$anyseg=$any+1;}
                ?>
        <table class="table table-bordered table-condensed table-hover" style="text-align:center; width: 90%; background-color: white; border-collapse: collapse; border: solid 1px;"><!---->
            <thead>                    
                <tr>
                    <th style="display: none">DNI</th>
                    <th rowspan="0" style="text-align: center"><?php echo $dto->__($lng,"Persona / Mes"); ?></th>
                    <th colspan="5" style="text-align: center" class="noExl">
                        <form action="AdminQuadrants.php" method="GET">
                            <button class="btn btn-default btn-xs" title="Mes Anterior" onclick="this.form.submit()">
                                <span class="glyphicon glyphicon-arrow-left"></span> <strong><?php echo $dto->__($lng,$dto->mostraNomMes($mesant))." ".$anyant; ?></strong>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $mesant; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyant; ?>">
                        </form>
                        </th>
                    <th colspan="<?php echo $diesmes;?>" style="text-align: center"><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?></th>
                    <th colspan="5" style="text-align: center" class="noExl">
                        <form action="AdminQuadrants.php" method="GET">
                            <button class="btn btn-default btn-xs" title="Mes Posterior" onclick="this.form.submit()">
                                <strong><?php echo $dto->__($lng,$dto->mostraNomMes($messeg))." ".$anyseg; ?></strong> <span class="glyphicon glyphicon-arrow-right"></span>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $messeg; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyseg; ?>">
                        </form>
                    </th>
                </tr>
                <tr>
                    <?php
                    $calmes = "";                    
                    for($a=0;$a<$diesmes;$a++){$dia->sub($undiames);} 
                    for($b=0;$b<5;$b++){$dia->sub($undiames);} 
                    $arrdatesmes = [];
                    $diaini = intval($dia->format('d'));
                    $zmesant = "";
                    if($mesant<10)$zmesant="0".$mesant; else $zmesant=$mesant;
                    for($i=$diaini;$i<($diaini+5);$i++)
                    {
                        $arrdatesmes[]=$anyant."-".$zmesant."-".$i;
                    }
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        
                            $zmes = "";
                            $zi="";
                            if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                            if($i<10)$zi="0".$i; else $zi=$i;                            
                            $arrdatesmes[]=$any."-".$zmes."-".$zi;
                    }
                    $zmesesg = "";
                    if($messeg<10)$zmesseg="0".$messeg; else $zmesseg=$messeg;
                    for($i=1;$i<=5;$i++)
                    {
                        $arrdatesmes[]=$anyseg."-".$zmesseg."-0".$i;
                    }
                    for($c=0;$c<5;$c++) 
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#13".$dto->__($lng,"Festiu a").": ".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $calmes.= '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    echo '<th style="display: none"></th><th style="display: none"></th>';
                    for($i=1;(($i<=31)&&($dia->format('m')==$mes));$i++)
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#13".$dto->__($lng,"Festiu a").": ".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $calmes.= '<th rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    for($d=0;$d<5;$d++) 
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#13".$dto->__($lng,"Festiu a").": ".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $calmes.= '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                try{
                $sqlsubemp = '';
                if($idsubemp!="Totes") $sqlsubemp = 'and e.idsubempresa='.$idsubemp;
                $sqljoindpt = '';
                $sqlnomdpt = '';
                if($dpt!="Tots") {
                    $sqljoindpt = 'join pertany as p on p.id_emp = e.idempleat join departament as dp on dp.iddepartament = p.id_dep';
                    $sqlnomdpt = 'and dp.nom like "'.$dpt.'"';
                }
                $sqljoinrol = '';
                $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
                $sqlnomrol = '';
                if($rol!="Tots") {
                    $sqlnomrol = 'and ro.nom like "'.$rol.'"';
                    $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';                    
                }
                
                $sqlpers = 'select e.idempleat as idempleat, e.cognom1 as cognom1, e.cognom2 as cognom2, e.nom as nomempl, e.dni as dni '
                        . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                        . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0))) order by e.cognom1, e.cognom2, e.nom';//
               
                $persones = $dto->getDb()->executarConsulta($sqlpers);
                
                
                }catch(Exception $ex){echo '<tr><td>'.$ex->getMessage().'</td></tr>';} 
                $prifestius = $dto->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"prifestius");
                $marcafestius = $dto->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"marcafestius");
                $arrempl = [];
                $dispm = array_fill(0,($diesmes+10),0);
                $dispt = array_fill(0,($diesmes+10),0);
                $dispn = array_fill(0,($diesmes+10),0);
                $dispmt = array_fill(0,($diesmes+10),0);
                $disponibles = array_fill(0,($diesmes+10),0);
                $arrttfrac = [];
                $rstt = $dto->getDb()->executarConsulta('select idtipustorn as idt, tf.mati as mt, tf.tarda as td, tf.nit as nt, tt.colortxt as colortxt, tt.colorbckg as colorbckg, tt.abrv as abrv, tt.nom as nom, tt.horaentrada as horaentrada, tt.horasortida as horasortida, tt.horestreball as horestreball from tipustorn as tt join tornfrac as tf on tt.torn = tf.idtornfrac');
                foreach($rstt as $tpt){$ttfrac = array_fill(0,11,0);$ttfrac[0]=$tpt["idt"];$ttfrac[1]=$tpt["mt"];$ttfrac[2]=$tpt["td"];$ttfrac[3]=$tpt["nt"];$ttfrac[4]=$tpt["colortxt"];$ttfrac[5]=$tpt["colorbckg"];$ttfrac[6]=$tpt["abrv"];$ttfrac[7]=$tpt["nom"];$ttfrac[8]=$tpt["horaentrada"];$ttfrac[9]=$tpt["horasortida"];$ttfrac[10]=$tpt["horestreball"];$arrttfrac[]=$ttfrac;}
                foreach ($persones as $empleat) 
                    {
                    //Consultar les rotacions del mes de cada empleat (A realitzar en una sola consulta abans per a tots) i ficar el resultat de la BD en un array:
                    $arrdatesrot =[];
                    $rsrot = $dto->getDb()->executarConsulta('select data, idtipustorn, idrotacio from rotacio where idempleat='.$empleat["idempleat"].' and date(data)>="'.$anyant.'-'.$zmesant.'-'.$diaini.'" and date(data)<="'.$anyseg.'-'.$zmesseg.'-05"');                    
                    foreach($arrdatesmes as $dtm){                            
                        $dayfound = 0;
                        $arrrotdia = array_fill(0,3,0);
                        foreach($rsrot as $rot){                        
                            if($rot["data"]==$dtm){
                                $arrotdia[0]=$rot["data"];
                                $arrotdia[1]=$rot["idtipustorn"];
                                $arrotdia[2]=$rot["idrotacio"];
                                $dayfound = 1;
                            }                   
                        }
                        if($dayfound==0) {
                            $arrotdia[0]=$dtm;
                            $arrotdia[1]=0;
                            $arrotdia[2]=null;
                        }
                       
                        $arrdatesrot[]=$arrotdia;
                    }                    
                    echo "<tr>";
                    echo '<td style="display: none">'.$empleat["dni"].'</td>';
                    echo '<td style="width:1%; white-space:nowrap; border: solid 1px;"><form method="get" style="display:inline">
                <button type="submit" style="background-color:white; cursor:pointer; width:100%; border: none" formaction="AdminMarcatgesEmpleat.php" name="id" value="'.$empleat["idempleat"].'" title="'.$dto->__($lng,"Veure els marcatges de l'usuari").'"><strong>'.$empleat["cognom1"].' '.$empleat["cognom2"].', '.$empleat["nomempl"].'</strong></button></form></td>';
                    // Imprimir horaris/rotacions dels 5 dies anteriors del mes seleccionat
                    $i=0;
                    for($e=$diaini;$e<($diaini+5);$e++){
                        
                        $i++;
                        $isexcep = 0;
                        $zmesant = "";
                        if($mesant<10)$zmesant="0".$mesant; else $zmesant=$mesant;  
                        $festiu = $dto->esFestiuPerIdDia($empleat["idempleat"],$anyant."-".$zmesant."-".$e);
                        $rota = $arrdatesrot[$i-1][2];                        
                        if(!empty($dto->esExcepcioPerIdDia($empleat["idempleat"],$anyant."-".$zmesant."-".$e))) 
                        {
                            $isexcep = 1;
                            $onclick = "";
                            $excepcio = $dto->esExcepcioPerIdDia($empleat["idempleat"],$anyant."-".$zmesant."-".$e);
                            foreach($excepcio as $excep) 
                            {
                                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                            }
                            if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                            else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                { 
                                echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                               
                                }
                            else echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                        }
                       
                        else if(!empty($rota)) { //BUSCAR A L'ARRAY DE ROTACIONS DE L'EMPLEAT QUE HEM CREAT ABANS
                            $title="";
                            $bckg = "";
                            $color = "";
                            $abr = "";
                            $tt = $arrdatesrot[$i-1][1];
                            foreach($arrttfrac as $ttch){    
                                if($ttch[0]==$tt){
                                $bckg = $ttch[5];
                                $color = $ttch[4];
                                $abr = $ttch[6];
                                $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                }
                            }
                            
                            echo '<td class="noExl" title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                            
                            $disponibles[$i-1]++;
                        }
                            // Afegir condició per si l'empresa prioritza els festius als horaris regulars    
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td class="noExl" title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyant."-".$zmesant."-".$e."',".');"></td>';
                            }
                            else if(!$dto->treballaria($empleat["idempleat"],$any."-".$zmes."-".$zi)) {
                                echo '<td class="noExl" title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyant."-".$zmesant."-".$e."',".');"></td>';
                            }
                            // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
                            else {echo '<td class="noExl" title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($empleat["idempleat"],$anyant."-".$zmesant."-".$e,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyant."-".$zmesant."-".$e."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$empleat["idempleat"],"nom"),0,1).'</td>'; 
                           
                            $disponibles[$i-1]++;}
                            if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$i-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} 
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$i-1]+=1;break;
                                case 2: $dispt[$i-1]+=1;break;
                                case 3: $dispn[$i-1]+=1;break;
                                case 4: $dispmt[$i-1]+=1;break; // Nou array de Matí i Tarda
                                }
                            }
                    }
                    $i=0;
                    // IMPRIMIR ROTACIONS I HORARIS DEL MES SELECCIONAT
                    for($e=6;$e<=($diesmes+5);$e++)
                    {
                        $i++;
                        $isexcep = 0;
                        if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                        if($i<10)$zi="0".$i; else $zi=$i;
                        $festiu = $dto->esFestiuPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi);
                        $rota = $arrdatesrot[$e-1][2];
                        
                       
                            $festiu = $dto->esFestiuPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi);
                           
                            $rota = $arrdatesrot[$e-1][2];
                            
                            if(!empty($dto->esExcepcioPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi))) 
                            {
                                $isexcep = 1;
                                $onclick = "";
                                $excepcio = $dto->esExcepcioPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi);
                                foreach($excepcio as $excep) 
                                {
                                    $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                                }
                                if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                                else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                    { 
                                    echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                                    
                                    }
                                else echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                            }
                            
                            else if(!empty($rota)) { //BUSCAR A L'ARRAY DE ROTACIONS DE L'EMPLEAT QUE HEM CREAT ABANS
                                    $title="";
                                    $bckg = "";
                                    $color = "";
                                    $abr = "";
                                $tt = $arrdatesrot[$e-1][1];
                                foreach($arrttfrac as $ttch){    
                                    if($ttch[0]==$tt){
                                    $bckg = $ttch[5];
                                    $color = $ttch[4];
                                    $abr = $ttch[6];
                                    $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                    }
                                }
                                
                                echo '<td title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                                
                                $disponibles[$e-1]++;
                            }
                            // Afegir condició per si l'empresa prioritza els festius als horaris regulars    
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$any."-".$zmes."-".$zi."',".');"></td>';
                            }
                            else if(!$dto->treballaria($empleat["idempleat"],$any."-".$zmes."-".$zi)) {
                                echo '<td title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$any."-".$zmes."-".$zi."',".');"></td>';
                            }
                            // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
                            else {echo '<td title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$any."-".$zmes."-".$zi."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$empleat["idempleat"],"nom"),0,1).'</td>'; 
                            
                            $disponibles[$e-1]++;}
                        //
                        if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$e-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} // Matí i Tarda
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$e-1]+=1;break;
                                case 2: $dispt[$e-1]+=1;break;
                                case 3: $dispn[$e-1]+=1;break;
                                case 4: $dispmt[$e-1]+=1;break; // Nou array de Matí i Tarda
                            }
                        }
                    }
                    $e=0;
                    // IMPRIMIR ROTACIONS I TORNS DELS 5 DIES DEL MES SEGÜENT AL SELECCIONAT
                    for($f=($diesmes+6);$f<=($diesmes+10);$f++){
                        
                        $e++;
                        $isexcep = 0;
                        $zmesseg="";
                        if($messeg<10)$zmesseg="0".$messeg; else $zmesseg=$messeg;  
                        $festiu = $dto->esFestiuPerIdDia($empleat["idempleat"],$anyseg."-".$zmesseg."-0".$e);
                        $rota = $arrdatesrot[$f-1][2];
                        if(!empty($dto->esExcepcioPerIdDia($empleat["idempleat"],$anyseg."-".$zmesseg."-0".$e))) 
                        {
                            $isexcep = 1;
                            $onclick = "";
                            $excepcio = $dto->esExcepcioPerIdDia($empleat["idempleat"],$anyseg."-".$zmesseg."-0".$e);
                            foreach($excepcio as $excep) 
                            {
                                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                            }
                            if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                            else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                { 
                                echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                                
                                }
                            else echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                        }
                        
                        else if(!empty($rota)) { 
                                $title="";
                                $bckg = "";
                                $color = "";
                                $abr = "";
                            $tt = $arrdatesrot[$f-1][1];
                            foreach($arrttfrac as $ttch){    
                                if($ttch[0]==$tt){
                                $bckg = $ttch[5];
                                $color = $ttch[4];
                                $abr = $ttch[6];
                                $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                }
                            }
                            
                            echo '<td class="noExl" title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                           
                        $disponibles[$f-1]++;}
                        
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td class="noExl" title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyseg."-".$zmesseg."-0".$e."',".');"></td>';
                            }
                            else if(!$dto->treballaria($empleat["idempleat"],$anyseg."-".$zmesseg."-0".$e)) {
                                echo '<td class="noExl" title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyseg."-".$zmesseg."-0".$e."',".');"></td>';
                            }
                            // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
                            else {echo '<td class="noExl" title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($empleat["idempleat"],$anyseg."-".$zmesseg."-0".$e,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$empleat["idempleat"].",'".$anyseg."-".$zmesseg."-0".$e."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$empleat["idempleat"],"nom"),0,1).'</td>'; 
                           
                            $disponibles[$f-1]++;}
                            if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$f-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} 
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$f-1]+=1;break;
                                case 2: $dispt[$f-1]+=1;break;
                                case 3: $dispn[$f-1]+=1;break;
                                case 4: $dispmt[$f-1]+=1;break; // Nou array de Matí i Tarda
                            }
                        }
                    }
                    echo "</tr>";
                    
                }
                    // TOTAL DISPONIBLES
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px;">'.$dto->__($lng,"Total Disponibles").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($disponibles[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($disponibles[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                ?>                
                    <td><button class="btn btn-default btn-sm" onclick="mostraPeuNecess();" title="Mostrar/Ocultar Necessitats"><span class="glyphicon glyphicon-folder-open"></span></button></td>
                <?php                
                if($tipusexcep=="Tots")
                    {
                    // TORNS MATÍ
                    $bckm = "yellow";
                    $colm = "black";
                    $rstcm = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "M"');
                    if(!empty($rstcm)) { foreach($rstcm as $cm) {$bckm = $cm["colorbckg"]; $colm = $cm["colortxt"];} }
                    echo '<tr id="peudispm" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispm[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispm[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispm[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA
                    $bckmt = "orange";
                    $colmt = "white";
                    $rstcmt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=4 order by idtipustorn limit 1');
                    if(!empty($rstcmt)) { foreach($rstcmt as $cmt) {$bckmt = $cmt["colorbckg"]; $colmt = $cmt["colortxt"];} }
                    echo '<tr id="peudispmt" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispmt[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispmt[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispmt[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    $bckt = "orangered";
                    $colt = "white";
                    $rstct = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "T"');
                    if(!empty($rstct)) { foreach($rstct as $ct) {$bckt = $ct["colorbckg"]; $colt = $ct["colortxt"];} }
                    echo '<tr id="peudispt" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispt[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispt[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispt[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS NIT
                    $bckn = "navy";
                    $coln = "white";
                    $rstcn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "N"');
                    if(!empty($rstcn)) { foreach($rstcn as $cn) {$bckn = $cn["colorbckg"]; $coln = $cn["colortxt"];} }
                    echo '<tr id="peudispn" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispn[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispn[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispn[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                else
                    {
                    echo '<tr><th style="display: none"></th><th style="text-align: center">'.$dto->__($lng,"Total de").' '.$dto->__($lng,$tipusexcep).'</th>';
                    $rgb = $dto->getExcepColors($tipusexcep);
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        if($disponibles[$i-1]>0) echo '<td style="background-color: rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')">';
                        else echo '<td>';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                ?>
            </body>
            <tr></tr>
            <tfoot id="peunec" style='<?php echo $dispnec;?>'>
            <?php
           
            $arrnecm = array_fill(0,($diesmes+10),0);
            $arrnecmt = array_fill(0,($diesmes+10),0);
            $arrnect = array_fill(0,($diesmes+10),0);
            $arrnecn = array_fill(0,($diesmes+10),0);
            
            $rsnecsubmes = $dto->getDb()->executarConsulta('select * from necsubmes where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes);
            if(empty($rsnecsubmes)){
                for($i=1;$i<=($diesmes);$i++){
                    for($n=1;$n<5;$n++){
                        $dto->getDb()->executarSentencia('insert into necsubmes (idsubempresa,anynec,mesnec,dianec,idtornfrac) values ('.$idsubemp.','.$any.','.$mes.','.$i.','.$n.')');
                    }
                }
                $rsnecsubmes = $dto->getDb()->executarConsulta('select * from necsubmes where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes);
            }
            $arrnec = [];
            foreach($rsnecsubmes as $rn){                
                $arrrsnc = array_fill(0,4,0);
                $arrrsnc[0] = $rn["idnecsubmes"];
                $arrrsnc[1] = $rn["dianec"];
                $arrrsnc[2] = $rn["idtornfrac"];
                $arrrsnc[3] = $rn["empleats"];
                $arrnec[]=$arrrsnc;                
            }
            // CREAR ARRAYS PER A CADA TIPUS DE FRACCIÓ DE TORN O BÉ UN SOL ARRAY ON CERCAR CADA COP EL VALOR EN FUNCIO DELS PARÀMETRES QUE TOQUIN
            foreach($arrnec as $nc){
                // filtrar quin tipus de fraccio de torn
                for($n=1;$n<5;$n++){
                    
                    if($nc[2]==$n){
                        switch($n){
                            case 1: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecm[($nc[1]+4)]=$arrdn; break;
                            case 2: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnect[($nc[1]+4)]=$arrdn; break;
                            case 3: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecn[($nc[1]+4)]=$arrdn; break;
                            case 4: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecmt[($nc[1]+4)]=$arrdn; break;
                        }
                       
                }
                }
            }
            $necm=[];
            $necmt=[];
            $nect=[];
            $necn=[];
            echo '<tr style="background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); color: white;"><th style="display: none"></th><th style="text-align: center; font-weight: bold;">'.$dto->__($lng,"Necessitat")." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any.'</th>';
            echo $calmes;
            echo '</tr>';
                    // TORNS MATÍ
                    $bckm = "yellow";
                    $colm = "black";
                    $rstcm = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "M"');
                    if(!empty($rstcm)) { foreach($rstcm as $cm) {$bckm = $cm["colorbckg"]; $colm = $cm["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                   
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        
                        $necm = $arrnecm[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                       
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necm[1].';}" onblur="actualitzaNCampTaulaNR('."'necsubmes','empleats',".$necm[0].',this.innerHTML);">';
                        echo $necm[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA
                    $bckmt = "orange";
                    $colmt = "white";
                    $rstcmt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=4 order by idtipustorn limit 1');
                    if(!empty($rstcmt)) { foreach($rstcmt as $cmt) {$bckmt = $cmt["colorbckg"]; $colmt = $cmt["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                    
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        
                        $necmt = $arrnecmt[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                        
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necmt.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$necmt[0].','.$necmt[1].',this.innerHTML);">';
                        echo $necmt[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    $bckt = "orangered";
                    $colt = "white";
                    $rstct = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "T"');
                    if(!empty($rstct)) { foreach($rstct as $ct) {$bckt = $ct["colorbckg"]; $colt = $ct["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    
                    for($i=1;$i<=($diesmes+10);$i++)
                    {                        
                        
                        $nect = $arrnect[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                       
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$nect.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$nect[0].','.$nect[1].',this.innerHTML);">';
                        echo $nect[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS NIT
                    $bckn = "navy";
                    $coln = "white";
                    $rstcn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "N"');
                    if(!empty($rstcn)) { foreach($rstcn as $cn) {$bckn = $cn["colorbckg"]; $coln = $cn["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    
                    for($i=1;$i<=($diesmes+10);$i++)
                    {                        
                        
                        $necn = $arrnecn[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                       
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necn.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$necn[0].','.$necn[1].',this.innerHTML);">';
                        echo $necn[1].'</td>';
                    }
                    echo '</tr>';
            
                    echo '<tr style="background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); color: white;"><th style="display: none"></th><th style="text-align: center; font-weight: bold;">'.$dto->__($lng,"Compliment").'</th>';
                    echo $calmes;
                    echo '</tr>';
                    // TORNS MATÍ                    
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                       
                            else{
                        $necm = $arrnecm[$i-1];
                        $snm = $dispm[$i-1]-$necm[1];
                        if($snm==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snm>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snm.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snm.'</td>';
                        
                        }                        
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA                    
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                        
                            else{
                        $necmt = $arrnecmt[$i-1];
                        $snmt = $dispmt[$i-1]-$necmt[1];
                        if($snmt==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snmt>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snmt.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snmt.'</td>';
                       
                        }
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5)))
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                        
                            else{
                        $nect = $arrnect[$i-1];
                        $snt = $dispt[$i-1]-$nect[1];
                        if($snt==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snt>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snt.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snt.'</td>';
                        
                        }
                    }
                    echo '</tr>';
                    // TORNS NIT
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                       
                        else{
                            $necn = $arrnecn[$i-1];
                            $snn = $dispn[$i-1]-$necn[1];
                            if($snn==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                            else if($snn>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snn.'</td>';
                            else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snn.'</td>';
                            
                        }
                    }
                    echo '</tr>';
                    // VEURE QUE PASSA AMB L'ARRAY DE NECESSITATS REGISTRADES (A COMPARAR AMB LES DISPONIBILITATS)
            ?> 
            </tfoot>
        </table>
                <button class="btn btn-default btn-sm" onclick="mostraPeuNecess();"><span class="glyphicon glyphicon-folder-open"></span></button>
                <br>
        </div><br>
        <div class="col-lg-l"></div>
    </div>
    <div id="tauladisp" class="row" style="padding-left: 10px; padding-right: 10px; <?php echo $dispnec;?>">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 well">
            <h3 class="etiq"><?php echo $dto->__($lng,"Necessitats del Quadrant");?></h3>  <button class="btn btn-success" onclick="mostraEnganxaNecessitat(<?php echo $any.",".$mes.",0,0,".$idsubemp;?>);" title="<?php echo $dto->__($lng,"Aplicar Necessitat al Quadrant del Mes Seleccionat");?>"><span class="glyphicon glyphicon-export"></span> </button></h3><br><br>
            <div class="row">
                <div class="col-lg-4">
                    <h4 class="smtag"><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",1,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,1);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn12">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,2);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn13">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,3); ?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </tfoot>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h4 class="smtag"><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",2,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn21">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,1);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn22">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,2);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn23">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,3); ?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </tfoot>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h4 class="smtag"><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",3,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn31">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,1);?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </thead>
                    </table>
                    <br>                    
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn32">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,2);?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </thead>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn btn-success btn-xs" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th></th>
                        </thead>
                        <tbody id="tbn33">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,3); ?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </center>
    <div class="modal fade" id="modAssignaNouPeriodeQuadrant" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Registrar Nou Període Especial");?></h3></div>
                <div class="modal-body">
                    <form name="assignaperiodequadrant">
                    <label><?php echo $dto->__($lng,"Persona");?>:</label>
                    <select name="idemp">
                        <?php
                        try{
                       
                        foreach($persones as $p)
                        {
                            $treballa=false;         
                            for($i=1;$i<=$diesmes;$i++) 
                            {
                                if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                                if($i<10)$zi="0".$i; else $zi=$i;
                                if($dto->treballaria($p["idempleat"],$any."-".$zmes."-".$zi)) $treballa=true;
                                else if($dto->terotacio($p["idempleat"],$any."-".$zmes."-".$zi)) $treballa=true;
                            }
                            if($treballa) echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nom"].'</option>';
                        }
                        ?>
                    </select><br><br>                    
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select name="idtipusexcep">
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    ?>
                    </select><br><br>
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="dataini" required><br><br>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi" required><br><br>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-info" data-toggle="modal" onclick="assignaExcep(assignaperiodequadrant.idemp.value,assignaperiodequadrant.idtipusexcep.value,assignaperiodequadrant.dataini.value,assignaperiodequadrant.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 25px"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    </body>    
        <iframe id="upload_quadrant" name="upload_quadrant" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</html>
