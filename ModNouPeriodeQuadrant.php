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
              <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng,"Registrar Nou Període Especial");?></h3></div>
            <div class="glassmorphism">
                <form name="assignaperiodeexcep">
                <label><?php echo $dto->__($lng,"Persona");?>: </label> 
                <select name="idempleatq">
                    <?php
                    
                        $nm="";
                    foreach($persones as $p) {echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nomempl"].'</option>';}
                    ?>
                </select><br><br>                    
                <label><?php echo $dto->__($lng,"Tipus");?>: </label> 
                <select name="idtipusexcep">
                <?php
                    $tipus = $dto->seleccionaTipusExcepcions();
                    foreach($tipus as $valor)
                    {
                        echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                    }
                ?>
                </select><br><br>
                <label><?php echo $dto->__($lng,"Data Inici");?>: </label> <input type="date" name="dataini" required><br><br>
                <label><?php echo $dto->__($lng,"Data Fi");?>: </label> <input type="date" name="datafi" required><br><br>
            </form>
            </div>
                <div class="">
                <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn_modal" data-toggle="modal" onclick="try{assignaExcep(assignaperiodeexcep.idempleatq.value,assignaperiodeexcep.idtipusexcep.value,assignaperiodeexcep.dataini.value,assignaperiodeexcep.datafi.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                </div>
          </div>
        </div>
        </center>
</html>
