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
<div class="modal fade" id="modLogo"></div>
<div class="modal fade" id="modContent"></div>
<div class="modal fade" id="modContentAux"></div>
<div class="modal fade" id="modFlash"></div>
<?php
$lng = 0;
if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
$id = $_GET["id"];
	$idsubemp = $_GET['idsubemp'];
$idempresa=$_SESSION["idempresa"];
$diesnat = $dto->getCampPerIdCampTaula("empresa",$idempresa,"comptadiesnatvac");
$anys = $dto->mostraAnysContractePerId($id);
$d = strtotime("now");
if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
$any = $_GET["any"];
$diesespecials1s = array_fill(0,11,0);
$diesespecials2s = array_fill(0,11,0);
$diesespecialsmes1s = array_fill(0,11,0);
$diesespecialsmes2s = array_fill(0,11,0);
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
foreach($rspers as $rp)
{
    if(($i==0)&&($id!=$rp["idempleat"])) {$idpersant=$rp["idempleat"];}
    if(($i>0)&&($id==$rp["idempleat"])) {$persant='<button class="btn btn-default btn-lg" name="id" value="'.$idpersant.'" formaction="AdminHorarisEmpleat.php" title="'.$dto->__($lng,"Anterior").'"><span class="glyphicon glyphicon-arrow-left"></span></button>';}
    else{$idpersant=$rp["idempleat"];}
    $persopt.='<option value="'.$rp["idempleat"].'">'.$rp["cognom1"].' '.$rp["cognom2"].' '.$rp["nom"].'</option>';
    if($chkpers==1) {$persseg='<button class="btn btn-default btn-lg" name="id" value="'.$rp["idempleat"].'" formaction="AdminHorarisEmpleat.php" title="'.$dto->__($lng,"Següent").'"><span class="glyphicon glyphicon-arrow-right"></span></button>';$chkpers=0;}
    if(($id==$rp["idempleat"])) {$chkpers=1;}
    $i++;
}
?>





<?php

//--------END UPLOAD
$res = $dto->seleccionaEmpPerId($id);
$rutafoto = "";

?>


<center>



    <div class="row">
        <div class="col-lg-12 ">



            <div class="col-lg-2" style="text-align: center">
                <form method="get" action="AdminHorarisEmpleat.php">
                    <h3 style="text-align: center; margin-top: 0px">
                        <div class="custom-select-container">
                            <select id="sizesel" class="custom-select" name="id" onchange="this.form.submit();" title="<?php echo $dto->__($lng,"Seleccionar Empleat");?>">
                                <option id="optself" hidden selected><?php echo $dto->__($lng,"Seleccionar Persona");?></option>
                                <?php echo $persopt?>
                            </select>
                            <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                        </div>
                    </h3>
                </form>
            </div>

            <div class="col-lg-8"></div>
            <div class="col-lg-2" style="text-align: right">
                <form method="get">

                    <?php echo $persant;?> <?php echo $persseg;?>

                </form>
            </div>
        </div>
    </div></center>
<hr width="90%">






<!--br-->

<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-4" style="text-align: left">
            <form action="AdminHorarisEmpleat.php" method="GET">
                <h2 class=""><?php echo $dto->__($lng,"Calendari Anual"); ?>

                    <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                        <option hidden selected value><?php echo $any; ?></option>
                        <?php
                        $toyear = date('Y',strtotime('today'));
                        for($year=2017;$year<=($toyear+1);$year++)

                        {
                            echo '<option value:"'.$year.'">'.$year.'</option>';
                        }

                        ?>
                    </select></h2>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form>
        </div>



        <div class="col-lg-3">
            <div style="text-align: center"> <h2 class=""><?php echo $dto->mostraNomEmpPerId($id);?>  </h2><br>
                <label class=""><?php echo $dto->__($lng,"Hores")." ".$dto->__($lng,"Teòriques")." ".$dto->__($lng,"any")." "."2023";?>:</label> <strong> <?php echo $dto->seleccionaHoresTeoriques($id,$any); ?> </strong><br>

                <?php
                foreach ($res as $fitxa)
                {
                    $rutafoto = $fitxa["rutafoto"];} ?>
                <img src="<?php echo $rutafoto; ?>" alt="<?php echo $dto->__($lng, "Foto"); ?>" style="height: 150px; width: 120px; border: solid 1px; border-radius: 50%;">
            </div>
        </div>




        <form method="get" class="text-right">
            <button type="submit" formaction="AdminMarcatgesEmpleat.php" class="btn-next" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Veure els marcatges de l'usuari");?>"><span class="glyphicon glyphicon-zoom-in"></span></button>

            <button type="submit" formaction="AdminFitxaEmpleat.php" class="btn-neutro" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Fitxa");?>"><span class="glyphicon glyphicon-user"></span></button>


            <button type="submit" class="btn-neutro" formaction='AdminPersones.php' name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Tornar a la llista de persones");?>"><span class="glyphicon glyphicon-eject"></span></button>


            <button type="submit" formaction="AdminUbicacionsEmpleat.php" class="btn-blue" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Gestionar Ubicacions");?>"><span class="glyphicon glyphicon-map-marker"></span> </button>


            <form method="get" action="process_correo_user.php">
                <!-- Suponemos que $id contiene el ID del empleado -->
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <button formaction="process_correo_user.php" type="submit" class="btn-red" name="submit" title="Enviar información de usuario y contraseña a empleado">
                    <span class="glyphicon glyphicon-lock"></span>
                </button>
            </form>


        </form>



        </h2>
    </div>

