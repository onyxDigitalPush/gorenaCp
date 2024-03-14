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
    
    <body class="" >    
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                    </div>
                  </div>
                </div>                
                </center>
        </div>
     
    <div id="content" style="display: table-row; width: 100%; float: right; text-align: center; top: 62px; bottom: 0px; overflow-x: hidden; overflow-y: auto; margin-top: 0px; background-size: cover">
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = $_SESSION["idempresa"];
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
        $mes = $_GET["mes"];
        if(!isset($_GET["dpt"]))$_GET["dpt"]="Tots";
        $dpt = $_GET["dpt"];
        if(!isset($_GET["rol"]))$_GET["rol"]="Tots";
        $rol = $_GET["rol"];
        $idsubempdef = 0;
        $rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa='.$idempresa.' limit 1');
        foreach($rssbe as $se) {$idsubempdef = $se["idsubempresa"];}
        if(!isset($_GET["idsubemp"])){
            if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
            else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
            else $_GET["idsubemp"]=$idsubempdef;//"Totes";
        }        
        $idsubemp = $_GET["idsubemp"];
        $_SESSION["filtidsubempq"] = $idsubemp;
        
        if(!isset($_GET["tipusexcep"]))$tipusexcep="Tots";        
        else if($_GET["tipusexcep"]!="Tots")$tipusexcep = $dto->mostraNomExcep($_GET["tipusexcep"]);
        else $tipusexcep=$_GET["tipusexcep"];
        $anys = $dto->mostraAnysMarcatges();
        ?>
    <center>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-3">
                    <h3 class=""><?php echo $dto->__($lng,"Quadrant Mensual"); ?> <button class="btn-green" onclick="mostraNouPeriodeQuadrant(<?php echo $any.",".$mes.",'".$dpt."','".$rol."','".$idsubemp."',".$idempresa;?>);" title="<?php echo $dto->__($lng,"Introduir període especial per a una persona del quadrant");?>"><span class="glyphicon glyphicon-plus"></span></button>
                    <button class="btn-blue" onclick="mostraCarregaQuadrantMes(<?php echo $any.",".$mes.",".$idsubemp;?>);" title="<?php echo $dto->__($lng,"Importar Quadrant via Excel");?>"><span class="glyphicon glyphicon-import"></span></button>
                    <button class="btn-red" onclick="mostraIntercanviTorns(<?php echo $any.",".$mes.",'".$dpt."','".$rol."','".$idsubemp."',".$idempresa.",1";?>);" title="<?php echo $dto->__($lng,"Intercanvi Torn de Rotació");?>"><span class="glyphicon glyphicon-transfer"></span></button>
                    </h3>
                </div>

                
             
                <div class="col-lg-9 text-right">
          <h3 >  <a href="" style="color: black">
                <p  data-toggle="collapse" href="#filtroCollapse" aria-expanded="false" aria-controls="filtroCollapse">
                    Filtrar
                    <i class="filtro-icon fas fa-chevron-down"></i>
                </p>
            </a></h3>
            <div class="collapse" id="filtroCollapse">
                <div class="filtro-content">



                <div id="filtroCollapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filtroHeading">
                    <div class="panel-body">
                <div class="col-lg-2">
                    <form method="GET" action="AdminQuadrants.php">
                        <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                    <?php
                        echo '<select name="idsubemp" onchange="this.form.submit();">
                        <option hidden selected value="'.$idsubemp.'">';
                        if($idsubemp=="Totes") echo $dto->__($lng,$idsubemp);
                        else echo $dto->mostraNomSubempresa($idsubemp);
                        echo '</option><option value="Totes">'.$dto->__($lng,"Totes").'</option>';                        
                        $resemp = $dto->mostraSubempreses($idempresa);
                        foreach ($resemp as $emp)
                        {
                        echo '<option value="'.$emp["idsubempresa"].'">'.$emp["nom"].'</option>';
                        }                        
                        echo '</select>';
                    ?>
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-1">
                </div>
                <div class="col-lg-2">
                    <form action="AdminQuadrants.php" method="GET">
                        <label><?php echo $dto->__($lng,"Perfil"); ?>:</label><br>
                        <select name="rol" onchange="this.form.submit();">
                            <option hidden selected value><?php echo $dto->__($lng,$rol); ?></option>
                            <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                            <?php
                                $resrol = $dto->mostraRolsEmpleat($idempresa);
                                foreach ($resrol as $rl)
                                {
                                echo '<option value="'.$rl["nom"].'">'.$rl["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                
                <div class="col-lg-1"><form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
                    <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                    <?php
                    $toyear = date('Y',strtotime('today'));
                    for($year=2017;$year<=($toyear+1);$year++)
                    
                    {
                        echo '<option value:"'.$year.'">'.$year.'</option>';
                    }
                    
                    ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-1"><form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Mes");?>:</label><br>
                    <select name="mes" id="LlistaMesos" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                    <?php
                    for($month=1;$month<=12;$month++)
                    {
                        echo '<option value="'.$month.'">'.$dto->__($lng,$dto->mostraNomMes($month)).'</option>';//
                    }
                    ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <button class="btn-green" onclick="taulaAExcel('tblquadrant','<?php echo $dto->__($lng,$dto->mostraNomMes($mes));?>','<?php echo $dto->__($lng,"Quadrant")." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?>');" title="<?php echo $dto->__($lng,"Exportar a Excel");?>"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <button class="btn-blue" onclick="printElem('tblquadrant');" title="<?php echo $dto->__($lng,"Imprimir"); ?>"><span class="glyphicon glyphicon-print"></span></button>
                </div>
            </div>
        </div>
                </div>
            </div>
                </div>

        <!br>




        <div class="row" style="padding-left: 10px; padding-right: 10px">
            <div class="col-lg-12 container" id="tblquadrant">
                
                <?php
                    $diesmes = 0;
                    $dia = new DateTime(); 
                    $dia->setISODate($any,0);
                    $undiames = new DateInterval('P1D');
                    while($dia->format('Y')<$any)$dia->add($undiames);
                    while($dia->format('m')<$mes)$dia->add($undiames);
                    for($i=1;(($dia->format('m')==$mes));$i++){$dia->add($undiames);$diesmes++;}
                    $mesant = $mes-1;
                    $anyant = $any;
                    if($mesant<1){$mesant = 12;$anyant=$any-1;}
                    $messeg = $mes+1;
                    $anyseg = $any;
                    if($messeg>12){$messeg=1;$anyseg=$any+1;}
                ?>
        <table class="table table-bordered table-condensed table-hover" style="text-align:center; width: 90%; background-color: white; border-collapse: collapse; border: solid 1px; margin-top: 80px;"><!---->
            <thead>                    
                <tr>
                    <th style="display: none">DNI</th>
                    <th rowspan="0" style="text-align: center; background-color:rgba(29, 79, 180, 0.5)"><?php echo $dto->__($lng,"Persona / Mes"); ?></th>
                    <th colspan="5" style="text-align: center; background-color:rgba(29, 79, 180, 0.5)"  class="noExl">
                        <form action="AdminQuadrants.php" method="GET">
                            <button class="btn-blue" style="background-color:rgba(200, 200, 200, 0.9)" title="Mes Anterior" onclick="this.form.submit()">
                                <span class="glyphicon glyphicon-arrow-left"></span> <strong><?php echo $dto->__($lng,$dto->mostraNomMes($mesant))." ".$anyant; ?></strong>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $mesant; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyant; ?>">
                        </form>
                        </th>
                    <th colspan="<?php echo $diesmes;?>" style="text-align: center; background-color:rgba(29, 79, 180, 0.5)"><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?></th>
                    <th colspan="5" style="text-align: center; background-color:rgba(29, 79, 180, 0.5)" class="noExl">
                        <form action="AdminQuadrants.php" method="GET">
                            <button class="btn-blue" style="background-color:rgba(200, 200, 200, 0.9)" title="Mes Posterior" onclick="this.form.submit()">
                                <strong><?php echo $dto->__($lng,$dto->mostraNomMes($messeg))." ".$anyseg; ?></strong> <span class="glyphicon glyphicon-arrow-right"></span>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $messeg; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyseg; ?>">
                        </form>
                    </th>
                </tr>
                <tr>
                    <?php
                    $calmes = "";                    
                    for($a=0;$a<$diesmes;$a++){$dia->sub($undiames);} 
                    for($b=0;$b<5;$b++){$dia->sub($undiames);} 
                    $arrdatesmes = [];
                    $diaini = intval($dia->format('d'));
                    $zmesant = "";
                    if($mesant<10)$zmesant="0".$mesant; else $zmesant=$mesant;
                    for($i=$diaini;$i<($diaini+5);$i++)
                    {
                        $arrdatesmes[]=$anyant."-".$zmesant."-".$i;
                    }
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        
                            $zmes = "";
                            $zi="";
                            if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                            if($i<10)$zi="0".$i; else $zi=$i;                            
                            $arrdatesmes[]=$any."-".$zmes."-".$zi;
                    }
                    $zmesesg = "";
                    if($messeg<10)$zmesseg="0".$messeg; else $zmesseg=$messeg;
                    for($i=1;$i<=5;$i++)
                    {
                        $arrdatesmes[]=$anyseg."-".$zmesseg."-0".$i;
                    }
                    for($c=0;$c<5;$c++) 
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#13".$dto->__($lng,"Festiu a").": ".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $calmes.= '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    echo '<th style="display: none"></th><th style="display: none"></th>';
                    for($i=1;(($i<=31)&&($dia->format('m')==$mes));$i++)
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#10;".$dto->__($lng,"Festiu a").":".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th rowspan="1" style="cursor: pointer; min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'" onclick="mostraIntercanviTorns('.$any.",".$mes.",'".$dpt."','".$rol."','".$idsubemp."',".$idempresa.','.$dia->format('d').');" >'.$dia->format('d').'</th>';
                        $calmes.= '<th rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    for($d=0;$d<5;$d++) 
                    {
                        try{
                        $bckg = '';
                        $ufestiu = $dto->getFestiuPerEmpresaDia($idempresa,$dia->format('Y-m-d'));
                        if(!empty($ufestiu)) {
                            if(date('w',strtotime($dia->format('Y-m-d')))==0) {$bckg = 'background-color: red;';}
                            else {$bckg = "background-color: rgb(150,50,50);";}
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')))."&#10;".$dto->__($lng,"Festiu a").":".$ufestiu;
                        }
                        else if(date('w',strtotime($dia->format('Y-m-d')))==0) {
                            $bckg = 'background-color: red;';
                            $data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));                            
                        }
                        else {$data = $dto->__($lng,$dto->mostraNomDia($dia->format('w')))." ".date('d/m/Y',strtotime($dia->format('Y-m-d')));}
                        echo '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $calmes.= '<th class="noExl" rowspan="1" style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$dia->format('d').'</th>';
                        $dia->add($undiames);
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                try{
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
                
                $sqlpers = 'select e.idempleat as idempleat, e.cognom1 as cognom1, e.cognom2 as cognom2, e.nom as nomempl, e.dni as dni '
                        . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                        . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0))) order by e.cognom1, e.cognom2, e.nom';//
                
                $sqlsubemp2 = '';
                if($idsubemp!="Totes") $sqlsubemp2 = 'and idsubempresa='.$idsubemp;
                
                $sqlnomrol2 = '';
                if($rol!="Tots") {
                    $sqlnomrol2 = 'and nomrol like "'.$rol.'"';                 
                }
                $sqlemproldpt = 'select * from emproldpt '
                        . 'where idempresa='.$idempresa.' '.$sqlsubemp2.' '.$sqlnomrol2.' and ((enplantilla=1) or ((DATE(datacessat)>"'.$any.'-'.$mes.'-01'.'") and (enplantilla=0)))';
                
                $sesarrpers = [];
                $sesarrpers = $_SESSION["arrpers"];
                
                    $arrdatesrottot =[];
                    $sqlidpersroldpt = 'select idempleat from emproldpt '
                        . 'where idempresa='.$idempresa.' '.$sqlsubemp2.' '.$sqlnomrol2.' and ((enplantilla=1) or ((DATE(datacessat)>"'.$any.'-'.$mes.'-01'.'") and (enplantilla=0)))';//
                    
                    $rsrot = $dto->getDb()->executarConsulta('select idempleat, data, idtipustorn, idrotacio from rotacio where idempleat in ('.$sqlidpersroldpt.') and date(data)>="'.$anyant.'-'.$zmesant.'-'.$diaini.'" and date(data)<="'.$anyseg.'-'.$zmesseg.'-05"');                    
                   
                    $arrpers = [];
                    $arridemp = [];
                    $countpers = 0;                            
                    $i = 0;
                    foreach($arrdatesmes as $dtm){
                        foreach($sesarrpers as $ps){
                            if($i==0){$countpers++;}
                            $idpers = $ps[0];
                            $dayfound = 0;
                            $persfound = 0;
                            $arrrotdia = array_fill(0,4,0);
                            foreach($rsrot as $rot){
                                if($ps[0]==$rot["idempleat"]) {
                                    $persfound = 1;
                                    $arridemp[] = $idpers;
                                    if(($rot["data"]==$dtm)){                                    
                                        $arrotdia[0]=$rot["data"];
                                        $arrotdia[1]=$rot["idtipustorn"];
                                        $arrotdia[2]=$rot["idrotacio"];
                                        $arrotdia[3]=$rot["idempleat"];
                                        $dayfound = 1;
                                    }                 
                                }                                    
                            }
                            if(($dayfound==0)&&($persfound==1)) {
                                $arrotdia[0]=$dtm;
                                $arrotdia[1]=0;
                                $arrotdia[2]=null;
                                $arrotdia[3]=$ps[0];
                            }
                            
                            if($persfound==1) {
                                $arrdatesrottot[]=$arrotdia;
                                
                            }
                        }
                        $i=1;
                    }
                   
                    for($n=0;$n<($countpers);$n++){
                        $fnd = 0;
                        foreach($arridemp as $i){
                            if($sesarrpers[$n][0]==$i){
                                $fnd = 1;
                            }
                        }
                        if(($fnd==0)&&(($sesarrpers[$n][5]!=$idsubemp)||(($rol!="Tots")&&($sesarrpers[$n][6]!=$rol))||(($sesarrpers[$n][7]==0)&&(strtotime($sesarrpers[$n][8])<strtotime($any."-".$zmes."-01"))))){
                            unset($sesarrpers[$n]);
                            array_values($sesarrpers);
                        }
                    }
               
                
                }catch(Exception $ex){echo '<tr><td>'.$ex->getMessage().'</td></tr>';} 
                $prifestius = $dto->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"prifestius");
                $marcafestius = $dto->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"marcafestius");
                $arrempl = [];
                $dispm = array_fill(0,($diesmes+10),0);
                $dispt = array_fill(0,($diesmes+10),0);
                $dispn = array_fill(0,($diesmes+10),0);
                $dispmt = array_fill(0,($diesmes+10),0);
                $disponibles = array_fill(0,($diesmes+10),0);
                
                
                $arrttfrac = [];
                $arrttfrac = $_SESSION["arrttfrac"];
                $arrdatesrot=[];
               
                foreach ($sesarrpers as $em) 
                    {                                        
                    $arrdatesrot=null;
                    echo "<tr>";
                    echo '<td style="display: none">'.$em[4].'</td>';
                    echo '<td style="width:1%; white-space:nowrap; border: solid 1px;"><form method="get" style="display:inline">
                <button type="submit" style="background-color:white; cursor:pointer; width:100%; border: none" formaction="AdminMarcatgesEmpleat.php" name="id" value="'.$em[0].'" title="'.$dto->__($lng,"Veure els marcatges de l'usuari").'"><strong>'.$em[1].' '.$em[2].', '.$em[3].'</strong></button></form></td>';
                    // Crear Sub array respecte al nou arrdatesrottot només per a l'empleat indicat
                    $arrdatesrot = [];
                    foreach($arrdatesrottot as $tot) 
                        {
                        if($tot[3]==$em[0]){
                            $arrdatesrot[]=$tot;}                            
                        }
                    
                    // Imprimir horaris/rotacions dels 5 dies anteriors del mes seleccionat
                    $i=0;
                    for($e=$diaini;$e<($diaini+5);$e++){
                        
                        $i++;
                        $isexcep = 0;
                        $zmesant = "";
                        if($mesant<10)$zmesant="0".$mesant; else $zmesant=$mesant;  
                        $festiu = $dto->esFestiuPerIdDia($em[0],$anyant."-".$zmesant."-".$e);
                        $rota = $arrdatesrot[$i-1][2];                        
                        if(!empty($dto->esExcepcioPerIdDia($em[0],$anyant."-".$zmesant."-".$e))) 
                        {
                            $isexcep = 1;
                            $onclick = "";
                            $excepcio = $dto->esExcepcioPerIdDia($em[0],$anyant."-".$zmesant."-".$e);
                            foreach($excepcio as $excep) 
                            {
                                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                            }
                            if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                            else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                { 
                                echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                                
                                }
                            else echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                        }
                        
                        else if(!empty($rota)) { 
                            $title="";
                            $bckg = "";
                            $color = "";
                            $abr = "";
                            $tt = $arrdatesrot[$i-1][1];
                            foreach($arrttfrac as $ttch){    
                                if($ttch[0]==$tt){
                                $bckg = $ttch[5];
                                $color = $ttch[4];
                                $abr = $ttch[6];
                                $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                }
                            }
                           
                            echo '<td class="noExl" title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                            
                            $disponibles[$i-1]++;
                        }
                            
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td class="noExl" title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyant."-".$zmesant."-".$e."',".');"></td>';
                            }
                            else if(!$dto->treballaria($em[0],$any."-".$zmes."-".$zi)) {
                                echo '<td class="noExl" title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyant."-".$zmesant."-".$e."',".');"></td>';
                            }
                            
                            else {echo '<td class="noExl" title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($em[0],$anyant."-".$zmesant."-".$e,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyant."-".$zmesant."-".$e."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$em[0],"nom"),0,1).'</td>'; 
                           
                            $disponibles[$i-1]++;}
                            if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$i-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} 
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$i-1]+=1;break;
                                case 2: $dispt[$i-1]+=1;break;
                                case 3: $dispn[$i-1]+=1;break;
                                case 4: $dispmt[$i-1]+=1;break; 
                                }
                            }
                    }
                    $i=0;
                   
                    for($e=6;$e<=($diesmes+5);$e++)
                    {
                        $i++;
                        $isexcep = 0;
                        if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                        if($i<10)$zi="0".$i; else $zi=$i;
                        $festiu = $dto->esFestiuPerIdDia($em[0],$any."-".$zmes."-".$zi);
                        $rota = $arrdatesrot[$e-1][2];
                        
                        
                            $festiu = $dto->esFestiuPerIdDia($em[0],$any."-".$zmes."-".$zi);
                            
                            $rota = $arrdatesrot[$e-1][2];
                            
                            if(!empty($dto->esExcepcioPerIdDia($em[0],$any."-".$zmes."-".$zi))) 
                            {
                                $isexcep = 1;
                                $onclick = "";
                                $excepcio = $dto->esExcepcioPerIdDia($em[0],$any."-".$zmes."-".$zi);
                                foreach($excepcio as $excep) 
                                {
                                    $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                                }
                                if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                                else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                    { 
                                    echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                                   
                                    }
                                else echo '<td title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                            }
                            
                            else if(!empty($rota)) { 
                                    $title="";
                                    $bckg = "";
                                    $color = "";
                                    $abr = "";
                                $tt = $arrdatesrot[$e-1][1];
                                
                                foreach($arrttfrac as $ttch){    
                                    if($ttch[0]==$tt){
                                    $bckg = $ttch[5];
                                    $color = $ttch[4];
                                    $abr = $ttch[6];
                                    $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                    }
                                }
                                
                                echo '<td title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                                
                                $disponibles[$e-1]++;
                            }
                            
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$any."-".$zmes."-".$zi."',".');"></td>';
                            }
                            else if(!$dto->treballaria($em[0],$any."-".$zmes."-".$zi)) {
                                echo '<td title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$any."-".$zmes."-".$zi."',".');"></td>';
                            }
                            // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
                            else {echo '<td title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($em[0],$any."-".$zmes."-".$zi,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$any."-".$zmes."-".$zi."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$em[0],"nom"),0,1).'</td>'; 
                            
                            $disponibles[$e-1]++;}
                        
                        if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$e-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} 
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$e-1]+=1;break;
                                case 2: $dispt[$e-1]+=1;break;
                                case 3: $dispn[$e-1]+=1;break;
                                case 4: $dispmt[$e-1]+=1;break;
                            }
                        }
                    }
                    $e=0;
                    // IMPRIMIR ROTACIONS I TORNS DELS 5 DIES DEL MES SEGÜENT AL SELECCIONAT
                    for($f=($diesmes+6);$f<=($diesmes+10);$f++){
                       
                        $e++;
                        $isexcep = 0;
                        $zmesseg="";
                        if($messeg<10)$zmesseg="0".$messeg; else $zmesseg=$messeg;  
                        $festiu = $dto->esFestiuPerIdDia($em[0],$anyseg."-".$zmesseg."-0".$e);
                        $rota = $arrdatesrot[$f-1][2];
                        if(!empty($dto->esExcepcioPerIdDia($em[0],$anyseg."-".$zmesseg."-0".$e))) 
                        {
                            $isexcep = 1;
                            $onclick = "";
                            $excepcio = $dto->esExcepcioPerIdDia($em[0],$anyseg."-".$zmesseg."-0".$e);
                            foreach($excepcio as $excep) 
                            {
                                $onclick = 'onclick="mostraExcep('.$excep["idexcepcio"].','.$excep["idtipusexcep"].",'".$excep["datainici"]."','".$excep["datafinal"]."'".');"';
                            }
                            if ($tipusexcep==$dto->__($lng,"Tots")) echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); cursor: pointer;" '.$onclick.'></td>';
                            else if ($tipusexcep==$dto->__($lng,$excep["nom"]))
                                { 
                                echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                               
                                }
                            else echo '<td class="noExl" title="'.$dto->__($lng,$excep["nom"]).'" style="background-color: rgb('.$excep["r"].','.$excep["g"].','.$excep["b"].'); border: solid 1px; cursor: pointer;" '.$onclick.'></td>';
                        }
                        
                        else if(!empty($rota)) { //BUSCAR A L'ARRAY DE ROTACIONS DE L'EMPLEAT QUE HEM CREAT ABANS
                                $title="";
                                $bckg = "";
                                $color = "";
                                $abr = "";
                            $tt = $arrdatesrot[$f-1][1];
                            foreach($arrttfrac as $ttch){    
                                if($ttch[0]==$tt){
                                $bckg = $ttch[5];
                                $color = $ttch[4];
                                $abr = $ttch[6];
                                $title=''.$dto->__($lng,"Torn").': '.$ttch[7].'&NewLine;'.$dto->__($lng,"Entrada").': '.date('H:i',strtotime($ttch[8])).'&NewLine;'.$dto->__($lng,"Sortida").': '.date('H:i',strtotime($ttch[9])).'&NewLine;'.$dto->__($lng,"Hores").': '.$ttch[10];
                                }
                            }
                            
                            echo '<td class="noExl" title="'.$title.'" style="background-color: '.$bckg.'; color: '.$color.'; border: solid 1px; cursor: pointer" onclick="mostraEditaRotacioDia('.$rota.');">'.$abr.'</td>';
                           
                        $disponibles[$f-1]++;}
                        // Afegir condició per si l'empresa prioritza els festius als horaris regulars    
                            else if(!empty($festiu)) {
                                $bckc = "rgb(150,50,50)";
                                if($marcafestius==0)$bckc = "gainsboro";
                                foreach($festiu as $festa) echo '<td class="noExl" title="'.$festa["descripcio"].'" style="background-color: '.$bckc.'; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyseg."-".$zmesseg."-0".$e."',".');"></td>';
                            }
                            else if(!$dto->treballaria($em[0],$anyseg."-".$zmesseg."-0".$e)) {
                                echo '<td class="noExl" title="No laborable" style="background-color: gainsboro; color: white; border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyseg."-".$zmesseg."-0".$e."',".');"></td>';
                            }
                            // Afegir else if amb la condició per si l'empresa no prioritza els festius als horaris, però es mostren igualment.
                            else {echo '<td class="noExl" title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($em[0],$anyseg."-".$zmesseg."-0".$e,$lng).'" style="border: solid 1px; cursor: pointer" onclick="mostraCreaRotacioDia('.$em[0].",'".$anyseg."-".$zmesseg."-0".$e."',".');">'.substr($dto->getCampPerIdCampTaula("empleat",$em[0],"nom"),0,1).'</td>'; 
                            
                            $disponibles[$f-1]++;}
                            if($isexcep==0){
                            $idtt = 0;
                            $idtt = $arrdatesrot[$f-1][1];
                            $idtf = 0;
                            foreach($arrttfrac as $tfr){
                                if($tfr[0]==$idtt){
                                    if(($tfr[1]==1)&&($tfr[2]==0)&&($tfr[3]==0)) {$idtf=1;}
                                if(($tfr[1]==0)&&($tfr[2]==1)&&($tfr[3]==0)) {$idtf=2;}
                                    if($tfr[3]==1) {$idtf=3;}
                                    if(($tfr[1]==1)&&($tfr[2]==1)) {$idtf=4;} // Matí i Tarda
                                }
                            }
                            switch($idtf){
                                case 1: $dispm[$f-1]+=1;break;
                                case 2: $dispt[$f-1]+=1;break;
                                case 3: $dispn[$f-1]+=1;break;
                                case 4: $dispmt[$f-1]+=1;break; // Nou array de Matí i Tarda
                            }
                        }
                    }
                    echo "</tr>";
                   
                }
                    // TOTAL DISPONIBLES
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px;">'.$dto->__($lng,"Total Disponibles").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($disponibles[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($disponibles[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                ?>                
                    <td><button class="btn btn-default btn-sm" onclick="mostraPeuNecess();" title="<?php echo $dto->__($lng,"Mostrar o Ocultar Necessitats");?>"><span class="glyphicon glyphicon-folder-open"></span></button></td>
                <?php                
                if($tipusexcep=="Tots")
                    {
                    // TORNS MATÍ
                    $bckm = "yellow";
                    $colm = "black";
                    $rstcm = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "M"');
                    if(!empty($rstcm)) { foreach($rstcm as $cm) {$bckm = $cm["colorbckg"]; $colm = $cm["colortxt"];} }
                    echo '<tr id="peudispm" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispm[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispm[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispm[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA
                    $bckmt = "orange";
                    $colmt = "white";
                    $rstcmt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=4 order by idtipustorn limit 1');
                    if(!empty($rstcmt)) { foreach($rstcmt as $cmt) {$bckmt = $cmt["colorbckg"]; $colmt = $cmt["colortxt"];} }
                    echo '<tr id="peudispmt" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispmt[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispmt[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispmt[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    $bckt = "orangered";
                    $colt = "white";
                    $rstct = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "T"');
                    if(!empty($rstct)) { foreach($rstct as $ct) {$bckt = $ct["colorbckg"]; $colt = $ct["colortxt"];} }
                    echo '<tr id="peudispt" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispt[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispt[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispt[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS NIT
                    $bckn = "navy";
                    $coln = "white";
                    $rstcn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "N"');
                    if(!empty($rstcn)) { foreach($rstcn as $cn) {$bckn = $cn["colorbckg"]; $coln = $cn["colortxt"];} }
                    echo '<tr id="peudispn" style="'.$dispnec.'"><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) $classnoExl = 'class="noExl"';
                        if($dispn[$i-1]==0) echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispn[$i-1]==1) echo '<td '.$classnoExl.' style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td '.$classnoExl.' style="border: solid 1px;">';
                        echo $dispn[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                else
                    {
                    echo '<tr><th style="display: none"></th><th style="text-align: center">'.$dto->__($lng,"Total de").' '.$dto->__($lng,$tipusexcep).'</th>';
                    $rgb = $dto->getExcepColors($tipusexcep);
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        if($disponibles[$i-1]>0) echo '<td style="background-color: rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')">';
                        else echo '<td>';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                ?>
            </body>
            <tr></tr>
            <tfoot id="peunec" style='<?php echo $dispnec;?>'>
            <?php
           
            $arrnecm = array_fill(0,($diesmes+10),0);
            $arrnecmt = array_fill(0,($diesmes+10),0);
            $arrnect = array_fill(0,($diesmes+10),0);
            $arrnecn = array_fill(0,($diesmes+10),0);
            // comprovar si hi ha registres de necessitat per subempresa del mes seleccionat
            $rsnecsubmes = $dto->getDb()->executarConsulta('select * from necsubmes where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes);
            if(empty($rsnecsubmes)){
                for($i=1;$i<=($diesmes);$i++){
                    for($n=1;$n<5;$n++){
                        $dto->getDb()->executarSentencia('insert into necsubmes (idsubempresa,anynec,mesnec,dianec,idtornfrac) values ('.$idsubemp.','.$any.','.$mes.','.$i.','.$n.')');
                    }
                }
                $rsnecsubmes = $dto->getDb()->executarConsulta('select * from necsubmes where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes);
            }
            $arrnec = [];
            foreach($rsnecsubmes as $rn){                
                $arrrsnc = array_fill(0,4,0);
                $arrrsnc[0] = $rn["idnecsubmes"];
                $arrrsnc[1] = $rn["dianec"];
                $arrrsnc[2] = $rn["idtornfrac"];
                $arrrsnc[3] = $rn["empleats"];
                $arrnec[]=$arrrsnc;                
            }
            // CREAR ARRAYS PER A CADA TIPUS DE FRACCIÓ DE TORN O BÉ UN SOL ARRAY ON CERCAR CADA COP EL VALOR EN FUNCIO DELS PARÀMETRES QUE TOQUIN
            foreach($arrnec as $nc){
                
                for($n=1;$n<5;$n++){
                  
                    if($nc[2]==$n){
                        switch($n){
                            case 1: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecm[($nc[1]+4)]=$arrdn; break;
                            case 2: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnect[($nc[1]+4)]=$arrdn; break;
                            case 3: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecn[($nc[1]+4)]=$arrdn; break;
                            case 4: $arrdn = array_fill(0,2,0);$arrdn[0]=$nc[0];$arrdn[1]=$nc[3] ;$arrnecmt[($nc[1]+4)]=$arrdn; break;
                        }
                        
                }
                }
            }
            $necm=[];
            $necmt=[];
            $nect=[];
            $necn=[];
            echo '<tr style="background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); color: white;"><th style="display: none"></th><th style="text-align: center; font-weight: bold;">'.$dto->__($lng,"Necessitat")." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any.'</th>';
            echo $calmes;
            echo '</tr>';
                    // TORNS MATÍ
                    $bckm = "yellow";
                    $colm = "black";
                    $rstcm = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=1 order by idtipustorn limit 1');
                    if(!empty($rstcm)) { foreach($rstcm as $cm) {$bckm = $cm["colorbckg"]; $colm = $cm["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                   
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        
                        $necm = $arrnecm[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                       
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necm[1].';}" onblur="actualitzaNCampTaulaNR('."'necsubmes','empleats',".$necm[0].',this.innerHTML);">';
                        echo $necm[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA
                    $bckmt = "orange";
                    $colmt = "white";
                    $rstcmt = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=4 order by idtipustorn limit 1');
                    if(!empty($rstcmt)) { foreach($rstcmt as $cmt) {$bckmt = $cmt["colorbckg"]; $colmt = $cmt["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                   
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        
                        $necmt = $arrnecmt[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                        
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necmt.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$necmt[0].','.$necmt[1].',this.innerHTML);">';
                        echo $necmt[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    $bckt = "orangered";
                    $colt = "white";
                    $rstct = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=2 order by idtipustorn limit 1');
                    if(!empty($rstct)) { foreach($rstct as $ct) {$bckt = $ct["colorbckg"]; $colt = $ct["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                   
                    for($i=1;$i<=($diesmes+10);$i++)
                    {                        
                        
                        $nect = $arrnect[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                        
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$nect.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$nect[0].','.$nect[1].',this.innerHTML);">';
                        echo $nect[1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS NIT
                    $bckn = "navy";
                    $coln = "white";
                    $rstcn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and torn=3 order by idtipustorn limit 1');
                    if(!empty($rstcn)) { foreach($rstcn as $cn) {$bckn = $cn["colorbckg"]; $coln = $cn["colortxt"];} }
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                   
                    for($i=1;$i<=($diesmes+10);$i++)
                    {                        
                       
                        $necn = $arrnecn[$i-1];
                        $contenteditable = 'contenteditable';
                        $classnoExl = '';
                        $bckcol = '';
                        if(($i<6)||($i>($diesmes+5))) {$classnoExl = 'class="noExl"';$contenteditable="";$bckcol='background-color: gainsboro;';}
                        
                        echo '<td '.$classnoExl.' style="border: solid 1px;'.$bckcol.'" '.$contenteditable.' onfocus="setTimeout(function(){document.execCommand('."'selectAll'".',false,null)},100);" onkeydown="if(event.key==='."'Escape'".'){this.innerHTML='.$necn.';}" onblur="actualitzaCampTaulaNR('."'necsubmes','empleats',".$necn[0].','.$necn[1].',this.innerHTML);">';
                        echo $necn[1].'</td>';
                    }
                    echo '</tr>';
            
                    echo '<tr style="background-image: linear-gradient(rgb(45,45,45),rgb(90,90,90),rgb(45,45,45)); color: white;"><th style="display: none"></th><th style="text-align: center; font-weight: bold;">'.$dto->__($lng,"Compliment").'</th>';
                    echo $calmes;
                    echo '</tr>';
                    // TORNS MATÍ                    
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                        
                            else{
                        $necm = $arrnecm[$i-1];
                        $snm = $dispm[$i-1]-$necm[1];
                        if($snm==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snm>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snm.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snm.'</td>';
                        
                        }                        
                    }
                    echo '</tr>';
                    // TORNS MATÍ I TARDA                    
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckmt.'; color: '.$colmt.';">'.$dto->__($lng,"Total Matí i Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                        
                            else{
                        $necmt = $arrnecmt[$i-1];
                        $snmt = $dispmt[$i-1]-$necmt[1];
                        if($snmt==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snmt>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snmt.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snmt.'</td>';
                       
                        }
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5)))
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                        
                            else{
                        $nect = $arrnect[$i-1];
                        $snt = $dispt[$i-1]-$nect[1];
                        if($snt==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                        else if($snt>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snt.'</td>';
                        else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snt.'</td>';
                       
                        }
                    }
                    echo '</tr>';
                    // TORNS NIT
                    echo '<tr><th style="display: none"></th><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    for($i=1;$i<=($diesmes+10);$i++)
                    {
                        $classnoExl = '';
                        if(($i<6)||($i>($diesmes+5))) 
                            {$classnoExl = 'class="noExl"';echo '<td '.$classnoExl.' style="border: solid 1px; background-color:gainsboro"></td>';}
                       
                        else{
                            $necn = $arrnecn[$i-1];
                            $snn = $dispn[$i-1]-$necn[1];
                            if($snn==0) echo '<td '.$classnoExl.' style="border: solid 1px;">0</td>';
                            else if($snn>0) echo '<td '.$classnoExl.' style="background-color: rgb(128,255,128); border: solid 1px;">+'.$snn.'</td>';
                            else echo '<td '.$classnoExl.' style="background-color: rgb(255,128,128); border: solid 1px;">'.$snn.'</td>';
                           
                        }
                    }
                    echo '</tr>';
                    // VEURE QUE PASSA AMB L'ARRAY DE NECESSITATS REGISTRADES (A COMPARAR AMB LES DISPONIBILITATS)
            ?> 
            </tfoot>
        </table>
                <button class="btn-neutro btn-medium" onclick="mostraPeuNecess();"><span class="glyphicon glyphicon-folder-open"></span></button>
                <br>
        </div><br>
        <div class="col-lg-l"></div>
    </div>
    <div id="tauladisp" class="row" style="padding-left: 10px; padding-right: 10px; <?php echo $dispnec;?>">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
            <h3 class=""><?php echo $dto->__($lng,"Necessitats del Quadrant");?></h3>  <button class="btn-green btn-medium" onclick="mostraEnganxaNecessitat(<?php echo $any.",".$mes.",0,0,".$idsubemp;?>);" title="<?php echo $dto->__($lng,"Aplicar Necessitat al Quadrant del Mes Seleccionat");?>"><span class="glyphicon glyphicon-export"></span> </button></h3><br><br>
            <div class="row">
                <div class="col-lg-4">
                    <h4 class=""><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",1,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,1);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn12">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,2);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'1','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn13">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,1,3); ?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </tfoot>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h4 class=""><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",2,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn21">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,1);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn22">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,2);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'2','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn23">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,2,3); ?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </tfoot>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h4 class=""><?php echo $dto->__($lng,$dto->getCampPerIdCampTaula("tipusnec",3,"nom"));?></h4><br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','1');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn31">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,1);?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckm.'; color: '.$colm.';';?>"><th><?php echo $dto->__($lng,"Total Matí");?></th><th colspan='2'></th></tr>    
                        </thead>
                    </table>
                    <br>                    
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Matí i Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','4');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn11">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,4);?>
                        </tbody>
                        <tfoot>
                            <tr style="<?php echo 'background-color: '.$bckmt.'; color: '.$colmt.';';?>"><th><?php echo $dto->__($lng,"Total Matí i Tarda");?></th><th colspan='2'></th></tr>    
                        </tfoot>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Tarda");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','2');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn32">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,2);?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckt.'; color: '.$colt.';';?>"><th><?php echo $dto->__($lng,"Total Tarda");?></th><th colspan='2'></th></tr>  
                        </thead>
                    </table>
                    <br>
                    <table class="table table-bordered table-condensed">
                        <thead>                            
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Torn")." ".$dto->__($lng,"Nit");?> <button class="btn-green btn-supersmall" onclick="mostraNovaNecess(<?php echo $idsubemp;?>,'3','3');"><span class="glyphicon glyphicon-plus"></span></button></th>
                        <th style="background-color:white; color:black"><?php echo $dto->__($lng,"Treballadors");?></th>
                        <th style="background-color:white; color:black"></th>
                        </thead>
                        <tbody id="tbn33">
                            <?php echo $dto->generaTbodyNecessitat($idsubemp,3,3); ?>
                        </tbody>
                        <thead>
                            <tr style="<?php echo 'background-color: '.$bckn.'; color: '.$coln.';';?>"><th><?php echo $dto->__($lng,"Total Nit");?></th><th colspan='2'></th></tr> 
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </center>
    <div class="modal fade" id="modAssignaNouPeriodeQuadrant" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Registrar Nou Període Especial");?></h3></div>
                <div class="modal-body">
                    <form name="assignaperiodequadrant">
                    <label><?php echo $dto->__($lng,"Persona");?>:</label>
                    <select name="idemp">
                        <?php
                        try{
                       
                        foreach($persones as $p)
                        {
                            $treballa=false;         
                            for($i=1;$i<=$diesmes;$i++) 
                            {
                                if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                                if($i<10)$zi="0".$i; else $zi=$i;
                                if($dto->treballaria($p["idempleat"],$any."-".$zmes."-".$zi)) $treballa=true;
                                else if($dto->terotacio($p["idempleat"],$any."-".$zmes."-".$zi)) $treballa=true;
                            }
                            if($treballa) echo '<option value="'.$p["idempleat"].'">'.$p["cognom1"].' '.$p["cognom2"].', '.$p["nom"].'</option>';
                        }
                        ?>
                    </select><br><br>                    
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select name="idtipusexcep">
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    ?>
                    </select><br><br>
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="dataini" required><br><br>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi" required><br><br>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-info" data-toggle="modal" onclick="assignaExcep(assignaperiodequadrant.idemp.value,assignaperiodequadrant.idtipusexcep.value,assignaperiodequadrant.dataini.value,assignaperiodequadrant.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Registrar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 25px"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>


    <script>
        function assignaExcep(id,idtipus,dataini,datafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
        function mostraPeuNecess()
        {
            if(document.getElementById("peunec").style.display === 'none'){
                document.getElementById("peunec").style.display = 'table-footer-group';
                document.getElementById("peudispm").style.display = 'table-row';
                document.getElementById("peudispt").style.display = 'table-row';
                document.getElementById("peudispn").style.display = 'table-row';                
                document.getElementById("peudispmt").style.display = 'table-row';
                document.getElementById("tauladisp").style.display = 'block';
            }
            else{
                document.getElementById("peunec").style.display = 'none';
                document.getElementById("peudispm").style.display = 'none';
                document.getElementById("peudispt").style.display = 'none';
                document.getElementById("peudispn").style.display = 'none';
                document.getElementById("peudispmt").style.display = 'none';
                document.getElementById("tauladisp").style.display = 'none';
            }
        }
    </script>

    </body>    
        <iframe id="upload_quadrant" name="upload_quadrant" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</html>
