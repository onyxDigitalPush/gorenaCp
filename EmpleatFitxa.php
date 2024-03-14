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
    <body class= "well" style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%;">
        <?php
        $id = $_SESSION["id"];
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $res = $dto->seleccionaEmpPerId($id);
        $rutafoto = "";
        ?>
    <center><div class="row container well">
            <div class="col-lg-3" style="text-align: left"><h3 class=""><?php echo $dto->__($lng,"Fitxa Personal"); ?></h3></div>
            <div class="col-lg-6" style="text-align: center"><h3 class=""><?php echo $dto->getCampPerIdCampTaula("empleat",$id,"nom")." ".$dto->getCampPerIdCampTaula("empleat",$id,"cognom1")." ".$dto->getCampPerIdCampTaula("empleat",$id,"cognom2"); ?></h3></div>
            <div class="col-lg-3" style="text-align: right">
                <form method="get">

                <!--Se omiten botones a petición del cliente, no se elimina la iopción solo se comenta por si se llega a necesitar-->

                    <!--<button type="submit" formaction="EmpleatMarcatges.php" class="btn btn-warning btn-lg" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Marcatges");?>"><span class="glyphicon glyphicon-list"></span></button>-->

                  <!-- <button type="submit" formaction="EmpleatCalendari.php" class="btn btn-info btn-lg" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Calendari");?>"><span class="glyphicon glyphicon-calendar"></span></button>-->

                 <!--   <a class="btn btn-default btn-lg" href='index.php' title="<?php echo $dto->__($lng,"Inici");?>"><span class="glyphicon glyphicon-home"></span></a>--> 

                </form>                
            </div>
        </div></center>
    <div class="container" style="min-width: 900px;">
        <section id="DadesEmp" style="float: left; width: 33%; text-align: center">
            <table class="table-striped table-hover table-condensed">
                <tbody style="background-color: white;">
                <?php
                foreach ($res as $fitxa)
                {
                $rutafoto = $fitxa["rutafoto"];
                if(empty($rutafoto)) $rutafoto = "./Pantalles/img/blacksiluet.jpg";
                echo ' <tr><th>'.$dto->__($lng,"Primer Cognom").'</th><td style="">'.$fitxa["cognom1"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Segon Cognom").'</th><td style="">'.$fitxa["cognom2"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Nom").'</th><td style="">'.$fitxa["nom"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Sexe").'</th><td style="">'.$dto->dirSexeLletra($fitxa["sexe"]).'</td></tr>
                    <tr><th>'.$dto->__($lng,"DNI").'</th><td style="">'.$fitxa["dni"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Data Naixement").'</th><td style="">'.date('d/m/Y',strtotime($fitxa["datanaixement"])).'</td></tr>                        
                    <tr><th>'.$dto->__($lng,"Nacionalitat").'</th><td style="">'.$fitxa["nacionalitat"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Població").'</th><td style="">'.$fitxa["poblacio"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Domicili").'</th><td style="">'.$fitxa["domicili"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Codi Postal").'</th><td style="">'.$fitxa["codipostal"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"E-mail").'</th><td style=""><a href="mailto:'.$fitxa["email"].'">'.$fitxa["email"].'</a></td></tr>
                    <tr><th>'.$dto->__($lng,"Telèfon de Contacte").'</th><td style="">'.$fitxa["telefon1"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Telèfon Alternatiu").'</th><td style="">'.$fitxa["telefon2"].'</td></tr>';
                }
                ?>
                   </tbody>
            </table>
        </section>
        <section id="DadesEmp1" style="float: left; width: 33%">
            <table class="table-striped table-condensed table-hover table-bordered">
                <tbody style="background-color: white; border: solid 1px;">
                <?php
                $torn = $dto->seleccionaTornActualEmpPerId($id);
                $idhorari = 0;
                foreach($torn as $codi) $idhorari=$codi["idhorari"];
                foreach ($res as $fitxa)
                {
                echo ' <tr><th>'.$dto->__($lng,"Empresa").'</th><td style="">'.$dto->mostraNomEmpresa($fitxa["idempresa"]).'</td></tr>'
                    .'<tr><th>'.$dto->__($lng,"Subempresa").'</th><td>'.$dto->getCampPerIdCampTaula("subempresa",$dto->getCampPerIdCampTaula("empleat",$fitxa["idempleat"],"idsubempresa"),"nom").'</td></tr>'
                    .'<tr><th>'.$dto->__($lng,"Departament").'</th><td style="">'.$dto->mostraNomDptPerIdEmp($fitxa["idempleat"]).'</td></tr>
                    <tr><th>'.$dto->__($lng,"Responsable").'</th><td style="">'.$dto->mostraNomEmpPerId($fitxa["idresp"]).'</td></tr>
                    <tr><th>'.$dto->__($lng,"Rol").'</th><td style="">'.$dto->mostraNomRolPerIdEmp($fitxa["idempleat"]).'</td></tr>
                    <tr><th>'.$dto->__($lng,"Horari").'</th><td style="">'.$dto->mostraNomHorariPerIdhorari($idhorari).'</td>';
                    $dataultc = "";
                    if(!empty($fitxa["dataultcontrac"])) $dataultc = date('d/m/Y',strtotime($fitxa["dataultcontrac"]));
                   
                    echo '</td></tr>
                    <tr><th>'.$dto->__($lng,"Data última contractació").'</th><td style="">'.$dataultc.'</td></tr>
                    <tr><th>'.$dto->__($lng,"Tipus de contracte").'</th><td style=""></td></tr>
                    <tr><th>'.$dto->__($lng,"Núm.Afiliació").'</th><td style="">'.$fitxa["numafiliacio"].'</td></tr>
                    <tr><th>'.$dto->__($lng,"Grau de Discapacitat").'</th><td style="">'.$fitxa["graudiscap"].'</td></tr>    
                    <tr><th>'.$dto->__($lng,"Ubicacions").'</th><td>'.$dto->getUbicacionsPerId($fitxa["idempleat"]).'</td>';
                }
                ?>
               </tr>
                </tbody>
            </table><br>
        </section>
        <section id="DadesEmp2" style="float: right; width: 33%;">
            <center>
                <img src="<?php echo $rutafoto; ?>" alt="<?php echo $dto->__($lng,"Foto");?>" style="height: 170px; width: 150px; border: solid 1px"><br><br>
            <br>
    </center>
        </section>
    </div>
    
    <div class="modal fade" id="modConsole" role="dialog">
        <center>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <label id="msgConsole"></label><br><br>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
            </div>
          </div>
        </div>                
        </center>
    </div>
    <div class="modal fade" id="modHorari" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Horari Actual"); ?></h3><br>
                    <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center">Dia</th>
                        <th style="text-align: center">Entrada</th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Sortida"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Hores"); ?></th>
                       
                        <th style="text-align: center" title="<?php echo $dto->__($lng,"Comptabilitza el temps de marcatges avançats de l'hora teòrica d'entrada");?>"><?php echo $dto->__($lng,"Anticipat"); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $horari = $dto->seleccionaTornActualEmpPerId($id);
                            foreach($horari as $dia)
                            {
                                echo '<tr>';
                                echo '<td>'.$dto->__($lng,$dto->mostraNomDia($dia["diasetmana"])).'</td>';
                                echo '<td>'.substr($dia["horaentrada"],0,5).'</td>';
                                echo '<td>'.substr($dia["horasortida"],0,5).'</td>';
                                echo '<td>'.$dia["horestreball"].'</td>';
                                
                                echo '<td>'.$dto->dirsiono($dia["marcabans"]).'<td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <br><button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
    </div>
    </body>
</html>