</div>
<br><br>


<?php
//DATA PARA CALENDARIO
$data = $dto->monthlyEmployeeCalendar($id,$any,$i,16.66,$lng);
$exception_days = $data['exception_days'];
$months = $data['months'];
?>


<div class="container" style="min-width: 1200px;">
    <?php $dto->paintCalendarMonth(1, $months[1], $lng);?>
    <?php $dto->paintCalendarMonth(2, $months[2], $lng);?>
    <?php $dto->paintCalendarMonth(3, $months[3], $lng);?>
    <?php $dto->paintCalendarMonth(4, $months[4], $lng);?>
</div><br>


<div class="container" style="min-width: 1200px;">
    <?php $dto->paintCalendarMonth(5, $months[5], $lng);?>
    <?php $dto->paintCalendarMonth(6, $months[6], $lng);?>
    <?php $dto->paintCalendarMonth(7, $months[7], $lng);?>
    <?php $dto->paintCalendarMonth(8, $months[8], $lng);?>
</div><br>


<div class="container" style="min-width: 1200px;">
    <?php $dto->paintCalendarMonth(9, $months[9], $lng);?>
    <?php $dto->paintCalendarMonth(10, $months[10], $lng);?>
    <?php $dto->paintCalendarMonth(11, $months[11], $lng);?>
    <?php $dto->paintCalendarMonth(12, $months[12], $lng);?>
</div><br>




</div>
</div>
<br><br>
<center>
    <?php foreach ($exception_days as $exception_day)
    {
        echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb('.$exception_day['rgb'].');"></span> '.$dto->__($lng,'Dies de ' .$exception_day['type_excepcio']  .' any').' '.$any.' (1S: '.$exception_day['semester1'].' / 2S: '.$exception_day['semester2'].') Total: '.$exception_day['count_days'].'</label><br>';
    }?>
    <br>
    <br>
