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

    $idrotacio = $_GET['1'];
    $idempl = $dto->getCampPerIdCampTaula("rotacio",$idrotacio,"idempleat");
    $idtipustorn = $dto->getCampPerIdCampTaula("rotacio",$idrotacio,"idtipustorn");
    $data = $dto->getCampPerIdCampTaula("rotacio",$idrotacio,"data");
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
          <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng,"Canviar Torn de Rotació");?></h3></div>
            <form name="noutipustorn" onsubmit="event.preventDefault();">
            <div class="modal-body">
            <h4><?php echo $dto->__($lng,"Empleat");?>: <?php echo $dto->getCampPerIdCampTaula("empleat",$idempl,"nom")." ".$dto->getCampPerIdCampTaula("empleat",$idempl,"cognom1"); ?></h4>
            <h4><?php echo $dto->__($lng,"Dia");?>: <?php echo date('d/m/Y',strtotime($data)); ?></h4>
            <br>
            <h4><input type="checkbox" id="editarepetirfins" style="height: 20px; width: 20px" onclick="if(this.checked===false){document.getElementById('datafitorn').value = null;}"> <?php echo $dto->__($lng,"Repetir fins el dia");?>: <input type="date" id="datafitorn" name="datafitorn" onchange="document.getElementById('repetirfins').checked = true;"> </h4>
            <br>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-3"><label><?php echo $dto->__($lng,"Nom Torn");?>: </label></div>
                <div class="col-lg-7">
                    <select name="idtipustorn" style="width: 100%">
                        <option hidden selected value="<?php echo $idtipustorn;?>"><?php echo $dto->getCampPerIdCampTaula("tipustorn",$idtipustorn,"nom");?></option>
                        <?php
                        $rstt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' order by nom');
                        foreach($rstt as $tt){
                            echo '<option value="'.$tt["idtipustorn"].'">'.$tt["nom"].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br><br>
            </div></form>
           
                <button class="btn_modal" data-dismiss="modal" onclick="eliminaRotacioDia(<?php echo $idrotacio;?>);"><span class="glyphicon glyphicon-trash"></span> <?php echo $dto->__($lng,"Eliminar");?></button>
                <button class="btn_modal" data-dismiss="modal" onclick="editaRotacioDia(<?php echo $idrotacio;?>,noutipustorn.idtipustorn.value,noutipustorn.datafitorn.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Canviar");?></button>            
        </div>
      </div>
    </div>
    </center>
    <?php
    }catch (Exception $ex) {echo $ex->getMessage(); http_response_code(404);}
    ?>
</html>
