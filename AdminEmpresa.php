<!DOCTYPE html>
<html>
    <head>
        <?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();
$dto->navResolver();

?>

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

    </head>

    <body class="well">



        <div id="content">


        <?php
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

$idempresa = $_SESSION["idempresa"];
$id = $_SESSION["id"];
$master = false;
if ($id > 0) {
    $master = $dto->esMaster($id);
}

if (isset($_GET["nomdpt"])) {
    if (!isset($_GET["ambit"])) {
        $_GET["ambit"] = "";
    }

    $dto->crearDepartament($_GET["nomdpt"], $idempresa, $_GET["ambit"]);
    unset($_GET);
    header('Location:' . $_SERVER['PHP_SELF']);
}
if (isset($_GET["nomrol"])) {
    if (!isset($_GET["empleat"])) {
        $_GET["empleat"] = 0;
    } else {
        $_GET["empleat"] = 1;
    }

    if (!isset($_GET["admin"])) {
        $_GET["admin"] = 0;
    } else {
        $_GET["admin"] = 1;
    }

    if (!isset($_GET["master"])) {
        $_GET["master"] = 0;
    } else {
        $_GET["master"] = 1;
    }

    $dto->crearRol($_GET["nomrol"], $idempresa, $_GET["empleat"], $_GET["admin"], $_GET["master"]);
    unset($_GET);
    header('Location:' . $_SERVER['PHP_SELF']);
}
if (isset($_GET["nomhorari"])) {
    $torns = new ArrayObject();
    for ($i = 1; $i <= 7; $i++) {
        if (($_GET[$i . "f1"] == 0) || ($_GET[$i . "f2"] == 0) || ($_GET[$i . "f3"] == 0)) {} else {
            if (!isset($_GET[$i . "f5"])) {
                $_GET[$i . "f5"] = 0;
            } else {
                $_GET[$i . "f5"] = 1;
            }

            if (!isset($_GET[$i . "f6"])) {
                $_GET[$i . "f6"] = 0;
            } else {
                $_GET[$i . "f6"] = 1;
            }

            $torn = new Torn($i, $_GET[$i . "f1"], $_GET[$i . "f2"], $_GET[$i . "f3"], $_GET[$i . "f4"], $_GET[$i . "f5"], $_GET[$i . "f6"]);
            $torns->append($torn);
        }
    }
    $dto->creaNouHorari($idempresa, $_GET["nomhorari"], $torns);
    unset($_GET);
    header('Location:' . $_SERVER['PHP_SELF']);
}
if (isset($_GET["nomubicacio"])) {
    if (!isset($_GET["fushorari"])) {
        $_GET["fushorari"] = "";
    }

    if (!isset($_GET["pais"])) {
        $_GET["pais"] = 0;
    } else {
        $_GET["pais"] = 1;
    }

    if (!isset($_GET["regio"])) {
        $_GET["regio"] = 0;
    } else {
        $_GET["regio"] = 1;
    }

    if (!isset($_GET["ciutat"])) {
        $_GET["ciutat"] = 0;
    } else {
        $_GET["ciutat"] = 1;
    }

    $dto->creaNovaUbicacio($idempresa, $_GET["nomubicacio"], $_GET["fushorari"], $_GET["pais"], $_GET["regio"], $_GET["ciutat"]);
    unset($_GET);
    header('Location:' . $_SERVER['PHP_SELF']);
}
if (isset($_GET["nomfestiu"])) {
    $anual = 1;
    $dia = $_GET["dia"];
    $mes = $_GET["mes"];
    $dataany = $_GET["data"];

    if ((!empty($dataany)) && ($dataany != "0000-00-00")) {
        $anual = 0;
    }

    $dto->afegeixFestiuUbicacio($_GET["idubicacio"], $dia, $mes, $dataany, $anual, $_GET["nomfestiu"]);
    unset($_GET);

}
?>

    <center>
        <br>
        <?php

$rssbe = $dto->mostraSubempreses($idempresa);
$tblsbe = "";
if (!empty($rssbe)) {
    $tblsbe = '<table class="table">'
    . '<thead><th style="text-align: center; background-color: #fff; color: black;">' . $dto->__($lng, "Nom") . '</th><th style="text-align: center; background-color: #fff; color: black;">' . $dto->__($lng, "Opcions") . '</th><thead>'
        . '<tbody style="background-color: white">';
    foreach ($rssbe as $r) {
        $btnxs = '<button class="btn-next btn-small" title="' . $dto->__($lng, "Editar Subempresa") . '" onclick="mostraEditaSubemp(' . $r["idsubempresa"] . ');"><span class="glyphicon glyphicon-pencil"></span></button>';
        $rseas = $dto->getDb()->executarConsulta('select * from empleat where idsubempresa=' . $r["idsubempresa"]);
        if (empty($rseas)) {
            $btnxs .= '<button class="btn-red btn-small" title="' . $dto->__($lng, "Eliminar Subempresa") . '" onclick="confElimSubemp(' . $r["idsubempresa"] . ',' . "'" . $dto->getCampPerIdCampTaula("subempresa", $r["idsubempresa"], "nom") . "'" . ');"><span class="glyphicon glyphicon-remove"></span></button>';
        }

        $tblsbe .= '<tr style="font-weight: bold"><td>' . $r["nom"] . '</td><td>' . $btnxs . '</td></tr>';
    }
    $tblsbe .= '</tbody></table><br><br>';
}
?>
        <div class="row ">


        <div class="col-lg-12" >


