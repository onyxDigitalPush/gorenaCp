<html>
    <head>
<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();
$dto->navResolver();
include 'Conexion.php';
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\Exception;

?>


<style>
            /* Estilo para el select personalizado */

            .btn-next {
            position: relative; /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color:  transparent;
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
            background-color: transparent;
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





        /* Estilos para el select personalizado */
        .custom-select {
        appearance: none; /* Elimina los estilos de apariencia nativos del sistema */
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #f2f2f2; /* Color de fondo del select */
        border: 1px solid #ccc; /* Borde del select */
        padding: 10px; /* Espaciado interno del select */
        border-radius: 5px; /* Radio de borde del select */
        width: 100%; /* Ancho del select */
        cursor: pointer; /* Cambia el cursor al pasar sobre el select */
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





        /* Estilo para la tabla */
        .glass-table {
        border-collapse: collapse;
        width: 100%;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px); /* Agrega el efecto de desenfoque */
        border: 1px solid rgba(255, 255, 255, 0.18);
            }




        /* Estilo para las celdas de datos */
        .glass-table td {
        background: rgba(255, 255, 255, 0.4); /* Blanco con transparencia */
        color: #333;
        padding: 5px;
        font-size: 15px;

            }

        /* Estilo para las celdas de datos */
        .glass-table th {
        background: rgba(255, 255, 255, 0.4); /* Blanco con transparencia */
        color: #333;
        padding: 5px;
        font-size: 15px;

        }

        /* Estilo para las filas impares */
        .glass-table tr:nth-child(odd) {
        background: rgba(255, 255, 255, 0.3); /* Blanco con más transparencia */
        }

        /* Estilo para las celdas de entrada */



        .glass-table input {
        border: none; /* Elimina el borde predeterminado */
        background: rgba(255, 255, 255, 0.7); /* Fondo con transparencia */
        width: 100%;
        font-size: 15px;
        color: #333;
        padding: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.6); /* Agrega una sombra */
        transition: background 0.3s, box-shadow 0.6s; /* Agrega una transición suave */
        }

        /* Estilo para los campos de entrada al enfocar (hover) */
        .glass-table input:focus {
        background: rgba(255, 168, 189, 0.9); /* Cambia el fondo al enfocar */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); /* Aumenta la sombra al enfocar */
        }


        /* Estilo para los selectores */
        .glass-table select {
        border: none;
        background: transparent;
        width: 100%;
        font-size: 15px;
        color: #333;
        }




        /* Cambiar el color de fondo en hover */
        .glass-table.table-hover tbody tr:hover {
            background-color:rgba(4, 60, 172, 0.1); /* Reemplaza "tu-color-preferido" con el color que desees */
        }


</style>
    </head>

    <body class="well">
<?php
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

if (!isset($_GET["id"])) {
    $_GET["id"] = $_POST["id"];
}

$id = $_GET['id'];
		$idsubemp = $_GET['idsubemp'];
$idempresa = $_SESSION["idempresa"];
$nomemp = $dto->getCampPerIdCampTaula("empresa", $idempresa, "nom");
if (!isset($_GET["any"])) {
    $_GET["any"] = date('Y', strtotime("now"));
}

$any = $_GET["any"];
//--------UPLOAD
if (isset($_POST["type"])) {
    $target_dir = './Pantalles/img/';
    $idreg = $_POST["id"];
    $target_file = $target_dir . $idreg . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $table = "";
    $camp = "";
    $location = "";
    // Check if image file is a actual image or fake image

    if ($_POST["type"] == "fotoempleat") {
        $table = "empleat";
        $camp = "rutafoto";
        $location = "Location: AdminFitxaEmpleat.php";
    }
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {

        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            $dto->actualitzaCampTaula($table, $camp, $idreg, $target_file);

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    unset($_POST);
}
//--------END UPLOAD
$res = $dto->seleccionaEmpPerId($id);
$rutafoto = "";
		
$horesteoany = $dto->seleccionaHoresTeoriques($id,$any);
				
/*
$horesteoany = 0.0;
$year = date('Y', strtotime('today'));
$datateoriques = date('Y-m-d', strtotime($year . '-01-01'));
while (date('Y', strtotime($datateoriques)) == $year) {
    $horesteoany += $dto->seleccionaHoresTeoriquesPerIdDia($id, $datateoriques);
    $datateoriques = date('Y-m-d', strtotime($datateoriques . ' + 1 days'));
}*/
		
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
    if (($i > 0) && ($id == $rp["idempleat"])) {$persant = '<button class="btn-neutro" name="id" value="' . $idpersant . '" formaction="AdminFitxaEmpleat.php" title="' . $dto->__($lng, "Anterior") . '"><span class="glyphicon glyphicon-arrow-left"></span></button>';} else { $idpersant = $rp["idempleat"];}
    $persopt .= '<option value="' . $rp["idempleat"] . '">' . $rp["cognom1"] . ' ' . $rp["cognom2"] . ' ' . $rp["nom"] . '</option>';
    if ($chkpers == 1) {$persseg = '<button class="btn-neutro" name="id" value="' . $rp["idempleat"] . '" formaction="AdminFitxaEmpleat.php" title="' . $dto->__($lng, "Següent") . '">
                    <span class="glyphicon glyphicon-arrow-right"></span>
                </button>
                ';
        $chkpers = 0;}
    if (($id == $rp["idempleat"])) {$chkpers = 1;}
    $i++;
}
?>

