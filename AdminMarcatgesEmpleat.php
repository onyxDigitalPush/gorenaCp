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
    <script type="text/javascript">
        /*function actualitzaHoraMarcatge(editableObj,idmarcatge)//Ajax intent
        {   jQuery.ajax({type: "GET",url: 'Serveis.php',
            data: {action: 'actualitzaMarcatge', argument: [idmarcatge,novahora]}});}*/

        function actualitzaHoraMarcatge(idmarcatge,horavella,horanova)
        {
            if(horavella === horanova) return false;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
                //popuphtml(horanova);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=actualitzaHoraMarc&idmarcatge=" + idmarcatge + "&novahora=" + horanova, true);
            xmlhttp.send();
        }

        function actualitzaObservacions(editableObj,idmarcatge)
        {
            if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
            return false;
            observ = editableObj.innerHTML;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //No és necessari recarregar pàgina...
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=actualitzaObsMarc&idmarcatge=" + idmarcatge + "&observ=" + observ, true);
            xmlhttp.send();
        }

        function ValidaMarcatges(stridsmarc)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=validaMarc&idsmarcatges=" + stridsmarc, true);
            xmlhttp.send();
        }

        function desvalidaMarcatgesDia(stridsmarc,weekday)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=desvalidaMarc&idsmarcatges=" + stridsmarc + "&weekday=" + weekday, true);
            xmlhttp.send();
        }

        function validaMarcatgesDia(stridsmarc,weekday)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=validaMarcDia&idsmarcatges=" + stridsmarc + "&weekday=" + weekday, true);
            xmlhttp.send();
        }

        function mostraInformeMes(id,any,mes,setmana)
        {
            window.location = "AdminInformeMesG3S.php?id=" +id+ "&any=" +any+ "&mes=" +mes+ "&setmana=" +setmana;
        }

        function mostraInformeMesMT(id,any,mes,setmana)
        {
            window.location = "AdminInformeMesMT.php?id=" +id+ "&any=" +any+ "&mes=" +mes+ "&setmana=" +setmana;
        }

		
		   function mostraInformeMes6M(id,any,mes,setmana)
        {
            window.location = "AdminInformeMes6M.php?id=" +id+ "&any=" +any+ "&mes=" +mes+ "&setmana=" +setmana;
        }
		
        function mostraFitxaEmpleat(id)
        {
            window.location = "AdminFitxaEmpleat.php?id=" +id;
        }

        function mostraPopupInformeMes(id,any,mes)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("modInforme").innerHTML = this.responseText;
                $modal = $('#modInforme');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalInformeMes.php?id=" + id + "&any=" + any + "&mes=" + mes, true);
            xmlhttp.send();
        }
        function GeneraPDF()
        {
            var doc = new jsPDF('p', 'pt', 'letter');
            doc.fromHTML($('#contingut').html());//, 150, 150, {'width': 900});
            $modal = $('#modInformeMes');
            $modal.modal('hide');
            doc.save('Informe.pdf');
        }

        /*function popuphtml(innerhtml)
        {
            document.getElementById("msgConsole").innerHTML = innerhtml;
            $modal = $('#modConsole');
            $modal.modal('show');
        }*/
    </script>

