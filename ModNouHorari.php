<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    //$id = intval($_GET['id']);
    $idempresa = $_GET['1'];    
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
          <div class="glassmorphism">
              <div class="row">
                  <div class='col-lg-3'><img src="<?php echo $_SESSION["logoempresa"]; ?>" style="width: 100%"></div>
                  <div class='col-lg-6'><h3 style="color:white;"><?php echo $dto->__($lng,"Crear Nou Horari");?></h3></div>
                  <div class='col-lg-3'><button type="button" class="close" data-dismiss="modal">&times;</button></div>
              </div>
          </div>
          <form name="modcreanouhorari" action="Serveis.php" method="post" target="upload_target" onsubmit="event.preventDefault();gestionaRefrescaHoraris(<?php echo $idempresa;?>);">
        <div class="modal-body">
            <!--h4><?php echo $dto->__($lng,"Empresa");?>: <?php echo $dto->mostraNomEmpresa($idempresa); ?></h4><br-->
                <h4 style="color:white;"><?php echo $dto->__($lng,"Nom");?>: <input type="text" autofocus name="nomhorari"></h4> <!--placeholder="<?php //echo $dto->__($lng,"Nom de l'horari");?>"-->
                <br>
            <table class="table-condensed table-bordered">
                <thead>
                <tr>
                <th title="<?php echo $dto->__($lng,"Marcar/Desmarcar Tots")." ".$dto->__($lng,"Laborables");?>"><input type="checkbox" id="chkalldays" onclick="marcaTotsDiesSetm();" style="width: 35px; height: 35px;"></th>
                <th><?php echo $dto->__($lng,"Dia");?></th>
                <th><?php echo $dto->__($lng,"Hª Inici");?></th>
                <th><?php echo $dto->__($lng,"Hª Final");?></th>
                <th title="<?php echo $dto->__($lng,"Hores Treball");?>"><?php echo $dto->__($lng,"H Trb");?></th>
                <th title="<?php echo $dto->__($lng,"Hores Descans");?>"><?php echo $dto->__($lng,"H Dsc");?></th>
                <!--th title="<?php //echo $dto->__($lng,"Automarcatge");?>"><?php echo $dto->__($lng,"Aut");?></th-->
                <th title="<?php echo $dto->__($lng,"Marcatge Anticipat Permès");?>"><?php echo $dto->__($lng,"Ant");?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    for($d=1;$d<=7;$d++){
                    echo '<tr>                        
                        <td><input type="checkbox" name="'.$d.'f0" id="'.$d.'f0" style="width: 35px; height: 35px;" title="'.$dto->__($lng,"Marcar/Desmarcar Dia Laborable").'"></td>
                        <td>'.$dto->__($lng,$dto->mostraNomDia($d)).'</td>
                        <td><input type="time" name="'.$d.'f1"></td>
                        <td><input type="time" name="'.$d.'f2"></td>
                        <td><input type="number" name="'.$d.'f3" min="0" max="24" step="0.1" size="2"></td>
                        <td><input type="number" name="'.$d.'f4" min="0" max="24" step="0.1" size="2"></td>
                        <td><input type="hidden" name="'.$d.'f5" style="width: 35px; height: 35px;">'
                            . '<input type="checkbox" name="'.$d.'f6" style="width: 35px; height: 35px;"></td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
                <input type="hidden" name="accio" value="creaHorari">
                <input type="hidden" name="idempresa" value="<?php echo $idempresa;?>">
            <br><br>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-success" onclick="try{this.form.submit();}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Crear");?></button>            
        </div></form>
      </div>
    </div>
    </center>
</html>
