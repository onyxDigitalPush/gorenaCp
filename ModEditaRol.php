<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();    
    if(isset($_SESSION["idempresa"])) $idempresa = $_SESSION["idempresa"];
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idrol = $_GET["1"];
    $chkemp = "";
    if(($dto->getCampPerIdCampTaula("rol",$idrol,"esempleat"))==1) $chkemp = "checked";
    $chkadm = "";
    if(($dto->getCampPerIdCampTaula("rol",$idrol,"esadmin"))==1) $chkadm = "checked";
    $chkmst = "";
    if(($dto->getCampPerIdCampTaula("rol",$idrol,"esmaster"))==1) $chkmst = "checked";    
    $id = $_SESSION['id'];
    $master = $dto->esMaster($id);
    ?>





<style>



          /* Estilo para el fondo del modal */
          .modal-content.glassmorphism {
          background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          backdrop-filter: blur(10px); /* Efecto de desenfoque */
          border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
          border-radius: 10px; /* Borde redondeado */
      }

      /* Estilo para el cuerpo del modal */
      .modal-body {
          background: rgba(255, 255, 255, 0.1); /* Color de fondo con transparencia */
          padding: 20px; /* Espaciado interior */
      }

      /* Estilo para los botones dentro del modal */
      .btn_modal {
          background-color: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          border: none; /* Sin borde */
          color: white; /* Color del texto */
          border-radius: 5px; /* Borde redondeado */
          margin-right: 10px; /* Espaciado entre botones */
      }

      /* Estilo para los botones cuando están en hover */
      .btn_modal:hover {
          background-color: rgba(81, 209, 246, 0.3); /* Cambia el color de fondo durante el hover */
          color: white; /* Cambia el color del texto durante el hover */
      }

      /* Estilo para el título del modal */
      .modal-body h3 {
          color: white; /* Color del texto del título */
          text-align: center; /* Alineación del texto del título */
      }

</style>

    <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content glassmorphism">
                    <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng,"Editar Rol");?></h3></div>
                  <div class="modal-body">
                      <h3><?php echo $dto->mostraNomEmpresa($idempresa); ?></h3>
                      <br>
                      <form name="editarol" onsubmit="event.preventDefault();">
                          <label><?php echo $dto->__($lng,"Nom");?>: </label><input type="text" name="nomrol" value="<?php echo $dto->getCampPerIdCampTaula("rol",$idrol,"nom");?>"><br><br>
                          <label><?php echo $dto->__($lng,"Perfil a l'Aplicació");?>: </label><br><br>
                          <table class="table"><tbody>
                                  <tr><td><label><?php echo $dto->__($lng,"Empleat");?>: </label></td><td><input id="esemp" <?php echo $chkemp;?> type="checkbox" style="height: 25px; width: 25px"/></td></tr>
                                  <tr><td><label><?php echo $dto->__($lng,"Administrador");?>: </label></td><td><input id="esadm" <?php echo $chkadm;?> type="checkbox" style="height: 25px; width: 25px"/></td></tr>
                          <?php if($master) echo '<tr><td><label>'.$dto->__($lng,"Master").': </label></td><td><input id="esmst" '.$chkmst.' type="checkbox" style="height: 25px; width: 25px"/></td></tr>'; ?>
                              </tbody></table>
                              <br><br>
                          </div>
                    <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                      <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="editaRol(<?php echo $idrol;?>,editarol.nomrol.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Guardar");?></button>
                      </form>
                  </div>
                </div>
              </div>
            </center>
</html>