<?php
if (isset($_GET['correo_enviado']) && $_GET['correo_enviado'] == 1) {
    if (isset($_GET['nombre_empleado'])) {
        $nombre_empleado = urldecode($_GET['nombre_empleado']);
        echo '<script>alert("La información se ha enviado correctamente por correo electrónico para el empleado: ' . $nombre_empleado . '");</script>';
    }
}
?>






    <center>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-2" style="text-align: center">
                <form method="get" action="AdminFitxaEmpleat.php">
                    <h3 style="text-align: center; margin-top: 0px">
                        <div class="custom-select-container">
                            <select id="sizesel" class="custom-select" name="id" onchange="this.form.submit();" title="<?php echo $dto->__($lng, "Seleccionar Empleat"); ?>">
                                <option id="optself" hidden selected><?php echo $dto->__($lng, "Seleccionar Persona"); ?></option>
                                <?php echo $persopt ?>
                            </select>
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                    </h3>
                </form>
            </div>

        <div class="col-lg-8"></div>
            <div class="col-lg-2" style="text-align: right">
                <form method="get">
                    <?php echo $persant; ?> <?php echo $persseg; ?>
                </form>
            </div>
        </div>
    </div></center>

    <hr width="90%">


    <div class="row">
        <div class="col-lg-12">
            <form method="get" class="text-right">
                <button type="submit" formaction="AdminMarcatgesEmpleat.php" class="btn-next" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Veure els marcatges de l'usuari"); ?>"><span class="glyphicon glyphicon-zoom-in"></span>
                </button>

                <button type="submit" formaction="AdminHorarisEmpleat.php" class="btn-blue" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Veure i gestionar el calendari d´horaris i períodes especials"); ?>"><span class="glyphicon glyphicon-calendar"></span>
                </button>

                <button type="submit" formaction="AdminPersones.php" class="btn-neutro" title="<?php echo $dto->__($lng, "Tornar a la llista de persones"); ?>"><span class="glyphicon glyphicon-eject"></span>
                </button>


                <button type="submit" formaction="AdminUbicacionsEmpleat.php" class="btn-blue" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Gestionar Ubicacions"); ?>"><span class="glyphicon glyphicon-map-marker"></span> 
                </button>
                
                <button formaction="process_correo_user.php" type="submit" class="btn-red" name="id" value="<?php echo $id; ?>" title="Enviar información de usuario y contraseña a empleado"><span class="glyphicon glyphicon-lock"></span>
                </button>
            </form>

                 <div class = "col-lg-12" style="text-align: center"> <h2 class=""><?php echo $dto->mostraNomEmpPerId($id); ?>  </h2><br>
                     <label class=""><?php echo $dto->__($lng, "Hores") . " " . $dto->__($lng, "Teòriques") . " " . $dto->__($lng, "any") . " " . $year; ?>:</label> <strong><?php echo number_format($horesteoany, 1, ",", "."); ?> h</strong><br>
<?php
    foreach ($res as $fitxa) {
        $rutafoto = $fitxa["rutafoto"];}
?>
                    <div class="container">
                         <a title="<?php echo $dto->__($lng, "Click per a canviar la foto"); ?>" onclick="editaFoto(<?php echo $id; ?>);" style="cursor: pointer;   display: inline-block; border-radius: 50%;">
                             <img src="<?php echo $rutafoto; ?>" alt="<?php echo $dto->__($lng, "Foto"); ?>" style="height: 150px; width: 120px; border: solid 1px; border-radius: 50%;">
                         </a>
