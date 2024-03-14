<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    
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
              <div class='col-lg-8'><h3><?php echo $dto->__($lng,"Reassignar Marcatges a Múltiples Persones");?></h3></div>
              <div class='col-lg-2'><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                  </div>
                <div class="modal-body">
                    <form name="marcapersona" onsubmit="event.preventDefault();">                   
                    <h4><?php echo $dto->__($lng,"Indiqueu la Data on reassignar marcatges per a aquestes persones");?>:</h4><br>
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
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10"><label><?php echo $dto->__($lng,"Data d'Inici de Torn");?>:</label> <input type="date" name="data" value="<?php echo date('Y-m-d',strtotime('today'));?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                    </div><br>
                    <h4><?php echo $dto->__($lng,"S'eliminaran els seus marcatges d'aquell dia i s'aplicaran els corresponents als Horaris o Torns de Rotació que tingués assignat");?></h4><br>                    
                    </form>
                </div>
                <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-warning" data-dismiss="modal" onclick="assignaMarcatgeMultipers(<?php echo $i;?>,marcapersona.data.value);"><span class="glyphicon glyphicon-pencil"></span> <?php echo $dto->__($lng,"Reassignar");?></button>
                </div>
              </div>
            </div>
    </center>
    
</html>
