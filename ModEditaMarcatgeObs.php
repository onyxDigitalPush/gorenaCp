<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    try{
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
   
    $id = $_GET['1'];
    $idempl = $dto->getCampPerIdCampTaula("marcatges",$id,"id_emp");
    $data = date('Y-m-d',strtotime($dto->getCampPerIdCampTaula("marcatges",$id,"datahora")));
    $hora = date('H:i:s',strtotime($dto->getCampPerIdCampTaula("marcatges",$id,"datahora")));
    $entsort = $dto->getCampPerIdCampTaula("marcatges",$id,"entsort");
    $nomentsort = $dto->__($lng,"Entrada");
    if($entsort==1) $nomentsort = $dto->__($lng,"Sortida");
    $id_tipus = $dto->getCampPerIdCampTaula("marcatges",$id,"id_tipus");
    $tipusact = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusactivitat",$id_tipus,"nom"));
    $obs = $dto->getCampPerIdCampTaula("marcatges",$id,"observacions");
    $idempresa = $dto->getCampPerIdCampTaula("empleat",$idempl,"idempresa");
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Editar Marcatge");?></h3>
                  </div>
                    <form name="noumarc">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Persona");?>: <?php echo $dto->mostraNomEmpPerId($idempl);?></h3><br>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5">
                    <label><?php echo $dto->__($lng,"Data");?>:</label><input type="date" name="data" value="<?php echo $data;?>" required>
                        </div>
                        <div class="col-lg-3">
                    <label><?php echo $dto->__($lng,"Hora");?>:</label><input type="time" name="hora" value="<?php echo $hora;?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6"><label><?php echo $dto->__($lng,"Tipus");?>:</label> 
                    <select name="entsort">
                        <option hidden selected value="<?php echo $entsort;?>"><?php echo $nomentsort;?></option>
                        <option value="0"><?php echo $dto->__($lng,"Entrada");?></option>
                        <option value="1"><?php echo $dto->__($lng,"Sortida");?></option>
                    </select>
                    <select name="tipus">
                        <option hidden selected value="<?php echo $id_tipus;?>"><?php echo $tipusact;?></option>
                    <?php
                        $tipus = $dto->mostraTipusActivitatsPerEmpresa($idempresa);
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusactivitat"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select></div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-1">
                            <label><?php echo $dto->__($lng,"Observacions");?>:</label></div>
                        <div class="col-lg-9"><input type="text" name="obs" style="height: 50px" value="<?php echo $obs;?>"></div>
                    </div>
                    <br>                   
                </div></form> 
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="editaMarcatgeObs(<?php echo $id;?>,noumarc.entsort.value,noumarc.tipus.value,noumarc.data.value,noumarc.hora.value,noumarc.obs.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Desar");?></button>
                </div>
              </div>
            </div>
            </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
