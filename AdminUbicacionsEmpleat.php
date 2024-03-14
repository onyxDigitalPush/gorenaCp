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





        .btn-supersmall {
            padding: 4px 6px; /* Ajusta el espaciado para botones pequeños */
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


    </head>
    <body class="well">
        <?php
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

$id = $_GET["id"];
$anys = $dto->mostraAnysContractePerId($id);
$d = strtotime("now");
if (!isset($_GET["any"])) {
    $_GET["any"] = date("Y", $d);
}

$any = $_GET["any"];
?>
        <center>
            <br><br>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="col-lg-4" style="text-align: left"><h3 class=""><?php echo $dto->__($lng, "Ubicacions i Festius"); ?></h3></div>
                <div class="col-lg-4" style="text-align: center"><h3 class=""><?php echo $dto->mostraNomEmpPerId($id); ?></h3></div>
                <div class="col-lg-4" style="text-align: right">
                    <form method="get">
                    <button type="submit" formaction="AdminFitxaEmpleat.php" class="btn-neutro" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Fitxa"); ?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button type="submit" formaction="AdminHorarisEmpleat.php" class="btn-blue" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Calendari"); ?>"><span class="glyphicon glyphicon-calendar"></span></button>
                    <button type="submit" formaction="AdminMarcatgesEmpleat.php" class="btn-next" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Marcatges"); ?>"><span class="glyphicon glyphicon-zoom-in"></span></button>
                    <button type="submit" formaction="AdminPersones.php" class="btn-neutro" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng, "Persones"); ?>"><span class="glyphicon glyphicon-eject"></span></button>
                </form>
                </div>
            </div>
        </div>
        <hr width="90%">
        <br><br>
        <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section style="width:40%; float:left; ">
            <br>
            <h4 class=""><?php echo $dto->__($lng, "Ubicacions Actuals"); ?></h4><br><br>
            <div>
            <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Ubicació"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Des de"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Fins a"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
$data = date('Y-m-d', $d);
$ubicacions = $dto->seleccionaUbicacionsEmpPerIdDia($id, $data);
foreach ($ubicacions as $lloc) {
    $datafi = "";
    if (!empty($lloc["datafi"])) {
        $datafi = date('d/m/Y', strtotime($lloc["datafi"]));
    }

    echo '<tr>';
    echo '<td>' . $lloc["nom"] . '</td>';
    echo '<td>' . date('d/m/Y', strtotime($lloc["datainici"])) . '</td>';
    echo '<td>' . $datafi . '</td>';
    echo '<td><button type="button" class="btn-neutro btn-supersmall" title="' . $dto->__($lng, "Veure Festius") . '" onclick="mostraFestius(' . $lloc["idlocalitzacio"] . ')">'
        . '<span class="glyphicon glyphicon-zoom-in"></span></button></td>';
    echo '</tr>';
}
?>
                        </tbody>
                    </table>
                </div><br>
                <button class="btn-green btn-small" data-toggle="modal" data-target="#modAssignaUbicacio"><span class="glyphicon glyphicon-plus"></span> <?php echo $dto->__($lng, "Nova Ubicació"); ?></button>
                <br><br>
                <h4 class=""><?php echo $dto->__($lng, "Històric d'Ubicacions"); ?></h4><br><br>
            <div>
            <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Ubicació"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Des de"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Fins a"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
$historic = $dto->seleccionaTotesUbicacionsEmpPerId($id);
foreach ($historic as $lloc) {
    $datafi = "";
    if (!empty($lloc["datafi"])) {
        $datafi = date('d/m/Y', strtotime($lloc["datafi"]));
    }

    echo '<tr>';
    echo '<td>' . $lloc["nom"] . '</td>';
    echo '<td>' . date('d/m/Y', strtotime($lloc["datainici"])) . '</td>';
    echo '<td>' . $datafi . '</td>';
    echo '<td>'
    . '<button type="button" class="btn-neutro btn-supersmall" title="' . $dto->__($lng, "Veure Festius") . '" onclick="mostraFestius(' . $lloc["idlocalitzacio"] . ')">'
    . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
    . '<a class="btn-next btn-supersmall" title="' . $dto->__($lng, "Edita Període") . '" onclick="mostraPeriodeUbicacio(' . $lloc["idsituat"] . ',' . $lloc["idlocalitzacio"] . ',' . strtotime($lloc["datainici"]) . ',' . strtotime($lloc["datafi"]) . ');">'
    . '<span class="glyphicon glyphicon-pencil"></span></a>'
    . '<a class="btn-red btn-supersmall" onclick="confElimPeriodeUbicacio(' . $lloc["idsituat"] . ',' . "'" . $dto->mostraNomUbicacio($lloc["idlocalitzacio"]) . "'" . ');"><span class="glyphicon glyphicon-remove" style="color:red" title="' . $dto->__($lng, "Elimina Període") . '"></span></a>';
    echo '</td></tr>';
}
?>
                        </tbody>
                    </table>
                </div><br>
        </section>
            <section style="width:50%; float:right">
                    <form action="AdminUbicacionsEmpleat.php" method="GET">
                        <h4 class=""><?php echo $dto->__($lng, "Festius"); ?> <?php echo $dto->__($lng, "Any"); ?>
                        <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                        <option hidden selected value><?php echo $any; ?></option>
                        <?php
foreach ($anys as $year) {
    echo '<option value:"' . $year . '">' . $year . '</option>';
}
?>
                        </select>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"></h4>
                    </form><br>
                <center>
                <table class="table table-condensed table-striped table-hover" style="text-align: center;">
                        <thead>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Dia"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Mes"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Descripció"); ?></th>
                        <th style="text-align: center; background-color: #FDFDFD; color: black; font-size:medium;"><?php echo $dto->__($lng, "Ubicació"); ?></th>
                        </thead>
                        <tbody style="background-color: white">
                            <?php