<h2 style="display: flex; justify-content: left; margin-left: 10px;">Empresa</h2>

            <ul class="nav " style="display: flex; justify-content: center;">

            <li  style="margin: 0 10px;" class="active" style="margin-right: 10px;"><a data-toggle="tab" href="#empresa"><?php echo $dto->__($lng, "Dades Empresa"); ?></a></li>
        <li  style="margin: 0 10px;"><a data-toggle="tab" href="#horaris"><?php echo $dto->__($lng, "Horaris i Conceptes"); ?></a></li>
        <li  style="margin: 0 10px;"><a data-toggle="tab" href="#sistema"><?php echo $dto->__($lng, "Preferències Sistema"); ?></a></li>

            </ul>

            <hr style="border-top: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px; width: 90%;">


            <div class="tab-content" style="height: 100%; overflow-y: auto; overflow-x: hidden">
                <div id="empresa" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-lg-4">
                            <br><br><h3 class=""><?php echo $dto->__($lng, "Dades"); ?> </h3><br><br><br>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4" style="text-align: right">
                                <label><?php echo $dto->__($lng, "Nom"); ?> </label>
                                </div>

                                <div class="col-lg-6" style="text-align: left">
                                    <input type="text" title="<?php echo $dto->mostraNomEmpresa($idempresa); ?>" value="<?php echo $dto->mostraNomEmpresa($idempresa); ?>" onblur="actualitzaCampTaulaNR('empresa','nom','<?php echo $idempresa; ?>',this.title,this.value);">
                                </div>
                            </div>
                                <br>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4" style="text-align: right">
                                <label><?php echo $dto->__($lng, "C.I.F/N.I.F"); ?> </label>
                                </div>
                                <div class="col-lg-6" style="text-align: left">
                                    <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "cif"); ?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "cif"); ?>" onblur="actualitzaCampTaulaNR('empresa','cif','<?php echo $idempresa; ?>',this.title,this.value);">
                                </div>
                            </div>
                                <br>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4" style="text-align: right">
                                <label><?php echo $dto->__($lng, "Centre de Treball"); ?> </label>
                                </div>
                                <div class="col-lg-6" style="text-align: left">
                                <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "centre_treball"); ?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "centre_treball"); ?>" onblur="actualitzaCampTaulaNR('empresa','centre_treball','<?php echo $idempresa; ?>',this.title,this.value);">
                                </div>
                            </div>
                                <br>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4" style="text-align: right">
                                <label><?php echo $dto->__($lng, "C.C.C."); ?> </label>
                                </div>
                                <div class="col-lg-6" style="text-align: left">
                                <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "ccc"); ?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "ccc"); ?>" onblur="actualitzaCampTaulaNR('empresa','ccc','<?php echo $idempresa; ?>',this.title,this.value);">
                                </div>
                            </div>
                                <br>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-4" style="text-align: right">
                                <label><?php echo $dto->__($lng, "Població"); ?> </label>
                                </div>
                                <div class="col-lg-6" style="text-align: left">
                                <input type="text" title="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "poblacio"); ?>" value="<?php echo $dto->getCampPerIdCampTaula("empresa", $idempresa, "poblacio"); ?>" onblur="actualitzaCampTaulaNR('empresa','poblacio','<?php echo $idempresa; ?>',this.title,this.value);">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <br><br><h3 class=""><?php echo $dto->__($lng, "Subempreses") . ' <button class="btn-green btn-medium" onclick="mostraNovaSubemp(' . $idempresa . ');" title="' . $dto->__($lng, "Nova Subempresa") . '"><span class="glyphicon glyphicon-plus"></span></button>'; ?></h3><br><br>
                            <?php echo $tblsbe; ?>
                            <br><br>
                        </div>
                        <div class="col-lg-4">
                            <br><br><h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Departaments"); ?>"><?php echo $dto->__($lng, "Departaments"); ?> <a class="btn-green btn-medium" data-toggle="modal" data-target="#modCreaNouDpt" title="<?php echo $dto->__($lng, "Crea Nou"); ?>"><span class="glyphicon glyphicon-plus"></span></a></h3><br><br>
                        <table class="">

                        <tbody>
                            <?php
$nomsDpts = $dto->mostraNomsDpt($idempresa);
foreach ($nomsDpts as $dept) {
    echo '<tr style="font-weight: bold"><td><input contenteditable data-old_value="' . $dept["nom"] . '" value="' . $dept["nom"] . '" title="' . $dto->__($lng, "Clica per a editar nom") . '"'
        . 'onblur="actualitzaCampTaula(' . "'departament','nom'," . $dept["iddepartament"] . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"></td><td>'

        . '</tr>';
}

?>
                        </tbody>
                        </table>
                        
                        <div class="modal fade" id="modCreaNouDpt" role="dialog">
                            <center>
                            <div class="modal-dialog">
                              <div class="modal-content glassmorphism">
                                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white"><?php echo $dto->__($lng, "Crear Departament"); ?></h3></div>
                                <div class="modal-body">
                                    <h3><?php echo $dto->mostraNomEmpresa($idempresa); ?></h3><br>
                                    <form method="GET" action="AdminEmpresa.php">
                                        <div class="row"><div class="col-lg-2"></div><div class="col-lg-2"><label><?php echo $dto->__($lng, "Nom"); ?>: </label></div><div class="col-lg-6"><input type="text" name="nomdpt" placeholder="<?php echo $dto->__($lng, "Nom del Departament"); ?>" style="width: 100%"></div></div><br>
                                        <div class="row"><div class="col-lg-2"></div><div class="col-lg-2"><label><?php echo $dto->__($lng, "Àmbit"); ?>: </label></div><div class="col-lg-6"><input type="text" name="ambit" placeholder="<?php echo $dto->__($lng, "Nom de l'àmbit"); ?>" style="width: 100%"></div></div><br>
                                        <br>
                                        </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                                    <button type="button" class="btn btn-success" data-toggle="modal" onclick="this.form.submit()"><span class="glyphicon glyphicon-plus"></span> <?php echo $dto->__($lng, "Crear"); ?></button>
                                    </form>
                                </div>
                              </div>
                            </div>
                            </center>
                        </div>
                        </div>
                    </div>
                </div>


                <div id="horaris" class="tab-pane fade in">
                    <div class="row">



                    <div class="col-lg-4">