<style>
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
      background-color: #f12911; /* Cambia el color de fondo durante el hover */
      color: #fff; /* Cambia el color del texto durante el hover */
      transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
  }





  .custom-select {
  appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #f2f2f2; /* Color de fondo del select */
  border: none;/* Borde del select */
  padding: 5px; /* Espaciado interno del select */
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


  .select-arrow {
    position: absolute;
    top: 50%;
    right: 10px; /* Ajusta el margen derecho según tu preferencia */
    transform: translateY(-50%);
    pointer-events: none; /* Evita que la flecha sea interactiva */
    }

    /* Estilo general de la tabla */
    #tblmarcatges {
                border-collapse: separate;
                border-spacing: 0;
                width: 100%;
                max-width: 800px; /* Ajusta el ancho máximo según tus necesidades */
                margin: 0 auto;
                background: rgba(255, 255, 255, 0.3); /* Fondo translúcido con mayor opacidad */
                backdrop-filter: blur(10px); /* Efecto de desenfoque */
                border-radius: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Sombra suave */
                padding: 20px;
            }

            /* Estilo para el encabezado de la tabla */
            #tblmarcatges th {
                background-color: rgba(255, 255, 255, 0.5); /* Fondo del encabezado con mayor opacidad */
                padding: 10px;
                text-align: center;
                color: #333; /* Cambiado a un color de texto más oscuro */
                white-space: nowrap;
                border-radius: 20px;
            }

            /* Estilo para las celdas de la tabla */
            #tblmarcatges td {
                background-color: rgba(255, 255, 255, 0.4); /* Fondo de las celdas con mayor opacidad */
                padding: 10px;
                text-align: center;
                color: #333; /* Cambiado a un color de texto más oscuro */
                border: 1px solid rgba(0, 0, 0, 0.1); /* Borde translúcido */
                white-space: nowrap;
                border-radius: 10px;

            }

            /* Estilo para las filas impares (opcional) */
            #tblmarcatges tr:nth-child(odd) td {
                background-color: rgba(255, 255, 255, 0.3);
            }

            /* Estilo para el botón (ajusta según tu botón real) */
            .btn_modal {
                background-color: rgba(255, 255, 255, 0.7); /* Fondo del botón con mayor opacidad */
                color: #333; /* Cambiado a un color de texto más oscuro */
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
            }



            .glass-container {
    background: rgba(255, 255, 255, 0.2); /* Color de fondo transparente */
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 10px;
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


    .card-container {
        background-color: #f0f0f0; /* Cambia esto al color de fondo que desees */
        padding: 20px; /* Espacio de relleno opcional */
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



</style>

    </head>


    <body class ="well">
        <div class="modal fade" id="modLogo"></div>
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
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

//if($_GET["setmana"]!="Totes")$_GET["setmana"]++;
$setmana = $_GET["setmana"];
if (!isset($_GET["mes"])) {
    $_GET["mes"] = abs(date("m", $d));
}

$mes = $_GET["mes"];
$zmes = "";
if ($mes < 10) {$zmes = "0" . $mes;} else { $zmes = $mes;}
/* Generació de resultats de la consulta en funció dels filtres seleccionats -> OBSOLET
if($any==$dto->__($lng,"Tots")) $result = $dto->seleccionaMarcatgesPerId($id);
else if(($mes==$dto->__($lng,"Tots"))&&($setmana==$dto->__($lng,"Totes"))) $result = $dto->seleccionaMarcatgesPerIdAny($id, $any);
else if(($mes==$dto->__($lng,"Tots"))&&($setmana!=$dto->__($lng,"Totes"))) $result = $dto->seleccionaMarcatgesPerIdAnySetmana($id, $any, $setmana-1);
else if($setmana==$dto->__($lng,"Totes")) $result = $dto->seleccionaMarcatgesPerIdAnyMes($id, $any, $mes);
else $result = $dto->seleccionaMarcatgesPerIdAnyMesSetmana($id, $any, $mes, $setmana-1);*/
if ($setmana != $dto->__($lng, "Totes")) {
    $diapopup = new DateTime();
    $diapopup->setISOdate($any, $setmana - 1);
    $diapopup = $diapopup->format('Y-m-d');
} else if ($mes != $dto->__($lng, "Tots")) {$diapopup = $any . "-" . $mes . "-01";} else if ($any != $dto->__($lng, "Tots")) {$diapopup = date('Y-m-d', strtotime('today'));}
		
$horesteoany = $dto->seleccionaHoresTeoriques($id,$any);
$horesteomes = $dto->seleccionaHoresTeoriquesMonth($id, $mes,$any);	
	
		
$horeslabany = 0.0;
$rsha = $dto->getDb()->executarConsulta('select hores from horesany where idempleat=' . $id . ' and anylab=' . $any);
foreach ($rsha as $ha) {$horeslabany = $ha["hores"];}
$horeslabmes = $horeslabany / 12;
?>
                    <?php
$persopt = "";
$persant = "";
$persseg = "";
		
if(empty($idsubemp)) $idsubemp =  $dto->getCampPerIdCampTaula("empleat", $id, "idsubempresa");	
$rspers = $dto->seleccionaEmpPerEmpresaActius($idsubemp);
$i = 0;
$idpersant = 0;
$chkpers = 0;
foreach ($rspers as $rp) {
    if (($i == 0) && ($id != $rp["idempleat"])) {$idpersant = $rp["idempleat"];}
    if (($i > 0) && ($id == $rp["idempleat"])) {$persant = '<button class="btn-neutro" name="id" value="' . $idpersant . '" formaction="AdminMarcatgesEmpleat.php" title="' . $dto->__($lng, "Anterior") . '"><span class="glyphicon glyphicon-arrow-left"></span></button>';} else { $idpersant = $rp["idempleat"];}
    $persopt .= '<option value="' . $rp["idempleat"] . '">' . $rp["cognom1"] . ' ' . $rp["cognom2"] . ' ' . $rp["nom"] . '</option>';
    if ($chkpers == 1) {$persseg = '<button class="btn-neutro" name="id" value="' . $rp["idempleat"] . '" formaction="AdminMarcatgesEmpleat.php" title="' . $dto->__($lng, "Següent") . '"><span class="glyphicon glyphicon-arrow-right"></span></button>';
        $chkpers = 0;}
    if (($id == $rp["idempleat"])) {$chkpers = 1;}
    $i++;
}
?>
    <center>

<div class = "">
<div class = "">
<div class="">
<div class="">
            <div class="row">
<div class ="col-lg-12" style = "margin-top: 20px">
        <div class="col-lg-2" style="text-align: center;">
    <form method="get" action="AdminMarcatgesEmpleat.php">
        <h3 style="text-align: center; margin-top: 0px">
            <div class="custom-select-container glass-container">
                <select id="sizesel" class="custom-select glass-select " name="id" onchange="this.form.submit();" title="<?php echo $dto->__($lng, "Seleccionar Empleat"); ?>">
                    <option id="optself" hidden selected><?php echo $dto->__($lng, "Seleccionar Persona"); ?></option>




                    <?php echo $persopt ?>
                </select>
                <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                            <input type="hidden" name="mes" value="<?php echo $dto->__($lng, $mes); ?>">
                            <input type="hidden" name="setmana" value="<?php echo $dto->__($lng, $setmana); ?>">
                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
            </div>
        </h3>
    </form>
</div>


<div class="col-lg-2" style = "margin-top: 15px; text-align:center;">
                <form method="get">

                <?php echo $persant; ?> <?php echo $persseg; ?>

                </form>
            </div>






<div class="col-lg-1">
<label><?php echo $dto->__($lng, "Mes"); ?>:</label>
                        <form action="AdminMarcatgesEmpleat.php" method="GET">
                        <div class="custom-select-container glass-container">
                    <select class = "custom-select" name="mes" id="LlistaMesos" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $dto->__($lng, $dto->mostraNomMes($mes)); ?></option>
                    <!--option value="<?php //echo $dto->__($lng,"Tots");?>"><?php //echo $dto->__($lng,"Tots"); ?></option-->
                    <?php
if ($any != $dto->__($lng, "Tots")) {
    /*$mesos = $dto->mostraMesosMarcatgesPerIdAny($id, $any);
    foreach($mesos as $month)
    {
    echo '<option value="'.$month["mesos"].'">'.$dto->__($lng,$dto->mostraNomMes($month["mesos"])).'</option>';//
    }*/
    for ($month = 1; $month <= 12; $month++) {
        echo '<option value="' . $month . '">' . $dto->__($lng, $dto->mostraNomMes($month)) . '</option>'; //
    }
}
?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                    <input type="hidden" name="setmana" value="<?php echo $dto->__($lng, "Totes"); ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                    
                    </form>
                    </div>
                <div class = "col-lg-1"></div>



                    <div class="col-lg-2">
                    <label><?php echo $dto->__($lng, "Setmana"); ?>:</label>
                        <form action="AdminMarcatgesEmpleat.php" method="GET">
                        <div class="custom-select-container glass-container">
                    <select class= " custom-select"  name="setmana" id="LlistaSetmanes" onchange="this.form.submit()">
                    <option hidden selected value>
                        <?php
if ($setmana != $dto->__($lng, "Totes")) {
    $dia = new DateTime();
    $dia->setISODate($any, $setmana - 1);
    echo ($setmana) . ' (' . $dia->format('d-M-Y') . ')';
} else {
    echo $setmana;
}

?>
                    </option>';
                    <option value=<?php echo $dto->__($lng, "Totes") . '>' . $dto->__($lng, "Totes"); ?></option>
                    <?php
if ($any != $dto->__($lng, "Tots") && $mes != $dto->__($lng, "Tots")) {
    $setmanes = $dto->mostraSetmanesMarcatgesPerIdAnyMes($id, $any, $mes);
} else if ($any != $dto->__($lng, "Tots")) {
    $setmanes = $dto->mostraSetmanesMarcatgesPerIdAny($id, $any);
}
foreach ($setmanes as $week) {
    $dia = new DateTime();
    $dia->setISODate($any, $week["setmanes"] + 1);
    echo '<option value="' . ($week["setmanes"] + 2) . '">' . ($week["setmanes"] + 2) . ' (' . $dia->format('d-M-Y') . ')</option>';
}
?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                    <input type="hidden" name="mes" value="<?php echo $dto->__($lng, $mes); ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                    </form>

                    </div>

<div class = "col-lg-1"></div>


                    <div class="col-lg-1">
                    <label><?php echo $dto->__($lng, "Any"); ?>:</label>
                        <form action="AdminMarcatgesEmpleat.php" method="GET">
                        <div class="custom-select-container glass-container">
                    <select class = "custom-select" name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                    <!--option value="<?php //echo $dto->__($lng,"Tots");?>"><?php //echo $dto->__($lng,"Tots");?></option-->
                    <?php
//$anys = $dto->mostraAnysContractePerId($id);;//$dto->mostraAnysMarcatgesPerId($id);
/*foreach($anys as $year)
{
echo '<option value:"'.$year["anys"].'">'.$year["anys"].'</option>';
}*/
$anyfi = date('Y', strtotime('today')) + 1;
for ($year = 2017; $year <= $anyfi; $year++) {
    echo '<option value:"' . $year . '">' . $year . '</option>';
}
?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="mes" value="<?php echo $dto->__($lng, $mes); ?>">
                    <input type="hidden" name="setmana" value="<?php echo $dto->__($lng, "Totes"); ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
</div>
                    </form>
                    </div>






        
    </center>

        
</div>
</div>
  
</div>



         <div class="row" style="margin-top: 40px">
<div class = "col-lg-3"  style ="text-align: left; margin-left: 50px;">





<h3><?php echo $dto->mostraNomEmpPerId($id); ?></h3>

 <?php $month_calendar = $dto->monthlyEmployeeCalendarMonth($id, $any, $mes, $lng); ?>


<h4><?php $dto->paintCalendarMonth($mes, $month_calendar, $lng); ?></h4>
<div class="row"></div>

<p> <strong>Horas asignadas Mes: <?php echo number_format($horesteomes, 2, ",", "."); ?> h</strong></p>
<p><strong>Año:<?php echo $dto->__($lng, "Any") . ": " . number_format($horesteoany, 2, ",", "."); ?> h </strong></p>




<br>


<h3 class="">MARCAJES</h3>
                    <span class="smbox">
                    <button class="btn-red" onclick="mostraNouMarcatgeObs(<?php echo $id; ?>,'<?php echo $diapopup; ?>');" title="<?php echo $dto->__($lng, "Nou"); ?>"><span class="glyphicon glyphicon-plus"></span> Nuevos</button>
                    <button class="btn-next" onclick="mostraMultiMarcatges(<?php echo $id; ?>,'<?php echo $diapopup; ?>');" title="<?php echo $dto->__($lng, "Múltiples"); ?>"><span class="glyphicon glyphicon-plus"></span> Múltiples</button>
                    <button class="btn-green" data-toggle="modal" data-target="#modValidar" title="<?php echo $dto->__($lng, "Validar Tot"); ?>"><span class="glyphicon glyphicon-ok-sign"></span> Validar</button>
                    </span>

                    
                  
<h3>INFORMES</h3>

                   <span class="smbox">
                <?php
$nom2t = "AdminInformeMesG3S.php";
$nom4t = "AdminInformeMesMT.php";
$rsinf = $dto->getDb()->executarConsulta('select * from informeempresa where idempresa=' . $idempresa . ' and checked=1');
//if (empty($rsinf)) {
    echo '
    <button class="btn-next btn-sm" onclick="mostraInformeMes(' . $id . ',' . $any . ',' . $mes . ",'" . $setmana . "'" . ');" title="' . $dto->__($lng, "Informe") . " 2 " . $dto->__($lng, "Marcatges") . '"><span class="glyphicon glyphicon-list-alt"></span> 2M</button>';
    echo '<button class="btn-next btn-sm" onclick="mostraInformeMesMT(' . $id . ',' . $any . ',' . $mes . ",'" . $setmana . "'" . ');" title="' . $dto->__($lng, "Informe") . " 4 " . $dto->__($lng, "Marcatges") . '"><span class="glyphicon glyphicon-list-alt"></span> 4M</button>';
	
	 echo '<button class="btn-next btn-sm" onclick="mostraInformeMes6M(' . $id . ',' . $any . ',' . $mes . ",'" . $setmana . "'" . ');" title="' . $dto->__($lng, "Informe") . " 6 " . $dto->__($lng, "Marcatges") . '"><span class="glyphicon glyphicon-list-alt"></span> 6M</button>';
	
	
/*} else {
    foreach ($rsinf as $i) {
        $nom2t = $dto->getCampPerIdCampTaula("tipusinforme", $i["idtipusinforme"], "ruta2m");
        $nom4t = $dto->getCampPerIdCampTaula("tipusinforme", $i["idtipusinforme"], "ruta4m");
        $nominf = $dto->getCampPerIdCampTaula("tipusinforme", $i["idtipusinforme"], "nom");
        $txtcol = $dto->getCampPerIdCampTaula("tipusinforme", $i["idtipusinforme"], "txtcol");
        $bckcol = $dto->getCampPerIdCampTaula("tipusinforme", $i["idtipusinforme"], "bckcol");
        echo '<button class="btn-next btn-sm " onclick="window.location = ' . "'" . $nom2t . '?id=' . $id . '&any=' . $any . '&mes=' . $mes . '&setmana=' . $setmana . "'" . ';" title="' . $nominf . " (2 " . $dto->__($lng, "Marcatges") . ')" style="background-color: #' . $bckcol . '; color: #' . $txtcol . ';"><span class="glyphicon glyphicon-list-alt"></span> 2M</button>';
        echo '<button class="btn-next btn-sm" onclick="window.location = ' . "'" . $nom4t . '?id=' . $id . '&any=' . $any . '&mes=' . $mes . '&setmana=' . $setmana . "'" . ';" title="' . $nominf . " (4 " . $dto->__($lng, "Marcatges") . ')" style="background-color: #' . $bckcol . '; color: #' . $txtcol . ';"><span class="glyphicon glyphicon-list-alt"></span> 4M</button>';
    }
}*/
?>


                    <button class="btn-green btn-sm" onclick="taulaAExcel('tblmarcatges','<?php echo $dto->__($lng, $dto->mostraNomMes($mes)); ?>','<?php echo $dto->__($lng, "Marcatges") . " " . $dto->mostraNomEmpPerId($id) . " " . $dto->__($lng, $dto->mostraNomMes($mes)) . " " . $any; ?>');" title="<?php echo $dto->__($lng, "Exportar a Excel"); ?>"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <button class="btn-blue btn-sm" onclick="printElem('fullmarcatges');" title="<?php echo $dto->__($lng, "Imprimir"); ?>"><span class="glyphicon glyphicon-print"></span></button>
                </span></h3>

<br><br>

                
<h3>NAVEGACIÓN</h3>
                    <form method="get">
                    <button class="btn-neutro btn-lg" formaction="AdminFitxaEmpleat.php" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Fitxa"); ?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button class="btn-blue btn-lg" formaction="AdminHorarisEmpleat.php" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Calendari Anual"); ?>"><span class="glyphicon glyphicon-calendar"></span></button>
                    <button class="btn-neutro btn-lg" formaction='AdminPersones.php' title="<?php echo $dto->__($lng, "Persones"); ?>"><span class="glyphicon glyphicon-eject"></span></button>

                            <input type="hidden" name="any" value="<?php echo $dto->__($lng, $any); ?>">
                            <input type="hidden" name="mes" value="<?php echo $dto->__($lng, $mes); ?>">
                            <input type="hidden" name="setmana" value="<?php echo $dto->__($lng, $setmana); ?>">
                    </form>
                    


</div>

<div class = "col-lg-8">

    
     
            <div class="container" >
        <table  id="tblmarcatges" class="table table-condensed" style="text-align: center;">


            <?php
// PREPARAR VARIABLES I ARRAYS
$idsMarcatges = [];
$datesMarcatges = [];
$diesvistos = [];
$numdiesvistos = 0;
$marcatgesfets = array_fill(0, 7, 0);
$marcatgesvalidats = array_fill(0, 7, 0);
$treballades = array_fill(0, 7, 0);
$teoriques = array_fill(0, 7, 0);
$avui = strtotime("now");
if ($setmana != $dto->__($lng, "Totes") && $any != $dto->__($lng, "Tots")) {
    $primerdiasetmana = new DateTime();
    $primerdiasetmana->setISODate($any, $setmana - 1);
    $diessetmana = [];
    for ($i = 0; $i < 7; $i++) {
        $diesvistos[$numdiesvistos] = $primerdiasetmana->format('Y-m-d');
        $numdiesvistos++;
        $diessetmana[$i] = $primerdiasetmana->format('Y-m-d');
        $primerdiasetmana->add($undiames);
    }
    for ($i = 0; $i <= 6; $i++) //&&($avui>=strtotime($diessetmana[$i]))
    {
        if (abs(substr($diessetmana[$i], 5, 2)) == $mes) {
            $teoriques[$i + 1] = $dto->seleccionaHoresTeoriquesPerIdDia($id, $diessetmana[$i]);
        }

    }
    if (abs(substr($diessetmana[0], 5, 2)) == $mes) {
        $teoriques[0] = $dto->seleccionaHoresTeoriquesPerIdDia($id, $diessetmana[6]);
    }

}
if ($mes != $dto->__($lng, "Tots") && $setmana == $dto->__($lng, "Totes")) {
    $primerdiames = new DateTime();
    $primerdiames->setISODate($any, 0);
    while ($primerdiames->format('Y') < $any) {
        $primerdiames->add($undiames);
    }

    while ($primerdiames->format('m') < $mes) {
        $primerdiames->add($undiames);
    }

    $diesmes = [];
    for ($i = 0; ((date("m", strtotime($primerdiames->format('Y-m-d'))) == $mes)); $i++) //$i<31
    {
        $diesvistos[$numdiesvistos] = $primerdiames->format('Y-m-d');
        $numdiesvistos++;
        $diesmes[$i] = $primerdiames->format('Y-m-d');
        $primerdiames->add($undiames);
    }
    for ($i = 0; (($i < count($diesmes))); $i++) //&&($avui>=strtotime($diesmes[$i]))
    {
        $weekday = date('w', strtotime($diesmes[$i]));
        if (empty($dto->esExcepcioPerIdDia($id, $diesmes[$i]))) {
            $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($id, $diesmes[$i]);
        }

    }
}
if ($any != $dto->__($lng, "Tots") && $mes == $dto->__($lng, "Tots") && $setmana == $dto->__($lng, "Totes")) {
    $primerdiaany = new DateTime();
    $primerdiaany->setISODate($any, 0, date("w", strtotime(($any . "-01-01"))));
    $diesany = [];
    for ($i = 0; $i < 366; $i++) {
        $diesvistos[$numdiesvistos] = $primerdiaany->format('Y-m-d');
        $numdiesvistos++;
        $diesany[$i] = $primerdiaany->format('Y-m-d');
        $primerdiaany->add($undiames);
    }
    for ($i = 0; $i < 366; $i++) //&&($avui>=strtotime($diesany[$i]))
    {
        $weekday = date('w', strtotime($diesany[$i]));
        $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($id, $diesany[$i]);
    }
}
$hihaespecial = 0;
$horesespecials = new ArrayObject();
$bodymarcatges = "";
$bidata = 0;
$bidata0 = 0;
$data = "";
$arrodmitjahoraextra = $dto->getCampPerIdCampTaula("empresa", $idempresa, "arrodmitjahoraextra");
for ($d = 0; $d < $numdiesvistos; $d++) {
    $dia = $diesvistos[$d];
    $weekday = date('w', strtotime($dia));
    $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $dia);
    $bidata = $dto->esTornBidata($id, $dia);
    $data0 = date('Y-m-d', strtotime($dia . " - 1 days"));
    $bidata0 = $dto->esTornBidata($id, $data0);
    // Calcular número de marcatges al dia
    $nummarc = 0;
    $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "' . $id . '" and date(datahora) like "' . $data . '"');
    foreach ($rsm as $n) {$nummarc = $n["nummarc"];}
    //
    // COMENTAT Que només calculi hores treballades en laborables
    //if($hteor>0)
    //{
    $htreb = $dto->calculaHoresTreballadesPerIdDia($id, $dia);
    //echo $dto->calculaHoresTreballadesPerIdDia($id, $dia);
    //$htreb = 8;
    //$hdesc = $dto->seleccionaHoresPausaPerIdDia($id, $dia);
    //if($htreb<($hteor-0.5)) $hdesc=0;
    //if($htreb>=$hdesc) $treballades[$weekday] += $htreb-$hdesc;
    $treballades[$weekday] += $htreb;
    //}
    $marcatgesdia = $dto->seleccionaMarcatgesPerIdDia($id, $diesvistos[$d]);
    if ((empty($marcatgesdia)) && ($dto->seleccionaHoresTeoriquesPerIdDia($id, $diesvistos[$d]) > 0)) {
        $bodymarcatges .= '<tr><td title="' . $dto->__($lng, "Horari") . ': ' . $dto->seleccionaTipusHorariPerIdDia($id, $dia, $lng) . '"><a class="btn btn-danger btn-xs" onclick="mostraNouMarcatgeObs(' . $id . ",'" . $diesvistos[$d] . "'" . ');"><span class="glyphicon glyphicon-plus" title="' . $dto->__($lng, "Nou Marcatge") . '"></span></a> ' . date('d-m-Y', strtotime($diesvistos[$d])) . ' ';
        if ($avui >= strtotime($dia)) {
            $bodymarcatges .= '<span class="glyphicon glyphicon-question-sign" title="' . $dto->__($lng, "Dia laborable sense marcatges") . '" style="color: red;"></span>';
        }

        $bodymarcatges .= '</td>';
        for ($c = 1; $c < 8; $c++) {
            $bodymarcatges .= '<td>-</td>';
        }

        $bodymarcatges .= '<td></td><td></td><td></td><td></td></tr>';
    } else {
        $contradicc = 0;
        $llistamarcdia = new ArrayObject();
        $nummarcdia = 0;
        foreach ($marcatgesdia as $rg) {
            $marcatge = new Marcatge(substr($rg["datahora"], 11, 5), $rg["id_tipus"], $rg["entsort"]);
            $llistamarcdia->append($marcatge);
            $nummarcdia++;
        }
        if (($nummarcdia % 2 != 0) && ($bidata == 0) && ($bidata0 == 0)) {
            $contradicc++;
        }

        // FUNCIO CALCUL HORES ESPECIALS AMB MARCATGES
        $horesact = 0.0;
        $harr = 0.0;
        //try{ // DE MOMENT ANULEM EL CALCUL D'HORES ESPECIALS.... INVESTIGANT
        if ($dto->esTornBidata($id, $dia) == 2) {
            for ($a = 0; $a < $nummarcdia; $a++) {
                if (($llistamarcdia[$a]->getIdtipus() > 4)) //<>4
                {
                    $hihaespecial++;
                    $exist = 0;
                    $nomactivitat = $dto->getNomidTipusActivitat($llistamarcdia[$a]->getIdtipus());
                    foreach ($horesespecials as $h) {
                        if ($h->getConcepte() == $nomactivitat) {
                            $exist = 1;
                        }
                    }

                    if (($a == 0)) {
                        $harr = $dto->calculaHoresActivitatsPerIdDiaIdtipusInici($id, $dia, $llistamarcdia[$a]->getHora());
                        if ($exist != 1) {
                            $horesconcepteespecial = new Horesresum($nomactivitat);
                            $horesconcepteespecial->setHores($weekday, $harr);
                            $horesespecials->append($horesconcepteespecial);}
                        if (($exist == 1)) {
                            foreach ($horesespecials as $h) {
                                if ($h->getConcepte() == $nomactivitat) {
                                    $h->setHores($weekday, ($h->getHores($weekday) + $harr));
                                }
                            }
                        }
                        if ($llistamarcdia[$a]->getEntsort() == 1) {$contradicc++;}
                    } else if (($a > 0) && ($llistamarcdia[$a]->getEntsort() == 0)) //($a<($nummarcdia-1))
                    {
                        $harr = $dto->calculaHoresActivitatsPerInterval($llistamarcdia[$a - 1]->getHora(), $llistamarcdia[$a]->getHora());
                        if ($exist != 1) {$horesconcepteespecial = new Horesresum($nomactivitat);
                            $horesconcepteespecial->setHores($weekday, $harr);
                            $horesespecials->append($horesconcepteespecial);}
                        if ($exist == 1) {
                            foreach ($horesespecials as $h) {
                                if ($h->getConcepte() == $nomactivitat) {
                                    $h->setHores($weekday, ($h->getHores($weekday) + $harr));
                                }
                            }
                        }
                        if ($nummarcdia > 4) {$treballades[$weekday] -= $harr;}
                    } else if ($a == ($nummarcdia - 1)) {
                        $harr = $dto->calculaHoresActivitatsPerIdDiaIdtipusFinal($id, $dia, $llistamarcdia[$a]->getHora());
                        if ($exist != 1) {$horesconcepteespecial = new Horesresum($nomactivitat);
                            $horesconcepteespecial->setHores($weekday, $harr);
                            $horesespecials->append($horesconcepteespecial);}
                        if ($exist == 1) {
                            foreach ($horesespecials as $h) {
                                if ($h->getConcepte() == $nomactivitat) {
                                    $h->setHores($weekday, ($h->getHores($weekday) + $harr));
                                }
                            }
                        }
                        if ($llistamarcdia[$a]->getEntsort() == 0) {$contradicc++;}
                    }
                }
            }
        }
        // FI FUNCIO CALCUL HORES ESPECIALS AMB MARCATGES
        foreach ($marcatgesdia as $marcatge) {
            $idsMarcatges[] = ($marcatge["idmarcatges"]);
            $diamarcatge = date('d-m-Y', strtotime($marcatge["datahora"])); //substr($marcatge["datahora"],0,10);
            $hora = substr($marcatge["datahora"], 11, 5);
            $bodymarcatges .= '<tr><td title="' . $dto->__($lng, "Horari") . ': ' . $dto->seleccionaTipusHorariPerIdDia($id, $dia, $lng) . '">';
            if ($contradicc > 0) {
                $bodymarcatges .= '<a class="btn btn-danger btn-xs" onclick="mostraNouMarcatgeObs(' . $id . ",'" . date('Y-m-d', strtotime($marcatge["datahora"])) . "'" . ');"><span class="glyphicon glyphicon-plus" title="' . $dto->__($lng, "Nou Marcatge") . '"></span></a> ';
            }

            $bodymarcatges .= $diamarcatge;
            if (($contradicc > 0)) {
                $bodymarcatges .= ' <span class="glyphicon glyphicon-exclamation-sign" title="' . $dto->__($lng, "Dia amb marcatges no esperats o desaparellats") . '" style="color: red;"></span>';
            }

            $bodymarcatges .= '</td>';
            $bckcol = "white";
            if ($marcatge["id_tipus"] != 4) {
                $bckcol = "yellow";
            }

            $iconcol = "";
            switch ($marcatge["entsort"]) {
                case 0:$iconcol = "rgb(112,225,112)";
                    break;
                case 1:$iconcol = "red";
                    break;
            }
            $icon = '<span class="glyphicon glyphicon-off" style="color: ' . $iconcol . ';"></span>';
            for ($i = 1; $i <= 6; $i++) {
                switch ($weekday) {
                    case $i:
                        if ($marcatge["validat"] == 1) {
                            $bodymarcatges .= '<td id="marcatge" style="background-color:rgb(128,255,128)" title="' . $dto->__($lng, $dto->direntsort($marcatge["entsort"])) . ": " . $dto->__($lng, $marcatge["tipus"]) . '">' . $icon . ' ' . $hora . '</td>';
                            $marcatgesfets[$i]++;
                            $marcatgesvalidats[$i]++;
                        } else {
                            $bodymarcatges .= '<td>'
                            . '<label style="border: solid 1px; border-radius: 5px; padding: 3px; background-color: ' . $bckcol . '; cursor: pointer" onclick="mostraEditaMarcatgeObs(' . $marcatge["idmarcatges"] . ');" title="' . $dto->__($lng, $dto->direntsort($marcatge["entsort"])) . ": " . $dto->__($lng, $marcatge["tipus"]) . '&NewLine;' . $dto->__($lng, "Click per a editar") . '">' . $icon . ' ' . $hora . '</label>'
                            //. '<input id="marcatge" type="time" value="'.$hora.'" contenteditable="true" data-old_value="'.$hora.'" onblur="actualitzaHoraMarcatge('.$marcatge["idmarcatges"].',this.getAttribute('."'data-old_value'".'),this.value);" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'"></input>'
                             . '</td>';
                            $marcatgesfets[$i]++;
                        }
                        break;
                    default:
                        $bodymarcatges .= '<td>-</td>';
                }
            }
            switch ($weekday) {
                case 0:
                    if ($marcatge["validat"] == 1) {
                        $bodymarcatges .= '<td id="marcatge" style="background-color:rgb(128,255,128)" title="' . $dto->__($lng, $dto->direntsort($marcatge["entsort"])) . ": " . $dto->__($lng, $marcatge["tipus"]) . '">' . $icon . ' ' . $hora . '</td>';
                        $marcatgesfets[0]++;
                        $marcatgesvalidats[0]++;
                    } else {
                        $bodymarcatges .= '<td>'
                        . '<label style="border: solid 1px; border-radius: 5px; padding: 3px; background-color: ' . $bckcol . '; cursor: pointer" onclick="mostraEditaMarcatgeObs(' . $marcatge["idmarcatges"] . ');" title="' . $dto->__($lng, $dto->direntsort($marcatge["entsort"])) . ": " . $dto->__($lng, $marcatge["tipus"]) . '&#13' . $dto->__($lng, "Click per a editar") . '">' . $icon . ' ' . $hora . '</label>'
                        //. '<input id="marcatge" type="time" value="'.$hora.'" contenteditable="true" data-old_value="'.$hora.'" onblur="actualitzaHoraMarcatge('.$marcatge["idmarcatges"].',this.getAttribute('."'data-old_value'".'),this.value);" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'"></input>'
                         . '</td>';
                        $marcatgesfets[0]++;
                    }
                    break;
                default:
                    $bodymarcatges .= '<td>-</td>';
            }
            $tdloc = '<td></td>';
            if (!empty($marcatge["utm_x"])) {
                $tdloc = '<td title="' . $dto->__($lng, "Veure Mapa") . '"><a style="cursor: pointer;" onclick="window.open(' . "'https://www.google.com/maps/search/?api=1&query=" . $marcatge["utm_x"] . "," . $marcatge["utm_y"] . "'" . ');">' . $marcatge["poblacio"] . ' <span class="glyphicon glyphicon-map-marker" style="color: orangered"></span></a></td>';
            }

            if ($marcatge["validat"] == 1) {
                $obs = $marcatge["observacions"];
                if (empty($obs)) {
                    $obs = $dto->__($lng, "Validat");
                }

                $bodymarcatges .= '<td>' . $marcatge["ipadress"] . '</td>'
                    . $tdloc
                    . '<td style="background-color:rgb(128,255,128)">' . $obs . '</td><td></td>';} else {
                $bodymarcatges .= '<td>' . $marcatge["ipadress"] . '</td>'
                    . $tdloc
                    . '<td>' . $marcatge["observacions"] . '</td>';
                $bodymarcatges .= '<td><a class="btn btn-xs btn-default" onclick="confElimMarcatge(' . $marcatge["idmarcatges"] . ');"><span class="glyphicon glyphicon-remove" style="color:red; background-color: white" title="' . $dto->__($lng, "Elimina Marcatge") . '"></span></a></td>';
            }
            $bodymarcatges .= '</tr>';
        }
    }
    // Si l'empresa té marcat el check d'arrodonir a mitja hora més si passen més de 10 minuts de l'hora o la mitja fracció més
    if ($arrodmitjahoraextra == 1) {
        $tb = $treballades[$weekday];
        $to = $hteor;
        if ($tb > $to) {
            $tex = $tb - $to;
            $tb = $to;
            $tsum = 0.0;
            while ($tex > 0.0) {
                if ($tex >= 0.17) {
                    $tsum += 0.5;
                }
                $tex -= 0.5;
            }
            $tb += $tsum;
        }
        $treballades[$weekday] = $tb;
    }
}
$stridsmarc = "";
foreach ($idsMarcatges as $idmarc) {
    $stridsmarc = $stridsmarc . $idmarc . "|";
}

