<!DOCTYPE html>
<html>
    <?php
    include '../persistencia/Conexio/API/GestorPersistenciaMySQL.php';
    include '../persistencia/Conexio/impl/GestorPersistenciaMySQLImpl.php';
    include '../logica/API/AdminApi.php';
    include '../logica/Impl/AdminApiImpl.php';    
    $dto = new AdminApiImpl();
    $plantilla = $_GET["plantilla"];
    $idfitxa = $_GET["idfitxa"];
    $taula = $_GET["taula"];
    $camp = $_GET["camp"];
    $lng = 0;
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header" style='background-color: rgb(90,90,90); color: white'>
                        <div class="col-lg-2"><img src="./img/g3sminilogo.jpg" style="width: 100%"></div>
                        <div class='col-lg-8'><center><h3><?php echo $dto->__($lng,"Subir Archivo"); ?></h3></center></div>
                        <div class='col-lg-2'><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                  </div>
                  <form name="arxiu" action="Upload1.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="gestionaCarregaAdjunt(<?php echo $idfitxa;?>,'<?php echo $plantilla;?>');">
                <div class="modal-body">      <br>
                        <h3>Seleccionar Archivo: </h3> 
                        <br>                        
                            <input type="file" name="fileToUpload[]" id="fileToUpload" style="border: solid 1px" class="well-sm">
                            <input type="hidden" name="camp" id="camp" value="<?php echo $camp; ?>">
                            <input type="hidden" name="taula" id="taula" value="<?php echo $taula; ?>">
                            <input type="hidden" name="idfitxa" id="idfitxa" value="<?php echo $idfitxa; ?>">
                            <input type="hidden" name="plantilla" id="plantilla" value="<?php echo $plantilla; ?>">
                    </div><br>
                    <div class='modal-footer' style='background-color: gainsboro; align-content: right'>
                   
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <span class='glyphicon glyphicon-remove'></span></button>
                    <button type="submit" class="btn btn-success">Adjuntar <span class='glyphicon glyphicon-ok'></span></button>
                    </form>
                </div>
              </div>
            </div>
        </center>
</html>

