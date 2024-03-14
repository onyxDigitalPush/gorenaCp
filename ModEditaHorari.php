<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idhorari = $_GET['1'];
    $nom = $dto->getCampPerIdCampTaula("horaris", $idhorari, "nom");
    $rstorns = $dto->getDb()->executarConsulta('select * from torn where idhorari='.$idhorari);
    $idempresa = $dto->getCampPerIdCampTaula("horaris", $idhorari, "idempresa");
    $torns = new ArrayObject();
    foreach($rstorns as $tsm){
        $torn = new Torn($tsm["diasetmana"],$tsm["horaentrada"],$tsm["horasortida"],$tsm["horestreball"],$tsm["horespausa"],$tsm["marcautomatic"],$tsm["marcabans"],$tsm["laborable"]);
        $torns->append($torn);
    }
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
                  <div class='col-lg-6'><h3 style="color:white;"><?php echo $dto->__($lng,"Editar Horari");?></h3></div>
                  <div class='col-lg-3'><button type="button" class="close" data-dismiss="modal">&times;</button></div>
              </div>
          </div>
            <form name="nouhorari" action="Serveis.php" method="post" target="upload_target" onsubmit="gestionaRefrescaHoraris(<?php echo $idempresa;?>);">
        <div class="modal-body">
            
                <h4><?php echo $dto->__($lng,"Nom");?>: <input type="text" autofocus name="nomhorari" value="<?php echo $nom;?>"></h4> 
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
                
                <th title="<?php echo $dto->__($lng,"Marcatge Anticipat Permès");?>"><?php echo $dto->__($lng,"Ant");?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    for($d=1;$d<=7;$d++){
                        $chklab = "";
                        $horaini = "";
                        $horafi = "";
                        $htreb = 0;
                        $hdesc = 0;
                        $chkaut = "";
                        $chkant = "";
                        foreach($torns as $t){
                            if($t->getDiasetm()==$d){
                                if($t->getLaborable()==1) $chklab = "checked";
                                $horaini = $t->getHoraini();
                                $horafi = $t->getHorafi();
                                $htreb = $t->getHtreb();
                                $hdesc = $t->getHdesc();
                                if($t->getAutomarc()==1) $chkaut = "checked";
                                if($t->getMarcabans()==1) $chkant = "checked";
                            }
                        }
                    echo '<tr>                        
                        <td><input type="checkbox" name="'.$d.'f0" id="'.$d.'f0" style="width: 35px; height: 35px;" '.$chklab.' title="'.$dto->__($lng,"Marcar/Desmarcar Dia Laborable").'"></td>
                        <td>'.$dto->__($lng,$dto->mostraNomDia($d)).'</td>
                        <td><input type="time" name="'.$d.'f1" value="'.$horaini.'"></td>
                        <td><input type="time" name="'.$d.'f2" value="'.$horafi.'"></td>
                        <td><input type="number" name="'.$d.'f3" min="0" max="24" size="2" step="0.01" value="'.$htreb.'"></td>
                        <td><input type="number" name="'.$d.'f4" min="0" max="24" size="2" step="0.01" value="'.$hdesc.'"></td>'
                        
                        .'<td><input type="checkbox" name="'.$d.'f6" style="width: 35px; height: 35px;" '.$chkant.'></td>
                    </tr>';
                    }
                    ?>
                <input type="hidden" name="accio" value="editaHorari">
                <input type="hidden" name="idhorari" value="<?php echo $idhorari;?>">
                </tbody>
            </table>
            <br><br>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-warning" onclick="this.form.submit();"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Desar");?></button>
            
        </div></form>
      </div>
    </div>
    </center>
</html>
