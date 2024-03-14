<!DOCTYPE html>
<html>


    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
  
    $ParmCrypt = urldecode($_GET["Parm"]);
    $Parm = $dto->decrypt($ParmCrypt);
    $parms = explode("|", $Parm);
    $idexcep =  $parms[1];
    $lng = $parms[0];
    $_SESSION["ididioma"] = $lng;
    $idemplead = $dto->getCampPerIdCampTaula("excepcio",$parms[1],"idempleat");
    $dataini = $dto->getCampPerIdCampTaula("excepcio",$parms[1],"datainici");
    $datafi = $dto->getCampPerIdCampTaula("excepcio",$parms[1],"datafinal");
    $nomexcep =  $dto->getCampPerIdCampTaula("tipusexcep",$dto->getCampPerIdCampTaula("excepcio",$parms[1],"idtipusexcep"),"nom") ;
    $nomempleencg = $dto->mostraNomEmpPerId($dto->getCampPerIdCampTaula("excepcio",$parms[1],"idresp"));
    $stateSolict = $dto->getCampPerIdCampTaula("excepcio",$parms[1],"aprobada");
    $MSJobligatori =  "'".$dto->__($lng,"La observacion es obligatoria")."'";

    if (is_null($stateSolict)) {
        $stateSolict = 3;
    }
    
    echo '<input type="hidden" id="stateexcep" name="stateexcep" value="'.$stateSolict .'">';

    ?>

    <center>

    <dialog id="DialogoNotificacion">
    <p>La peticion ya ha sido procesada.</p>
    </dialog>

    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3><?php echo $dto->__($lng,"Solicitud Periodo");?></h3>
        </div>
          <div class="modal-body">

          <?php 

                echo '<h4>'.$dto->__($lng,"Empleat").': '.$dto->mostraNomEmpPerId($idemplead).'</h4><br>';
    
            ?>

             
              <form name="editaexcepM">
              <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcepM" value="<?php echo $dataini;?>" readonly>
              <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcepM" value="<?php echo $datafi;?>" readonly><br><br>
              <label><?php echo $dto->__($lng,"Tipus");?>:</label><input type="text" id="Tipus" name="TipusM" value="<?php echo $dto->__($lng,$nomexcep);?>" readonly>
                   <br>
                    <table class="table table-condensed table-striped table-hover" style="text-align: center" id="TableFiles">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Archivos");?></th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?php

                                    $root = $_SERVER["DOCUMENT_ROOT"];

                                    if (strpos($root,'/') === false) {
										$sep = "\\";
									}else{
										$sep = "/";
									}

                                    $micarpeta = $root.$sep.'excepciFiles';
                                    $pathFoler = $micarpeta.$sep.$idexcep;

                                    if (file_exists($pathFoler)) {

                                        $listFiles = array_values(array_diff(scandir($pathFoler), array('..', '.')));

                                        for ($i=0; $i < count($listFiles ); $i++) { 
                                            $nameFile = $listFiles[$i];
                                            $stringparse = "'".$pathFoler.$sep.$nameFile."'";
                                            echo '<tr><td><a href="FileDowloader.php?File='.urlencode($nameFile).'&Idexcepcio='.$idexcep.'">'.$nameFile.'</a></td></tr>';
                                        }

                                        
                                    }

                            ?>
                        </tbody>
                    </table>
                    
                
                <?php 


                            if ($stateSolict == '3') {

                                echo  '<label>'.$dto->__($lng,"Observaciones").':</label><input type="text" id="observ" name="observN">';
                                echo '<br>';
                                echo '<button type="button" class="btn btn-info" onclick="CahngeStateSolcExepct('.$idexcep.',0,'.$MSJobligatori.');">'.$dto->__($lng,"DENEGAR").'</button>';
                                echo '<button type="button" class="btn btn-info" onclick="CahngeStateSolcExepct('.$idexcep.',1,'.$MSJobligatori.');">'.$dto->__($lng,"APROBAR").'</button>';


                            }else {
                               

                                $stateexeptctrl = '<label>'.$dto->__($lng,"Estado").':</label><input type="text" id="Estate" name="EstateN" value="'; 
                
                                $stateExept = $dto->__($lng,"pendiente");
                                if($stateSolict == '1') $stateExept = $dto->__($lng,"aprobada");
                                else if($stateSolict == '0') $stateExept = $dto->__($lng,"Denegada");
                                $stateexeptctrl .= $stateExept.'" readonly>';     
                                $dataaprovacio = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"dataaprovacio");
                                echo  '<label>'.$dto->__($lng,"Fecha").' '.$stateExept.':</label><input type="date" id="DateActu" name="DateActuN" value="'.$dataaprovacio.'" readonly>';
                                echo '<br>';
                                $Observ = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"observacions");
                                echo  '<label>'.$dto->__($lng,"Observaciones").':</label><input type="text" id="observ" name="observN" value="'.$Observ.'" readonly>';

                            }
                  

                ?>
                

             </form>
              <br>
          </div>
        <div class="modal-footer">
        </div>
        </div>
      </div>
    </center>

    <script type="text/javascript">

            if (document.getElementById("stateexcep").value != "3") {
                var dialogo = document.getElementById('DialogoNotificacion');
                dialogo.addEventListener('click', () => dialogo.close());
                dialogo.showModal();
            }

            function CahngeStateSolcExepct(SolictID,type,MSJobligt){

            ObserData = document.getElementById('observ');

            if (ObserData.value == '') {
                alert(MSJobligt)
                return;
            }

            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
            };
            var lati = pos['lat'];
            var long = pos['lng'];
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                const str = window.location.href;    
                const urlHOME = str.split('SolicExepcProces');
                location.href = urlHOME[0]+'index.php';
             
            }
            };
            
            ObserData = encodeURI(ObserData.value)

            xmlhttp.open("GET", "Serveis.php?action=UpdateStateSolicExcep&id=" + SolictID + "&Obs=" + ObserData + "&Type=" + type+ "&utm_x=" + lati+ "&utm_y=" + long, true);
            xmlhttp.send();

            }, function() {
                 
                    navigator.permissions.query({name:'geolocation'})
                            .then(function(permissionStatus) {
                                popuphtml('geolocation permission state is ', permissionStatus.state);
        
                                permissionStatus.onchange = function() {
                                popuphtml('geolocation permission state has changed to ', this.state);
                                };
                            });
                    });
                }  
        
                    
            }
        
        </script>

</html>
