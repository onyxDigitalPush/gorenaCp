<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    include '../persistencia/Conexio/API/GestorPersistenciaMySQL.php';
    include '../persistencia/Conexio/impl/GestorPersistenciaMySQLImpl.php';
    include '../logica/API/AdminApi.php';
    include '../logica/Impl/AdminApiImpl.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    try{
    $idempresa = $_GET["0"];
    $any = $_GET["1"]; 
    $mes = $_GET["2"];
    $zmes = "";
    if($mes<10){$zmes="0".$mes;}
    else{$zmes=$mes;}
    $dpt = $_GET["3"]; 
    $rol = $_GET["4"]; 
    $idsubemp = $_GET["5"];
    $sqlsubemp = '';
    if($idsubemp!="Totes") $sqlsubemp = 'and e.idsubempresa='.$idsubemp;
    $sqljoindpt = '';
    $sqlnomdpt = '';
    if($dpt!="Tots") {
        $sqljoindpt = 'join pertany as p on p.id_emp = e.idempleat join departament as dp on dp.iddepartament = p.id_dep';
        $sqlnomdpt = 'and dp.nom like "'.$dpt.'"';
    }
    $sqljoinrol = '';
    $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
    $sqlnomrol = '';
    if($rol!="Tots") {
        $sqlnomrol = 'and ro.nom like "'.$rol.'"';
        $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';                    
    }
   
    $sqlpers = 'select *, e.idempleat as idempleat, e.nom as nomempl '
            . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
            . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0))) order by e.cognom1, e.cognom2, e.nom';//
    
    $persones = $dto->getDb()->executarConsulta($sqlpers);
    $data = $any."-".$zmes."-01";
    if(isset($_GET["6"])){$data = $any."-".$zmes."-".$_GET["6"];}    
    }catch(Exception $ex) {$msg = $ex->getMessage();}
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
                <div class="col-lg-2"><img src="<?php echo $dto->getCampPerIdCampTaula("empresa",$idempresa,"ruta_logo");?>" style="width: 100%"></div>
                <div class='col-lg-8'><h3><?php echo $dto->__($lng,"Intercanvi Torn de Rotació");?></h3></div>
                
              </div>
            <div class="modal-body">
                <h3><?php echo $dto->__($lng,"Seleccioneu la Data, les Persones i el Tipus d'Intercanvi");?></h3>
                <br>
                <form name="canvi">
                    <label><?php echo $dto->__($lng,"Data Intercanvi");?>: </label> <input type="date" name="data" required value='<?php echo date('Y-m-d',strtotime($data));?>'><br><br>
                <label><?php echo $dto->__($lng,"Persona");?> 1: </label> 
                <select name="idemp1">
                    <?php
                    
                        $nm="";
                    foreach($persones as $p) {echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nomempl"].'</option>';}
                    ?>
                </select><br><br>                    
                
                <label><?php echo $dto->__($lng,"Persona");?> 2: </label> 
                <select name="idemp2">
                    <?php
                    
                        $nm="";
                    foreach($persones as $p) {echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nomempl"].'</option>';}
                    ?>
                </select><br><br>
                <h3><?php echo $dto->__($lng,"Tipus d'Intercanvi");?></h3>
                <br>
                <div class="row"><div class="col-lg-2"></div><div class="col-lg-6"><label><?php echo $dto->__($lng,"Intercanvi de Torns");?>: </label></div><div class="col-lg-1"><input type="radio" name="tipus" value="inter" checked style="height: 25px; width: 25px"></div></div><br>
                <div class="row"><div class="col-lg-2"></div><div class="col-lg-6"><label><?php echo $dto->__($lng,"Persona 2 Absorbeix Torn Persona 1 i Persona 1 Queda Lliure");?>: </label></div><div class="col-lg-1"><input type="radio" name="tipus" value="abs2" style="height: 25px; width: 25px"></div></div><br><br>
            </form>                
            </div>
                <div class="">
                <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn_modal" data-toggle="modal" onclick="try{intercanviTorns(canvi.data.value,canvi.idemp1.value,canvi.idemp2.value,canvi.tipus.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Realitzar");?></button>
                </div>
          </div>
        </div>
        </center>
</html>
