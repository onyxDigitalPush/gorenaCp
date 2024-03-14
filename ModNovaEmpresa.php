<!DOCTYPE html>
<html>
    <?php
    try{
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
   
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
              <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Alta de Nova Empresa");?></h3></div>
            <div class="modal-body">
                <form name="empresanova" onsubmit="event.preventDefault();">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"Nom");?> </label>                  
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="nomemp">                   
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"C.I.F/N.I.F");?> </label>                    
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="cifnif">                    
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"Centre de Treball");?> </label>                    
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ctreb">                   
                    </div>
                </div>  
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"C.C.C.");?> </label>                   
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ccc">                   
                    </div>
                </div>  
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"Població");?> </label>                   
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="poblacio">                   
                    </div>
                </div></form>
                <br>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn btn-success" onclick="try{novaEmpresa(empresanova.nomemp.value,empresanova.cifnif.value,empresanova.ctreb.value,empresanova.ccc.value,empresanova.poblacio.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Crear");?></button>
                </div>
          </div>
            </div>
    </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
