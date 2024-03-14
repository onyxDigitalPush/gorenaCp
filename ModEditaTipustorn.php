<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idtipustorn = $_GET['1'];
    $idempresa = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "idempresa");
    $nom = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "nom");
    $abr = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "abrv");
    $torn = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "torn");
    $tornnom = $torn;
    if($tornnom>0) $tornnom = $dto->getCampPerIdCampTaula("tornfrac",$torn,"nom");
    $tornfracopt = "";
    $sqlempttorn = "";
    $nomempr = $dto->getCampPerIdCampTaula("empresa",$idempresa,"nom");
    if($nomempr=="Skytanking"){$sqlempttorn=" where idtornfrac<5 or idtornfrac=8";}
    $rstf = $dto->getDb()->executarConsulta('select * from tornfrac '.$sqlempttorn);
    foreach($rstf as $tf) $tornfracopt.= '<option value="'.$tf["idtornfrac"].'">'.$tf["nom"].' ('.$dto->__($lng,$tf["descripcio"]).')</option>';
    $hini = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "horaentrada");
    $hfi = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "horasortida");
    $htreb = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "horestreball");
    $hnit = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "horesnit");
    $hpaus = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "horespausa");
    $bscsb = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "buscasubst");
    $chksbs = '';
    if($bscsb==1) {$chksbs = 'checked';}
    $coltxt = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "colortxt");
    $colbkg = $dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "colorbckg");
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
          <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white"><?php echo $dto->__($lng,"Editar Torn per a Rotacions");?></h3></div>
            <form name="noutipustorn" onsubmit="event.preventDefault();">
        <div class="modal-body">
            <h4 style="color:white"><?php echo $dto->__($lng,"Empresa");?>: <?php echo $dto->mostraNomEmpresa($idempresa); ?></h4><br>
                <div class="row"><div class="col-lg-1"></div><div class="col-lg-3"><label><?php echo $dto->__($lng,"Nom Torn");?>: </label></div><div class="col-lg-7"><input type="text" name="nom" style="width: 100%" value="<?php echo $nom;?>"></div></div><!--placeholder="<?php //echo $dto->__($lng,"Nom de l'horari");?>"-->
                <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3"><label><?php echo $dto->__($lng,"Abreviació");?>: </label></div>
                    <div class="col-lg-2"><input type="text" name="abr" style="width: 100%" value="<?php echo $abr;?>"></div>
                    <div class="col-lg-3"><label><?php echo $dto->__($lng,"Tipus Torn");?>: </label></div>
                    <div class="col-lg-2"><select name="torn" style="width: 100%"><option hidden selected value="<?php echo $torn;?>"><?php echo $tornnom.'</option>'.$tornfracopt;?></select></div>
                </div>                
                <br><br>
            <table class="table-condensed table-bordered">
                <thead>
                <tr>
                <th><?php echo $dto->__($lng,"Hª Inici");?></th>
                <th><?php echo $dto->__($lng,"Hª Final");?></th>
                <th title="<?php echo $dto->__($lng,"Hores Treball");?>"><?php echo $dto->__($lng,"H Trb");?></th>
                <th title="<?php echo $dto->__($lng,"Hores Nocturnes");?>"><?php echo $dto->__($lng,"H Noc");?></th>
                <th title="<?php echo $dto->__($lng,"Hores Descans");?>"><?php echo $dto->__($lng,"H Dsc");?></th>
                <th title="<?php echo $dto->__($lng,"Autocerca Substitut");?>"><?php echo $dto->__($lng,"Aut.Subs");?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    echo '<tr>
                        <td><input type="time" name="hora1" value="'.$hini.'"></td>
                        <td><input type="time" name="hora2" value="'.$hfi.'"></td>
                        <td><input type="number" name="htreb" min="0" max="24" step="0.1" size="2" value="'.$htreb.'"></td>
                        <td><input type="number" name="hnoct" min="0" max="24" step="0.1" size="2" value="'.$hnit.'"></td>
                        <td><input type="number" name="hdesc" min="0" max="24" step="0.1" size="2" value="'.$hpaus.'"></td>
                        <td style="text-align: center"><input type="checkbox" '.$chksbs.' name="autsb" style="width: 35px; height: 35px;"></td>
                    </tr>';
                    ?>
                </tbody>
            </table>
                <br><br>
                <div class="row">  
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3"><label class="well-sm"><?php echo $dto->__($lng,"Color Text");?>:</label></div>
                    <div class="col-lg-2"><input type="color" name="colortxt" style="width: 60px; height: 40px" value="<?php echo $coltxt;?>"></div>
                    <div class="col-lg-3"><label class="well-sm"><?php echo $dto->__($lng,"Color Fons");?>:</label></div>
                    <div class="col-lg-2"><input type="color" name="colorbckg" style="width: 60px; height: 40px" value="<?php echo $colbkg;?>"></div>
                </div>
            <br>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button class="btn btn-success" data-dismiss="modal" onclick="editaTipusTorn(<?php echo $idtipustorn;?>,noutipustorn.nom.value,noutipustorn.abr.value,noutipustorn.torn.value,noutipustorn.hora1.value,noutipustorn.hora2.value,noutipustorn.htreb.value,noutipustorn.hnoct.value,noutipustorn.hdesc.value,noutipustorn.colortxt.value,noutipustorn.colorbckg.value,noutipustorn.autsb.checked);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Desar");?></button>
            
        </div></form>
      </div>
    </div>
    </center>
</html>