</div>


<br><br>


<div class="col-lg-12">
        <h1 class="text-center">Ficha Empleado</h1>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#persona">Persona</a></li>
                    <li><a data-toggle="tab" href="#empresa">Empresa</a></li>
                    <li><a data-toggle="tab" href="#pestaña3">Registro</a></li>
                </ul>
            </div>
        </div>
        <br><br>






        <div class="row">
    <div class="col-lg-12" style="text-align:rigth;" >
        <div class="tab-content" style = "text-align: center;">

                <div id="persona" class="tab-pane fade in active">

        <section id="DadesEmp">

           <table class="glass-table table-hover">



                    <tbody class="col-lg-4 ">
                        <?php
foreach ($res as $fitxa) {
    echo '<tr>
                                    <th>' . $dto->__($lng, "Primer Cognom") . '</th>
                                    <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','cognom1'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["cognom1"] . '" data-old_value="' . $fitxa["cognom1"] . '"></td>
                                </tr>
                                <tr>
                                    <th>' . $dto->__($lng, "Segon Cognom") . '</th>
                                    <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','cognom2'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["cognom2"] . '" data-old_value="' . $fitxa["cognom2"] . '"></td>
                                </tr>
                                <tr>
                                    <th>' . $dto->__($lng, "Nom") . '</th>
                                    <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','nom'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["nom"] . '" data-old_value="' . $fitxa["nom"] . '"></td>
                                </tr>
                                <tr>
                                    <th>' . $dto->__($lng, "Sexe") . '</th>
                                    <td>
                                        <select onchange="actualitzaCampTaulaNR(' . "'empleat','sexe'," . $id . ',' . "'" . $fitxa["sexe"] . "'" . ',this.value);">
                                            <option hidden selected>' . $dto->dirSexeLletra($fitxa["sexe"]) . '</option>
                                            <option value="h">' . $dto->__($lng, "Home") . '</option>
                                            <option value="d">' . $dto->__($lng, "Dona") . '</option>
                                        </select>
                                    </td>
                                </tr>';
}
?>
                    </tbody>



                    <tbody class="col-lg-4 ">

                        <?php
foreach ($res as $fitxa) {
    echo ' <tr>
                            <th>DNI</th>
                            <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','dni'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["dni"] . '" data-old_value="' . $fitxa["dni"] . '"></td>
                        </tr>
                        <tr>
                            <th>' . $dto->__($lng, "Data Naixement") . '</th>
                            <td><input type="date"'
    . 'value="' . $fitxa["datanaixement"] . '" oninput="actualitzaCampTaulaNR(' . "'empleat','datanaixement'," . $id . ',' . "'" . $fitxa["datanaixement"] . "'" . ',this.value);"></td>
                        </tr>
                        <tr>
                            <th>' . $dto->__($lng, "Nacionalitat") . '</th>
                            <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','nacionalitat'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["nacionalitat"] . '" data-old_value="' . $fitxa["nacionalitat"] . '"></td>
                        </tr>
                        <tr>
                            <th>' . $dto->__($lng, "Població") . '</th>
                            <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','poblacio'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["poblacio"] . '" data-old_value="' . $fitxa["poblacio"] . '"></td>
                        </tr>';

}
?>

                    </tbody>



                    <tbody class = "col-lg-4">
                        <?php
foreach ($res as $fitxa) {
    echo '
                            <tr>
                                <th>' . $dto->__($lng, "Domicili") . '</th>
                                <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','domicili'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["domicili"] . '" data-old_value="' . $fitxa["domicili"] . '"></td>
                            </tr>
                            <tr>
                                <th>' . $dto->__($lng, "Codi Postal") . '</th>
                                <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','codipostal'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["codipostal"] . '" data-old_value="' . $fitxa["codipostal"] . '"></td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','email'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["email"] . '" data-old_value="' . $fitxa["email"] . '"></td>
                            </tr>
                            <tr>
                                <th>' . $dto->__($lng, "Telèfon de Contacte") . '</th>
                                <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','telefon1'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["telefon1"] . '" data-old_value="' . $fitxa["telefon1"] . '"></td>
                            </tr>
                            <tr>
                                <th>' . $dto->__($lng, "Telèfon Alternatiu") . '</th>
                                <td><input onblur="actualitzaCampTaulaNR(' . "'empleat','telefon2'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["telefon2"] . '" data-old_value="' . $fitxa["telefon2"] . '"></td>
                            </tr>';

}
?>
                    </tbody>



                </table>
            </section>



        </div>