<h3 class=""><?php echo $dto->__($lng, "Periodos Especiales"); ?>
    <button class="btn-green btn-medium" data-toggle="modal" data-target="#modalCrearPeriodo" title="<?php echo $dto->__($lng, "Crear Nuevo"); ?>">
        <span class="glyphicon glyphicon-plus"></span>
    </button>
</h3>
<br>

    <table class="table table-striped table-hover table-condensed">
        <thead>
            <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Tipus"); ?></th>
            <th style="text-align: center; background-color: #FAFAFA; color: black;"> <?php echo $dto->__($lng, "Color"); ?></th>
            <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Hora lectiva"); ?></th>
            <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Acciones"); ?></th>
        </thead>
        <tbody style="background-color: white">
                            <?php
$tipusexcep = $dto->seleccionaTotsTipusExcepcions();
foreach ($tipusexcep as $t) {
    $TableRow = '<tr style="font-weight: bold">';
    $TableRow .= '<td style="text-align: center;">' . $dto->__($lng, $t["nom"]) . '</td>';

    $TableRow .= '<td style="background-color: rgb(' . $t["r"] . ',' . $t["g"] . ',' . $t["b"] . ')"></td>';

    $isHorelect = "<td style='text-align: center;'><input id='isHorelect" . $t["idtipusexcep"] . "' type='checkbox' style='height: 20px; width: 20px' onclick='changeHoraElectVal(this," . $t["idtipusexcep"] . ");' ";

    if ($t["HorElectiv"]) {
        $isHorelect = $isHorelect . " checked ";
    }

    $isHorelect = $isHorelect . "></td>";

    $TableRow .= $isHorelect;

    // Agregar enlace de edición con modal
    $TableRow .= '<td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#modalEditar' . $t["idtipusexcep"] . '" class="btn-next btn-small" >   <span class="glyphicon glyphicon-pencil"></span></a>
    <a href="#" data-toggle="modal" data-target="#modalEliminar' . $t["idtipusexcep"] . '"  class="btn-red btn-small" ><span class="glyphicon glyphicon-remove"></span></a></td>';

    $TableRow .= '</tr>';

    echo $TableRow;





    

    // Modal de edición
    echo '<div class="modal fade" id="modalEditar' . $t["idtipusexcep"] . '" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel' . $t["idtipusexcep"] . '" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content glassmorphism">';
    echo '<div class="glassmorphism">';
    echo '<h5 class="modal-title" style="color:white;" id="modalEditarLabel' . $t["idtipusexcep"] . '">Editar Período</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<form action="editar_periodo.php" method="POST">';
    echo '<input type="hidden" name="id" value="' . $t["idtipusexcep"] . '">';
    echo '<label for="nombre">Nombre:</label>';
    echo '<input type="text" name="nombre" value="' . $dto->__($lng, $t["nom"]) . '"><br>';
    echo '<label for="color">Color:</label>';
    echo '<input type="color" name="color" value="rgb(' . $t["r"] . ',' . $t["g"] . ',' . $t["b"] . ')"><br>';
    echo '<label for="hora_electiva">Hora electiva:</label>';
    echo '<input type="checkbox" name="hora_electiva" ' . ($t["HorElectiv"] ? 'checked' : '') . '><br>';
    echo '<button type="submit">Guardar cambios</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

//MODAL ELIMINAR PERIODO
    echo '<div class="modal fade" id="modalEliminar' . $t["idtipusexcep"] . '" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel' . $t["idtipusexcep"] . '" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="modalEliminarLabel' . $t["idtipusexcep"] . '">Eliminar Período</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<form action="eliminar_periodo.php" method="POST">';
    echo '<input type="hidden" name="id" value="' . $t["idtipusexcep"] . '">';

    echo '<button type="submit">Eliminar</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

}
?>


                    <!--MODAL CREAR PERIODO-->

                    <div class="modal fade" id="modalCrearPeriodo" tabindex="-1" role="dialog" aria-labelledby="modalCrearPeriodoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content glassmorphism">
                                <div class="glassmorphism">
                                    <h5 class="modal-title" style="color:white;" id="modalCrearPeriodoLabel">Crear Nuevo Período</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="crear_periodo.php" method="POST">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" name="nombre"><br>
                                        <label for="color">Color:</label>
                                        <input type="color" name="color"><br>
                                        <label for="hora_electiva">Hora electiva:</label>
                                        <input type="checkbox" name="hora_electiva"><br>
                                        <button type="submit">Crear período</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                            </tbody>
                            </table>


                            </div>





                            <div class="col-lg-4">
                            <h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Torns de Rotació"); ?>"><?php echo $dto->__($lng, "Torns Rotacions"); ?> <a class="btn-green btn-medium" onclick="mostraNouTipustorn(<?php echo $idempresa; ?>);" title="<?php echo $dto->__($lng, "Crea Nou"); ?>"><span class="glyphicon glyphicon-plus"></span></a></h3><br><br>
                        <table class="table table-striped table-hover table-condensed">
                            <thead>
                                <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Nom"); ?></th>
                                <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Abrv"); ?></th>
                                <th style="text-align: center; background-color: #FAFAFA; color: black;"><?php echo $dto->__($lng, "Torn"); ?></th>
                                <th style="text-align: center; background-color: #FAFAFA; color: black;">Acciones</th>
                            </thead>
                        <tbody id="tbodytipustorns" style="background-color: white">
                            <?php
                            echo $dto->generaTblTipustorn($idempresa);
                            ?>
                        </tbody>
                        </table>



                        <div class="modal fade" id="modAssignaNouTipustorn" role="dialog">

                        </div>
                        </div>





                            <!--MARCAJES DESPLEGABLE-->

                            <div class="col-lg-2">
                            <h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Tipus de Períodes Especials"); ?>"><?php echo $dto->__($lng, "Marcajes desplegable"); ?>
                            <button class="btn-green btn-medium" data-toggle="modal" data-target="#modalCrearMarcajeEspecial" title="<?php echo $dto->__($lng, "Crear Nuevo"); ?>"><span class="glyphicon glyphicon-plus"></span></button></h3>
                            <br><br>
                            <table class="table-condensed">

                            <tbody >
                                <?php
