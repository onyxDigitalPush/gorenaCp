<!DOCTYPE html>
<html>
    <head>
        <?php 
        session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl();?>
        <script>        
        function chkAllPers(numpers)
        {
            
            if(numpers>0) {
                if(document.getElementById('chkallpers').checked === true) {
                    for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = true;
                }
                else for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = false;
            }
        }
        function asgMultRot(numpers)
        {
           
            var anychk = 0;
            var stridpers = [];
            var strdataini = [];
            var nompers = "<tbody>";
            for(var i=1;i<=numpers;i++) {
                if(document.getElementById('pers'+i).checked === true) {
                    var data = new Date(document.getElementById('datainirot'+i).value);
                    var dd = data.getDate();
                    if(dd<10) { dd = "0"+dd; }
                    var mm = data.getMonth()+1;
                    if(mm<10) { mm = "0"+mm; }
                    var datacomp = dd+"/"+mm+"/"+data.getFullYear();
                    anychk=1;
                    stridpers.push(document.getElementById("idpers"+i).value);
                    strdataini.push(document.getElementById("datainirot"+i).value);
                    nompers+="<tr><td>"+document.getElementById('nompers'+i).value+"</td><td>"+datacomp+"</td></tr>";
                }
            }
            nompers+="</tbody>";
                    
            if(anychk===1) {
                document.getElementById('stridpersona').value = stridpers;
                document.getElementById('strdataini').value = strdataini;
                document.getElementById('nomspers').innerHTML = nompers;
                $modal = $('#modAsgMultRot');
                $modal.modal('show');
            }
            else {
                $modal = $('#modErrSelect');
                $modal.modal('show');
            }
        }
        function assignaRotacioMultipers(stridpers,strdataini,datafi)
        {
           
            popupwait();
            var data = new Date(datafi);
            var mm = data.getMonth()+1;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                popdownwait();
                window.location.replace("/AdminQuadrants.php?mes="+mm);
                
            }
            if (this.readyState === 4 && this.status === 404) {
                popdownwait();
                popuphtml(this.responseText);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaRotacioMultipers3T&stridpers=" + JSON.stringify(stridpers) + "&2=" + JSON.stringify(strdataini) + "&3=" + datafi, true);
            xmlhttp.send();
        }
        </script>
    </head> 
    <body onload="var width = $(window).width();document.getElementById('cnttbl').style.width = width+'px';width-=20;document.getElementById('divtbl').style.width = width+'px';DoubleScroll(document.getElementById('divtbl'),20);" style="display: table; position: absolute; top: 0px; bottom: 62px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden">
        <div style="width: 100%; color: white; background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); position: absolute; top: 0px; height: 62px; margin-bottom: 0">
        <?php $dto->navResolver();?>
        </div>
        <div id="content"style="display: table-row; width: 100%; float: right; text-align: center; position: absolute; top: 62px; bottom: 0px; overflow-x: hidden; overflow-y: auto; margin-top: 0px; background-color: white; background-size: cover">
        <?php
        $idemp = $_SESSION["idempresa"];
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_SESSION["id"];
        $master = $dto->esMaster($id);
        $idempresa = $idemp;
        if(!isset($_GET["idsubemp"])){
            if(isset($_SESSION["filtidsubemp"])) $_GET["idsubemp"] = $_SESSION["filtidsubemp"];
            else $_GET["idsubemp"]=0;
        }
        $idsubemp = $_GET["idsubemp"];
        $_SESSION["filtidsubemp"] = $idsubemp;
        if(!isset($_GET["dpt"])) $_GET["dpt"]=0;
        $dpt = $_GET["dpt"];
        $nomdpt = $dto->__($lng,"Tots");
        if($dpt!=0) $nomdpt = $dto->__($lng,$dto->getCampPerIdCampTaula("departament",$dpt,"nom"));
        if(!isset($_GET["rol"])) $_GET["rol"]=0;
        $rol = $_GET["rol"];
        $nomrol = $dto->__($lng,"Tots");
        if($rol!=0) $nomrol = $dto->__($lng,$dto->getCampPerIdCampTaula("rol",$rol,"nom"));
        if(!isset($_GET["situacio"])) $_GET["situacio"]=1;
        $situacio = $_GET["situacio"];
        $nomsituacio = "En Plantilla";
        switch($situacio){
            case 0: $nomsituacio = "Cessat"; break;
            case 2: $nomsituacio = "Totes"; break;
        }
        $tblpers = "";
        $tipustornopt = '<option value="0">('.$dto->__($lng,"Cap").')</option>';;
        $rstr = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idemp);
        foreach($rstr as $tr) {$tipustornopt.='<option value="'.$tr["idtipustorn"].'">'.$tr["nom"].'</option>';}
        $i = 0;
        $sqlsubemp = '';
        if($idsubemp!=0) $sqlsubemp = 'and e.idsubempresa='.$idsubemp;
        $sqljoindpt = '';
        $sqlnomdpt = '';
        if($dpt!=0) {
            $sqljoindpt = 'join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep';
            $sqlnomdpt = 'and d.iddepartament like "'.$dpt.'"';
        }
        $sqljoinrol = '';
        $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
        $sqlnomrol = '';
        if($rol!=0) {
            $sqlnomrol = 'and ro.idrol='.$rol;                   
        }
        $sqlenplant = '';
        if($situacio!=2) $sqlenplant = 'and e.enplantilla='.$situacio;
       
        $result = $dto->getDb()->executarConsulta('select *, e.nom as nomempl '
                . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' '.$sqlenplant.' order by e.cognom1, e.cognom2, e.nom');
            foreach ($result as $r)
            {
                $i++;
                $subemp = '';
                $chkrot = '';
                $chkalt = '';
                $chktmp = '';
                $chknat = '';
                $chknit = '';
                $chkdnt = '';
                $chksbs = '';
                if($r["rotacio"]==1) {$chkrot = 'checked';}
                if($r["alta"]==1) {$chkalt = 'checked';}
                if($r["temporal"]==1) {$chktmp = 'checked';}
                if($r["diesnat"]==1) {$chknat = 'checked';}
                if($r["nits"]==1) {$chknit = 'checked';}
                if($r["dianit"]==1) {$chkdnt = 'checked';}
                if($r["substsuperv"]==1) {$chksbs = 'checked';}
                $rolpers = $dto->getRolActiuPerId($r["idempleat"]);                
                $idsbeemp = $dto->getCampPerIdCampTaula("empleat",$r["idempleat"],"idsubempresa");
                if(!empty($idsbeemp)) {$subemp = $dto->getCampPerIdCampTaula("subempresa",$idsbeemp,"nom");}
               
                $nomh1 = $dto->getCampPerIdCampTaula("tipustorn",$r["idhorari1"],"nom");
                if((empty($r["idhorari1"])||$r["idhorari1"]==0)) $nomh1 = "(".$dto->__($lng,"Cap").")";
                $nomh2 = $dto->getCampPerIdCampTaula("tipustorn",$r["idhorari2"],"nom");
                if((empty($r["idhorari2"])||$r["idhorari2"]==0)) $nomh2 = "(".$dto->__($lng,"Cap").")";
                $nomh3 = $dto->getCampPerIdCampTaula("tipustorn",$r["idhorari3"],"nom");
                if((empty($r["idhorari3"])||$r["idhorari3"]==0)) $nomh3 = "(".$dto->__($lng,"Cap").")";
                    $tblpers.= "<tr>"
                   ."<td>".$r["cognom1"]." ".$r["cognom2"]."</td>"
                   ."<td>".$r["nomempl"]."</td>"
                   .'<td><form method="get" action="AdminFitxaEmpleat.php"><button type="submit" title="'.$dto->__($lng,"Veure Fitxa").'" class="btn btn-default btn-xs" name="id" value="'.$r["idempleat"].'"><span class="glyphicon glyphicon-user"></span></button></form></td>'
                   .'<td>'.$rolpers.'</td>'
                   .'<td><input type="date" id="datainirot'.$i.'" value="'.$r["ordredist"].'" onchange="actualitzaNCampTaulaNR('."'empleat','ordredist',".$r["idempleat"].',this.value);" style=""></td>'
                  
                   .'<td>'
                            .'<select onchange="actualitzaNCampTaulaNR('."'empleat','idhorari1',".$r["idempleat"].',this.value);" style="width: 125px; height: 25px;">'
                            . '<option hidden selected value="'.$r["idhorari1"].'">'.$nomh1.'</option>'
                            .$tipustornopt.'</select>'
                   .'</td>'
                   .'<td><input value="'.$r["dieslabor"].'" onchange="actualitzaNCampTaulaNR('."'empleat','dieslabor',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td>'
                            . '<select onchange="actualitzaNCampTaulaNR('."'empleat','idhorari2',".$r["idempleat"].',this.value);" style="width: 125px; height: 25px;">'
                            . '<option hidden selected value="'.$r["idhorari2"].'">'.$nomh2.'</option>'
                            .$tipustornopt.'</select>'
                   .'</td>'
                   .'<td><input value="'.$r["dieslabor2"].'" onchange="actualitzaNCampTaulaNR('."'empleat','dieslabor2',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td>'
                            . '<select onchange="actualitzaNCampTaulaNR('."'empleat','idhorari3',".$r["idempleat"].',this.value);" style="width: 125px; height: 25px;">'
                            . '<option hidden selected value="'.$r["idhorari3"].'">'.$nomh3.'</option>'
                            .$tipustornopt.'</select>'
                   .'</td>'
                   .'<td><input value="'.$r["dieslabor3"].'" onchange="actualitzaNCampTaulaNR('."'empleat','dieslabor3',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td><input value="'.$r["diesfesta"].'" onchange="actualitzaNCampTaulaNR('."'empleat','diesfesta',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>';
               
                $nomcomplet = "";
                $nomcomplet = $r["nom"]." ".$r["cognom1"]." ".$r["cognom2"];
                $btnx = "";
                $tblpers.= "<td><input type='hidden' id='nompers".$i."' value='".$nomcomplet."'><input type='hidden' id='idpers".$i."' value='".$r["idempleat"]."'><input id='pers".$i."' type='checkbox' style='height: 20px; width: 20px'></td>".'<td style="text-align: center">'.$btnx.'</td></tr>';
                //}
            }
        ?>
        <center>
            <br>
        <div class="row" id="FiltresEmpleats">
            <div class="col-lg-12 well">            
                <div class="col-lg-3"><h3 class="etiq"><?php echo $dto->__($lng,"Gestió de Persones")?></h3>
                </div>
                <div class="col-lg-2"><form method="GET" id="LlistaEmpreses" action="AdminAdvPersones.php">
                    <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                        <select name="idsubemp" onchange="this.form.submit();">
                    <?php
                        echo '<option hidden selected value="'.$idsubemp.'">';
                        if($idsubemp==0) echo $dto->__($lng,"Totes");
                        else echo $dto->mostraNomSubempresa($idsubemp);
                        echo '</option>'
                        . '<option value="0">'.$dto->__($lng,"Totes").'</option>';                        
                        $resemp = $dto->mostraSubempreses($idemp);
                        foreach ($resemp as $emp)
                        {
                        echo '<option value="'.$emp["idsubempresa"].'">'.$emp["nom"].'</option>';
                        }                        
                        echo '</select>';
                    ?>
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">                    
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaRols" action="AdminAdvPersones.php">
                        <label><?php echo $dto->__($lng,"Perfil"); ?>:</label><br>
                        <select name="rol" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $rol; ?>"><?php echo $nomrol; ?></option>
                            <option value="0"><?php echo $dto->__($lng,"Tots");?></option>
                            <?php
                                $resrol = $dto->mostraRols($idempresa,$master);
                                foreach ($resrol as $rol)
                                {
                                echo '<option value="'.$rol["idrol"].'">'.$rol["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaDpts" action="AdminAdvPersones.php">
                        <label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
                        <select name="dpt" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $dpt; ?>"><?php echo $nomdpt; ?></option>
                            <option value="0"><?php echo $dto->__($lng,"Tots");?></option>  
                            <?php
                                $resdpt = $dto->mostraNomsDpt($idempresa);
                                foreach ($resdpt as $dpt)
                                {
                                echo '<option value="'.$dpt["iddepartament"].'">'.$dpt["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaSituacions" action="AdminAdvPersones.php">
                        <label><?php echo $dto->__($lng,"Situació"); ?>:</label><br>
                        <select name="situacio" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $situacio;?>"><?php echo $dto->__($lng,$nomsituacio); ?></option>
                            <option value="2"><?php echo $dto->__($lng,"Totes");?></option>  
                            <option value="1"><?php echo $dto->__($lng,"En plantilla");?></option>
                            <option value="0"><?php echo $dto->__($lng,"Cessat");?></option>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    </form>
                </div>
            </div>
        </div><!br>       
        <div class="row">
           
        <div id="cnttbl" class="col-lg-12 well">        
        <div id="divtbl" class="divtbl" style="overflow: auto; overflow-y: hidden; padding: 0; margin-left: 0px; margin-right: 20px;">
            
        <table class="table table-striped table-hover table-condensed" style="border-collapse: collapse; border-spacing: 0; border-top: 1px solid grey; background-color: white; text-align:center; align-self: flex-end">
        <thead>
                <th><?php echo $dto->__($lng,"Cognoms");?></th>
                <th><?php echo $dto->__($lng,"Nom");?></th>
                <th><?php echo $dto->__($lng,"Fitxa");?></th>                
                <th><?php echo $dto->__($lng,"Perfil");?></th>
                <th><?php echo $dto->__($lng,"Data Ini. Dist.");?> <button class="btn btn-info btn-xs" onclick="asgMultDataini(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Assignar Data Inici Rotació a Múltiples Persones");?>"><span class="glyphicon glyphicon-calendar"></span></button></th>
              
                <th><?php echo $dto->__($lng,"Primer Horari");?></th>
                <th title="<?php echo $dto->__($lng,"Dies Laborables de l´Horari Principal de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"D.Lab.P");?></th>
                <th><?php echo $dto->__($lng,"Segon Horari");?></th>
                <th title="<?php echo $dto->__($lng,"Dies Laborables de l´Horari Secundari de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"D.Lab.S");?></th>
                <th><?php echo $dto->__($lng,"Tercer Horari");?></th>
                <th title="<?php echo $dto->__($lng,"Dies Laborables del Tercer Horari de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"D.Lab.T");?></th>
                <th title="<?php echo $dto->__($lng,"Dies de Festa entre Torns de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"Dies Fes.");?></th>
                <th><input type='checkbox' id="chkallpers" style='height: 20px; width: 20px' onclick="chkAllPers(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Marcar/Desmarcar Tots");?>"></th>
                <th title="<?php echo $dto->__($lng,"Opcions");?>"><button class="btn btn-primary btn-xs" onclick="asgMultRot(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Assignar Rotació a Múltiples Persones");?>"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-calendar"></span></button></th>
        </thead>
        <tbody style="background-color: white">
            <?php
            echo $tblpers;
        ?>       
        </tbody>
        </table>
           
        </div>
        </div>        
        </div>
    </div>
    </center>
    <div class="modal fade" id="modAsgMultRot" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3><?php echo $dto->__($lng,"Crear Rotació per a Múltiples Persones");?></h3>
                  </div>
                <div class="modal-body">
                    <form name="rotapersona" onsubmit="event.preventDefault();">
                    <input type="hidden" id="stridpersona" name="stridpersona">
                    <input type="hidden" id="strdataini" name="strdataini">
                    <h4><?php echo $dto->__($lng,"Confirmeu Persones i Data Final de Rotació");?>:</h4><br>
                    <div class="row"><div class="col-lg-2"></div><div class="col-lg-8"><table id="nomspers" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;"></table></div><div class="col-lg-2"></div></div><br>
                    <div class="row">
                        <div class="col-lg-2"></div>                        
                        <div class="col-lg-4"><label><?php echo $dto->__($lng,"Data Final Rotació");?>:</label></div>
                        <div class="col-lg-3"><input type="date" name="datafi" value="<?php echo date('Y-m-d',strtotime(date('Y',strtotime('today')).'-12-31'));?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                    </div><br><br></form>                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="assignaRotacioMultipers(rotapersona.stridpersona.value,rotapersona.strdataini.value,rotapersona.datafi.value);"><span class="glyphicon glyphicon-calendar"></span> <?php echo $dto->__($lng,"Crear");?></button>
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
    <div class="modal fade" id="modErrSelect" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 25px"><?php echo $dto->__($lng,"No hi ha cap Persona seleccionada"); ?></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    <div class="modal fade" id="modWait" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                   
                    <div class="modal-body">
                        <h1>Cargando</h1>
                        <img src="./Pantalles/img/Loading_icon.gif" style="height: 200px; width: 280px">
                                        
                    </div>
              </div>
            </div>                
            </center>
        </div>
    </body>
    
</html>