<!---------------------------------------------------EMPRESA-------------------------------------------------------------->






<?php
// Consulta SQL para traer los días de vacaciones del año actual
$total_dias = null;
$total_dias_anterior = null;
$id_empleat = $id;

$current_year = date("Y"); // Año actual
$previous_year = $current_year - 1; // Año anterior

// Consulta SQL para obtener el total de días del año actual
$sql_actual = "SELECT total_dias FROM vacances WHERE idempleat = ? AND any = ?";
$stmt_actual = $conn->prepare($sql_actual);
$stmt_actual->bind_param("ss", $id_empleat, $current_year);
$stmt_actual->execute();
$stmt_actual->bind_result($total_dias);

if ($stmt_actual->fetch()) {
    // Aquí puedes usar el valor de $total_dias_actual para lo que necesites

}

$stmt_actual->close();

// Consulta SQL para obtener el total de días del año anterior
$sql_anterior = "SELECT total_dias FROM vacances WHERE idempleat = ? AND any = ?";
$stmt_anterior = $conn->prepare($sql_anterior);
$stmt_anterior->bind_param("ss", $id_empleat, $previous_year);
$stmt_anterior->execute();
$stmt_anterior->bind_result($total_dias_anterior);

if ($stmt_anterior->fetch()) {
    // Aquí puedes usar el valor de $total_dias_anterior para lo que necesites

}

$stmt_anterior->close();

?>



<div class="col-lg-12 " >
        <div class="tab-content">
                <div id="empresa" class="tab-pane fade">

        <section id="DadesEmp1">

            <table class="glass-table table-hover">
                <tbody class ="col-lg-4">

                <?php
