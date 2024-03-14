<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idmarcatge = $_GET["1"];
    ?>
    <center>
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Eliminar Marcatge");?></h3></div>            
            <div class="modal-body">
            <h3><?php echo $dto->__($lng,"Està segur d'eliminar aquest Marcatge?");?></h3>
                <br>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-danger" onclick="eliminaMarcatge(<?php echo $idmarcatge;?>);"><span class="glyphicon glyphicon-trash"></span> <?php echo $dto->__($lng,"Eliminar");?></button>
            </div>
      </div>
    </div>
    </center>
</html>
