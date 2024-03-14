<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idempresa = $_GET['1'];
    $nom = $dto->getCampPerIdCampTaula("empresa",$idempresa,"nom");
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3><?php echo $dto->__($lng,"Editar Dades Empresa"); ?></h3>
                  </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Nom");?> </label>                  
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $nom;?>" value="<?php echo $nom;?>" onblur="actualitzaCampTaulaNR('empresa','nom','<?php echo $idempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"C.I.F/N.I.F");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"cif");?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"cif");?>" onblur="actualitzaCampTaulaNR('empresa','cif','<?php echo $idempresa;?>',this.title,this.value);">                    
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Centre de Treball");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"centre_treball");?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"centre_treball");?>" onblur="actualitzaCampTaulaNR('empresa','centre_treball','<?php echo $idempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>  
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"C.C.C.");?> </label>                   
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"ccc");?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"ccc");?>" onblur="actualitzaCampTaulaNR('empresa','ccc','<?php echo $idempresa;?>',this.title,this.value);">                
                        </div>
                    </div>  
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Població");?> </label>                   
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"poblacio");?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"poblacio");?>" onblur="actualitzaCampTaulaNR('empresa','poblacio','<?php echo $idempresa;?>',this.title,this.value);">                
                        </div>
                    </div>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-eject"></span> <?php echo $dto->__($lng,"Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
</html>