if ($setmana != $dto->__($lng, "Totes")) {
    $bodymarcatges .= '<tr style="background-color: rgb(255,255,255)"><th></th>';
    for ($j = 1; $j <= 6; $j++) {
        if ($marcatgesfets[$j] > 0) {
            if (($marcatgesvalidats[$j] > 0)) {
                $bodymarcatges .= '<td><button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Desvalida dia") . '" onclick="desvalidaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',' . ($j - 1) . ');"><span class="glyphicon glyphicon-ban-circle" style="color:red"></span></button>';
                if ($marcatgesfets[$j] > $marcatgesvalidats[$j]) {
                    $bodymarcatges .= '<button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Valida dia") . '" onclick="validaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',' . ($j - 1) . ');"><span class="glyphicon glyphicon-ok" style="color:green"></span></button>';
                }

                $bodymarcatges .= '</td>';
            } else if ($treballades[$j] > 0) {
                $bodymarcatges .= '<td><button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Valida dia") . '" onclick="validaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',' . ($j - 1) . ');"><span class="glyphicon glyphicon-ok" style="color:green"></span></button></td>';
            } else {
                $bodymarcatges .= '<td></td>';
            }

        } else {
            $bodymarcatges .= '<td></td>';
        }

    }
    if ($marcatgesfets[0] > 0) {
        if (($marcatgesvalidats[0] > 0)) {
            $bodymarcatges .= '<td><button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Desvalida dia") . '" onclick="desvalidaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',6);"><span class="glyphicon glyphicon-ban-circle" style="color:red"></span></button>';
            if ($marcatgesfets[0] > $marcatgesvalidats[0]) {
                $bodymarcatges .= '<button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Valida dia") . '" onclick="validaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',6);"><span class="glyphicon glyphicon-ok" style="color:green"></span></button>';
            }

            $bodymarcatges .= '</td>';
        } else if ($treballades[0] > 0) {
            $bodymarcatges .= '<td><button class="btn btn-xs btn-default" title="' . $dto->__($lng, "Valida dia") . '" onclick="validaMarcatgesDia(' . "'" . $stridsmarc . "'" . ',6);"><span class="glyphicon glyphicon-ok" style="color:green"></span></button></td>';
        } else {
            $bodymarcatges .= '<td></td>';
        }

    } else {
        $bodymarcatges .= '<td></td>';
    }

    $bodymarcatges .= '<td></td><td></td><td></td><td></td></tr>';
}
$bodymarcatges .= "</tbody>";




