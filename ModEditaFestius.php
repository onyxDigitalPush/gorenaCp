<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
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

    
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3 style="color:white; text-align: center;"><?php echo $dto->__($lng,"Editar Festius de l'any"); ?></h3>
                  </div>
                <div class="modal-body">
                    <table class="table table-hover table-condensed" style="text-align: center">
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
                                echo '<td style="border-radius: 10px;"><input style="text-align: center; width: 60px; height: 20px; background: rgba(255, 255, 255, 0.2);" data-old_value="'.$dia["dia"].'" value="'.$dia["dia"].'" '
                                    . 'title="'.$dto->__($lng, "Clica per a editar dia").'" onblur="actualitzaCampTaulaNR('."'festiu','dia',".$dia["idfestiu"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>';

                                echo '<td style="border-radius: 10px;"><input style="text-align: center; width: 60px; height: 20px; background: rgba(255, 255, 255, 0.2);" data-old_value="'.$dia["mes"].'" value="'.$dia["mes"].'" '
                                    . 'title="'.$dto->__($lng, "Clica per a editar mes").'" onblur="actualitzaCampTaulaNR('."'festiu','mes',".$dia["idfestiu"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>';


                                if($dia["dataany"]!="") $any = substr($dia["dataany"],0,4);
                                else $any = $dto->__($lng,"Cada any");
                                echo '<td style="border-radius: 10px;">'.$any.'</td>';

                                echo '<td style="border-radius: 10px;"><input style="text-align: center; background: rgba(255, 255, 255, 0.2);" data-old_value="'.$dia["descripcio"].'" value="'.$dia["descripcio"].'" '
                                    . 'title="'.$dto->__($lng, "Clica per a editar festivitat").'" onblur="actualitzaCampTaulaNR('."'festiu','descripcio',".$dia["idfestiu"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>';
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
