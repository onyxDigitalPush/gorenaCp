<!DOCTYPE html>
<html>

    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();

     
    

    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idexcep = $_GET["1"];
    $idtipusexcep = $_GET["2"];
    $dataini = $_GET["3"];
    $datafi = $_GET["4"];
    $idempleencarg = $_GET["5"];
    $coment_excepcio =$_GET["7"];
    $nomempleencg= $dto->getCampPerIdCampTaula("empleat",$idempleencarg,"nom", "cognom1");
    $idsession = $_GET["6"];
    include 'Conexion.php';
    $idempresa=$_SESSION["idempresa"];
    $d = strtotime("now");
    if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
    $any = $_GET["any"];
    $diesespecials1s = array_fill(0,4,0);
    $diesespecials2s = array_fill(0,4,0);
    $diesespecialsmes1s = array_fill(0,4,0);
    $diesespecialsmes2s = array_fill(0,4,0);



    //EXCEPCION ELEMENTO SELECCIONADO
    $data_exception = $dto->seeException($idexcep, $idtipusexcep);

    $nomexcep = $data_exception['nom'];
    $id = $data_exception['id_employee'];
    $stateSolict = $data_exception['approved'];
    $comentario = $data_exception['comment'];
    $observations = $data_exception['observations'];
    $date_approved = $data_exception['date_approved'];



    //DIAS DE VACACIONES AÑO ANTERIOR Y AÑO ACTUAL

    $data_days_vacation = $dto->days_vacation($id);
    $year = date("Y");
    $before_year = $year - 1;

    $total_dias = $data_days_vacation[$year];
    $total_dias_anterior = $data_days_vacation[$before_year];


    //TRAIGO LOS DIAS EXCEPCION
    $exception_days = $dto->days_exception($id, $year);



    // DIAS USADOS DE VACACIONES HASTA LA FECHA
    $data_days_vacation_used = $dto->days_vacation_used($id, '2023-09-08');
    $diesvacances = 0;
    $diesvacances = $data_days_vacation_used[2]['count_days'];

    //OPERACIONES RESUMEN VACACIONES
    $total_dias_restantes = $diesvacances; //$total_dias + $total_dias_anterior - $diesvacances;
    $total_dias_actual_anterior = $total_dias + $total_dias_anterior;


    //$nomexcep = $dto->getCampPerIdCampTaula("tipusexcep",$idtipusexcep,"nom");
    //$id = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"idempleat");
    //$stateSolict = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"aprobada");

    //$anys = $dto->mostraAnysContractePerId($id);
    ?>


    <?php
    /*
    include 'Conexion.php';
    $idexcepcio = $idexcep; // Reemplaza con el ID de excepcio adecuado
    // Consulta SQL para obtener el valor de la columna "comentario" de la tabla "excepcio"
    $sql = "SELECT comentario FROM excepcio WHERE idexcepcio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idexcepcio);
    $stmt->execute();
    $comentario = 'comentario';
    $stmt->bind_result($comentario);

    if ($stmt->fetch()) {
        print_r($comentario);
        echo "SE ENCONTRO COMENTARIO";
    } else {
        echo "No se encontró ningún comentario para el ID de excepcio especificado.";
    }
    $stmt->close();
    */
    ?>



    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <link href="css/estilos_chat.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>


<style>
input[type="date"],
input[type="text"] {
  display: inline-block;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 250px;
  margin-bottom: 10px;
}

input[type="date"]:read-only,
input[type="text"]:read-only {
  background-color: #ddd;
}
</style>







<center>
    <div class="modal-dialog_admin">
        <div class="modal-content_admin">

            <div class="modal-header_admin">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3  class="modal-title"><?php echo $dto->__($lng,"Solicitud Periodo");?></h3>
            </div>

          <div class="modal-body_admin">
            <?php
                if ($id != $idsession) {
                    echo '<h4>'.$dto->__($lng,"Empleat").': '.$dto->mostraNomEmpPerId($id).'</h4><br>';
                }
            ?>

              <form name="editaexcepM">
                  <label class="label_admin"><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcepM" value="<?php echo $dataini;?>" readonly>
                  <label class="label_admin"><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcepM" value="<?php echo $datafi;?>" readonly><br><br>
                  <label class="label_admin"><?php echo $dto->__($lng,"Tipus");?>:</label><input type="text" id="Tipus" name="TipusM" value="<?php echo $dto->__($lng,$nomexcep);?>" readonly>
                  <label class="label_admin"><?php echo $dto->__($lng,"Encargados");?>:</label><input type="text" id="idempleat" name="idempleat" value="<?php echo $dto->__($lng,$nomempleencg);?>" readonly><br>


                  <label class="label_admin"><?php echo $dto->__($lng,"Comentario");?>:</label><input type="text" id="idempleat" name="idempleat" value="<?php echo $dto->__($lng,$comentario);?>" readonly>
                  <br><br>
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
                  <label class="label_admin"><?php echo $dto->__($lng,"Estado");?>:</label><input type="text" id="Estate" name="EstateN" value="<?php

                  $stateExept = $dto->__($lng,"pendiente");
                  if($stateSolict == '1') $stateExept = $dto->__($lng,"aprobada");
                  else if($stateSolict == '0') $stateExept = $dto->__($lng,"Denegada");
                  echo $stateExept;?>" readonly>


                  <br>

                <?php 
                if (!is_null($stateSolict)){
                    echo  '<label class="label_admin">'.$dto->__($lng,"Fecha").' '.$date_approved.':</label><input type="date" id="DateActu" name="DateActuN" value="'.$date_approved.'" readonly>';
                    echo '<br><br>';
                    echo  '<label class="label_admin">'.$dto->__($lng,"Observaciones").':</label><input type="text" id="observ" name="observN" value="'.$observations.'" readonly>';
                }
                ?>
                
              </form>

              <br><br>

                <strong><h3 class="modal-title">Total de permisos acumulados aprobados</h3></strong>
                <br>


              <?php foreach ($exception_days as $exception_day)
              {
                  echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Dies de ' .$exception_day['type_excepcio']  .' any').' '.$any.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'</label><br>';
              }
              ?>


            <h3><strong>Resumen Vacaciones</strong></h3>

            <?php
                echo '<span><span class="glyphicon glyphicon-stop" style="color: rgb(51, 156, 255)"></span> '.$dto->__($lng,"Días de vacaciones").' '.$any.''. ":".' '.$total_dias.'</span> '.'/ ';
                echo '<span>'.$dto->__($lng,"Días vacaciones año anterior").' : '.$total_dias_anterior.'</span> '.'/ ';
                echo '<span>'.$dto->__($lng,"Total asignados:").' '.''.$total_dias_actual_anterior.' '.'</span>';
                echo '<span>'.$dto->__($lng,"Total disponibles:").' '.''.$total_dias_restantes.'</span>';
            ?>



          </div>

       

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cerrar");?></button>
                </div>

            </div>
        </div>

    </div>
     

        </div>
        </div>
      </div>


    </center>






</html>
