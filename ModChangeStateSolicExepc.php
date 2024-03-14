<!DOCTYPE html>
<html>

    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idexcep = $_GET["1"];
    $Typeopen = $_GET["2"];
    $MSJobligatori = "'".$dto->__($lng,"La observacion es obligatoria")."'";
  
    ?>
    <center>
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php 
            if ($Typeopen == '1') {
                echo '<h3>'.$dto->__($lng,"Aprobar Periodo").'</h3>';
            }else{
                echo '<h3>'.$dto->__($lng,"Denegar Periodo").'</h3>';
            }

            ?>
        </div>
          <div class="modal-body">

              <form name="changestatesoltper">
              <label><?php echo $dto->__($lng,"Observaciones");?>:</label><input type="text" id="obs" name="obsN" required>

             </form>
              <br>
          </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
        <button type="button" class="btn btn-info" data-toggle="modal" onclick="CahngeStateSolcExepct(obs,<?php echo $idexcep;?>,<?php echo $Typeopen;?>,<?php echo $MSJobligatori;?>);"><span class="glyphicon glyphicon-ok"></span>
        </div>
        </div>
      </div>
    </center>
</html>
