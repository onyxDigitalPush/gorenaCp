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
                      <h3 style="color: white;"><?php echo "Festivos del año"?></h3>
                  </div>
                <div class="modal-body">
                    <br>
                    <table class="table  table-hover table-condensed" style="text-align: center; ">
                        <thead>
                        <th style="text-align: center;background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Dia"); ?></th>
                        <th style="text-align: center;background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Mes"); ?></th>
                        <th style="text-align: center;background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Any"); ?></th>
                        <th style="text-align: center;background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Descripció"); ?></th>
                        </thead>
                        <tbody>
                        <?php    
                            foreach($ubicacio as $dia)
                            {
                                echo '<tr>';
                                echo '<td style="border-radius: 10px;">'.$dia["dia"].'</td>';
                                echo '<td style="border-radius: 10px;">'.$dto->__($lng,$dto->mostraNomMes($dia["mes"])).'</td>';
                                if($dia["dataany"]!="") $any = substr($dia["dataany"],0,4);
                                else $any = $dto->__($lng,"Cada any");
                                echo '<td style="border-radius: 10px;">'.$any.'</td>';
                                if($dto->esAdmin($_SESSION["id"])) echo '<td style="border-radius: 10px;"><input style="text-align: center" data-old_value="'.$dia["descripcio"].'" value="'.$dia["descripcio"].'" '
                                . 'title="'.$dto->__($lng,"Clica per a editar festivitat").'" onblur="actualitzaCampTaula('."'festiu','descripcio',".$dia["idfestiu"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>';
                                else echo '<td style="border-radius: 10px;">'.$dia["descripcio"].'</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
</html>