$conceptes = $dto->mostraTipusActivitats();
foreach ($conceptes as $c) {
    echo '<tr >';
    echo '<td><input data-old_value="' . $c["descripcio"] . '" value="' . $c["descripcio"] . '" title="' . $dto->__($lng, "Clica per a editar nom") . '"'
        . 'onblur="actualitzaCampTaula(' . "'tipusactivitat','descripcio'," . $c["idtipusactivitat"] . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"> <a href="#" data-toggle="modal" data-target="#modalEliminarMarcajeEspecial' . $c["idtipusactivitat"] . '"  class="btn-red btn-small" ><span class="glyphicon glyphicon-remove"></span></a>


                                        </td>'
        . '</tr>';

    //MODAL ELIMINAR MARCAJE ESPECIAL
    echo '<div class="modal fade" id="modalEliminarMarcajeEspecial' . $c["idtipusactivitat"] . '" tabindex="-1" role="dialog" aria-labelledby="modalEliminarMarcajeEspecialLabel' . $c["idtipusactivitat"] . '" aria-hidden="true">';
    echo '<div class="modal-dialog" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="modalEliminarMarcajeEspecialLabel' . $c["idtipusactivitat"] . '">Eliminar Marcaje</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<form action="eliminar_marcaje_especial.php" method="POST">';
    echo '<input type="hidden" name="id" value="' . $c["idtipusactivitat"] . '">';

    echo '<button type="submit">Eliminar</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

}

?>

                                </td>
                            </tbody>
                            </table><br><br>






 <!--MODAL CREAR PERIODO-->

                    <div class="modal fade" id="modalCrearMarcajeEspecial" tabindex="-1" role="dialog" aria-labelledby="modalCrearMarcajeEspecialLabel"             aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content glassmorphism">
                                <div class="glassmorphism">
                                    <h5 class="modal-title" style="color:white;" id="modalCrearMarcajeEspecialLabel">Crear Nuevo Marcaje</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="crear_marcaje_especial.php" method="POST">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" name="nombre"><br>
                                        <button type="submit">Crear período</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                         </div>





                       


                        <div class="col-lg-2">
                            <h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Horaris Setmanals"); ?>"><?php echo $dto->__($lng, "Horaris Setmanals"); ?> <a class="btn-green btn-medium" onclick="mostraNouHorari(<?php echo $idempresa; ?>);" title="<?php echo $dto->__($lng, "Crea Nou"); ?>"><span class="glyphicon glyphicon-plus"></span></a></h3><br><br>
                        <table>

                        <tbody id="tbodyhoraris">
                            <?php
$horaristipus = $dto->seleccionaTipusHoraris($idempresa);
foreach ($horaristipus as $horari) {
    $btnx = "";
    $rsht = $dto->getDb()->executarConsulta('select idhorari from quadrant where idhorari=' . $horari["idhoraris"]);
    if (empty($rsht)) {
        $btnx = '<button type="button" class="btn-red btn-small" title="' . $dto->__($lng, "Eliminar Horari") . '" onclick="confElimHorari(' . $horari["idhoraris"] . ',' . $idempresa . ');">'
            . '<span class="glyphicon glyphicon-remove"></span></button>';
    }

    echo '<tr style="font-weight: bold"><td><input contenteditable data-old_value="' . $horari["nom"] . '" value="' . $horari["nom"] . '" title="' . $dto->__($lng, "Clica per a editar nom") . '"'
    . 'onblur="actualitzaCampTaulaNR(' . "'horaris','nom'," . $horari["idhoraris"] . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"></td><td>'
    . '<button type="button" class="btn-blue btn-small" title="' . $dto->__($lng, "Veure Torns") . '" onclick="mostraTorns(' . $horari["idhoraris"] . ')">'
    . '<span class="glyphicon glyphicon-zoom-in"></span>'
    . '<button type="button" class="btn-next btn-small" title="' . $dto->__($lng, "Editar Horari") . '" onclick="mostraEditaHorari(' . $horari["idhoraris"] . ')">'
        . '<span class="glyphicon glyphicon-pencil"></span>' . $btnx . '</button>'

        . '</tr>';
}
?>
                        </tbody>
                        </table>

 <!-- MODALES DE LOS BOTONES HORARIOS  -->

          <div class="modal fade" id="modAssignaNouHorari" role="dialog">
                                    <div class="modal-body " id="modAssignaNouHorari">
                                    </div>

                                               

                               

                                  

                                </div>
                                <div class="modal fade" id="modTorns" role="dialog">
                                    <div class="modal-body " id="modTorns">
                                    </div>
                               