</center>
<div class="container" style="min-width: 1100px">
    <section style="width:50%; float:left; ">
        <center>
            <h4 class=""><?php echo $dto->__($lng,"Històric d'Horaris");?>:  <a href= "" class="btn-green" style="color: black; margin-left: 20px;" data-toggle="modal" data-target="#modAssignaNouHorariTipus"><span class="glyphicon glyphicon-plus"></span> </a></h4>



            <br><br>
            <div>
                <table class="table table-striped table-hover table-condensed" style="text-align: center">
                    <thead>
                    <th style="text-align: center; background-color:#f5f5f5 ; color: black;"><?php echo $dto->__($lng,"Inici");?></th>
                    <th style="text-align: center; background-color:#f5f5f5 ; color: black;"><?php echo $dto->__($lng,"Final");?></th>
                    <th style="text-align: center; background-color:#f5f5f5 ; color: black;"><?php echo $dto->__($lng,"Hr/St");?></th>
                    <th style="text-align: center; background-color:#f5f5f5 ; color: black;"><?php echo $dto->__($lng,"Tipus");?></th>
                    <th style="text-align: center; background-color:#f5f5f5 ; color: black;"><?php echo $dto->__($lng,"Vigent");?></th>
                    <th style="text-align: center; background-color:#f5f5f5 ;"></th>
                    </thead>
                    <tbody>
                    <?php
                    $horari = $dto->seleccionaHorarisEmpPerIdEmpleat($id,$any);
                    foreach($horari as $period)
                    {
                        $datafi = "";
                        if(!empty($period["datafi"])) $datafi = date('d/m/Y',strtotime($period["datafi"]));
                        echo '<tr>';
                        echo '<td>'.date('d/m/Y',strtotime($period["datainici"])).'</td>';
                        echo '<td>'.$datafi.'</td>';
                        echo '<td>'.$period["horesetmana"].'</td>';
                        echo '<td>'.$period["nom"].'</td>';
                        echo '<td>'.$dto->__($lng,$dto->dirsiono($period["actiu"])).'</td>';
                        echo '<td>'
                            . '<button type="button" class="btn-neutro btn-supersmall" title="'.$dto->__($lng,"Veure Torns").'" onclick="mostraTorns('.$id.','.$period["idhorari"].')">'
                            . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
                            . '<button class="btn-next btn-supersmall" type="button" title="'.$dto->__($lng,"Edita Període").'" onclick="mostraPeriodeHorari('.$period["idquadrant"].','.$period["idhorari"].','.strtotime($period["datainici"]).','.strtotime($period["datafi"]).');">'
                            . '<span class="glyphicon glyphicon-pencil"></span></button>'
                            . '<button type="button" class="btn-red btn-supersmall" onclick="confElimPeriodeHorari('.$period["idquadrant"].','."'".$period["nom"]."'".');"><span class="glyphicon glyphicon-remove" style="color:red" title="'.$dto->__($lng,"Elimina Període").'"></span></button>';

                        echo '</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div><br>

        </center>
    </section>
    <section style="width:45%; float:right">
        <center>
            <h4 class=""><?php echo $dto->__($lng,"Períodes Especials");?>: <a style="color: black; margin-left: 20px;" class="btn-green" data-toggle="modal" data-target="#modAssignaNouPeriodeEspecial"><span class="glyphicon glyphicon-plus"></span> </a></h4><br><br>
            <div >
                <table class="table" style="text-align: center">
                    <thead>
                    <th style="background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng,"Inici");?></th>
                    <th style="text-align: center; background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng,"Final");?></th>
                    <th style="text-align: center; background-color: #f5f5f5; color: black;"><?php echo $dto->__($lng,"Tipus");?></th>
                    <th style="text-align: center; background-color: #f5f5f5; color: black;"></th>
                    </thead>
                            <tbody>
                            <?php
                            $excepcions = $dto->seleccionaExcepcionsEmpPerIdHorariEmpleat($id,$any);
                            foreach($excepcions as $periode)
                            {
                                $tipus = $periode["nom"];
                                $inicial = substr($periode["nom"],0,4);
                                $datafi = "";
                                if(strtotime($periode["datafinal"])>=strtotime($periode["datainici"])) $datafi = date('d/m/Y',strtotime($periode["datafinal"]));
								
								
								// Verifica si se encontraron colores en la base de datos
                                if ($periode['r'] !== null && $periode['g'] !== null && $periode['b'] !== null) {
                                    $color = "rgb(" . $periode['r'] . ", " . $periode['g'] . ", " . $periode['b'] . ")";
                                } else {
                                    // Si no se encuentra el color en la base de datos, utiliza un color predeterminado
                                    $color = "rgb(255, 255, 255)";
                                }

                                echo '<tr style="background-color: ' . $color . '">';

								
								/*
                                if($tipus=="Vacaciones") echo '<tr style="background-color: rgb(128,255,255)">';
                                else if($inicial=="Baja") echo '<tr style="background-color: rgb(255,128,128)">';
                                else if(($inicial=="Perm")||($inicial=="Exc")||($inicial=="Abs")) echo '<tr style="background-color: rgb(128,255,128)">';
                                else if(($inicial=="Asun")||($inicial=="Mal")) echo '<tr style="background-color: rgb(255,255,128)">';
                                else if($inicial=="Visi") echo '<tr style="background-color: rgb(230,51,255)">';
                                else if($inicial=="Hosp") echo '<tr style="background-color: rgb(227,134,16)">';
                                else if($inicial=="Camb") echo '<tr style="background-color: rgb(218,247,166)">';
                                else if($inicial=="Hosp") echo '<tr style="background-color: rgb(227,134,16)">';
                                else if($inicial=="Debe") echo '<tr style="background-color: rgb(66,183,227)">';
                                else if($inicial=="Mate") echo '<tr style="background-color: rgb(66,227,198)">';
                                else if($inicial=="Defu") echo '<tr style="background-color: rgb(222,188,70)">';
                                else echo '<tr>';
								*/
								
                                echo '<td>'.date('d/m/Y',strtotime($periode["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td id="nomexcep'.$periode["idexcepcio"].'">'.$dto->__($lng,$tipus).'</td>';
                                echo '<td style="background-color: rgb(255,255,255)"><button class="btn btn-xs btn-default" onclick="mostraExcep('.$periode["idexcepcio"].','.$periode["idtipusexcep"].",'".$periode["datainici"]."','".$periode["datafinal"]."'".');">';//." 12:00:00"
                                echo '<span class="glyphicon glyphicon-pencil" style="color:black" title="'.$dto->__($lng,"Edita Període").'"></span></button>';
                                echo '<button class="btn btn-xs btn-default" onclick="confElimExcep('.$periode["idexcepcio"].');"><span class="glyphicon glyphicon-remove" style="color:red" title="'.$dto->__($lng,"Elimina Període").'"></span></button></td>';
                                echo '</tr>';
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>

            <br>

                </center>
            </section>
        </div>

        <br><br>

        <div class="modal fade" id="modTorns" role="dialog">

</div>
        <div class="modal fade" id="modAssignaNouHorariTipus" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="glassmorphism"><h3 style="color:white;"><?php echo "Asignar Nuevo Horario para"?></h3></div>
                <div class="modal-body">
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="assignahoraritipus">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="datainici" required>
                        <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi"><br><br>
                        <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                        <select name="idnouhorari">
                            <?php
                            $tipus = $dto->seleccionaHorarisActiusEmpresa($idempresa);
                            foreach($tipus as $valor)
                            {
                                echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                            }
                            ?>
                        </select>
                        <br><br>
                </div>
                <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="assignaHorariTipus(<?php echo $id; ?>,assignahoraritipus.idnouhorari.value,assignahoraritipus.datainici.value,assignahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Assignar");?></button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
        <div class="modal fade" id="modEditaPeriodeHorariTipus" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="glassmorphism"><h3 style="color:white;"><?php echo "Editar Período Horario para"?></h3></div>
                <div class="modal-body">
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editahoraritipus">
                        <input type="hidden" id="idquadrant" name="idquadrant">
                        <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainici" name="datainici" required>
                        <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafi" name="datafi"><br><br>
                        <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                        <select id="idnouhorari" name="idnouhorari">
                            <?php
                            $tipus = $dto->seleccionaTipusHoraris($idempresa);
                            foreach($tipus as $valor)
                            {
                                echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                            }
                            ?>
                        </select>
                        <br><br>
                </div>
                <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="editaPeriodeHorari(editahoraritipus.idquadrant.value,editahoraritipus.idnouhorari.value,editahoraritipus.datainici.value,editahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
        <div class="modal fade" id="modAssignaNouPeriodeEspecial" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="glassmorphism"><h3 style="color:white;"><?php echo "Registrar Nuevo Período Especial"?></h3></div>
                <div class="modal-body">
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="assignaexcep">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="datainici" required>
                        <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi"><br><br>
                        <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                        <select name="idtipusexcep">
                            <?php
                            $tipus = $dto->seleccionaTipusExcepcions();
                            foreach($tipus as $valor)
                            {
                                echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                            }
                            ?>
                        </select>
                        <br><br>
                </div>
                <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="assignaExcep(<?php echo $id; ?>,assignaexcep.idtipusexcep.value,assignaexcep.datainici.value,assignaexcep.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
        <div class="modal fade" id="modConfElimPeriodeHorari" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="modal-glassmorphism"><h3 style="color:white;"><?php echo "Eliminar Período Horario"?></h3></div>
                <div class="modal-body">
                    <h4><?php echo "¿Está seguro de eliminar este período horario de "?> <span id="tipushorariaelim"></span></h4>
                    <br><br>
                    <form name="eliminaperiodehorari">
                        <input type="hidden" id="idhorariaelim" name="idhorariaelim">
                </div>
                <div class="">
                    <button type="button" class="btn_modal" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn_modal" data-toggle="modal" onclick="eliminaPeriodeHorari(eliminaperiodehorari.idhorariaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
            </div>
        </div>

    </center>
</div>
        <div class="modal fade" id="modExcep" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Editar Període Especial per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editaexcep">
                        <input type="hidden" id="idExcep" name="idExcep">
                        <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcep">
                        <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcep"><br><br>
                        <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                        <select id="tipusExcep" name="tipusExcep">
                            <?php
                            $tipus = $dto->seleccionaTipusExcepcions();
                            foreach($tipus as $valor)
                            {
                                echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                            }
                            ?>
                        </select>
                        <br><br><button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                        <button type="button" class="btn_modal" data-toggle="modal" onclick="editaExcep(editaexcep.idExcep.value,editaexcep.tipusExcep.value,editaexcep.datainiexcep.value,editaexcep.datafiexcep.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
        <div class="modal fade" id="modConfElimExcep" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Eliminar Període Especial");?></h3><br>
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar aquest període especial de");?> <span id="tipusexcepaelim"></span></h4>
                    <br><br>
                    <form name="eliminaexcep">
                        <input type="hidden" id="idexcepaelim" name="idexcepaelim">
                        <button type="button" class="btn_modal" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                        <button type="button" class="btn_modal" data-toggle="modal" onclick="eliminaExcep(eliminaexcep.idexcepaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
            </div>
        </div>

    </center>
</div>
        <div class="modal fade" id="modConsole" role="dialog">
    <center>
        <div class="modal-dialog glassmorphism">
            <div class="modal-content glassmorphism">
                <div class="modal-body">
                    <label id="msgConsole"></label><br><br>
                    <button type="button" class="btn_modal" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>
                </div>
            </div>
        </div>
    </center>
</div>
        <div class="modal fade" id="modAdminFoto"></div>




    <script type="text/javascript">
    function mostraTorns(id,idhorari)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modTorns").innerHTML = this.responseText;
                $modal = $('#modTorns');
                $modal.modal('show');
            }
        };
        xmlhttp.open("GET", "ModalTorns.php?id=" + id + "&idhorari=" + idhorari, true);
        xmlhttp.send();
    }

    function assignaHorariTipus(id,idtipus,datainici,datafi)
    {
		 if (datainici === "" || datafi === "") {
        alert("Por favor, completa las fechas.");
        return; // Detiene la función si las fechas no están completas
    }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
        };
        xmlhttp.open("GET", "Serveis.php?action=assignaHorariTipus&id=" + id + "&idtipus=" + idtipus + "&datainici=" + datainici + "&datafi=" + datafi, true);
        xmlhttp.send();
    }

    function editaPeriodeHorari(idquadrant,idtipus,novadataini,novadatafi)
    {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
        };
        xmlhttp.open("GET", "Serveis.php?action=editaPeriodeHorari&idquadrant=" + idquadrant + "&idtipus=" + idtipus + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
        xmlhttp.send();
    }

    function dataString(strtotime)
    {
        var data = new Date(strtotime*1000);
        var mm = data.getMonth()+1;
        var dd = data.getDate();
        return data.getFullYear()+"-"+(mm<10 ? '0' : '')+mm+"-"+(dd<10 ? '0' : '')+dd;
    }

    function mostraPeriodeHorari(idquadrant,idtipus,dataini,datafi)
    {
        $('#datainici').val(dataString(dataini));
        $('#datafi').val(dataString(datafi));
        $('#idnouhorari').val(idtipus);
        $('#idquadrant').val(idquadrant);
        $modal = $('#modEditaPeriodeHorariTipus');
        $modal.modal('show');
    }

    function confElimPeriodeHorari(idquadrant,nomhorari)
    {

        document.getElementById("tipushorariaelim").innerHTML = nomhorari+"?";
        $('#idhorariaelim').val(idquadrant);
        $modal = $('#modConfElimPeriodeHorari');
        $modal.modal('show');
    }

    function eliminaPeriodeHorari(idquadrant)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
        };
        xmlhttp.open("GET", "Serveis.php?action=eliminaPeriodeHorari&idquadrant=" + idquadrant, true);
        xmlhttp.send();
    }

    function popuphtml(innerhtml)
    {
        document.getElementById("msgConsole").innerHTML = innerhtml;
        $modal = $('#modConsole');
        $modal.modal('show');
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

</script>

    </body>
</html>
