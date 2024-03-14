<!DOCTYPE html>
<html>
    <?php
    session_start();
    include 'autoloader.php';    
    $dto = new AdminApiImpl();
   
    $lng = $_SESSION["ididioma"];
    $idemp = $_SESSION["idempresa"];
    $any = $_GET["1"];
    $mes = $_GET["2"];
    $idsubemp = $_GET["3"];
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
          background-color: rgba(72, 90, 255, 0.9); /* Color de fondo con transparencia */
          border: none; /* Sin borde */
          color: white; /* Color del texto */
          border-radius: 5px; /* Borde redondeado */
          margin-right: 10px; /* Espaciado entre botones */
      }

      /* Estilo para los botones cuando están en hover */
      .btn_modal:hover {
          background-color: rgba(81, 209, 246, 0.7); /* Cambia el color de fondo durante el hover */
          color: white; /* Cambia el color del texto durante el hover */
      }


      /* Estilo para el título del modal */
      .modal-body h3 {
          color: white; /* Color del texto del título */
          text-align: center; /* Alineación del texto del título */
      }


      /* Estilo para el select */
      .mi-select {
          width: 100%; /* Ancho del select, puedes ajustarlo según tus necesidades */
          padding: 10px; /* Espaciado interno */
          font-size: 16px; /* Tamaño de fuente */
          border: 1px solid #ccc; /* Borde del select */
          border-radius: 10px; /* Borde redondeado */
          background-color: #fff; /* Color de fondo */
          color: #333; /* Color del texto */
      }

      /* Estilo para el select cuando está en hover (opcional) */
      .mi-select:hover {
          border-color: #007bff; /* Cambia el color del borde al pasar el mouse sobre él */
      }

      /* Estilo para el select cuando está enfocado (opcional) */
      .mi-select:focus {
          border-color: #007bff; /* Cambia el color del borde cuando el select está enfocado */
          outline: none; /* Elimina el contorno predeterminado al hacer clic en el select */
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Agrega una sombra suave cuando el select está enfocado */
      }


</style>



    <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="modal-header">
                      <div class="col-lg-2"><img src="<?php echo $dto->getCampPerIdCampTaula("empresa",$idemp,"ruta_logo");?>" style="width: 100%"></div>
                        <div class='col-lg-8'><center><h3><?php echo $dto->__($lng,"Carregar Excel de Quadrant"); ?></h3></center></div>
                       
                  </div>
                  <form name="quadrantfile" id="quadrantfile" method="post" action="UploadQuadrant.php" enctype="multipart/form-data" target="upload_quadrant">
                      <div class="modal-body">
                        <h3><?php echo $dto->__($lng,"Selecciona l'Arxiu"); ?>:</h3> 
                        <br>                        
                            <input type="file" name="fileToUpload" id="fileToUpload" style="border: solid 1px" class="well-sm">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp;?>">
                            <br>
                            <label><?php echo $dto->__($lng,"Mes d'Aplicació").": ";?></label> <h3><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any;?></h3>
                            <br><br>                            
                            <h4><span class='glyphicon glyphicon-exclamation-sign' style='color: red'></span> <?php echo $dto->__($lng,"Atenció, Aquesta Operació Actualitzarà la Composició dels Torns de la Plantilla d'Empleats per a aquest mes");?></h4>
                           
                    </div><br>
                <div>
                    
                    <button type="button" class="btn_modal" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?> <span class='glyphicon glyphicon-remove'></span></button>
                    <button type="button" class="btn_modal" data-dismiss="modal" onclick="try{document.getElementById('quadrantfile').submit();gestionaCarregaQuadrant(<?php echo $any.",".$mes.",".$idsubemp;?>);}catch(err){alert(err);}" ><?php echo $dto->__($lng,"Carregar");//?> <span class='glyphicon glyphicon-import'></span></button>
                    </div></form>                    
              </div>
            </div>
        </center>
</html>
