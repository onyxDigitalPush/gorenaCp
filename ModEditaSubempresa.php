<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
   
    $idsubempresa = $_GET['1'];
    $nom = $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"nom");
    $idempresa = $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"idempresa");
    ?>



<style>



          /* Estilo para el fondo del modal */
          .modal-content.glassmorphism {
          background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          backdrop-filter: blur(10px); /* Efecto de desenfoque */
          border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
          border-radius: 10px; /* Borde redondeado */
      }

      /* Estilo para el cuerpo del modal */
      .modal-body {
          background: rgba(255, 255, 255, 0.1); /* Color de fondo con transparencia */
          padding: 20px; /* Espaciado interior */
      }

      /* Estilo para los botones dentro del modal */
      .btn_modal {
          background-color: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          border: none; /* Sin borde */
          color: white; /* Color del texto */
          border-radius: 5px; /* Borde redondeado */
          margin-right: 10px; /* Espaciado entre botones */
      }

      /* Estilo para los botones cuando están en hover */
      .btn_modal:hover {
          background-color: rgba(81, 209, 246, 0.3); /* Cambia el color de fondo durante el hover */
          color: white; /* Cambia el color del texto durante el hover */
      }

      /* Estilo para el título del modal */
      .modal-body h3 {
          color: white; /* Color del texto del título */
          text-align: center; /* Alineación del texto del título */
      }



</style>


    <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3 style="color:white;"><?php echo $dto->__($lng,"Editar Dades Subempresa"); ?></h3>
                  </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right"><h3><label><?php echo $dto->__($lng,"Empresa");?>:</label></h3>                  
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <h3><?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"nom");?></h3>
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Nom");?> </label>                  
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"nom");?>" value="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"nom");?>" onblur="actualitzaCampTaulaNR('subempresa','nom','<?php echo $idsubempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"C.I.F/N.I.F");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                            <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"cif");?>" value="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"cif");?>" onblur="actualitzaCampTaulaNR('subempresa','cif','<?php echo $idsubempresa;?>',this.title,this.value);">                    
                        </div>
                    </div>
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Centre de Treball");?> </label>                    
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"centre_treball");?>" value="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"centre_treball");?>" onblur="actualitzaCampTaulaNR('subempresa','centre_treball','<?php echo $idsubempresa;?>',this.title,this.value);">                   
                        </div>
                    </div>  
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"C.C.C.");?> </label>                   
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"ccc");?>" value="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"ccc");?>" onblur="actualitzaCampTaulaNR('subempresa','ccc','<?php echo $idsubempresa;?>',this.title,this.value);">                
                        </div>
                    </div>  
                        <br>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4" style="text-align: right">
                        <label><?php echo $dto->__($lng,"Població");?> </label>                   
                        </div>
                        <div class="col-lg-6" style="text-align: left">
                        <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"poblacio");?>" value="<?php echo $dto->getCampPerIdCampTaula("subempresa",$idsubempresa,"poblacio");?>" onblur="actualitzaCampTaulaNR('subempresa','poblacio','<?php echo $idsubempresa;?>',this.title,this.value);">                
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
