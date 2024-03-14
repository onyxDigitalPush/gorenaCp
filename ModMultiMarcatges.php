<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $id = $_GET['1'];
    $data = $_GET["2"];
    $idempresa = $dto->getCampPerIdCampTaula("empleat",$id,"idempresa");
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Registrar Múltiples Marcatges");?></h3>
                  </div>
                <div class="modal-body">
                    <form name="noumarc">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <h3><label class="smtag"><?php echo $dto->__($lng,"Empleat");?>: </label> <?php echo $dto->mostraNomEmpPerId($id);?></h3></div>
                    </div>
                    <br>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-lg-6">
                    <label class="smtag"><?php echo $dto->__($lng,"Des de");?>:</label> <input type="date" name="dataini" value="<?php echo $data;?>" required>
                        </div>
                        <div class="col-lg-6">
                    <label class="smtag"><?php echo $dto->__($lng,"Fins a");?>:</label> <input type="date" name="datafi" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10" style="text-align: center">
                            <label class="smtag"><?php echo $dto->__($lng,"Hores segons l'Horari o rotació assignat");?>: <input class="smtag" checked type="checkbox" name="chkhrqd" id="chkhrqd" onclick="try{lockhours();}catch(err){alert(err);}" style="width: 25px; height: 25px; align-self: baseline"></label>
                        </div>                   
                    </div><br>
                    <div class="row" id="frmhores">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                    <label class="smtag"><?php echo $dto->__($lng,"Hora Inici");?>:</label> <input id="horam1" disabled type="time" name="horaini">
                        </div>
                        <div class="col-lg-5">
                    <label class="smtag"><?php echo $dto->__($lng,"Hora Fi");?>:</label> <input id="horam2" disabled type="time" name="horafi">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10" style="text-align: center">
                            <label class="smtag"><?php echo $dto->__($lng,"Hora sortida variable de 0 a 5 mins aleatoris");?>: <input class="smtag" checked type="checkbox" name="chkhrrd" id="chkhrrd" onclick="" style="width: 25px; height: 25px; align-self: baseline"></label>
                        </div>                   
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="try{insereixMultiMarcatges(noumarc.id.value,noumarc.dataini.value,noumarc.horaini.value,noumarc.datafi.value,noumarc.horafi.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                </div>
              </div>
            </div>
            </center>
</html>