$festius = $dto->seleccionaFestiusEmpPerIdAny($id, $any);
foreach ($festius as $festa) {
    echo '<tr>';
    echo '<td>' . $festa["dia"] . '</td>';
    echo '<td>' . $dto->__($lng, $dto->mostraNomMes($festa["mes"])) . '</td>';
    echo '<td>' . $festa["descripcio"] . '</td>';
    echo '<td>' . $festa["nom"] . '</td>';
    echo '</tr>';
}
?>
                        </tbody>
                    </table>
                </center>
            </section>
        </div>
        </div>
        </center>





      <!--INICIO MODALES-->
    <div class="modal fade" id="modAssignaUbicacio" role="dialog">
            <center>
            <div class="modal-dialog glassmorphism">
              <div class="modal-content glassmorphism">

                <div class="modal-body">
                <h3><?php echo "Asignar Ubicación" ?></h3>
                    <h4><?php echo $dto->__($lng, "Assignar Nova Ubicació per a"); ?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id); ?></h3><br>
                    <form name="assignaubicacio">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label><?php echo $dto->__($lng, "Data Inici"); ?>:</label><input type="date" name="datainici" required>
                    <label><?php echo $dto->__($lng, "Data Fi"); ?>:</label><input type="date" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng, "Ubicació"); ?>:</label>
                    <select name="idnovaubicacio">
                    <?php
$localitzacio = $dto->seleccionaUbicacionsPerIdEmpresa($_SESSION["idempresa"]);
foreach ($localitzacio as $lloc) {
    echo '<option value="' . $lloc["idlocalitzacio"] . '">' . $lloc["nom"] . '</option>';
}
?>
                    </select>
                    <br><br>
                    </div>
                  <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="assignaUbicacio(<?php echo $id; ?>,assignaubicacio.idnovaubicacio.value,assignaubicacio.datainici.value,assignaubicacio.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Assignar"); ?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modFestius"></div>
    <div class="modal fade" id="modEditaPeriodeUbicacio" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism"><h3 style="color: white;"><?php echo "Editar Periodo de Ubicación" ?></h3></div>
                <div class="modal-body">
                    <h4><?php echo "Editar Período de Ubicación Persona" ?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id); ?></h3><br>
                    <form name="editaperiodeubicacio">
                    <input type="hidden" id="idsituat" name="idsituat">
                    <label><?php echo $dto->__($lng, "Data Inici"); ?>:</label><input type="date" id="datainici" name="datainici" required>
                    <label><?php echo $dto->__($lng, "Data Fi"); ?>:</label><input type="date" id="datafi" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng, "Ubicació"); ?>:</label>
                    <select id="idubicacio" name="idubicacio">
                    <?php
$tipus = $dto->seleccionaUbicacionsPerIdEmpresa($_SESSION["idempresa"]);
foreach ($tipus as $valor) {
    echo '<option value="' . $valor["idlocalitzacio"] . '">' . $valor["nom"] . '</option>';
}
?>
                    </select>
                    <br><br>
                    </div>
                  <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="editaPeriodeUbicacio(editaperiodeubicacio.idsituat.value,editaperiodeubicacio.idubicacio.value,editaperiodeubicacio.datainici.value,editaperiodeubicacio.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Modificar"); ?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimPeriodeUbicacio" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism"><h3 style="color:white;"><?php echo "Eliminar Período de Ubicación" ?></h3></div>
                <div class="modal-body">

                    <h4 style="color:white;"><?php echo "¿Está seguro de eliminar este período de ubicación en "; ?> <span id="nomubicacioaelim"></span></h4>
                    <br><br>
                    <form name="eliminaperiodeubicacio">
                    <input type="hidden" id="idubicacioaelim" name="idubicacioaelim">
                    </div>
                  <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar"); ?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="eliminaPeriodeUbicacio(eliminaperiodeubicacio.idubicacioaelim.value);"><span class="glyphicon glyphicon-trash"></span> <?php echo $dto->__($lng, "Eliminar"); ?></button>
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
                    <label id="msgConsole"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng, "Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
    </div>

 <!--FINALIZACIÓN MODALES-->




    <script>
        function assignaUbicacio(id,idubicacio,datainici,datafi)
        {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaUbicacio&id=" + id + "&idubicacio=" + idubicacio + "&datainici=" + datainici + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
        function mostraPeriodeUbicacio(idsituat,idubicacio,dataini,datafi)
        {
        $('#datainici').val(dataString(dataini));
        $('#datafi').val(dataString(datafi));
        $('#idsituat').val(idsituat);
        $('#idubicacio').val(idubicacio);
        $modal = $('#modEditaPeriodeUbicacio');
        $modal.modal('show');
        }
        function dataString(strtotime)
        {
        var data = new Date(strtotime*1000);
        var mm = data.getMonth()+1;
        var dd = data.getDate();
        return data.getFullYear()+"-"+(mm<10 ? '0' : '')+mm+"-"+(dd<10 ? '0' : '')+dd;
        }
        function editaPeriodeUbicacio(idsituat,idubicacio,novadataini,novadatafi)
        {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=editaPeriodeUbicacio&idsituat=" + idsituat + "&idubicacio=" + idubicacio + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
            xmlhttp.send();
        }
        function confElimPeriodeUbicacio(idsituat,nomubicacio)
        {

        document.getElementById("nomubicacioaelim").innerHTML = nomubicacio+"?";
        $('#idubicacioaelim').val(idsituat);
        $modal = $('#modConfElimPeriodeUbicacio');
        $modal.modal('show');
        }

        function eliminaPeriodeUbicacio(idsituat)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaPeriodeUbicacio&idsituat=" + idsituat, true);
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