<!----------------------------------------------PERIODOS ESPECIALES---------------------------------------------------------------------------->






                    </div>
                </div>


                <div id="sistema" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-lg-4">
                            <br><br><h3 class=""><?php echo $dto->__($lng, "Festius"); ?></h3><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class="smtag"><?php echo $dto->__($lng, "Prioritat sobre Horaris"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <select style="width: 100%" onchange='actualitzaCampTaulaNR("empresa","prifestius",<?php echo $idempresa; ?>,this.getAttribute("data-old_value"),this.value);'>
                                        <?php $prifestius = $dto->getCampPerIdCampTaula("empresa", $idempresa, "prifestius");?>
                                        <option hidden selected><?php echo $dto->__($lng, $dto->dirsiono($prifestius)); ?></option>
                                        <option value='0'><?php echo $dto->__($lng, $dto->dirsiono(0)); ?></option>
                                        <option value='1'><?php echo $dto->__($lng, $dto->dirsiono(1)); ?></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class="smtag"><?php echo $dto->__($lng, "Marcar als Quadrants"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <select style="width: 100%" onchange='actualitzaCampTaulaNR("empresa","marcafestius",<?php echo $idempresa; ?>,this.getAttribute("data-old_value"),this.value);'>
                                        <?php $marcafestius = $dto->getCampPerIdCampTaula("empresa", $idempresa, "marcafestius");?>
                                        <option hidden selected><?php echo $dto->__($lng, $dto->dirsiono($marcafestius)); ?></option>
                                        <option value='0'><?php echo $dto->__($lng, $dto->dirsiono(0)); ?></option>
                                        <option value='1'><?php echo $dto->__($lng, $dto->dirsiono(1)); ?></option>
                                    </select>
                                </div>
                            </div>

                            <br><br><h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Ubicacions i Festius per ubicació"); ?>"><?php echo $dto->__($lng, "Ubicacions"); ?> <a class="btn-green btn-medium" data-toggle="modal" data-target="#modCreaNovaUbicacio" title="<?php echo $dto->__($lng, "Crea Nova"); ?>"><span class="glyphicon glyphicon-plus"></span></a></h3><br><br>
                        <table class="table-hover table-condensed">

                        <tbody id="tbodyubicacions">
                            <?php
$ubicacions = $dto->seleccionaUbicacionsPerIdEmpresa($idempresa);
foreach ($ubicacions as $ubicat) {
    $chkact = "";
    if ($ubicat["activa"] == 1) {
        $chkact = "checked";
    }

    echo '<tr style="font-weight: bold"><td title="Activa"><input id="chklocact' . $ubicat["idlocalitzacio"] . '" type="checkbox" ' . $chkact . ' onclick="marcaLocAct(' . $ubicat["idlocalitzacio"] . ');" style="width: 20px; height: 20px"></td><td><input contenteditable data-old_value="' . $ubicat["nom"] . '" value="' . $ubicat["nom"] . '" title="' . $dto->__($lng, "Clica per a editar nom") . '"'
    . 'onblur="actualitzaCampTaula(' . "'localitzacio','nom'," . $ubicat["idlocalitzacio"] . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"></td><td>'
    . '<button type="button" class="btn-blue btn-small" title="' . $dto->__($lng, "Veure Festius") . '" onclick="mostraFestius(' . $ubicat["idlocalitzacio"] . ')">'
    . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
    . '<button class="btn-next btn-small" title="' . $dto->__($lng, "Editar Festius") . '" onclick="mostraEditaFestius(' . $ubicat["idlocalitzacio"] . ')">'
    . '<span class="glyphicon glyphicon-pencil"></span></button>'
    . '<a class="btn-green btn-small" title="' . $dto->__($lng, "Afegeix Festiu") . '" onclick="afegeixFestiu2(' . $ubicat["idlocalitzacio"] . ',' . "'" . $dto->mostraNomUbicacio($ubicat["idlocalitzacio"]) . "'" . ');">'
        . '<span class="glyphicon glyphicon-plus"></span></a>'
        . '<button class="btn-next btn-small" title="' . $dto->__($lng, "Eliminar Festius") . '" onclick="showDeleteHoliday(' . $ubicat["idlocalitzacio"] . ')"><span class="glyphicon glyphicon-remove"></span></button>'
        . '</tr>';
}
?>
                        </tbody>
                        </table>
                        <br><br>
							
						 <div class="modal fade" id="modFestius" role="dialog">
                                    
                                                <div class="modal-body " id="modFestius">
                                                   
                                   			 </div>	
							</div>
							
                        <div class="modal fade" id="modCreaNovaUbicacio" role="dialog">
                            <center>
                            <div class="modal-dialog">
                              <div class="modal-content glassmorphism">
                                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng, "Crear Nova Ubicació"); ?></h3></div>
                                <div class="modal-body">
                                    <h3><?php echo $dto->mostraNomEmpresa($idempresa); ?></h3>
                                    <br>
                                    <form name="novaubic" method="GET" action="AdminEmpresa.php" onsubmit="event.preventDefault();">
                                        <div class="row"><div class="col-lg-2"></div><div class="col-lg-2"><label><?php echo $dto->__($lng, "Nom"); ?>: </label></div><div class="col-lg-6"><input type="text" name="nomubicacio" placeholder="<?php echo $dto->__($lng, "Nom de la ubicació"); ?>" style="width: 100%"></div></div><br><br>

                                        </div>
                                  <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="afegeixUbicacio(novaubic.nomubicacio.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Crear"); ?></button>
                                    </form>
                                </div>
                              </div>
                            </div>
                            </center>
                        </div>
                        <div class="modal fade" id="modAfegeixFestiu" role="dialog">
                            <center>
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content glassmorphism">
                                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng, "Afegir Festiu a"); ?>: </h3><h4 style="color:white;"  id="calendari"></h4></div>
                                <div class="modal-body">
                                    <br>
                                    <form name="noufest" method="GET" action="AdminEmpresa.php">
                                        <input type="hidden" id="idubicacio" name="idubicacio" />
                                        <label><?php echo $dto->__($lng, "Nom"); ?>: </label><input type="text" name="nomfestiu" placeholder="<?php echo $dto->__($lng, "Nom de la Festivitat"); ?>">
                                        <br>
                                        <br>
                                        <label><?php echo $dto->__($lng, "Data"); ?> Puntual: </label> <input type="date" name="dataany">
                                        <br><br>
                                        O
                                        <br><br>
                                        <label><?php echo $dto->__($lng, "Dia"); ?>: </label><input type="number" name="dia" placeholder="<?php echo $dto->__($lng, "Dia"); ?>" min="1" max="31">
                                        <label><?php echo $dto->__($lng, "Mes"); ?>: </label> <input type="number" name="mes" placeholder="<?php echo $dto->__($lng, "Mes"); ?>" min="1" max="12">
                                        <label>(<?php echo $dto->__($lng, "Anual"); ?>) </label>
                                        <br><br>
                                        </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="afegeixFestiuUbicacio(noufest.idubicacio.value,noufest.dia.value,noufest.mes.value,noufest.dataany.value,noufest.nomfestiu.value);"><span class="glyphicon glyphicon-plus"></span><?php echo $dto->__($lng, "Afegir"); ?></button>
                                    </form>
                                </div>
                              </div>
                            </div>
                            </center>
                        </div>
                        </div>
                        <div class="col-lg-4">
                        <br><br>



                            <h3 class="" title="<?php echo $dto->__($lng, "Veure, editar i Crear Perfils / Rols"); ?>"><?php echo $dto->__($lng, "Perfils / Rols"); ?> <a class="btn-green btn-medium" data-toggle="modal" data-target="#modCreaNouRol" title="<?php echo $dto->__($lng, "Crea Nou"); ?>"><span class="glyphicon glyphicon-plus"></span></a></h3><br><br>
                        <table class="table-hover table-condensed">

                        <tbody id="bodyrols">
                            <?php