// IMPRIMIR RESUM HORES PERIODE
if ($any != $dto->__($lng, "Tots")) {
    echo "<thead>";
    echo '<th style="text-align: center; background-color: #dfdfdf; color: black;">' . $dto->__($lng, "Hores") . '</th>';
    for ($j = 1; $j <= 7; $j++) {
        echo '<th style="text-align: center; background-color: #dfdfdf; color: black;"></th>';
    }
    echo '<th colspan="3" style="text-align: center; background-color: #dfdfdf; color: black;">' . $dto->__($lng, "Total Hores") . '</th><th style="text-align: center; background-color: #dfdfdf; color: black;"></th>';
    echo "</thead>";
    echo "<tbody>";
    echo "<tr >";
    echo '<td>' . $dto->__($lng, "Treballades") . '</td>';

    //FUNCION PARA SUMAR HORAS EN FORMATO HORAS
    function sumHours($hours) {

        $hoursTotals = 0;
        $secondTotals = 0;
        foreach ($hours as $hour) {
            $time = explode(":", $hour);
            $hh = $time[0];
            $mm = $time[1];
            $secondTotals += strtotime("+$hh hours +$mm minutes", 0);
        }

        $hoursTotals = $secondTotals / 3600;
        $hoursTotals = toHourFormat($hoursTotals);

        return $hoursTotals;
    }

    //FUNCION PARA CONVERTIR DE DECIMALES  A FORMATO HORAS
    function toHourFormat($hours_decimals) {
        $hour_aux = floor($hours_decimals);
        $minutes_aux = ($hours_decimals - $hour_aux) * 60;
        $hours_format = sprintf('%02d:%02d', $hour_aux, $minutes_aux);
        return $hours_format;
    }

    //FUNCION PARA RESTAR LAS HORAS
    function differenceHours($hours1, $hours2) {
        // Divide las horas y minutos de la primera hora
        $time1 = explode(":", $hours1);
        $hh1 = $time1[0];
        $mm1 = $time1[1];

        // Divide las horas y minutos de la segunda hora
        $time2 = explode(":", $hours2);
        $hh2 = $time2[0];
        $mm2 = $time2[1];

        // Convierte las horas y minutos a segundos
        $seconds1 = $hh1 * 3600 + $mm1 * 60;
        $seconds2 = $hh2 * 3600 + $mm2 * 60;

        // Calcula la diferencia en segundos
        $differenceSeconds_aux = $seconds1 - $seconds2;
        $differenceSeconds = abs($seconds1 - $seconds2);

        $negative = false;
        if ($differenceSeconds_aux < 0) $negative = true;



        // Convierte la diferencia en horas y minutos
        $hoursDifference = floor($differenceSeconds / 3600);
        $minutesDifference = floor(($differenceSeconds - $hoursDifference * 3600) / 60);


        // Formatea el resultado
        $result = sprintf("%02d:%02d", $hoursDifference, $minutesDifference);

        if ($negative) $result = "-" . $result;;

        return $result;
    }

    //WORKED HOURS
    $worked_hours = [];
    $worked_hours[] = toHourFormat($treballades[0]);
    for ($j = 1; $j <= 6; $j++) {
        echo '<td>' . toHourFormat($treballades[$j]) . '</td>';
        $worked_hours[] = toHourFormat($treballades[$j]);
    }
    //FIRST WORKED HOURS
    echo '<td>' . toHourFormat($treballades[0]) . '</td>';


    $total_worked_hours = sumHours($worked_hours);
    echo '<td colspan="3">' . $total_worked_hours . '</td>';




//OPERACION APARTE PARA ALGO MAS ABAJO
    $totaltreballades = 0;
    for ($k = 0; $k <= 6; $k++) {
        $totaltreballades += $treballades[$k];
    }






    echo '<td></td></tr>';
    echo "<tr>";
    echo '<td>' . $dto->__($lng, "Teòriques") . '</td>';

    $theoretical_hours = [];
    $theoretical_hours[] = toHourFormat($teoriques[0]);
    for ($j = 1; $j <= 6; $j++) {
        $theoretical_hours[] = toHourFormat($teoriques[$j]);
        echo '<td>' . toHourFormat($teoriques[$j]) . '</td>';
    }
    echo '<td>' . toHourFormat($teoriques[0]) . '</td>';



    $total_theoretical_hours = sumHours($theoretical_hours);
    echo '<td colspan="3">' . $total_theoretical_hours . '</td>';




    $totalteoriques = 0;
    for ($k = 0; $k <= 6; $k++) {
        $totalteoriques += $teoriques[$k];
    }






    echo '<td></td></tr>';
    echo "<tr>";




    echo '<td>' . $dto->__($lng, "Diferència") . '</td>';
    for ($j = 1; $j <= 6; $j++) {

        $deficit = differenceHours($worked_hours[$j], $theoretical_hours[$j]);

        if ($deficit > 0 || (($deficit == 0) && ($teoriques[$j] > 0))) {
            echo '<td style="background-color:rgb(128,255,128)">' . $deficit . '</td>';
        } else if ($deficit < 0 && $deficit > -1) {
            echo '<td style="background-color:rgb(255,255,128)">' . $deficit . '</td>';
        } else if ($deficit == 0) {
            echo '<td>' . toHourFormat($deficit) . '</td>';
        } else {
            echo '<td style="background-color:rgb(255,128,128)">' . $deficit . '</td>';
        }

    }
    $deficit = differenceHours($worked_hours[0], $theoretical_hours[0]);
    if ($deficit > 0 || (($deficit == 0) && ($teoriques[0] > 0))) {
        echo '<td style="background-color:rgb(128,255,128)">' . $deficit . '</td>';
    } else if ($deficit < 0 && $deficit > -1) {
        echo '<td style="background-color:rgb(255,255,128)">' . $deficit . '</td>';
    } else if ($deficit == 0) {
        echo '<td>' . $deficit . '</td>';
    } else {
        echo '<td style="background-color:rgb(255,128,128)">' . $deficit . '</td>';
    }

    $totaldeficit = differenceHours($total_worked_hours, $total_theoretical_hours); //$totaltreballades - $totalteoriques;
    if ($totaldeficit >= 0) {
        echo '<td colspan="3" style="background-color:rgb(128,255,128)">' . $totaldeficit . '</td>';
    } else if ($totaldeficit < 0 && $totaldeficit > -1) {
        echo '<td colspan="3" style="background-color:rgb(255,255,128)">' . $totaldeficit . '</td>';
    } else {
        echo '<td colspan="3" style="background-color:rgb(255,128,128)">' . $totaldeficit . '</td>';
    }

    echo '<td></td></tr>';
   
    for ($j = 1; $j <= 12; $j++) {
        echo '<th style="text-align: center; background-color: #dfdfdf; color: black;"></th>';
    }
    echo '</tbody>';
    //------ Hores Especials (ara metge)
    if ($hihaespecial > 0) {
        echo "<thead>";
        echo '<th style="text-align: center; background-color: #fff; color: black;">' . $dto->__($lng, "Hores Especials") . '</th>';
        for ($j = 1; $j <= 7; $j++) {
            echo '<th></th>';
        }
        echo '<th style="text-align: center; background-color: #fff; color: black;">' . $dto->__($lng, "Total Hores") . '</th><th></th>';
        echo "</thead>";
        echo "<tbody>";
        foreach ($horesespecials as $hs) {
            echo "<tr>";
            echo '<td>' . $dto->__($lng, $hs->getConcepte()) . '</td>';
            for ($j = 1; $j <= 6; $j++) {
                if ($hs->getHores($j) > 0) {
                    echo '<td style="background-color: yellow">';
                } else if ($hs->getHores($j) < 0) {
                    echo '<td title="' . $dto->__($lng, "Marcatges d´hores especials fora de l´horari de treball") . '"><span class="glyphicon glyphicon-exclamation-sign" style="color: red"></span>';
                } else {
                    echo '<td>';
                }

                echo number_format((float) $hs->getHores($j), 2, ",", ".") . '</td>';
            }
            echo '<td>' . number_format((float) $hs->getHores(0), 2, ",", ".") . '</td>';
            $totalespecials = 0;
            for ($k = 0; $k <= 6; $k++) {
                $totalespecials += $hs->getHores($k);
            }

            echo '<td colspan="3">' . number_format((float) $hs->getHtotals(), 2, ",", ".") . '</td>';
            echo '<td></td></tr>';
          
        }
        echo "</tbody>";
    }
}
?>






            <thead style="margin-top: 20px;">
            <strong>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Data"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Dilluns"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Dimarts"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Dimecres"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Dijous"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Divendres"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Dissabte"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Diumenge"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "IP Registrada"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Ubicació"); ?></th>
            <th style="text-align: center; background-color: #fff; color: black;"><?php echo $dto->__($lng, "Observacions"); ?></strong></th>
            <th style="text-align: center; background-color: #fff; color: black;"></th>
            </thead>
            <div name="divhores">
            <tbody>
            <?php
