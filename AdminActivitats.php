<!DOCTYPE html>
<html>
    <head>
        <?php 
        session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl(); 
        ?>
        <script lang="text/javascript">
           
            var width = $(window).width();
            document.getElementById('cnttbl').style.width = width+"px";
            
            document.getElementById('divtbl').style.width = width+"px";
        function assignaActivitat(id,idtipus,data,horaini,horafi)
        {
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaActivitat&id=" + id + "&idtipus=" + idtipus + "&data=" + data + "&horaini=" + horaini + "&horafi=" + horafi, true);
            xmlhttp.send();
        }
        function confElimActiv(idactiv,nomactiv,nompers)
        {
        document.getElementById("tipusactivaelim").innerHTML = nomactiv;
        document.getElementById("nompersactiv").innerHTML = nompers;
        $('#idactivaelim').val(idactiv);
        $modal = $('#modConfElimActivitat');
        $modal.modal('show');
        }
        
        function eliminaActivitat(idactiv)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaActivitat&id=" + idactiv, true);
            xmlhttp.send();
        }

      
        </script>
    </head>
    <body id="bodyact" onload="var width = $(window).width();document.getElementById('cnttbl').style.width = width+'px';width-=270;document.getElementById('divtbl').style.width = width+'px';DoubleScroll(document.getElementById('divtbl'),270);" style="display: table; position: absolute; top: 0px; bottom: 62px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden">
        <div style="width: 100%; color: white; background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); position: absolute; top: 0px; height: 62px; margin-bottom: 0">
        <?php $dto->navResolver();?>
        </div>
        <div id="content"style="display: table-row; width: 100%; float: right; text-align: center; position: absolute; top: 62px; bottom: 0px; overflow-x: hidden; overflow-y: auto; margin-top: 0px; background-color: white; background-size: cover">
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = $_SESSION["idempresa"];
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
        $mes = $_GET["mes"];
        $setmana="";
        $setmanaact = "";
        if(!isset($_GET["setmana"])){$setmana=date("W",$d);$dia = new DateTime();$dia->setISODate($any, $setmana);$setmanaact = ($setmana).' ('.$dia->format('d-M-Y').')';}
        else {$setmana = $_GET["setmana"];}
        $setmanesopt = "";
        $setmanes = $dto->mostraSetmanesMesAny($any,$mes);
        $i=0;
        foreach($setmanes as $week)
        {            
            $dia = new DateTime();
            $dia->setISODate($any, $week);
            if(($i==0)&&($setmana=="")){$setmana=$week;$setmanaact = abs($setmana).' ('.$dia->format('d-M-Y').')';}
            else if($setmana==$week) {$setmanaact = abs($setmana).' ('.$dia->format('d-M-Y').')';}
            $setmanesopt.= '<option value="'.($week).'">'.abs($week).' ('.$dia->format('d-M-Y').')</option>';
            $i++;
        }        
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
        if(!isset($_GET["tipusactivitat"]))$tipusactivitat="Totes";        
        else if ((isset($_GET["tipusactivitat"]))&&($_GET["tipusactivitat"])<>"Totes") $tipusactivitat = $dto->mostraNomPerIdTaula($_GET["tipusactivitat"],"tipusactivitat");
        else $tipusactivitat = "Totes";
        $anys = $dto->mostraAnysMarcatges();
        ?>
    <center>
        <br>
        <div class="row">
            <div class="col-lg-12 well">
            <div class="col-lg-3">
                <h3 class="etiq"><?php echo $dto->__($lng,"Agenda Setmanal"); ?> <button class="btn btn-warning" data-toggle="modal" data-target="#modAssignaNovaActivitat" title="<?php echo $dto->__($lng,"Nova Activitat");?>"><span class="glyphicon glyphicon-plus"></span></button></h3>
            </div>
            <div class="col-lg-1" style="width:15%">
                <form method="GET" action="AdminActivitats.php">
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
                    <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                    </form>
            </div>
                <div class="col-lg-1" style="width:10%">
                    <form action="AdminActivitats.php" method="GET">
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
                    <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                    </form>
                </div>
            <div class="col-lg-1" style="width:10%"><form action="AdminActivitats.php" method="GET"><label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
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
                <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                </form>
            </div>
            
            <div class="col-lg-1" style="width:10%"><form action="AdminActivitats.php" method="GET"><label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
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
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                </form>
            </div>
            <div class="col-lg-1" style="width:10%"><form action="AdminActivitats.php" method="GET"><label><?php echo $dto->__($lng,"Mes");?>:</label><br>
                <select name="mes" id="LlistaMesos" onchange="this.form.submit()">
                <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                <?php
                for($month=1;$month<=12;$month++)
                {
                    echo '<option value="'.$month.'">'.$dto->__($lng,$dto->mostraNomMes($month)).'</option>';//
                }
                ?>
                </select>
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="setmana" value="">
                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                </form>
            </div>
            <div class="col-lg-1" style="width:10%"><form action="AdminActivitats.php" method="GET"><label><?php echo $dto->__($lng,"Setmana");?>:</label><br>
                <select name="setmana" id="LlistaSetmanes" onchange="this.form.submit()">
                <option hidden selected value>
                    <?php 
                        echo $setmanaact;
                    ?>
                </option>
                <?php
                echo $setmanesopt;
                ?>
                </select>
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                <input type="hidden" name="tipusactivitat" value="<?php echo $tipusactivitat; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                </form>
            </div>
            </div>
        </div>
        <div id="cnttbl" class="col-lg-12 well" style=''><div id="divtbl" class="divtbl" style="overflow: auto; overflow-y: hidden; padding: 0; margin-left: 240px; margin-right: 20px;">
        <table class="table" style="border-collapse: collapse; border-spacing: 0; border-top: 1px solid grey; background-color: white; text-align:center; align-self: flex-end">
            <thead>                    
                <tr>
                    <th class="headcol"  style="height: 35px; text-align: center; background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90));
    color: white; border-top: solid grey 1px;"><?php echo $dto->__($lng,"Persona / Dia");?></th>
                    <?php
                    $dia = new DateTime();
                    $dia->setISODate($any,$setmana);
                    $diessetmana = 0;
                    $undiames = new DateInterval('P1D');
                    while($dia->format('Y')<$any)$dia->add($undiames);
                    while($dia->format('m')<$mes)$dia->add($undiames);
                    
                    while(date('w',strtotime($dia->format('Y-m-d')))>1)$dia->sub($undiames);
                    for($i=1;($i<=7);$i++) 
                    {
                        echo '<th class="long" style="height: 25px; margin: 0;
  border: 1px solid grey;
  white-space: nowrap;
  border-bottom-width: 0px; text-align: center" colspan="24">'.$dto->__($lng,$dto->mostraNomDia((date("w",strtotime($dia->format("Y-m-d"))))))." ".$dia->format("d/m/Y").'</th>';
                        $dia->add($undiames);
                        $diessetmana++;
                    }
                    echo '</tr>
  <tr style="height: 25px"><td class="headcol" style="height: 35px; text-align: center; background-image: linear-gradient(rgb(90,90,90),rgb(45,45,45));
    color: white;">'.$dto->__($lng,"Hores").'</td>';
                    for($i=1;($i<=7);$i++)
                    {
                        for($j=0;$j<24;$j++)
                        {
                            if($j<10) echo '<td class="long" style="height: 25px; text-align: center">0'.$j.'</td>';
                            else echo '<td class="long" style="height: 25px; text-align: center">'.$j.'</td>';
                        }
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
               
                $sqlpers = 'select *, e.nom as nomempl '
                        . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                        . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0))) order by e.cognom1, e.cognom2, e.nom';//
                
                $persones = $dto->getDb()->executarConsulta($sqlpers);
                
                
                }catch(Exception $ex){echo '<tr><td>'.$ex->getMessage().'</td></tr>';}
                $pid = 0;
                $disponibles = array_fill(0,168,0);
                foreach ($persones as $p)
                {
                    $horessetm = 0;
                    $diat = new DateTime();
                    $diat->setISODate($any,$setmana);
                    $treballa=false;                   
                    for($i=1;$i<=7;$i++)
                        {
                        if(
                                ($dto->treballaria($p["idempleat"],$diat->format("Y-m-d")))
                                ||
                                ($dto->terotacio($p["idempleat"],$diat->format("Y-m-d"))>0)
                            )$treballa=true;
                        $diat->add($undiames);
                        }
                    if($treballa)   
                    {
                    $pid = $p["idempleat"];
                    echo '<tr style="line-height: 25px;"><td class="headcol" style="margin: 0; border: solid grey 1px; border-collapse: collapse; white-space: nowrap;"><form method="get" style="display:inline">
                    <button type="submit" style="background-color:white; cursor:pointer; width:99%; position: absolute; top:2px; left:1px; border: none" formaction="AdminMarcatgesEmpleat.php" name="id" value="'.$p["idempleat"].'" title="'.$dto->__($lng,"Veure els marcatges de l'usuari").'"><strong>'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nomempl"].'</strong></button></form></td>';
                    $diap = new DateTime();
                    $diap->setISODate($any,$setmana);
                    $horessetm = 0;
                    for($i=1;$i<=7;$i++)
                    {                                          
                        for($j=0;$j<24;$j++)
                        {
                            $horessetm++;
                            $disponibles[($horessetm)-1]+= $dto->imprimeixHoraPerIdDiaHora($pid, $diap->format('Y-m-d'), $j, $lng);                            
                        }
                        $diap->add($undiames);
                    }
                    echo '</tr>';
                    }
                }
                
                
                echo '</tr>';
                
                // RECORDATORI HORES PER SI ES DESPLAÇA A LA PART INFERIOR
                echo '<tr><td class="headcol" style="height: 35px; text-align: center; background-image: linear-gradient(rgb(90,90,90),rgb(45,45,45),rgb(90,90,90)); color: white;">'.$dto->__($lng,"Hores").'</td>';
                    for($i=1;($i<=7);$i++)
                    {
                        for($j=0;$j<24;$j++)
                        {
                            if($j<10) echo '<td class="long" style="height: 35px; text-align: center; background-image: linear-gradient(rgb(90,90,90),rgb(45,45,45),rgb(90,90,90)); color: white;">0'.$j.'</td>';
                            else echo '<td class="long" style="height: 35px; text-align: center; background-image: linear-gradient(rgb(90,90,90),rgb(45,45,45),rgb(90,90,90)); color: white;">'.$j.'</td>';
                        }
                    }
                echo '</tr>';
                if($tipusactivitat=="Totes")
                    {
                    echo '<tr><th class="headcol" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-width: 1px;text-align: center">'.$dto->__($lng,"Disponibles").'</th>';
                    for($i=1;$i<=168;$i++)
                    {
                        if($disponibles[$i-1]==0) echo '<td class="long" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;background-color: rgb(255,128,128)">';
                        else if($disponibles[$i-1]==1) echo '<td class="long" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;background-color: rgb(255,255,128)">';
                        else echo '<td class="long" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;">';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                else
                    {
                    echo '<tr><th class="headcol" style="margin: 0; height: 35px; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;text-align: center">'.$dto->__($lng,"Total de").' '.$dto->__($lng,$tipusactivitat).'</th>';
                    $rgb = $rgb = array_fill(0,3,0);
                    $rgb[0]=128;
                    $rgb[1]=255;
                    $rgb[2]=255;
                    for($i=1;$i<=168;$i++)
                    {
                        if($disponibles[$i-1]>0) echo '<td class="long" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px; background-color: rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')">';
                        else echo '<td class="long" style="height: 35px; margin: 0; border: 1px solid grey; white-space: nowrap; border-top-width: 0px;">';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
        </div>
       
    </div>
        </div>
    </center>
    <div class="modal fade" id="modAssignaNovaActivitat" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Registrar Nova Activitat");?>:</h3>
                  </div>
                <div class="modal-body">
                    <form name="assignaactiv">
                    <label><?php echo $dto->__($lng,"Persona");?>:</label>
                    <select name="idemp">
                        <?php 
                        $persact = $dto->seleccionaPersonesPerEmpAnyMes($idempresa, $any, $mes);
                        foreach($persact as $p)
                        {
                            echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nom"].'</option>';
                        }
                        ?>
                    </select><br><br>                    
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select name="idtipusactiv">
                    <?php
                       
                        $tipus = $dto->getDb()->executarConsulta('select * from tipusactivitat');
                        foreach($tipus as $valor)
                        {
                            if($valor["idtipusactivitat"]<>4)
                            echo '<option value="'.$valor["idtipusactivitat"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select><br><br>
                    <label><?php echo $dto->__($lng,"Data");?>:</label><input type="date" name="data" required><br><br>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-4"><label><?php echo $dto->__($lng,"Hora Inici");?>:</label> <input type="time" name="horaini" required></div>
                        <div class="col-lg-4"><label><?php echo $dto->__($lng,"Hora Fi");?>:</label> <input type="time" name="horafi" required></div>
                    </div>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" onclick="assignaActivitat(assignaactiv.idemp.value,assignaactiv.idtipusactiv.value,assignaactiv.data.value,assignaactiv.horaini.value,assignaactiv.horafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimActivitat" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header"><?php echo $dto->__($lng,"Eliminar Activitat");?></div>
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar aquesta activitat per a:");?></h4>
                    <h3 id="nompersactiv">?</h3>
                    <label>Tipus:</label>
                    <h4 id="tipusactivaelim"></h4><br>
                    <form name="eliminaactivitat">
                    <input type="hidden" id="idactivaelim" name="idactivaelim">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaActivitat(eliminaactivitat.idactivaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    </body>
</html>