$rolstipus = $dto->mostraRols($idempresa, $master);
foreach ($rolstipus as $role) {
    echo '<tr style="font-weight: bold"><td><input contenteditable data-old_value="' . $role["nom"] . '" value="' . $role["nom"] . '" title="' . $dto->__($lng, "Clica per a editar nom") . '"'
        . 'onblur="actualitzaCampTaulaNR(' . "'rol','nom'," . $role["idrol"] . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"></td><td>'

        . '<button class="btn-next btn-small" title="Edita Permisos" onclick="mostraEditaRol(' . $role["idrol"] . ');">'
        . '<span class="glyphicon glyphicon-pencil"></span></button>'
        . '</tr>';
}

?>
                        </tbody>
                        </table>
                        <br><br>
                        <div class="modal fade" id="modCreaNouRol" role="dialog">
                            <center>
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content glassmorphism">
                                  <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 style="color:white;"><?php echo $dto->__($lng, "Crear Rol"); ?></h3></div>
                                <div class="modal-body">
                                    <h3><?php echo $dto->mostraNomEmpresa($idempresa); ?></h3>
                                    <br>
                                    <form name="nourol" onsubmit="event.preventDefault();">
                                        <label><?php echo $dto->__($lng, "Nom"); ?>: </label><input type="text" name="nomrol" placeholder="<?php echo $dto->__($lng, "Nom del Rol"); ?>"><br><br>
                                        <label><?php echo $dto->__($lng, "Perfil a l'Aplicació"); ?>: </label><br><br>
                                        <table class="table"><tbody>
                                                <tr><td><label><?php echo $dto->__($lng, "Empleat"); ?>: </label></td><td><input id="chkesemp" name="empleat" type="checkbox" style="height: 25px; width: 25px"/></td></tr>
                                                <tr><td><label><?php echo $dto->__($lng, "Administrador"); ?>: </label></td><td><input id="chkesadm" name="admin" type="checkbox" style="height: 25px; width: 25px"/></td></tr>
                                        <?php if ($master) {
    echo '<tr><td><label>' . $dto->__($lng, "Master") . ': </label></td><td><input id="chkesmst" name="master" type="checkbox" style="height: 25px; width: 25px"/></td></tr>';
}
?>
                                            </tbody></table>
                                            <br><br>
                                        </div>
                                  <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="try{creaRol(nourol.nomrol.value);}catch(err){alert(err);}"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Crear"); ?></button>
                                    </form>
                                </div>
                              </div>
                            </div>
                            </center>
                        </div>
                        </div>
                        <div class="col-lg-4">
                            <br><br><h3 class=""><?php echo $dto->__($lng, "Opcions") . " " . $dto->__($lng, "Empresa"); ?></h3><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class=""><?php echo $dto->__($lng, "No Registrar Marcatges Sense Horari Assignat"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <select style="width: 100%" onchange='actualitzaCampTaulaNR("empresa","noregmarcsensehorari",<?php echo $idempresa; ?>,this.getAttribute("data-old_value"),this.value);'>
                                        <?php $noregmarcsensehorari = $dto->getCampPerIdCampTaula("empresa", $idempresa, "noregmarcsensehorari");?>
                                        <option hidden selected><?php echo $dto->__($lng, $dto->dirsiono($noregmarcsensehorari)); ?></option>
                                        <option value='0'><?php echo $dto->__($lng, $dto->dirsiono(0)); ?></option>
                                        <option value='1'><?php echo $dto->__($lng, $dto->dirsiono(1)); ?></option>
                                    </select>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class=""><?php echo $dto->__($lng, "Arrodonir Mitja Hora Extra si es Passa 10 Minuts"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <select style="width: 100%" onchange='actualitzaCampTaulaNR("empresa","arrodmitjahoraextra",<?php echo $idempresa; ?>,this.getAttribute("data-old_value"),this.value);'>
                                        <?php $arrodmitjahoraextra = $dto->getCampPerIdCampTaula("empresa", $idempresa, "arrodmitjahoraextra");?>
                                        <option hidden selected><?php echo $dto->__($lng, $dto->dirsiono($arrodmitjahoraextra)); ?></option>
                                        <option value='0'><?php echo $dto->__($lng, $dto->dirsiono(0)); ?></option>
                                        <option value='1'><?php echo $dto->__($lng, $dto->dirsiono(1)); ?></option>
                                    </select>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class=""><?php echo $dto->__($lng, "Comptar Dies Naturals de Vacances (Laborables i Festius)"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <select style="width: 100%" onchange='actualitzaCampTaulaNR("empresa","comptadiesnatvac",<?php echo $idempresa; ?>,this.getAttribute("data-old_value"),this.value);'>
                                        <?php $comptadiesnatvac = $dto->getCampPerIdCampTaula("empresa", $idempresa, "comptadiesnatvac");?>
                                        <option hidden selected><?php echo $dto->__($lng, $dto->dirsiono($comptadiesnatvac)); ?></option>
                                        <option value='0'><?php echo $dto->__($lng, $dto->dirsiono(0)); ?></option>
                                        <option value='1'><?php echo $dto->__($lng, $dto->dirsiono(1)); ?></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                          <div class="row">
                                        <div class="col-lg-7">
                                            <label class="smtag">Primer Marcaje del día siempre entrada</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <?php
                                            $chk1marcatge = null;
                                            $rsinfemp = $dto->getDb()->executarConsulta('select primermarcatge from empresa where idempresa=' . $idempresa);
                                           // print_r($rsinfemp[0]["primermarcatge"]);
                                            if ($rsinfemp[0]["primermarcatge"] == 1)
                                            {
                                                $chk1marcatge = "checked";
                                            }
                                            ?>
                                            <input type='checkbox' id="chk1marcatge" <?php echo $chk1marcatge; ?> style="width: 25px; height: 25px;" onchange='updatePrimermarcaje(this);'>
                                        </div>
                                    </div>
							




                            <br>
                            <!--CHECK DE AUTOMARCAJE-->


                            <div class="row">
                            <div class="col-lg-7">
                                            <label class="">Automarcaje</label>
                                        </div>
                            <div class="col-lg-3">
                            <?php
$chk1marcatge = null;
$rsinfemp = $dto->getDb()->executarConsulta('select automarcaje from empresa where idempresa=' . $idempresa);

if ($rsinfemp[0]["automarcaje"] == 1) {
    $chk1marcatge = "checked";
}
?>
                            <input type="checkbox" id="chk1marcatge" <?php echo $chk1marcatge; ?> style="width: 25px; height: 25px;" onchange="updateAutomarcaje(this);">
                            </div>
                            </div>

                            <!--CHECK DE AUTOMARCAJE-->





							              <div class="row">               
                                <div class="col-lg-7">
                                    <label class="">Excepciones del index</label>
                                </div>
                                <div class="col-lg-3">
                                    <?php
                                    $responseCheckIndex = $dto->getDb()->executarConsulta('select checkExceptionIndex from empresa where idempresa=' . $idempresa);
                                    $chk1ExceptionIndex = null;
                                    if ($responseCheckIndex[0]["checkExceptionIndex"] == 1) {
                                        $chk1ExceptionIndex = "checked";
                                    }
                                    ?>
                              <input type="checkbox" id="chk1ExceptionIndex" <?php echo $chk1ExceptionIndex; ?> style="width: 25px; height: 25px;" onchange="updateExceptionIndex(this);">

                                    <br><br>

                                </div>
                            </div>
















                            <!-- Informes Disponibles -->
                            <?php
$chkdinf1 = "";
$chkdinf2 = "";
$rsinfemp = $dto->getDb()->executarConsulta('select * from informeempresa where idempresa=' . $idempresa);
foreach ($rsinfemp as $ie) {
    if ($ie["idtipusinforme"] == 1) {if ($ie["checked"] == 1) {$chkdinf1 = "checked";}}
    if ($ie["idtipusinforme"] == 2) {if ($ie["checked"] == 1) {$chkdinf2 = "checked";}}
}
?>
                            <br><br><h3 class=""><?php echo $dto->__($lng, "Informes") . " " . $dto->__($lng, "Disponibles"); ?></h3><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class=""><?php echo $dto->__($lng, "Informe amb Hores Complementàries"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <input type='checkbox' id="chkinf1" <?php echo $chkdinf1; ?> style="width: 25px; height: 25px;" onchange='marcaInformeDisp(<?php echo $idempresa; ?>,1);'>
                                </div>
                            </div><br><br>
                            <div class="row">
                                <div class="col-lg-7">
                                    <label class=""><?php echo $dto->__($lng, "Informe Comparatiu amb Hores Teòriques"); ?></label>
                                </div>
                                <div class="col-lg-3">
                                    <input type='checkbox' id="chkinf2" <?php echo $chkdinf2; ?> style="width: 25px; height: 25px;" onchange='marcaInformeDisp(<?php echo $idempresa; ?>,2);'>
                                </div>
                            </div><br><br>
                        </div>

                            </tbody>
                        </table>
                        <br><br>
                        </div-->
                    </div>
                </div>
            </div>
        </div>


        </div>
        </div>
    </center>
            <div class="modal fade" id="modLogo"></div>
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
    <div class="modal fade" id="modTorns" role="dialog">

    </div>
    <div class="modal fade" id="modFestius" role="dialog">
    </div>


    <div class="modal fade" id="modNovaSubempresa">
            <center>
            <div class="modal-dialog">
              <div class="modal-content ">
              <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng, "Alta de Subempresa Nova"); ?></h3></div>
            <div class="modal-body">
                <h3 id="nomempacrearsub"></h3><br>
                <form name="subempresanova" onsubmit="event.preventDefault();">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng, "Nom"); ?> </label>
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="nomsubemp">
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng, "C.I.F/N.I.F"); ?> </label>
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="cifnif">
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng, "Centre de Treball"); ?> </label>
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ctreb">
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng, "C.C.C."); ?> </label>
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ccc">
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng, "Població"); ?> </label>
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="poblacio">
                    </div>
                </div>
                    <input type="hidden" name="idempacrearsub" id="idempacrearsub">
                    <br>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                <button type="button" class="btn btn-success" onclick="novaSubempresa(subempresanova.idempacrearsub.value,subempresanova.nomsubemp.value,subempresanova.cifnif.value,subempresanova.ctreb.value,subempresanova.ccc.value,subempresanova.poblacio.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Crear"); ?></button>
                </div>
          </div>
            </div>
    </div>
    <div class="modal fade" id="modAdminConfElimSubEmp">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3><?php echo $dto->__($lng, "Eliminar Subempresa"); ?></h3>
                  </div>
                <div class="modal-body">
                    <form name="cessasubemp">
                    <input type="hidden" id="idsubempacessar" name="idsubempacessar">
                    <h4><?php echo $dto->__($lng, "Està segur d'eliminar aquesta subempresa?"); ?>:</h4>
                    <h3 id="nomsubempacessar"></h3><br><br>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaSubempresa(cessasubemp.idsubempacessar.value);"><?php echo $dto->__($lng, "Eliminar"); ?></button>
                    </form>
                </div>
              </div>
            </div>

            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 25px"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
    </div>
        <div class="modal fade" id="modMessage">
            <center>
            <div class="modal-dialog">
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
                            <div class="col-lg-2"><img src="./img/g3sminilogo.jpg" style="witdh: 100%; max-height: 80px"/></div>
                            <div class="col-lg-8"><h3><span class="glyphicon glyphicon-info-sign"></span> Información</h3></div>
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
        <div class="modal fade" id="modLoad" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-body"><h1><?php echo $dto->__($lng, "Carregant"); ?>...<img src="./Pantalles/img/Loading_icon.gif" style="height: 200px; width: 280px"></h1>
                </div>
              </div>
            </div>
            </center>
        </div>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

        <div class="modal fade" id="modAssignaNouHorari" role="dialog">

                            </div>

