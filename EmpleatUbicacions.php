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
    <body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden">
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_GET["id"];
        $anys = $dto->mostraAnysContractePerId($id);
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        ?>
        <center>
            <div class="row container well">
                <div class="col-lg-4" style="text-align: left"><h3 class="etiq"><?php echo $dto->__($lng,"Ubicacions i Festius"); ?></h3></div>
                <div class="col-lg-4" style="text-align: center"><h3 class="etiq"><?php echo $dto->mostraNomEmpPerId($id);?></h3></div>
                <div class="col-lg-4" style="text-align: right">
                    <form method="get">
                    <button type="submit" formaction="EmpleatFitxa.php" class="btn btn-default btn-lg" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Fitxa");?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button type="submit" formaction="EmpleatCalendari.php" class="btn btn-info btn-lg" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Calendari");?>"><span class="glyphicon glyphicon-calendar"></span></button>
                    <button type="submit" formaction="EmpleatMarcatges.php" class="btn btn-warning btn-lg" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Marcatges");?>"><span class="glyphicon glyphicon-list"></span></button>
                    <a class="btn btn-default btn-lg" href='index.php' title="<?php echo $dto->__($lng,"Inici");?>"><span class="glyphicon glyphicon-home"></span></a>
                </form>
                </div>
            </div>
        <div class="container well" style="min-width: 900px;">
        <section style="width:40%; float:left; "><br>
            <label class="etiq"><?php echo $dto->__($lng,"Ubicacions Actuals"); ?></label><br><br>
            <div style="border:solid grey 1px">
            <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Ubicació"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Des de"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Fins a"); ?></th>
                        <th></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
                            $data = date('Y-m-d',$d);
                            $ubicacions = $dto->seleccionaUbicacionsEmpPerIdDia($id,$data);
                            foreach($ubicacions as $lloc)
                            {
                                $datafi = "";
                                if(!empty($lloc["datafi"])) $datafi = date('d/m/Y',strtotime($lloc["datafi"]));
                                echo '<tr>';
                                echo '<td>'.$lloc["nom"].'</td>';
                                echo '<td>'.date('d/m/Y',strtotime($lloc["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td><button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Festius").'" onclick="mostraFestius('.$lloc["idlocalitzacio"].')">'
                                    . '<span class="glyphicon glyphicon-zoom-in"></span></button></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div><br>                
                
                <br><br>
                <label class="etiq"><?php echo $dto->__($lng,"Històric d'Ubicacions"); ?></label><br><br>
            <div style="border:solid grey 1px">                
            <table class="table table-striped table-hover table-condensed" style="text-align: center">                
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Ubicació"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Des de"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Fins a"); ?></th>
                        <th></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
                            $historic = $dto->seleccionaTotesUbicacionsEmpPerId($id);
                            foreach($historic as $lloc)
                            {
                                $datafi = "";
                                if(!empty($lloc["datafi"])) $datafi = date('d/m/Y',strtotime($lloc["datafi"]));
                                echo '<tr>';
                                echo '<td>'.$lloc["nom"].'</td>';
                                echo '<td>'.date('d/m/Y',strtotime($lloc["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td>'
                                    . '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Festius").'" onclick="mostraFestius('.$lloc["idlocalitzacio"].')">'
                                    . '<span class="glyphicon glyphicon-zoom-in"></span></button>';
                                    
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div><br>
        </section>
            <section style="width:50%; float:right">
                <center>                    
                    <form action="EmpleatUbicacions.php" method="GET">
                        <h4 class="etiq"><?php echo $dto->__($lng,"Festius")." ".$dto->__($lng,"Any");?>
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        </h4>
                    </form><br>
                <table class="table table-condensed table-striped table-hover" style="text-align: center; border:solid grey 1px">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Dia"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Mes"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Descripció"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Ubicació"); ?></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
                            $festius = $dto->seleccionaFestiusEmpPerIdAny($id, $any);
                            foreach($festius as $festa)
                            {
                                echo '<tr>';
                                echo '<td>'.$festa["dia"].'</td>';
                                echo '<td>'.$dto->__($lng,$dto->mostraNomMes($festa["mes"])).'</td>';
                                echo '<td>'.$festa["descripcio"].'</td>';
                                echo '<td>'.$festa["nom"].'</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </center>
            </section>
        </div>
            <br>            
            <form method="get" action="EmpleatFitxa.php">
                <button type="submit" class="btn btn-default" name="id" value="<?php echo $id;?>"><span class="glyphicon glyphicon-user"></span> <?php echo $dto->__($lng,"Fitxa"); ?></button>
            </form>
        </center>
    
    <div class="modal fade" id="modAssignaUbicacio" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Assignar Nova Ubicació per a"); ?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="assignaubicacio">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label>Data Inici:</label><input type="date" name="datainici" required>
                    <label>Data Fi:</label><input type="date" name="datafi"><br><br>
                    <label>Ubicacions Disponibles:</label>
                    <select name="idnovaubicacio">
                    <?php
                        $localitzacio = $dto->seleccionaUbicacionsPerIdEmpresa($_SESSION["idempresa"]);
                        foreach($localitzacio as $lloc)
                        {
                            echo '<option value="'.$lloc["idlocalitzacio"].'">'.$lloc["nom"].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar"); ?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="assignaUbicacio(<?php echo $id; ?>,assignaubicacio.idnovaubicacio.value,assignaubicacio.datainici.value,assignaubicacio.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Assignar"); ?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modFestius"></div>
</body>
</html>
