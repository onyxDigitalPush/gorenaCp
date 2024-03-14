<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    try{
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    $idempresa = $_SESSION["idempresa"];
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
   
    $idempl = $_GET['1'];
    $data = $_GET['2'];
    ?>
    <center>
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Assignar Torn de Rotació");?></h3></div>
            <form name="noutipustorn" onsubmit="event.preventDefault();">
            <div class="modal-body">
            <h4><?php echo $dto->__($lng,"Empleat");?>: <?php echo $dto->getCampPerIdCampTaula("empleat",$idempl,"nom")." ".$dto->getCampPerIdCampTaula("empleat",$idempl,"cognom1"); ?></h4>
            <br>
            <h4><?php echo $dto->__($lng,"Dia");?>: <input type="date" name="datatorn" value="<?php echo $data;?>"> </h4>
            <br>
            <h4><input type="checkbox" id="repetirfins" style="height: 20px; width: 20px" onclick="if(this.checked===false){document.getElementById('datafitorn').value = null;}"> <?php echo $dto->__($lng,"Repetir fins el dia");?>: <input type="date" id="datafitorn" name="datafitorn" onchange="document.getElementById('repetirfins').checked = true;"> </h4>
            <br>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3"><label><?php echo $dto->__($lng,"Nom Torn");?>: </label></div>
                <div class="col-lg-7">
                    <select name="idtipustorn" style="width: 100%">
                        <?php
                        $rstt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa);
                        foreach($rstt as $tt){
                            echo '<option value="'.$tt["idtipustorn"].'">'.$tt["nom"].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br><br>
            </div></form>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-info" data-dismiss="modal" onclick="creaRotacioDia(<?php echo $idempl;?>,noutipustorn.idtipustorn.value,noutipustorn.datatorn.value,noutipustorn.datafitorn.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Canviar");?></button>            
        </div>
      </div>
    </div>
    </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