<script>
	
	function updatePrimermarcaje(checkbox) {
        var valor = checkbox.checked ? 1 : 0; // Obtener el valor 1 si está marcado, de lo contrario, obtener 0
  var idempresa = 7; // Reemplaza con el valor correcto de idempresa
            console.log(valor);
          //  Realizar la solicitud AJAX utilizando jQuery
            $.ajax({
                url: "primermarcaje.php",
                type: "POST",
                data: {
                    idempresa: idempresa,
                    valor: valor
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
	
	
        function updateAutomarcaje(checkbox) {
  var valor = checkbox.checked ? 1 : 0; // Obtener el valor 1 si está marcado, de lo contrario, obtener 0
  var idempresa = 7; // Reemplaza con el valor correcto de idempresa

  // Realizar la solicitud AJAX utilizando jQuery
  $.ajax({
    url: "automarcaje.php",
    type: "POST",
    data: {
      idempresa: idempresa,
      valor: valor
    },
    success: function(response) {
      console.log(response);
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });
}
	
	
	function updateExceptionIndex (checkbox) {
            var valor = checkbox.checked ? 1 : 0; // Obtener el valor 1 si está marcado, de lo contrario, obtener 0
            var idempresa = 7; // Reemplaza con el valor correcto de idempresa

            // Realizar la solicitud AJAX utilizando jQuery
            $.ajax({
                url: "updateExceptionIndex.php",
                type: "POST",
                data: {
                    idempresa: idempresa,
                    valor: valor
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
	

</script>


    </body>
</html>