// IMPRIMIR TAULA MARCATGES SETMANAL
echo $bodymarcatges;
?>
        </table>

            </div>
        </div>




    


        </div>







</div>




    </center>
    <div class="modal-fade" id="modContent"></div>
    <div class="modal fade" id="modNouMarcatge"></div>
    <div class="modal fade" id="modEliminaMarcatge"></div>
    <div class="modal fade" id="modInforme" role="dialog">

    </div>
    <div class="modal fade" id="modValidar" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                    <div class="glassmorphism"><h3 style="color:#fff"><?php echo $dto->__($lng, "Validar Múltiples Marcatges"); ?></h3></div>
                <div class="modal-body">
                    <h2 style="color:#fff"><?php echo $dto->__($lng, "Està segur de realitzar aquesta validació múltiple?"); ?></h2><br><br>
                </div>
                
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="ValidaMarcatges('<?php echo $stridsmarc ?>')"><span class="glyphicon glyphicon-ok-sign"></span> <?php echo $dto->__($lng, "Confirmar"); ?></button>
                
              </div>
            </div>

            </center>
    </div>
    <div class="modal fade" id="modCalendariMes" role="dialog">
           <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header"><h3><?php echo $dto->__($lng, "Calendari Mensual"); ?><button type="button" class="close" data-dismiss="modal">&times;</button></h3></div>
                <div id="contingut" class="modal-body">
                    <div>
                    <?php $dto->imprimeixMesPerIdAnyMes($id, $any, $mes, 100, $lng);?>
                </div>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                <br><br>
                </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
    </div>
		</body>
</html>
