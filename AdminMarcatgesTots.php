<!DOCTYPE html>
<html>
    <head>
        <?php 
        session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        $dto->navResolver(); 
        ?> 
    </head>
    <body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%;">
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = $_SESSION["idempresa"];
        //Si s'actualitzen els filtres
            if(!isset($_GET["dpt"]))$_GET["dpt"]="Tots";
            $dpt = $_GET["dpt"];
            $depts = $dto->mostraNomsDpt($idempresa);
            if($dpt!="Tots") $anys = $dto->mostraAnysMarcatgesPerDpt($idempresa,$dpt);
            else $anys = $dto->mostraAnysMarcatges();
            $d = strtotime("now");
            if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
            $any = $_GET["any"];
            if(!isset($_GET["setmana"]))$_GET["setmana"]=date("W",$d);
            $setmana = $_GET["setmana"];
            if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
            $mes = $_GET["mes"];
            if($any!="Tots")
            {
                if($dpt=="Tots")$mesos = $dto->mostraMesosMarcatgesPerAny($idempresa,$any);
                else if($dpt!="Tots")$mesos = $dto->mostraMesosMarcatgesPerDptAny($idempresa,$dpt, $any);
            }
        if(isset($_GET["validacio"])) 
        {
            $llistaidmarc = explode(",",$_GET["validacio"]);
            foreach ($llistaidmarc as $idmarc) $dto->validaMarcatge($idmarc);
        }
            
        ?>
    <center>
        <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 well">
            <div class="col-lg-3"><h3><?php echo $dto->__($lng,"Graella de Marcatges"); ?></h3></div>
            <div class="col-sm-2"><label>Empresa:</label><br> <?php echo $dto->mostraNomEmpresa($idempresa); ?></div>
            <div class="col-sm-1">
            <form action="AdminMarcatgesTots.php" method="GET"><label><?php echo $dto->__($lng,"Departament"); ?>:</label>
            <select name="dpt" id="LlistaDepts" onchange="this.form.submit()">
            <option hidden selected value><?php echo $dto->__($lng,$dpt); ?></option>
            <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
            <?php
            foreach($depts as $dept)
            {
                echo '<option value:"'.$dept["iddepartament"].'">'.$dept["nom"].'</option>';
            }
            ?>
            </select>
            </form>
            </div>
            <div class="col-sm-1"></div>
            <?php
            // Tots els resultats, per període
            if(($dpt=="Tots")&&($any=="Tots")) $result = $dto->seleccionaMarcatgesTots($idempresa);
            else if(($dpt=="Tots")&&($any!="Tots")&&($mes=="Tots")&&($setmana=="Totes")) $result = $dto->seleccionaMarcatgesTotsPerAny($idempresa,$any);
            else if(($dpt=="Tots")&&($any!="Tots")&&($mes!="Tots")&&($setmana=="Totes")) $result = $dto->seleccionaMarcatgesTotsPerAnyMes($idempresa,$any,$mes);
            else if(($dpt=="Tots")&&($any!="Tots")&&($mes=="Tots")&&($setmana!="Totes")) $result = $dto->seleccionaMarcatgesTotsPerAnySetmana($idempresa,$any,$setmana);
            else if(($dpt=="Tots")&&($any!="Tots")&&($mes!="Tots")&&($setmana!="Totes")) $result = $dto->seleccionaMarcatgesTotsPerAnyMesSetmana($idempresa,$any,$mes,$setmana);
            // Resultats per departament i període
            else if(($dpt!="Tots")&&($any=="Tots")) $result = $dto->seleccionaMarcatgesTotsPerDpt($dpt);
            else if(($dpt!="Tots")&&($any!="Tots")&&($mes=="Tots")&&($setmana=="Totes")) $result = $dto->seleccionaMarcatgesTotsPerDptAny($idempresa,$dpt,$any);
            else if(($dpt!="Tots")&&($any!="Tots")&&($mes!="Tots")&&($setmana=="Totes")) $result = $dto->seleccionaMarcatgesTotsPerDptAnyMes($idempresa,$dpt,$any,$mes);
            else if(($dpt!="Tots")&&($any!="Tots")&&($mes=="Tots")&&($setmana!="Totes")) $result = $dto->seleccionaMarcatgesTotsPerDptAnySetmana($idempresa,$dpt,$any,$setmana);
            else  $result = $dto->seleccionaMarcatgesTotsPerDptAnyMesSetmana($idempresa,$dpt,$any,$mes,$setmana);
            ?>
            <div class="col-sm-1">
                <form action="AdminMarcatgesTots.php" method="GET"><label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
                <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                <option hidden selected value><?php echo $any; ?></option>
                <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                <?php
                foreach($anys as $year)
                {
                    echo '<option value:"'.$year["anys"].'">'.$year["anys"].'</option>';
                }
                ?>
                </select>
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                </form>
            </div>
            <div class="col-sm-1">
                <form action="AdminMarcatgesTots.php" method="GET"><label><?php echo $dto->__($lng,"Mes");?>:</label><br>
                <select name="mes" id="LlistaMesos" onchange="this.form.submit()">
                <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                <?php
                if($any!="Tots") 
                {
                    for($month=1;$month<=12;$month++)
                    {
                        echo '<option value="'.$month.'">'.$dto->__($lng,$dto->mostraNomMes($month)).'</option>';//
                    }
                }
                ?>
                </select>
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="setmana" value="Totes">
                </form>
            </div>
            <div class="col-sm-1">
                <form action="AdminMarcatgesTots.php" method="GET"><label><?php echo $dto->__($lng,"Setmana"); ?>:</label><br>
            <select name="setmana" id="LlistaSetmanes" onchange="this.form.submit()">
            <option hidden selected value>
                <?php 
                    if($setmana!="Totes")
                    {
                        $dia = new DateTime();
                        $dia->setISODate($any, $setmana);
                        echo $setmana.' ('.$dia->format('d-M-Y').')';
                    }
                    else echo $setmana;
                ?>
            </option>';
            <option value="Totes"><?php echo $dto->__($lng,"Totes");?></option>
            <?php
            if($any!="Tots"&&$mes!="Tots") $setmanes = $dto->mostraSetmanesMarcatgesPerAnyMes($any, $mes);
            else if ($any!="Tots") 
            {
                $setmanes = $dto->mostraSetmanesMarcatgesPerAny($any);
            }
            foreach($setmanes as $week)
            {
                $dia = new DateTime();
                $dia->setISODate($any, $week["setmanes"]);
                echo '<option title="('.$dia->format('d-M-Y').')" value="'.$week["setmanes"].'">'.$week["setmanes"].' ('.$dia->format('d-M-Y').')</option>';
            }
            ?>
            </select>
            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
            <input type="hidden" name="any" value="<?php echo $any; ?>">
            <input type="hidden" name="mes" value="<?php echo $mes; ?>">
            </form>
            </div>
        </div>
        </div>
        <br>
        <div class="container well">
            <table class="table table-striped table-hover table-condensed table-" style="text-align: center; background-color: white">
            <thead>
            <th style="text-align: center"><?php echo $dto->__($lng,"Departament"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Persona"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Data"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dilluns"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dimarts"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dimecres"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dijous"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Divendres"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dissabte"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Diumenge"); ?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Observacions"); ?></th>
            </thead>
            <tbody style="background-color: white">
            <?php
            $idsMarcatges = [];
            $datesMarcatges = [];
            $idsemps = [];
            $id_emp = 0;
            $num_emp = 0;
            $treballades = array_fill(0,7,0);
            $teoriques = array_fill(0,7,0);
            $avui = strtotime("now");
            $undiames = new DateInterval('P1D');
            foreach ($result as $marcatge)
            {
              if ($marcatge["id"]!=$id_emp)
              {
                  $idsemps[]= $marcatge["id"];
                  $num_emp++;
              }
              $id_emp = $marcatge["id"];
            }
            for($i=0;$i<$num_emp;$i++)
            {
            if($setmana!="Totes")
                {                
                $primerdiasetmana = new DateTime();
                $primerdiasetmana->setISODate($any, $setmana);
                $diessetmana = [];
                for($j=0;$j<7;$j++)
                    {
                    $diessetmana[$j]=$primerdiasetmana->format('Y-m-d');
                    $primerdiasetmana->add($undiames);
                    }
                for($j=1;$j<=6&&($avui>=strtotime($diessetmana[$j-1]));$j++)
                    {
                        $teoriques[$j] += $dto->seleccionaHoresTeoriquesPerIdDia($idsemps[$i], $diessetmana[$j-1]);
                    }
                    $teoriques[0] += $dto->seleccionaHoresTeoriquesPerIdDia($idsemps[$i], $diessetmana[6]);
                }
            if($mes!="Tots"&&$setmana=="Totes")
            {
                $primerdiames = new DateTime();
                $setmanaprimera = date("W",strtotime($any."-".$mes."-01")); 
                $primerdiames->setISODate($any, $setmanaprimera,date("w",strtotime(($any."-".$mes."-01"))));
                $primerdiamesseguent = new DateTime();
                $setmanaprimeramesseguent = date("W",strtotime($any."-".($mes+1)."-01"));
                $primerdiamesseguent->setISODate($any, $setmanaprimeramesseguent,date("w",strtotime(($any."-".($mes+1)."-01"))));
                $ultimdiames = $primerdiamesseguent->sub($undiames);
                $diesmes = [];
                for($j=0;$j<date("d",strtotime($ultimdiames->format('Y-m-d')));$j++)
                    {
                    $diesmes[$j]=$primerdiames->format('Y-m-d');
                    $primerdiames->add($undiames);
                    }
                for($j=0;$j<date("d",strtotime($ultimdiames->format('Y-m-d')))&&($avui>=strtotime($diesmes[$j]));$j++)
                    {
                    $weekday = date('w',strtotime($diesmes[$j]));    
                    $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($idsemps[$i], $diesmes[$j]);
                    }
            }
            if($any!="Tots"&&$mes=="Tots"&&$setmana=="Totes")
                {                
                $primerdiasetmana = new DateTime();
                $primerdiasetmana->setISODate($any, 1,date("w",strtotime(($any."-01-01"))));
                $diesany = [];
                for($j=0;$j<366;$j++)
                    {
                    $diesany[$j]=$primerdiasetmana->format('Y-m-d');
                    $primerdiasetmana->add($undiames);
                    }
                for($j=0;$j<366&&($avui>=strtotime($diesany[$j]));$j++)
                    {
                        $weekday = date('w',strtotime($diesany[$j]));
                        $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($idsemps[$i], $diesany[$j]);
                    }
                }
            }
            $id_emp = 0;
            $dia = "";
            foreach ($result as $marcatge)
            {
                $idsMarcatges[]=($marcatge["idmarcatges"]);
                echo "<tr>";
                echo "<td>".$marcatge["Dept"]."</td>";
                echo "<td>".$marcatge["Nom"]."</td>";
                echo "<td>".substr($marcatge["datahora"],0,10)."</td>";
                $datahora = "".substr($marcatge["datahora"],0,19);
                $hora = substr($marcatge["datahora"],11,5);
                $data = strtotime($marcatge["datahora"]);
                $weekday = date('w',$data);
                $diamarcatge = substr($marcatge["datahora"],0,10); 
                if (($dia!=$diamarcatge)||(($dia==$diamarcatge)&&($id_emp!=$marcatge["id"])))
                {
                    $id_emp = $marcatge["id"];
                    $dia = $diamarcatge;
                    $treballades[$weekday] += $dto->calculaHoresTreballadesPerIdDia($id_emp, $dia);
                }
                for ($i=1;$i<=7;$i++)
                {
                    switch ($weekday)
                    {
                        case $i:
                        if($marcatge["validat"]==1)
                            echo '<td id="marcatge" style="background-color:rgb(128,255,128)" title="'.$marcatge["tipus"].'">'.$hora.'</td>';
                        else
                            echo '<td id="marcatge" title="'.$marcatge["tipus"].'">'.$hora.'</td>';
                        break;
                        default:
                            echo '<td>-</td>';
                    }
                }
            if($marcatge["validat"]==1)
                echo '<td style="background-color:rgb(128,255,128)">'.$marcatge["obs"].'</td>';
            else
                echo '<td>'.$marcatge["obs"].'</div>';
                echo "</tr>";
            }
            if($any!="Tots")
            {
                echo "<thead>";
                echo '<th></th><th style="text-align: center">Hores</th><th></th>';
                for ($j=1;$j<=7;$j++)
                {
                    echo '<th></th>';
                }
                echo '<th style="text-align: center">Total Hores:</th>';
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";
                echo '<td></td><td>'.$dto->__($lng,"Treballades").'</td><td></td>';
                for ($j=1;$j<=6;$j++)
                {
                    echo '<td>'.$treballades[$j].'</td>';
                }
                echo '<td>'.$treballades[0].'</td>';
                $totaltreballades = 0;
                for ($k=0;$k<=6;$k++) $totaltreballades += $treballades[$k]; 
                echo '<td>'.$totaltreballades.'</td>';
                echo "</tr>";
                echo "<tr>";
                echo '<td></td><td>'.$dto->__($lng,"Teòriques").'</td><td></td>';
                for ($j=1;$j<=6;$j++)
                {
                    echo '<td>'.$teoriques[$j].'</td>';
                }
                echo '<td>'.$teoriques[0].'</td>';
                $totalteoriques = 0;
                for ($k=0;$k<=6;$k++) $totalteoriques += $teoriques[$k]; 
                echo '<td>'.$totalteoriques.'</td>';
                echo '</tr>';
                echo "<tr>";
                echo '<td></td><td>'.$dto->__($lng,"Diferència").'</td><td></td>';
                for ($j=1;$j<=6;$j++)
                {
                    $deficit = $treballades[$j]-$teoriques[$j];
                    if ($deficit>0||(($deficit==0)&&($teoriques[$j]>0))) echo '<td style="background-color:rgb(128,255,128)">'.$deficit.'</td>';
                    else if ($deficit<0&&$deficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.$deficit.'</td>';
                    else if ($deficit==0) echo '<td>'.$deficit.'</td>';
                    else echo '<td style="background-color:rgb(255,128,128)">'.$deficit.'</td>';
                }
                $deficit = $treballades[0]-$teoriques[0];
                    if ($deficit>0||(($deficit==0)&&($teoriques[0]>0))) echo '<td style="background-color:rgb(128,255,128)">'.$deficit.'</td>';
                    else if ($deficit<0&&$deficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.$deficit.'</td>';
                    else if ($deficit==0) echo '<td>'.$deficit.'</td>';
                    else echo '<td style="background-color:rgb(255,128,128)">'.$deficit.'</td>';
                $totaldeficit = $totaltreballades-$totalteoriques;
                if ($totaldeficit>=0) echo '<td style="background-color:rgb(128,255,128)">'.$totaldeficit.'</td>';
                else if ($totaldeficit<0&&$totaldeficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.$totaldeficit.'</td>';
                else echo '<td style="background-color:rgb(255,128,128)">'.$totaldeficit.'</td>';
                echo '</tr>';
                echo '</tbody>';
            }
            ?>
            </tbody>
        </table>
        </div>
    <br>
    <?php
    if(($any!="Tots"))echo '<a class="btn btn-success" data-toggle="modal" data-target="#modValidar"><span class="glyphicon glyphicon-ok"></span> '.$dto->__($lng,"Validar Tot").'</a><br><br>';
    ?>
    <a class="btn btn-default" href="AdminPersones.php"><span class="glyphicon glyphicon-user"></span> <?php echo $dto->__($lng,"Persones"); ?></a>
    <br>
    </center>
    <div class="modal fade" id="modValidar" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Validar Múltiples Marcatges");?></h3><br>
                    <label><?php echo $dto->__($lng,"Està segur de realitzar aquesta validació múltiple?");?></label><br>
                    <br>
                    <form method="GET" action="AdminMarcatgesTots.php">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                    <input type="hidden" name="validacio" value="<?php foreach($idsMarcatges as $codis)echo $codis.","; ?>">
                    <button type="button" class="btn btn-success" data-toggle="modal" onclick="this.form.submit()"><?php echo $dto->__($lng,"Confirmar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    </body>
</html>