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

    $idempleat = $_GET['1'];
    $nomempl = $dto->getCampPerIdCampTaula("empleat",$idempleat,"nom");
    $any = $_GET["2"];
    $hores = 0;
    $rsh = $dto->getDb()->executarConsulta('select * from horesany where idempleat='.$idempleat.' and anylab='.$any);
    if(!empty($rsh)) {foreach($rsh as $h){$hores = $h["hores"];}}
    ?>




<style>
      /* Estilo para el fondo del modal */
      .modal-content.glassmorphism {
          background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
          backdrop-filter: blur(10px); /* Efecto de desenfoque */
          border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
          border-radius: 10px; /* Borde redondeado */
          padding: 10px;
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





    <div class="modal-dialog glassmorphism">
      <div class="modal-content glassmorphism">
          <div class=""><h3 style="color: black;"><?php echo "Editar Horas Anuales"?></h3></div>
            <form name="horesanylab" onsubmit="event.preventDefault();">
            <div class="modal-body">
            <h3 style="color: black;"><?php echo "Empleado"?>: <?php echo $nomempl." ".$dto->getCampPerIdCampTaula("empleat",$idempleat,"cognom1"); ?></h3>
            <h3 style="color: black;"><?php echo "Año"?>: <?php echo $any; ?></h3>
            <br>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-3"><h4><?php echo $dto->__($lng,"Hores");?>: </h4></div>
                <div class="col-lg-3">
                    <input class="well-sm" type="number" step="0.1" name="numhores" style="width: 100%" value="<?php echo $hores;?>">
                </div>
            </div>
            <br>
            </div></form>
            <div class="">
                <button class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn_modal" data-dismiss="modal" onclick="try{desaHoresAny(<?php echo $idempleat;?>,<?php echo $any; ?>,horesanylab.numhores.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Canviar");?></button>            
        </div>
      </div>
    </div>
    </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