try {

    $tipustornopt = "";
    $rstr = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa=' . $idempresa);
    foreach ($rstr as $tr) {$tipustornopt .= '<option value="' . $tr["idtipustorn"] . '">' . $tr["nom"] . '</option>';}
    $torn = $dto->seleccionaTornActualEmpPerId($id);
    $idhorari = 0;
    foreach ($torn as $codi) {
        $idhorari = $codi["idhorari"];
    }

    $rs = $dto->seleccionaEmpPerId($id);
    foreach ($rs as $fitxa) {
        echo '<tr><th>' . $dto->__($lng, "Empresa") . '</th><td>' . $dto->mostraNomEmpresa($fitxa["idempresa"]) . '</td></tr>'

        . '<tr><th>' . $dto->__($lng, "Subempresa") . '</th><td>' . $dto->getCampPerIdCampTaula("subempresa", $dto->getCampPerIdCampTaula("empleat", $fitxa["idempleat"], "idsubempresa"), "nom") . '</td><td><button class="btn-next" title="' . $dto->__($lng, "Assigna Nova") . '" onclick="editaPertanySubemp(' . $fitxa["idempleat"] . ');"><span class="glyphicon glyphicon-pencil"></button></td></tr>'

        . '<tr><th>' . $dto->__($lng, "Departament") . '</th><td>' . $dto->mostraNomDptPerIdEmp($fitxa["idempleat"]) . '</td><td><button class="btn-next" title="' . $dto->__($lng, "Assigna Nou") . '" onclick="editaPertany(' . $fitxa["idempleat"] . ');"><span class="glyphicon glyphicon-pencil"></button></td></tr>

                    <tr><th>' . $dto->__($lng, "Responsable") . '</th><td>' . $dto->mostraNomEmpPerId($fitxa["idresp"]) . '</td><td><button class="btn-next" title="' . $dto->__($lng, "Assigna Nou") . '" onclick="editaResp(' . $fitxa["idempleat"] . ',' . $fitxa["idresp"] . ');"><span class="glyphicon glyphicon-pencil"></button></td></tr>

                    <tr><th>' . $dto->__($lng, "Perfil / Rol") . '</th><td>' . $dto->mostraNomRolPerIdEmp($fitxa["idempleat"]) . '</td><td><button class="btn-next" title="' . $dto->__($lng, "Assigna Nou") . '" onclick="editaRolAssignat(' . $fitxa["idempleat"] . ');"><span class="glyphicon glyphicon-pencil"></button></td></tr>

                    <tr><th>' . $dto->__($lng, "Horari Setmanal") . '</th><td>' . $dto->mostraNomHorariPerIdhorari($idhorari) . '</td><td>';
        if (empty($dto->seleccionaHorarisEmpPerId($fitxa["idempleat"]))) {
            echo ' <span class="glyphicon glyphicon-exclamation-sign" title="' . $dto->__($lng, "Sense horari setmanal assignat") . '" style="color:red"></span>';
        } else if (empty($dto->seleccionaTornActualEmpPerId($fitxa["idempleat"]))) {
            echo ' <span class="glyphicon glyphicon-exclamation-sign" title="' . $dto->__($lng, "Sense horari actualment") . '" style="color:red"></span>';
        } else {
            echo '<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modHorari" title="' . $dto->__($lng, "Veure Horari") . '"><span class="glyphicon glyphicon-zoom-in"></a></td>';
        }

        echo '</td></tr>';

    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
                </tbody>






                <tbody class = "col-lg-4">

               <?php
try {

    $tipustornopt = "";
    $rstr = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa=' . $idempresa);
    foreach ($rstr as $tr) {$tipustornopt .= '<option value="' . $tr["idtipustorn"] . '">' . $tr["nom"] . '</option>';}
    $torn = $dto->seleccionaTornActualEmpPerId($id);
    $idhorari = 0;
    foreach ($torn as $codi) {
        $idhorari = $codi["idhorari"];
    }

    $rs = $dto->seleccionaEmpPerId($id);
    foreach ($rs as $fitxa) {
        echo

        '<tr><th>' . $dto->__($lng, "Horari R. Principal") . '</th><td colspan="2">' .
        '<select onchange="actualitzaNCampTaulaNR(' . "'empleat','idhorari1'," . $fitxa["idempleat"] . ',this.value);" style="width: 100%;">'
        . '<option hidden selected value="' . $fitxa["idhorari1"] . '">' . $dto->getCampPerIdCampTaula("tipustorn", $fitxa["idhorari1"], "nom") . '</option>'
        . $tipustornopt . '</select>' . '</td></tr>'

        . '<tr><th>' . $dto->__($lng, "Horari R. Secundari") . '</th><td colspan="2">' .
        '<select onchange="actualitzaNCampTaulaNR(' . "'empleat','idhorari2'," . $fitxa["idempleat"] . ',this.value);" style="width: 100%;">'
        . '<option hidden selected value="' . $fitxa["idhorari2"] . '">' . $dto->getCampPerIdCampTaula("tipustorn", $fitxa["idhorari2"], "nom") . '</option>'
            . $tipustornopt . '</select>' . '</td></tr>';

        try {
            for ($jear = 2017; $jear <= (date('Y', strtotime('now')) + 1); $jear++) {$optany .= '<option value:"' . $jear . '">' . $jear . '</option>';}
            $horesasgany = 0.0;
            $rsha = $dto->getDb()->executarConsulta('select * from horesany where idempleat=' . $id . ' and anylab=' . $any);
            if (!empty($rsha)) {foreach ($rsha as $ha) {$horesasgany = $ha["hores"];}}
            echo '<tr><form name="horesany" method="GET"><input hidden name="id" value="' . $id . '"><th>' . $dto->__($lng, "Hores a Realitzar Any") . ' <select name="any" onchange="this.form.submit();"><option hidden selected value="' . $any . '">' . $any . '</option>' . $optany . '</select></th><td>' . number_format($horesasgany, 1, ",", ".") . ' Hs.</td></form><td><button class="btn-next" title="' . $dto->__($lng, "Edita") . '" onclick="editaHoresAny(' . $fitxa["idempleat"] . ',horesany.any.value);"><span class="glyphicon glyphicon-pencil"></button></td></tr>';
        } catch (Exception $ex) {echo $ex->getMessage();}
        $noubic = $dto->getUbicacionsPerId($fitxa["idempleat"]);
        if (empty($dto->seleccionaUbicacionsEmpPerIdDia($id, date('Y-m-d', strtotime("now"))))) {
            $noubic = ' <span class="glyphicon glyphicon-exclamation-sign" title="' . $dto->__($lng, "Sense ubicació assignada") . '" style="color:red"></span>';
        }

        $datacessat = "";
        if ($fitxa["enplantilla"] == 0) {
            $datacessat = '<tr><th style="background-color: red; color: white">' . $dto->__($lng, "Cessat") . ' ' . $dto->__($lng, "a") . ' ' . $dto->__($lng, "Data") . '</th><td><input type="date" onchange="actualitzaCampTaulaNR(' . "'empleat','datacessat'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
                . 'value="' . $fitxa["datacessat"] . '" data-old_value="' . $fitxa["datacessat"] . '"></td></tr>';
        }

        echo '<tr><th>' . $dto->__($lng, "Total días vacaciones") . ' ' . $any . '</th><td>' . $total_dias . ' días </td><td><button class="btn-next" title="' . $dto->__($lng, "Assigna Nou") . '" onclick="editaVacancesAssignat(' . $fitxa["idempleat"] . ');"><span class="glyphicon glyphicon-pencil"></button></td></tr>';

        echo '<tr><th>' . $dto->__($lng, "Total días vacaciones año anterior") . '</th><td>' . $total_dias_anterior . ' días </td><td></td></tr>';

    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
               </tbody>







               <tbody class = "col-lg-4">

               <?php
try {

    $tipustornopt = "";
    $rstr = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa=' . $idempresa);
    foreach ($rstr as $tr) {$tipustornopt .= '<option value="' . $tr["idtipustorn"] . '">' . $tr["nom"] . '</option>';}
    $torn = $dto->seleccionaTornActualEmpPerId($id);
    $idhorari = 0;
    foreach ($torn as $codi) {
        $idhorari = $codi["idhorari"];
    }

    $rs = $dto->seleccionaEmpPerId($id);
    foreach ($rs as $fitxa) {

        echo '<tr><th>' . $dto->__($lng, "Ubicacions") . '</th><td>' . $noubic . '</td>
                   <td><form method="get" action="AdminUbicacionsEmpleat.php">
               <button type="submit" class="btn-next" name="id" value="' . $id . '" title="' . $dto->__($lng, "Gestionar Ubicacions") . '"><span class="glyphicon glyphicon-map-marker"></span></button>
               </form></td>
                   </tr>


                   <tr><th>' . $dto->__($lng, "Data última contractació") . '</th><td colspan="2"><input type="date" onchange="actualitzaCampTaulaNR(' . "'empleat','dataultcontrac'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["dataultcontrac"] . '" data-old_value="' . $fitxa["dataultcontrac"] . '"></td></tr>


                   <tr><th>' . $dto->__($lng, "Tipus de contracte") . '</th><td colspan="2"><input onblur="actualitzaCampTaulaNR(' . "'empleat','tipuscontrac'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["tipuscontrac"] . '" data-old_value="' . $fitxa["tipuscontrac"] . '" style="width: 100%"></td></tr>
                   <tr><th>' . $dto->__($lng, "Núm.Afiliació") . '</th><td colspan="2"><input onblur="actualitzaCampTaulaNR(' . "'empleat','numafiliacio'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["numafiliacio"] . '" data-old_value="' . $fitxa["numafiliacio"] . '"></td></tr>


                   <tr><th>' . $dto->__($lng, "Grau de Discapacitat") . '</th><td colspan="2"><input onblur="actualitzaCampTaulaNR(' . "'empleat','graudiscap'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["graudiscap"] . '" data-old_value="' . $fitxa["graudiscap"] . '" style="width: 100%"></td></tr>


                   <tr><th>' . $dto->__($lng, "Núm.Targeta Identificació") . '</th><td colspan="2"><input id="idtargeta" onblur="actualitzaChkExisteixCampTaula(' . "'idtargeta','idtargeta','empleat'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["idtargeta"] . '" data-old_value="' . $fitxa["idtargeta"] . '" style="width: 100%"></td></tr>


                   <tr><th>' . $dto->__($lng, "Usuari Sessió") . '</th><td colspan="2"><input id="user" onblur="actualitzaChkExisteixCampTaula(' . "'user','user','empleat'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
            . 'value="' . $fitxa["user"] . '" data-old_value="' . $fitxa["user"] . '"></td></tr>' . $datacessat;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
               </tbody>






            </table>

        </section>
</div>
        </div>
</div>





<!--------------------------------------------------ASIGNACION TURNOS------------------------------------------>
<div class="col-lg-12">
<div class="tab-content">

                <div id="pestaña3" class="tab-pane fade">
        <section id="DadesEmp2">

        <table class="glass-table">
        <tbody class="col-lg-4">
            <?php

$rs = $dto->seleccionaEmpPerId($id);
foreach ($rs as $fitxa) {
    echo '<tr><th>' . $dto->__($lng, "Data Inici Distribució") . '</th><td><input type="date" onblur="actualitzaCampTaulaNR(' . "'empleat','ordredist'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["ordredist"] . '" data-old_value="' . $fitxa["ordredist"] . '" style=""></td></tr>

                    <tr><th>' . $dto->__($lng, "Torn Distribució") . '</th><td><input onblur="actualitzaCampTaulaNR(' . "'empleat','torndist'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["torndist"] . '" data-old_value="' . $fitxa["torndist"] . '" style="width: 50%"></td></tr>

                    <tr><th>' . $dto->__($lng, "Rotació") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','rotacio'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["rotacio"] . '" data-old_value="' . $fitxa["rotacio"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["rotacio"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["rotacio"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>

                    <tr><th>' . $dto->__($lng, "Alta") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','alta'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["alta"] . '" data-old_value="' . $fitxa["alta"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["alta"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["alta"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>

                    <tr><th>' . $dto->__($lng, "Temporal") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','temporal'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["temporal"] . '" data-old_value="' . $fitxa["temporal"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["temporal"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["temporal"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>';
}

?>
        </tbody>


        <tbody class="col-lg-4">
            <?php

$rs = $dto->seleccionaEmpPerId($id);
foreach ($rs as $fitxa) {
    echo '



                    <tr><th>' . $dto->__($lng, "Dies Naturals") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','diesnat'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["diesnat"] . '" data-old_value="' . $fitxa["diesnat"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["diesnat"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["diesnat"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>

                    <tr><th>' . $dto->__($lng, "Nits") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','nits'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["nits"] . '" data-old_value="' . $fitxa["nits"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["nits"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["nits"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>

                    <tr><th>' . $dto->__($lng, "Dia/Nit") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','dianit'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["dianit"] . '" data-old_value="' . $fitxa["dianit"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["dianit"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["dianit"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>
                    <tr><th>' . $dto->__($lng, "Subst. Supervisor") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','substsuperv'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["substsuperv"] . '" data-old_value="' . $fitxa["substsuperv"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["substsuperv"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["substsuperv"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>
                    <tr><th>' . $dto->__($lng, "Dies Laborables") . ' RP</th><td><input onblur="actualitzaCampTaulaNR(' . "'empleat','dieslabor'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
        . 'value="' . $fitxa["dieslabor"] . '" data-old_value="' . $fitxa["dieslabor"] . '" style="width: 50%"></td></tr>';
}

?>




        </tbody>



        <tbody class="col-lg-4">
            <?php

$rs = $dto->seleccionaEmpPerId($id);
foreach ($rs as $fitxa) {
    echo '<tr><th>' . $dto->__($lng, "Dies Laborables") . ' RS</th><td><input onblur="actualitzaCampTaulaNR(' . "'empleat','dieslabor2'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["dieslabor2"] . '" data-old_value="' . $fitxa["dieslabor2"] . '" style="width: 50%"></td></tr>
                    <tr><th>' . $dto->__($lng, "Dies Festius") . '</th><td><input onblur="actualitzaCampTaulaNR(' . "'empleat','diesfesta'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["diesfesta"] . '" data-old_value="' . $fitxa["diesfesta"] . '" style="width: 50%"></td></tr>
                    <tr><th>' . $dto->__($lng, "Automarcatge") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','automarc'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["automarc"] . '" data-old_value="' . $fitxa["automarc"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["automarc"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["automarc"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>
                        <tr><th>' . $dto->__($lng, "Automarcatge Sortida") . '</th><td><select onchange="actualitzaCampTaulaNR(' . "'empleat','automarcsort'," . $id . ',this.getAttribute(' . "'data-old_value'" . '),this.value);"'
    . 'value="' . $fitxa["automarcsort"] . '" data-old_value="' . $fitxa["automarcsort"] . '" style="width: 50%"><option hidden selected value="' . $fitxa["automarcsort"] . '">' . $dto->__($ididioma, $dto->dirsiono($fitxa["automarcsort"])) . '</option><option value="1">' . $dto->__($ididioma, "Sí") . '</option><option value="0">' . $dto->__($ididioma, "No") . '</option></select></td></tr>';
}

?>



        </tbody>


        </table>
                    </section>
                    </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
    </div>
<!--------------------------------------------------ASIGNACION TURNOS------------------------------------------>



    </div>
    </div>
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
    <div class="modal fade" id="modHorari" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng, "Horari Actual"); ?></h3><br>
                    <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng, "Dia"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng, "Entrada"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng, "Sortida"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng, "Hores"); ?></th>

                        <th style="text-align: center" title="<?php echo $dto->__($lng, "Comptabilitza el temps de marcatges avançats de l'hora teòrica d'entrada"); ?>"><?php echo $dto->__($lng, "Anticipat"); ?></th>
                        </thead>
                        <tbody>
                            <?php
$horari = $dto->seleccionaTornActualEmpPerId($id);
foreach ($horari as $dia) {
    echo '<tr>';
    echo '<td>' . $dto->__($lng, $dto->mostraNomDia($dia["diasetmana"])) . '</td>';
    echo '<td>' . substr($dia["horaentrada"], 0, 5) . '</td>';
    echo '<td>' . substr($dia["horasortida"], 0, 5) . '</td>';
    echo '<td>' . $dia["horestreball"] . '</td>';

    echo '<td>' . $dto->dirsiono($dia["marcabans"]) . '</td>';
    echo '</tr>';
}
?>
                        </tbody>
                    </table>
                    <br><button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modSbe"></div>
    <div class="modal fade" id="modDpts"></div>
    <div class="modal fade" id="modRols"></div>
    <div class="modal fade" id="modResps"></div>
    <div class="modal fade" id="modAdminPass"></div>
    <div class="modal fade" id="modAdminFoto"></div>
    <div class="modal fade" id="modVacances"></div>




    <script>
        $(document).ready(function () {
            // Oculta el contenido de las pestañas al cargar la página
            //$(".tab-pane").removeClass("in active");

            // Muestra el contenido de la pestaña activa al hacer clic en una pestaña
            $("ul.nav-tabs li").click(function () {
                $("ul.nav-tabs li").removeClass("active");
                $(this).addClass("active");
                var tab_id = $(this).find("a").attr("href");
                $(".tab-pane").removeClass("in active");
                $(tab_id).addClass("in active");
            });
        });




    function editaPertanySubemp(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modSbe").innerHTML = this.responseText;
                $modal = $('#modSbe');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalSbe.php?id=" + idempleat, true);
            xmlhttp.send();
    }
    function editaPertany(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modDpts").innerHTML = this.responseText;
                $modal = $('#modDpts');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalDpts.php?id=" + idempleat, true);
            xmlhttp.send();
    }
    function assignaDpt(idempleat,iddpt)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaDpt&idemp=" + idempleat + "&iddpt=" + iddpt, true);
            xmlhttp.send();
    }
    function editaRolAssignat(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modRols").innerHTML = this.responseText;
                $modal = $('#modRols');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalRols.php?id=" + idempleat, true);
            xmlhttp.send();
    }




    function editaVacancesAssignat(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modVacances").innerHTML = this.responseText;
                $modal = $('#modVacances');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalVacances.php?id=" + idempleat, true);
            xmlhttp.send();
    }







    function editaEncargadoAssigna(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modEncargado").innerHTML = this.responseText;
                $modal = $('#modEncargado');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalEncargado.php?id=" + idempleat + "&idresp=" + idresp, true);
            xmlhttp.send();
    }








    function assignaRol(idempleat,idrol)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaRol&idemp=" + idempleat + "&idrol=" + idrol, true);
            xmlhttp.send();
    }
    function editaResp(idempleat,idresp)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modResps").innerHTML = this.responseText;
                $modal = $('#modResps');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalResps.php?id=" + idempleat + "&idresp=" + idresp, true);
            xmlhttp.send();
    }
    function editaHoresAny(idempleat,any)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modDpts").innerHTML = this.responseText;
                $modal = $('#modDpts');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModEditaHoresAny.php?1=" + idempleat +"&2="+any , true);
            xmlhttp.send();
    }
    function editaContrasenya(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modAdminPass").innerHTML = this.responseText;
                $modal = $('#modAdminPass');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalAdminPass.php?id=" + idempleat, true);
            xmlhttp.send();
    }
    function assignaContrasenya(idempleat,pwd1,pwd2)
    {
        if(pwd1 != pwd2) return false;
        actualitzaCampTaula('empleat','contrasenya',idempleat,null,pwd2)
    }
    function editaFoto(idempleat)
    {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modAdminFoto").innerHTML = this.responseText;
                $modal = $('#modAdminFoto');
                $modal.modal('show');
            }
            };
            xmlhttp.open("GET", "ModalUpload.php?id=" + idempleat +"&type=fotoempleat", true);
            xmlhttp.send();
    }
    function popuphtml(innerhtml)
        {
            document.getElementById("msgConsole").innerHTML = innerhtml;
            $modal = $('#modConsole');
            $modal.modal('show');
        }



    </script>




</body>
    </html>
