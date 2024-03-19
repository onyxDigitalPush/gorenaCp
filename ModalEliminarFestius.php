<!DOCTYPE html>
<html>
    <?php
    session_start();
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
  
    $idubicacio = intval($_GET['idubicacio']);
    $ubicacio = $dto->seleccionaFestiusPerUbicacio($idubicacio);
    echo '<h4>'.$dto->mostraNomUbicacio($idubicacio).'</h4>';
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
                      <h3 style="color: white;"><?php echo "Eliminar ubicacion"?></h3>
                  </div>
                <div class="modal-body">
                <form name="eliminarFestivo" onsubmit="event.preventDefault();">       
                    <br>
                   
                
                      <p>Desea eliminar la ubicacion? <?php  echo '<h4>'.$dto->mostraNomUbicacio($idubicacio).'</h4>'; ?> </p>
                   
                    <br>
                    <button type="button" class="btn btn-warning"  data-dismiss="modal" onclick="eliminarFestivoCompleto(<?php echo $idubicacio;?>) "><?php echo $dto->__($lng,"Eliminar"); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
</html>
