<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idexcep = $_GET["1"];
    $idtipusexcep = $_GET["2"];
    $nomexcep = $dto->getCampPerIdCampTaula("tipusexcep",$idtipusexcep,"nom");;
    $dataini = $_GET["3"];
    $datafi = $_GET["4"];
    $id = $dto->getCampPerIdCampTaula("excepcio",$idexcep,"idempleat");
    include 'Conexion.php'
    
    ?>





                    <?php


                    $idexcepcio = $idexcep; // Reemplaza con el ID de excepcio adecuado

                    // Consulta SQL para obtener el valor de la columna "comentario" de la tabla "excepcio"
                    $sql = "SELECT comentario FROM excepcio WHERE idexcepcio = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $idexcepcio);
                    $stmt->execute();
                    $stmt->bind_result($comentario);

                    if ($stmt->fetch()) {
                        // Aquí puedes usar el valor de $comentario para lo que necesites
                    

                    } else {
                        echo "No se encontró ningún comentario para el ID de excepcio especificado.";
                    }



                    $stmt->close();
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
        <div class="glassmorphism">
            <h3 style="color:white;"><?php echo "Editar Período Especial"?></h3>
        </div>
          <div class="modal-body">
              <h4><?php echo $dto->__($lng,"Empleat").": ".$dto->mostraNomEmpPerId($id);?></h4><br>
              <form name="editaexcepM">
              <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcepM" value="<?php echo $dataini;?>">
              <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcepM" value="<?php echo $datafi;?>"><br><br>
              <label><?php echo $dto->__($lng,"Tipus");?>:</label>
<br>
              <label><?php echo $dto->__($lng,"Comentario");?>:</label><input type="text" id="comentario" name="comentarioM" value="<?php echo $comentario;?>">

              <select id="tipusExcep" name="tipusExcepM">
                  <option hidden selected value="<?php echo $idtipusexcep;?>"><?php echo $dto->__($lng,$nomexcep);?></option>
              <?php
                  $tipus = $dto->seleccionaTipusExcepcions();
                  foreach($tipus as $valor)
                  {
                      echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                  }
              ?>
              </select>


            </form>
              <br>
          </div>
        <div class="">
        <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
        <button type="button" class="btn_modal" data-toggle="modal" onclick="try{editaExcep(<?php echo $idexcep;?>,editaexcepM.tipusExcepM.value,editaexcepM.datainiexcepM.value,editaexcepM.datafiexcepM.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
        </div>
        </div>
      </div>
    </center>
</html>
