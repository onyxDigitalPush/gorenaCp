<!DOCTYPE html>
<html><?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
include 'autoloader.php';
include './Pantalles/HeadGeneric.html';
$dto = new AdminApiImpl();
$dto->navResolver();

?>

<head id="header">





<style>
    /* Estilo específico para la palabra "Filtro" */
    .filtro-text {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-right: 10px; /* Agrega un espacio entre la palabra "Filtro" y el desplegable */
        color: black;
        text-decoration: none;
    }

    /* Estilo para el enlace del desplegable */
    .filtro-link {
        font-size: 16px;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        padding: 5px 10px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
        outline: none;
    }

    /* Estilo para el enlace del desplegable al pasar el mouse por encima */
    .filtro-link:hover {
        background-color: #ddd;
        color: #333;
    }

    /* Estilo para el contenido del desplegable */
    .filtro-content {
        background-color: #fff;
        border: 1px solid #ddd;
        border-top: 0;
        border-radius: 0 0 4px 4px;
        padding: 10px;
    }


    .btn-next {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-next .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-next .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-next:hover {
      background-color: #ff5722; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }

	

  .btn-green {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3); 
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-green .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-green .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-green:hover {
      background-color: #00cd00; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }
	
	
	
	
	
	  .btn-red {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3); 
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-red .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-red .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-red:hover {
      background-color: #ec5653; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }


  .btn-blue {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent; /* Fondo transparente */
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-blue .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-blue .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-blue:hover {
      background-color: #0088fa; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }



	
  .btn-neutro {
      position: relative; /* Necesario para el posicionamiento de los elementos internos */
      padding: 10px 20px;
      background-color: transparent;
      color: black; /* Texto transparente */
      border:2px solid rgba(0, 0, 0, 0.3);
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease; /* Animación suave en todos los cambios */
  }

  .btn-neutro .icon-arrow-right {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 84px; /* Tamaño de la flecha */
      color: #007bff; /* Color de la flecha antes del hover */
      transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
  }

  .btn-neutro .btn-text {
      position: relative;
      z-index: 1; /* Coloca el texto del botón sobre la flecha */
  }

  .btn-neutro:hover {
      background-color: #919191; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }
	






  .btn-supersmall {
    padding: 2px 5px; /* Ajusta el espaciado para botones pequeños */
    font-size: 10px; /* Tamaño de fuente más pequeño */
    /* Otros estilos específicos para botones pequeños si es necesario */
    }

  .btn-small {
    padding: 5px 10px; /* Ajusta el espaciado para botones pequeños */
    font-size: 14px; /* Tamaño de fuente más pequeño */
    /* Otros estilos específicos para botones pequeños si es necesario */
    }

    .btn-medium {
        padding: 10px 15px; /* Ajusta el espaciado para botones pequeños */
        font-size: 18px; /* Tamaño de fuente más pequeño */
        /* Otros estilos específicos para botones pequeños si es necesario */
    }

	

  .custom-select {
  appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #f2f2f2; /* Color de fondo del select */
  border: none;/* Borde del select */

  border-radius: 5px; /* Radio de borde del select */
  width: 100%; /* Ancho del select */
  cursor: pointer; /* Cambia el cursor al pasar sobre el select */
  color:#333;

  }

  /* Estilos para el desplegable del select */
  .custom-select option {
  padding: 10px; /* Espaciado interno de las opciones */
  cursor: pointer; /* Cambia el cursor al pasar sobre las opciones */

  }

  /* Estilos para el contenedor del select */
  .custom-select-container {
  display: inline-block; /* Alinea el contenedor en línea */
  position: relative; /* Establece una posición relativa para el contenedor */
  width: 100%; /* Ancho del contenedor */
  }

  /* Estilos para el triángulo desplegable (flecha) */
  .custom-select::after {
  content: '\25BC'; /* Código Unicode para una flecha hacia abajo */
  position: absolute; /* Posición absoluta en relación con el contenedor */
  top: 50%; /* Alinea la flecha verticalmente en el centro */
  right: 10px; /* Espaciado desde el borde derecho */
  transform: translateY(-50%); /* Alinea la flecha verticalmente en el centro */
  pointer-events: none; /* Evita que la flecha sea clickeable */
  }




        /* Estilos para el select al pasar el cursor sobre él */
        .glass-select:hover {
        background-color: #d1ffff; /* Cambia el color de fondo en hover */

        transition: background-color 0.3s, border 0.3s; /* Agrega una transición suave */
        border-radius: 10px;
        }






        .select-arrow {
            position: absolute;
            top: 50%;
            right: 10px; /* Ajusta el margen derecho según tu preferencia */
            transform: translateY(-50%);
            pointer-events: none; /* Evita que la flecha sea interactiva */
            }

            .glass-container {
            background: rgba(255, 255, 255, 0.2); /* Color de fondo transparente */
            backdrop-filter: blur(10px);
            border-radius: 10px;
           
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .glass-select {
            background: transparent;
            border: none;
            outline: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            color: #333; /* Color del texto */
            appearance: none;
            cursor: pointer;
        }




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





    <script type="text/javascript">
        function mostraInformeMes(any, mes) {
            $('#myModal').modal('show');
            window.location = "AdminInformeMesG3STotal.php?&any=" + any + "&mes=" + mes;
        }

        function mostraInformeMesMT(any, mes) {
            $('#myModal').modal('show');
            window.location = "AdminInformeMesMTotal.php?&any=" + any + "&mes=" + mes;
        }
        function mostraInformeTotal4M(any, mes) {
            $('#myModal').modal('show');
            window.location = "AdminInformeTotal4M.php?&any=" + any + "&mes=" + mes;
        }

    </script>




</head>



<!--body style="position: absolute; top: 0px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden"-->

<body class="well">
    <?php
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

$id = $_GET["id"];
$idempresa = $_SESSION["idempresa"];
$d = strtotime("now");
$undiames = new DateInterval('P1D');
if (!isset($_GET["any"])) {
    $_GET["any"] = date("Y", $d);
}

$any = $_GET["any"];
if (!isset($_GET["setmana"])) {
    $_GET["setmana"] = date("W", $d) + 1;
}

$setmana = $_GET["setmana"];
if (!isset($_GET["mes"])) {
    $_GET["mes"] = abs(date("m", $d));
}

$mes = $_GET["mes"];
$zmes = "";
if ($mes < 10) {
    $zmes = "0" . $mes;
} else {
    $zmes = $mes;
}

if ($setmana != $dto->__($lng, "Totes")) {
    $diapopup = new DateTime();
    $diapopup->setISOdate($any, $setmana - 1);
    $diapopup = $diapopup->format('Y-m-d');
} else if ($mes != $dto->__($lng, "Tots")) {
    $diapopup = $any . "-" . $mes . "-01";
} else if ($any != $dto->__($lng, "Tots")) {
    $diapopup = date('Y-m-d', strtotime('today'));
}
$diateoriques = date('Y-m-d', strtotime($any . "-01-01"));
$horesteoany = 0.0;
?>








    <div id="content" class ="" style="display: table-row; width: 100%; float: right; text-align: center; top: 62px; bottom: 0px; overflow-x: hidden; overflow-y: auto; margin-top: 0px; background-color: #f5f5f5; background-size: cover">
        <?php
$idemp = $_SESSION["idempresa"];
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

$id = $_SESSION["id"];
$master = $dto->esMaster($id);
$idempresa = $idemp;

$idsubempdef = 0;
$rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa=' . $idemp . ' limit 1');
 foreach ($rssbe as $se) {
     $idsubempdef = $se["idsubempresa"];
 }
 if (!isset($_GET["idsubemp"])) {
     if (isset($_SESSION["filtidsubempq"])) {
         $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
     } else if (isset($_SESSION["idsubempresa"])) {
         $_GET["idsubemp"] = $_SESSION["idsubempresa"];
     } else {
         $_GET["idsubemp"] = $idsubempdef;
     }

 }

$idsubemp = $_GET["idsubemp"];


 $_SESSION["filtidsubemp"] = $idsubemp;


		
		
if (!isset($_GET["dpt"])) {
    $_GET["dpt"] = 0;
}

$dpt = $_GET["dpt"];
$nomdpt = $dto->__($lng, "Tots");
if ($dpt != 0) {
    $nomdpt = $dto->__($lng, $dto->getCampPerIdCampTaula("departament", $dpt, "nom"));
}

if (!isset($_GET["rol"])) {
    $_GET["rol"] = 0;
}

$rol = $_GET["rol"];
$nomrol = $dto->__($lng, "Tots");
if ($rol != 0) {
    $nomrol = $dto->__($lng, $dto->getCampPerIdCampTaula("rol", $rol, "nom"));
}

if (!isset($_GET["situacio"])) {
    $_GET["situacio"] = 1;
}

$situacio = $_GET["situacio"];
$nomsituacio = "En Plantilla";
switch ($situacio) {
    case 0:
        $nomsituacio = "Cessat";
        break;
    case 2:
        $nomsituacio = "Totes";
        break;
}

$sqlsubemp = '';
if ($idsubemp != 0) {
    $sqlsubemp = 'and e.idsubempresa=' . $idsubemp;
}

$sqljoindpt = '';
$sqlnomdpt = '';
if ($dpt != 0) {
    $sqljoindpt = 'join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep';
    $sqlnomdpt = 'and d.iddepartament=' . $dpt;
}
$sqljoinrol = '';
$sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
$sqlnomrol = '';
if ($rol != 0) {
    $sqlnomrol = 'and ro.idrol=' . $rol;
    $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
}
$sqlenplant = '';
if ($situacio != 2) {
    $sqlenplant = 'and e.enplantilla=' . $situacio;
}

$result = $dto->getDb()->executarConsulta('select *, e.nom as nomempl '
    . 'from empleat as e ' . $sqljoinrol . ' ' . $sqljoindpt . ' '
    . 'where e.idempresa=' . $idemp . ' and ro.esempleat=1 and a.actiu=1 ' . $sqlsubemp . ' ' . $sqlnomdpt . ' ' . $sqlnomrol . ' ' . $sqlenplant . ' order by e.cognom1, e.cognom2, e.nom');
$tblpers = "";
$i = 0;

foreach ($result as $row) {
    //

    $i++;

    $idempleat = $row["idempleat"];
    $nomcomplet = "";
    $nomcomplet = $row["nomempl"] . " " . $row["cognom1"] . " " . $row["cognom2"];
    $subemp = "";
    $rolpers = $dto->getRolActiuPerId($row["idempleat"]);
    $idsbeemp = $dto->getCampPerIdCampTaula("empleat", $row["idempleat"], "idsubempresa");
    if (!empty($idsbeemp)) {
        $subemp = $dto->getCampPerIdCampTaula("subempresa", $idsbeemp, "nom");
    }
	
	
    // PARAMETRITZAR LA CONSULTA DE PERSONES PER A QUÈ NO APAREGUIN ELS MASTERS ALS USUARIS ADMINISTRADORS!!

    $tblpers .= "<tr>"
    . "<td>" . $row["cognom1"] . " " . $row["cognom2"] . "</td>"
    . "<td>" . $row["nomempl"] . "<input type='hidden' id='nompers" . $i . "' value='" . $nomcomplet . "'></td>"
    . "<td>" . $row["dni"] . "<input type='hidden' id='idempleat" . $i . "' value='" . $idempleat . "'></td>"

    . '<td><form method="get"></form><form name="frmf' . $idempleat . '" method="get" action="AdminFitxaEmpleat.php"><input type="hidden" name="id" value="' . $idempleat . '"><input type="hidden" name="idsubemp" value="' . $idsubemp . '"><button class="btn-neutro btn-small" onclick="this.form.submit();" title="' . $dto->__($lng, "Veure Fitxa") . '"><span class="glyphicon glyphicon-user"></span></button></form></td>'
    . '<td><form name="frmc' . $idempleat . '" method="get" action="AdminHorarisEmpleat.php"><input type="hidden" name="id" value="' . $idempleat . '"><input type="hidden" name="idsubemp" value="' . $idsubemp . '"><button class="btn-blue btn-small" onclick="this.form.submit();" title="' . $dto->__($lng, "Veure Calendari") . '"><span class="glyphicon glyphicon-calendar"></span></button></form></td>'
    . '<td><form name="frmm' . $idempleat . '" method="get" action="AdminMarcatgesEmpleat.php"><input type="hidden" name="id" value="' . $idempleat . '"><input type="hidden" name="idsubemp" value="' . $idsubemp . '"><button class="btn-next btn-small" onclick="this.form.submit();" title="' . $dto->__($lng, "Veure Marcatges") . '"><span class="glyphicon glyphicon-zoom-in"></span></button></form></td>'
    . "<td>" . $rolpers . "</td>"
    . "<td>" . $dto->getNomDptActiuPerId($idempleat) . "</td>"
    . "<td>" . $dto->getAmbitDptActiuPerId($idempleat) . "</td>"
    . '<td>' . $dto->getUbicacionsPerId($idempleat) . '</td>'
        . '<td>' . $subemp . '</td>'
        . '<td><a href="mailto:' . $row["email"] . '"target="_top">' . $row["email"] . '</a>' . "</td>";
    //
    $sit = "";
    $btnx = "";
    if ($row["enplantilla"] == 1) {
        $sit = $dto->__($lng, "En plantilla") . ' (' . date('d/m/Y', strtotime($row["dataultcontrac"])) . ')';
        $btnx = '<button class="btn-red btn-small" title="' . $dto->__($lng, "Cessar") . '" onclick="confCessaPersona(' . $row["idempleat"] . ',' . "'" . $nomcomplet . "'" . ');">'
            . '<span class="glyphicon glyphicon-thumbs-down"></span></button>';} else {
        $sit = $dto->__($lng, "Cessat") . ' (' . date('d/m/Y', strtotime($row["datacessat"])) . ')';
        $btnx = '<button class="btn-red btn-small" title="' . $dto->__($lng, "Reactivar") . '" onclick="confReactivaPersona(' . $row["idempleat"] . ',' . "'" . $nomcomplet . "'" . ');">'
            . '<span class="glyphicon glyphicon-thumbs-up"></span></button>';}
    $tblpers .= '<td>' . $sit . '</td>'
        . '<td style="text-align: center">' . $btnx . "</td>"
        . "<td><input id='pers" . $i . "' type='checkbox' style='height: 20px; width: 20px'></td>";

    $isEncargCol = "<td><input id='isEncarg" . $i . "' type='checkbox' style='height: 20px; width: 20px' onclick='changeEncargVal(this," . $idempleat . ");' ";

    if ($row["isEncargado"]) {
        $isEncargCol = $isEncargCol . " checked ";
    }

    $isEncargCol = $isEncargCol . "></td>";

    $tblpers .= $isEncargCol
        . "</tr>";
}
?>
        <center>
            <br>
            <div class="row" id="FiltresEmpleats" >

                <div class="col-lg-12 ">
                    <div class="col-lg-3" >
                        <h3><?php
echo $dto->__($lng, "Llistat de Persones") . ' <a class="btn-green" style="color: black; margin-left: 20px;" href="" data-toggle="modal" data-target="#modPersonaNova" title="' . $dto->__($lng, "Nova Persona") . '"><span class="glyphicon glyphicon-plus"></span></a>';
?></h3>



                    </div>


                    <div class = "col-lg-2" style="text-align: right;">


                    </div>
                    <div class ="col-lg-4">
                        <p>
<h3>INFORMES: </h3>
<button class="btn-next" onclick="mostraInformeMes('<?php echo $any; ?>','<?php echo $mes; ?>')"><span class="glyphicon glyphicon-list-alt"></span> 2M</button>
<button class="btn-next" onclick="mostraInformeTotal4M('<?php echo $any; ?>','<?php echo $mes; ?>')"><span class="glyphicon glyphicon-list-alt"></span> 4M</button>
<button class="btn-next" onclick="mostraInformeMesMT('<?php echo $any; ?>','<?php echo $mes; ?>')"><span class="glyphicon glyphicon-list-alt"></span> 6M</button>



<?php

echo '<button class="btn-next"; data-toggle="modal"   data-target="#modalInformeAbsentismo    " title="' . $dto->__($lng, "Informe Absentismo") . '"><span class="glyphicon glyphicon-list-alt"></span> Absentismo</button>';


echo '<div class="modal fade" id="modalInformeAbsentismo' . '" tabindex="-1" role="dialog" aria-labelledby="modalInformeAbsentismoLabel' . '" aria-hidden="true">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content glassmorphism">';
echo '<div class="glassmorphism">';
echo '<h5 style="color:white;" class="modal-title" id="modalInformeAbsentismoLabel' . '">Informe de Absentismo</h5>';
echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
echo '<form action="process_informe_absentismo.php" method="POST">';
echo '<input type="hidden" name="id" value="' . '">';

// Campo de fecha inicial
echo '<label for="fecha_inicial">Fecha Inicial:</label>';
echo '<input type="date" name="fecha_inicial"><br>';

// Campo de fecha final
echo '<label for="fecha_final">Fecha Final:</label>';
echo '<input type="date" name="fecha_final"><br>';

echo '<br><br><button class="btn_modal"type="submit">Generar Informe</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
?>
    
    

</p>







                    </div>


                    <br><br><br><br>








<div class="row">
        <div class="col-lg-12 text-right">
            <a href="" class="filtro-text">
                <p class="" data-toggle="collapse" href="#filtroCollapse" aria-expanded="false" aria-controls="filtroCollapse">
                    Filtrar
                    <i class="filtro-icon fas fa-chevron-down"></i>
                </p>
            </a>
            <div class="collapse" id="filtroCollapse">
                <div class="filtro-content" style="background-color: #f5f5f5">



                <div id="filtroCollapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filtroHeading">
                    <div class="panel-body">


<div class="col-lg-1" ></div>


                    <div class="col-lg-1" >
                        <form  method="GET" id="LlistaEmpreses" action="AdminPersones.php">
                        <label><?php echo $dto->__($lng, "Subempresa"); ?>:</label>
                            <div class = "custom-select-container glass-container">

                            <select class = "glass-select" name="idsubemp" onchange="this.form.submit();">
                                <?php
echo '<option hidden selected value="' . $idsubemp . '">';
if ($idsubemp == 0) {
    echo $dto->__($lng, "Totes");
} else {
    echo $dto->mostraNomSubempresa($idsubemp);
}

echo '</option><option value="Totes">' . $dto->__($lng, "Totes") . '</option>';
$resemp = $dto->mostraSubempreses($idemp);
foreach ($resemp as $emp) {
    echo '<option value="' . $emp["idsubempresa"] . '">' . $emp["nom"] . '</option>';
}
echo '</select>';
?>
                                 <input type="hidden" name="rol" value="<?php echo $rol; ?>">
								   <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                  <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                                   <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2">
                        <form method="GET" id="LlistaRols" action="AdminPersones.php">
                        <label><?php echo $dto->__($lng, "Perfil"); ?>:</label>
                        <div class = "custom-select-container glass-container">

                            <select class="glass-select" name="rol" onchange="this.form.submit();">
                                <option hidden selected value="<?php echo $rol; ?>"><?php echo $nomrol; ?></option>
                                <option value="0"><?php echo $dto->__($lng, "Tots"); ?></option>
                                <?php
$resrol = $dto->mostraRols($idempresa, $master);
foreach ($resrol as $rl) {
    echo '<option value="' . $rl["idrol"] . '">' . $rl["nom"] . '</option>';
}
?>
                            </select>
                             <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                               <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                               <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                                <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                                <input type="hidden" name="mes" value="<?php echo $mes ?>">
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                        </form>
                    </div>
                    <div class="col-lg-1">
                        <form method="GET" id="LlistaDpts" action="AdminPersones.php">
                        <label><?php echo $dto->__($lng, "Departament"); ?>:</label>
                        <div class = "custom-select-container glass-container">

                            <select class="glass-select" name="dpt" onchange="this.form.submit();">
                                <option hidden selected value="<?php echo $dpt; ?>"><?php echo $nomdpt; ?></option>
                                <option value="0"><?php echo $dto->__($lng, "Tots"); ?></option>
                                <?php
$resdpt = $dto->mostraNomsDpt($idempresa);
foreach ($resdpt as $dptOption) {
    echo '<option value="' . $dptOption["iddepartament"] . '">' . $dptOption["nom"] . '</option>';
}
?>
                            </select>
                             <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                              <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                                <input type="hidden" name="mes" value="<?php echo $mes ?>">
                                 <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                                 <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                        </form>
                    </div>

                    <div class="col-lg-1">
                        <form method="GET" id="LlistaSituacions" action="AdminPersones.php">
                        <label><?php echo $dto->__($lng, "Situació"); ?>:</label>
                        <div class = "custom-select-container glass-container">

                            <select class="glass-select" name="situacio" onchange="this.form.submit();">
                                <option hidden selected value="<?php echo $situacio; ?>"><?php echo $dto->__($lng, $nomsituacio); ?></option>
                                <option value="2"><?php echo $dto->__($lng, "Totes"); ?></option>
                                <option value="1"><?php echo $dto->__($lng, "En plantilla"); ?></option>
                                <option value="0"><?php echo $dto->__($lng, "Cessat"); ?></option>
                            </select>
                             <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                               <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                               <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
								<input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                                <input type="hidden" name="mes" value="<?php echo $mes ?>">
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                        </form>
                    </div>



               



                    <div class="col-lg-1">
                        <form action="AdminPersones.php" method="GET">

                        <label><?php echo $dto->__($lng, "Any"); ?>:</label>
                        <div class = "custom-select-container glass-container">
                            <select class="glass-select" name="any" id="LlistaAnys" onchange="this.form.submit()">
                                <option hidden selected value><?php echo $any; ?></option>

                                <?php
$anyfi = date('Y', strtotime('today')) + 1;
for ($year = 2017; $year <= $anyfi; $year++) {
    echo '<option value:"' . $year . '">' . $year . '</option>';
}
?>
                            </select>

                             <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                              <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                                <input type="hidden" name="mes" value="<?php echo $mes ?>">
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                        </form>
                    </div>

                    <div class="col-lg-1">
                        <form action="AdminPersones.php" method="GET"><label><?php echo $dto->__($lng, "Mes"); ?>:</label>
                        <div class="custom-select-container glass-container">
                            <select class="glass-select" name="mes" id="LlistaMesos" onchange="this.form.submit()">
                                <option hidden selected value><?php echo $dto->__($lng, $dto->mostraNomMes($mes)); ?></option>

                                <?php
if ($any != $dto->__($lng, "Tots")) {

    for ($month = 1; $month <= 12; $month++) {
        echo '<option value="' . $month . '">' . $dto->__($lng, $dto->mostraNomMes($month)) . '</option>'; //
    }
}
?>
                            </select>
                             <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                              <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                              <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                                <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                                  <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>

                        </form>
                            </div>
                    </div>
                </div>


            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





            <div class="row class="table table-striped table-hover table-condensed" ">

                <div class="col-lg-12" style="margin: auto;">

                    <form id="tblpers" onsubmit="event.preventDefault();">
                        <table class="table table-striped table-hover table-condensed"  >

                            <thead>
                                <th style="background-color: #f5f5f5; color: black; font-size:large;"><?php echo $dto->__($lng, "Cognoms"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Nom"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "DNI"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Fitxa"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:small;"><?php echo $dto->__($lng, "Cal"); ?>. <button class="btn-blue btn-supersmall" onclick="asgMultHorari(<?php echo $i; ?>);" title="<?php echo $dto->__($lng, "Assignar Horari Setmanal a Múltiples Persones"); ?>"><span class="glyphicon glyphicon-plus"></span></button></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:small;"><?php echo $dto->__($lng, "Full"); ?> <button class="btn-next btn-supersmall" onclick="asgMultMarcatData(<?php echo $i; ?>);" title="<?php echo $dto->__($lng, "Reassignar Marcatges a Múltiples Persones en una data concreta"); ?>"><span class="glyphicon glyphicon-plus"></span></button></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Perfil"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Departament"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Àmbit"); ?></th>
                                <th style="background-color: #f5f5f5; color: black;  font-size:medium;"><?php echo $dto->__($lng, "Ubicació"); ?> <button class="btn-blue btn-supersmall" onclick="asgMultUbic(<?php echo $i; ?>);" title="<?php echo $dto->__($lng, "Assignar Ubicació a Múltiples Persones"); ?>"><span class="glyphicon glyphicon-plus"></span></button></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Subempresa"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Email"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Situació"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng, "Opcions"); ?></th>
                                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><input type='checkbox' id="chkallpers" style='height: 20px; width: 20px' onclick="chkAllPers(<?php echo $i; ?>);" title="<?php echo $dto->__($lng, "Marcar/Desmarcar Tots"); ?>"></th>
                                <th style="background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng, "Encargado"); ?></th>
                            </thead>
                            <tbody style="background-color: white; overflow-y: auto">
                                <?php
echo $tblpers;
?>
                            </tbody>
                        </table>
                    </form>
                    <!--END CONTAINER/div-->
                </div>

            </div>
        </center>
    </div>


    
    <div class="modal fade" id="modPersonaNova" role="dialog">
        <center>
            <div class="modal-dialog">
                <div class="modal-content glassmorphism modal-lg">
                    <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 style="color: white;"><?php echo $dto->__($lng, "Alta de Persona Nova"); ?></h3>
                    </div>
                    <div class="modal-body">
                        <form name="personanova">
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-5" style="text-align: left">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "Primer Cognom"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="text" name="cognom1" autofocus></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "Segon Cognom"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="text" name="cognom2"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "Nom"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="text" name="nom"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "DNI"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="text" name="dni"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "Data Naixement"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="date" name="datanaixement"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-5"><label><?php echo $dto->__($lng, "Núm.Afiliació"); ?>: </label></div>
                                        <div class="col-lg-7"><input type="text" name="numafiliacio"></div>
                                    </div><br>
                                </div>
                                <div class="col-lg-5" style="text-align: center">
                                    <image src="<?php echo $_SESSION["logoempresa"]; ?>" alt="Logo" title="Logo" style="width: 200px"><br><br>
                                        <div class="row">
                                            <div class="col-lg-5"><label><?php echo $dto->__($lng, "Subempresa"); ?>:</label></div>
                                            <div class="col-lg-7">
                                                <select name="subemp">
                                                    <?php

$sube = $dto->getDb()->executarConsulta('select idsubempresa, nom from subempresa where idempresa =' . $idempresa);
foreach ($sube as $valor) {
    echo '<option value="' . $valor["idsubempresa"] . '">' . $valor["nom"] . '</option>';
}
?>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-lg-5"><label><?php echo $dto->__($lng, "Departament"); ?>:</label></div>
                                            <div class="col-lg-7">
                                                <select name="depasg">
                                                    <?php
echo '<option hidden selected value="0">(' . $dto->__($lng, "No Especificat") . ')</option>';
$dpts = $dto->mostraNomsDpt($idempresa);
foreach ($dpts as $valor) {
    echo '<option value="' . $valor["iddepartament"] . '">' . $valor["nom"] . '</option>';
}
?>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-lg-5"><label><?php echo $dto->__($lng, "Perfil"); ?>:</label></div>
                                            <div class="col-lg-7">
                                                <select name="rolasg">
                                                    <?php

$rols = $dto->mostraRols($idempresa, $master);
foreach ($rols as $valor) {
    echo '<option value="' . $valor["idrol"] . '">' . $valor["nom"] . '</option>';
}
?>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-lg-5"><label><?php echo $dto->__($lng, "Responsable"); ?>:</label></div>
                                            <div class="col-lg-7">
                                                <select name="respasg">
                                                    <?php
echo '<option hidden selected value="0">(' . $dto->__($lng, "Cap") . ')</option>';
$noms = $dto->mostraRespEmp($idempresa);
foreach ($noms as $valor) {
    echo '<option value="' . $valor["idempleat"] . '">' . $valor["nom"] . '</option>';
}
?>
                                                </select>
                                            </div>
                                        </div><br>
                                </div>
                            </div>
                            <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                        <button type="button" class="btn btn-success" data-toggle="modal" onclick="novaPersona(<?php echo $idempresa; ?>, personanova.cognom1.value, personanova.cognom2.value, personanova.nom.value, personanova.dni.value, personanova.datanaixement.value, personanova.numafiliacio.value, personanova.depasg.value, personanova.rolasg.value, personanova.subemp.value, personanova.respasg.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Crear"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modConfCessaPersona" role="dialog">
        <center>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><?php echo $dto->__($lng, "Cessar Persona en Plantilla"); ?></h3>
                    </div>
                    <div class="modal-body">
                        <form name="cessapersona">
                            <input type="hidden" id="idpersonaacessar" name="idpersonaacessar">
                            <h4><?php echo $dto->__($lng, "Està segur de cessar aquesta persona?"); ?>:</h4>
                            <h3 id="nompersonaacessar"></h3>
                            <br>(<?php echo $dto->__($lng, "Es finalitzaran amb data d´avui els seus horaris actius"); ?>)<br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="cessaPersona(cessapersona.idpersonaacessar.value);"><?php echo $dto->__($lng, "Cessar"); ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </center>
    </div>
    <div class="modal fade" id="modConfReactivaPersona" role="dialog">
        <center>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3><?php echo $dto->__($lng, "Reincorporar Persona en Plantilla"); ?></h3><br>
                        <h4><?php echo $dto->__($lng, "Està segur de reincorporar aquesta persona?"); ?>:</h4>
                        <h3 id="nompersonaareactivar"></h3>
                        <br>(<?php echo $dto->__($lng, "S´actualitzarà la seva data de contractació a data d´avui"); ?>)<br><br>
                        <form name="reactivapersona">
                            <input type="hidden" id="idpersonaareactivar" name="idpersonaareactivar">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                        <button type="button" class="btn btn-success" data-toggle="modal" onclick="reactivaPersona(reactivapersona.idpersonaareactivar.value);"><?php echo $dto->__($lng, "Reincorporar"); ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </center>
    </div>
    <div class="modal fade" id="modAsgMultUbic" role="dialog">
        <center>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><?php echo $dto->__($lng, "Assignar Ubicació a Múltiples Persones"); ?></h3>
                    </div>
                    <div class="modal-body">
                        <form name="ubicapersona" onsubmit="event.preventDefault();">
                            <input type="hidden" id="stridpersona" name="stridpersona">
                            <h4><?php echo $dto->__($lng, "Assigneu Ubicació i Data d'Inici per a aquestes persones"); ?>:</h4><br>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8">
                                    <table id="nomspers" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;"></table>
                                </div>
                                <div class="col-lg-2"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-4"><label><?php echo $dto->__($lng, "Ubicació"); ?>:</label><br><select class="well-sm" name="idubicacio">
                                        <?php
$rsu = $dto->seleccionaUbicacionsPerIdEmpresa($idemp);
foreach ($rsu as $u) {
    echo '<option value="' . $u["idlocalitzacio"] . '">' . $u["nom"] . '</option>';
}

?>
                                    </select></div>
                                <div class="col-lg-4"><label><?php echo $dto->__($lng, "Data Inici"); ?>:</label><br><input type="date" name="dataini" value="<?php echo date('Y-m-d', strtotime('today')); ?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                            </div><br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="try {
                                                                            assignaUbicacioMultipers(ubicapersona.stridpersona.value, ubicapersona.idubicacio.value, ubicapersona.dataini.value);
                                                                        } catch (err) {
                                                                            alert(err);
                                                                        }"><?php echo $dto->__($lng, "Assignar"); ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </center>
    </div>
    <div class="modal fade" id="modAsgMultHorari" role="dialog">
        <center>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><?php echo $dto->__($lng, "Assignar Horari Setmanal a Múltiples Persones"); ?></h3>
                    </div>
                    <div class="modal-body">
                        <form name="horaripersona" onsubmit="event.preventDefault();">
                            <input type="hidden" id="stridpersonah" name="stridpersonah">
                            <h4><?php echo $dto->__($lng, "Assigneu Horari i Data d'Inici i Final, si s'escau, per a aquestes persones"); ?>:</h4><br>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8">
                                    <table id="nomspersh" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;"></table>
                                </div>
                                <div class="col-lg-2"></div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6"><label><?php echo $dto->__($lng, "Horari"); ?>:</label><br><select class="well-sm" name="idhorari">
                                        <?php
$rsh = $dto->seleccionaHorarisActiusEmpresa($idemp);
foreach ($rsh as $h) {
    echo '<option value="' . $h["idhoraris"] . '">' . $h["nom"] . '</option>';
}

?>
                                    </select></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4"><label><?php echo $dto->__($lng, "Data Inici"); ?>:</label><br><input type="date" name="dataini" value="<?php echo date('Y-m-d', strtotime('today')); ?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                                <div class="col-lg-4"><label><?php echo $dto->__($lng, "Data Final"); ?>:</label><br><input type="date" name="datafi" value="<?php echo date('Y-m-d', strtotime('today')); ?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                            </div><br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                        <button type="button" class="btn btn-info" data-toggle="modal" onclick="try {
                                                                            assignaHorariMultipers(horaripersona.stridpersonah.value, horaripersona.idhorari.value, horaripersona.dataini.value, horaripersona.datafi.value);
                                                                        } catch (err) {
                                                                            alert(err);
                                                                        }"><?php echo $dto->__($lng, "Assignar"); ?></button>
                        </form>
                    </div>
                </div>
            </div>

        </center>
    </div>
    <div class="modal fade" id="modErrSelect" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label id="msgConsole" style="font-size: 25px"><?php echo $dto->__($lng, "No hi ha cap Persona seleccionada"); ?></label><br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modContent"></div>
    <div class="modal fade" id="modContentAux"></div>
    <div class="modal fade" id="modFlash"></div>
    <div class="modal fade" id="modLoad"></div>
    <div class="modal fade" id="modMessage" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label id="msgConsole" style="font-size: 28px"></label><br><br>
                        <button type="button" class="btn btn-default" autofocus data-dismiss="modal"><?php echo "Aceptar"; ?></button>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modInfo" role="dialog">
        <center>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style='background-color: lavender'>
                        <div class="row">
                            <div class="col-lg-2"><img src="./img/g3sminilogo.jpg" style="witdh: 100%; max-height: 80px" /></div>
                            <div class="col-lg-8">
                                <h3><span class="glyphicon glyphicon-info-sign"></span> Información</h3>
                            </div>
                            <div class="col-lg-2"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label style="font-size: large" id="msgInfo"></label><br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Cerrar"; ?></button>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modWait" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-body">
                        <h1>Cargando</h1>
                        <img src="./img/Loading_icon.gif" style="height: 200px; width: 280px">

                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modWaitMsg" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-body">
                        <h1 id="waitMsg"></h1>
                        <img src="./img/Loading_icon.gif" style="height: 200px; width: 280px">

                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modExpire" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <div class="modal-body">
                        <h3>La sesión ha expirado!</h3>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Aceptar"; ?></button>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <iframe id="upload_excel" name="upload_excel" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>





    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content glassmorphism">
                <div class="glassmorphism">
                   
                    <h4 style="color: white;" class="modal-title" id="myModalLabel">Generando Informes</h4>

                </div>
                <div style="color: white;" class="modal-body">Se están generando los informes
                    <img src="./Pantalles/img/cargando.gif" style="witdh: 100%; max-height: 80px" />
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modLoad" role="dialog">
        <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <label id="msgLoad" style="font-size: 28px">Subiendo...</label><br>

                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
        <center>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <label id="msgConsole" style="font-size: 28px"></label><br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                    </div>
                </div>
            </div>
        </center>
    </div>



</body>


</html>