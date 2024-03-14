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
   
    $arridpers=[];
    $arridpers = json_decode($_GET['1']);
    ?>
    <center>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <div class="col-lg-2"><img src="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"ruta_logo");?>" style="width: 100%"></div>
              <div class='col-lg-8'><h3><?php echo $dto->__($lng,"Assignar Ubicació a Múltiples Persones");?></h3></div>
              <div class='col-lg-2'><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            </div>
          <div class="modal-body">                  
              <h4><?php echo $dto->__($lng,"Assigneu Ubicació i Data d'Inici per a aquestes persones");?>:</h4><br>
              <div class="row">
                  <div class="col-lg-2"></div>
                  <div class="col-lg-8">
                      <table id="nomspers" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;">
                      <thead><th colspan="2"><?php echo $dto->__($lng,"Personas");?></th></thead>
                      <tbody>
                      <?php 
                      $i = 0;
                      foreach($arridpers as $p){
                          $i++;                                
                          echo '<tr><td>'.$dto->getCampPerIdCampTaula("empleat",$p,"nom")." ".$dto->getCampPerIdCampTaula("empleat",$p,"cognom1")." ".$dto->getCampPerIdCampTaula("empleat",$p,"cognom2").'</td>'
                                  . '<td><input type="hidden" id="idemp'.$i.'" value="'.$p.'"><input type="checkbox" checked id="chkemp'.$i.'" style="height: 20px; width:20px"></td></tr>';
                      }
                      ?>   
                      </tbody>   
                      </table>
                  </div>
                  <div class="col-lg-2"></div>                            
              </div>
              <br>
              <div class="row">
                  <div class="col-lg-2"></div>                        
                  <div class="col-lg-4"><label><?php echo $dto->__($lng,"Ubicació");?>:</label><br><select class="well-sm" id="idlocalitzacio">
                      <?php 
                      $rsu = $dto->seleccionaUbicacionsPerIdEmpresa($idempresa);
                      foreach($rsu as $u) echo '<option value="'.$u["idlocalitzacio"].'">'.$u["nom"].'</option>';
                      ?>
                  </select></div>
                  <div class="col-lg-4"><label><?php echo $dto->__($lng,"Data Inici");?>:</label><br><input type="date" id="dataini" value="<?php echo date('Y-m-d',strtotime('today'));?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
              </div><br><br>                    
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="try{assignaUbicacioMultipers(<?php echo $i;?>);}catch(err){alert(err);}"><?php echo $dto->__($lng,"Assignar");?></button>
          </div>
        </div>
      </div>
    </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
