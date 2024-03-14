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
    $login = $dto->getCampPerIdCampTaula("empresa",$idempresa,"usuari_inici");
    $pwd = $dto->getCampPerIdCampTaula("empresa",$idempresa,"contrasenya_inici");
    $domini = $dto->getCampPerIdCampTaula("empresa",$idempresa,"website");
    $ididioma = $dto->getCampPerIdCampTaula("empresa",$idempresa,"ididiomadef");
    $nomidioma = $dto->getCampPerIdCampTaula("idioma",$ididioma,"nom");
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3><?php echo $dto->__($lng,"Editar Administrador Empresa"); ?></h3>
                  </div>
                <div class="modal-body">
                    <h3><label><?php echo $dto->__($lng,"Empresa");?>:</label> <?php echo $nom;?></h3><br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Domini");?> </label>                  
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" style="width: 100%" title="<?php echo $domini;?>" value="<?php echo $domini;?>" onblur="actualitzaCampTaulaNR('empresa','website','<?php echo $idempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Usuari");?> </label>                  
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $login;?>" value="<?php echo $login;?>" onblur="actualitzaCampTaulaNR('empresa','usuari_inici','<?php echo $idempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Contrasenya");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $pwd;?>" value="<?php echo $pwd;?>" onblur="actualitzaCampTaulaNR('empresa','contrasenya_inici','<?php echo $idempresa;?>',this.title,this.value);">                    
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Idioma");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <select onchange="actualitzaCampTaulaNR('empresa','ididiomadef','<?php echo $idempresa;?>',this.title,this.value);">
                                <option hidden selected value="<?php echo $ididioma;?>"><?php echo $nomidioma;?></option>
                                <?php
                                $rsidioma = $dto->getDb()->executarConsulta('select * from idioma where global=1');
                                foreach($rsidioma as $i) { echo '<option value="'.$i["ididioma"].'"><image src="'.$i["ruta_bandera"].'" style="height: 15px; width: 25px"> '.$i["nom"].'</option>'; } 
                                ?>
                            </select>
                        </div>
                    </div>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Acceptar"); ?></button>
                </div>
              </div>
            </div>
            </center>
</html>
