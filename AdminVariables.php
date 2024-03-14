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
        <script>
        function assignaExcep(id,idtipus,dataini,datafi)
        {
            /*var innerhtml = id+","+idtipus+","+dataini+","+datafi;
            popuphtml(innerhtml);*/
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
    </script>





<style>





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



</style>


    </head>
    <!--body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%;"
    onload="var width = $(window).width();document.getElementById('cnttbl').style.width = width+'px';width-=20;document.getElementById('divtbl').style.width = width+'px';DoubleScroll(document.getElementById('divtbl'),20);" -->
    <body >    
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
       
    <div>
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = $_SESSION["idempresa"];
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
        $mes = $_GET["mes"];
        $zmes = "";
        if($mes<10){$zmes="0".$mes;}
        else {$zmes=$mes;}
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
        $dispnec = "";
        if($idsubemp=="Totes") $dispnec = "display: none"; 
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
                    <h3 class=""><?php echo $dto->__($lng,"Informe Variables"); ?> <!--button class="btn btn-info" onclick="mostraNouPeriodeQuadrant(<?php echo $any.",".$mes.",'".$dpt."','".$rol."','".$idsubemp."',".$idempresa;?>);" title="<?php echo $dto->__($lng,"Introduir període especial per a una persona del quadrant");?>"><span class="glyphicon glyphicon-plus"></span> <?php //echo $dto->__($lng,"Nou Període");?></button--></h3><!--data-toggle="modal" data-target="#modAssignaNouPeriodeQuadrant"-->
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
                    <form method="GET" action="AdminVariables.php">
                        <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                    <?php
                        echo '<select name="idsubemp" onchange="this.form.submit();">
                        <option hidden selected value="'.$idsubemp.'">';
                        if($idsubemp=="Totes") echo $dto->__($lng,$idsubemp);
                        else echo $dto->mostraNomSubempresa($idsubemp);
                        echo '</option>';
                        //. '<option value="Totes">'.$dto->__($lng,"Totes").'</option>';                        
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
                <div class="col-lg-1"><form action="AdminVariables.php" method="GET"><label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
                    <select name="dpt" onchange="this.form.submit();">
                    <option hidden selected value><?php echo $dto->__($lng,$dpt); ?></option>
                    <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                    <?php
                        $resdpt = $dto->mostraNomsDpt($idempresa);
                        foreach ($resdpt as $deptm)
                        {
                            echo '<option value="'.$deptm["nom"].'">'.$deptm["nom"].'</option>';
                        }
                    ?>                                  
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <div class="col-lg-2">
                    <form action="AdminVariables.php" method="GET">
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
                <!--div class="col-lg-2">
                    <form action="AdminQuadrants.php" method="GET"><label><?php echo $dto->__($lng,"Tipus"); ?>:</label><br>
                    <select name="tipusexcep" onchange="this.form.submit();">
                    <option hidden selected value><?php echo $dto->__($lng,$tipusexcep); ?></option>
                    <option value="Tots"><?php echo $dto->__($lng,"Tots");?></option>
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select>
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div-->
                <div class="col-lg-1"><form action="AdminVariables.php" method="GET"><label><?php echo $dto->__($lng,"Any"); ?>:</label><br>
                    <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                    <?php
                    $toyear = date('Y',strtotime('today'));
                    for($year=2017;$year<=($toyear+1);$year++)
                    //foreach($anys as $year)
                    {
                        echo '<option value:"'.$year.'">'.$year.'</option>';
                    }
                    /*foreach($anys as $year)
                    {
                        echo '<option value:"'.$year["anys"].'">'.$year["anys"].'</option>';
                    }*/
                    ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                    <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </form>
                </div>
                <?php
                    $mesant = $mes-1;
                    $anyant = $any;
                    if($mesant<1){$mesant = 12;$anyant=$any-1;}
                    $messeg = $mes+1;
                    $anyseg = $any;
                    if($messeg>12){$messeg=1;$anyseg=$any+1;}
                ?>
                <div class="col-lg-1">
                    <div class="row">
                        <div class="col-lg-4">
                        <form action="AdminVariables.php" method="GET">
                            <button class="btn-neutro btn-supersmall" title="<?php echo $dto->__($lng,$dto->mostraNomMes($mesant))." ".$anyant; ?>" onclick="this.form.submit()">
                                <span class="glyphicon glyphicon-arrow-left"></span> <strong><?php //echo $dto->__($lng,"Persona - Dia");?></strong>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $mesant; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyant; ?>">
                        </form>
                        </div>
                        <div class="col-lg-4"><label><?php echo $dto->__($lng,"Mes");?></label></div>
                        <div class="col-lg-4">
                        <form action="AdminVariables.php" method="GET">
                            <button class="btn-neutro btn-supersmall" title="<?php echo $dto->__($lng,$dto->mostraNomMes($messeg))." ".$anyseg; ?>" onclick="this.form.submit()">
                                <strong><?php //echo $dto->__($lng,"Persona - Dia");?></strong> <span class="glyphicon glyphicon-arrow-right"></span>
                            </button>
                            <input type="hidden" name="mes" value="<?php echo $messeg; ?>">
                            <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                            <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                            <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                            <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                            <input type="hidden" name="any" value="<?php echo $anyseg; ?>">
                        </form>
                        </div>
                    </div>
                    <form action="AdminVariables.php" method="GET">
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
                    <button class="btn-green" onclick="taulaAExcel('tblquadrant','<?php echo $dto->__($lng,$dto->mostraNomMes($mes));?>','<?php echo $dto->__($lng,"Variables")." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?>');" title="<?php echo $dto->__($lng,"Exportar a Excel");?>"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <button class="btn-blue" onclick="printElem('tblquadrant');" title="<?php echo $dto->__($lng,"Imprimir"); ?>"><span class="glyphicon glyphicon-print"></span></button>
                </div>
            </div>
        </div>
                </div>
            </div>
                </div>
            </div>
        </div>
        <!br>








        <div class="row" style="padding-left: 10px; padding-right: 10px; margin-top:50px;">
            <div class="col-lg-12 container" id="tblquadrant">
                <!--center><h4 class="etiq"></h4></center><br-->
        <table class="table table-condensed table-hover" style="text-align:center; width: 90%; background-color: white; border-collapse: collapse;"><!---->
            <thead>                    
                <tr>
                    <th style="text-align: center; background-color: #FFFFFF; color: black; font-size:large;""><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?><?php //echo $dto->__($lng,"Persona - Dia");?></th>
                    <?php
                    $dia = new DateTime();
                    $dia->setISODate($any,0);
                    $diesmes = 0;
                    $undiames = new DateInterval('P1D');
                    while($dia->format('Y')<$any)$dia->add($undiames);
                    while($dia->format('m')<$mes)$dia->add($undiames);
                    $calmes = "";
                    for($i=1;(($i<=31)&&($dia->format('m')==$mes));$i++) 
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
                        //echo '<th style="min-width: 27px; text-align: center; border: solid 1px; '.$bckg.'" title="'.$data.'">'.$i.'</th>';
                        $calmes.= '<th style="min-width: 27px; text-align: center; border: solid 1px; background-color: #FFFFFF; color: black; font-size:large; '.$bckg.'" title="'.$data.'">'.$i.'</th>';
                        $dia->add($undiames);
                        $diesmes++;
                        }catch(Exception $ex) {echo $ex->getMessage();}
                    }
                    ?>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas a Trabajar">HORAS TEORICAS</th>
                    <th  style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas Trabajadas">HORAS TRABAJADAS</th>
                    <th  style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas Trabajadas de Lunes a Viernes">Hª ENTRE SEMANA</th>
                    <th  style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas Trabajadas Sábados y Domingos">Hª FIN SEMANA</th>
                    <th  style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas Trabajadas en Festivos Intersemanales">Hª FESTIVOS INTERSEM.</th>
                    <th  style="background-color: #FFFFFF; color: black; font-size:large;" title="Total de Horas Trabajadas en Festivos en Fin de Semana">Hª FESTIVOS FIN.SEM.</th>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;">Movimiento de Turno</th>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;">HORAS EXTRA</th>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;" title="Suma de Horas Nocturnas de los Turnos Trabajados">Nocturnidad, horas</th>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;" title="Horas en Turno Mañana/Tarde">TURNO PARTIDO</th>
                    <th style="background-color: #FFFFFF; color: black; font-size:large;">Diferencia Puesto Trabajo, días</th>
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
                //e.idempleat, e.nom, e.cognom1, e.cognom2
                $sqlpers = 'select *, e.nom as nomempl '
                        . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                        . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' and ((e.enplantilla=1) or ((DATE(e.datacessat)>"'.$any.'-'.$mes.'-01'.'") and (e.enplantilla=0))) order by e.cognom1, e.cognom2, e.nom';//
                //echo $sqlpers;
                
                // NOU METODE CONSULTANT TAULA INICIAL DE CÀRREGA DE PERSONES, comentem la consulta inicial que havíem creat
                //$persones = $dto->getDb()->executarConsulta($sqlpers);
                //$persones = [];
                $persones = $_SESSION["arrpers"];
                $countpers = count($persones);
                //echo '<strong>'.$countpers.'</strong>';
                for($n=0;$n<($countpers);$n++){                        
                        if((($persones[$n][5]!=$idsubemp)||(($rol!="Tots")&&($persones[$n][6]!=$rol))||(($persones[$n][7]==0)&&(strtotime($persones[$n][8])<strtotime($any."-".$zmes."-01"))))){
                            unset($persones[$n]);
                            array_values($persones);
                        }
                    }
                //'select * from empleat where idempresa like "'.$idempresa.'" order by cognom1, cognom2, nom'
                //if($dpt=="Tots") $persones = $dto->seleccionaPersonesPerEmpAnyMes($idempresa, $any, $mes);
                //else $persones = $dto->seleccionaPersonesPerEmpDptAnyMes($idempresa,$dpt,$any,$mes);
                
                }catch(Exception $ex){echo '<tr><td>'.$ex->getMessage().'</td></tr>';}
                //$dispm = array_fill(0,$diesmes,0);
                //$dispt = array_fill(0,$diesmes,0);
                //$dispn = array_fill(0,$diesmes,0);
                //$disponibles = array_fill(0,$diesmes,0);
                foreach ($persones as $empleat) 
                    {
                    $treballa=false;
                    //total hores
                    $htot=0.0;
                    //total hores entre setmana
                    $hsem=0.0;
                    //total hores cap de setmana
                    $hfin=0.0;
                    //festius entre sem:
                    $f=0.0;
                    //festius capdesem:
                    $ff=0.0;
                    //extres:
                    $ex=0.0;
                    //nocturnes:
                    $n=0.0;
                    //hores torn partit
                    $htp=0.0;
                    //HORES EXTRES
                    //Teoriques:
                    $hteor=0.0;
                    //Treballades:
                    $hwrkd=0.0;
                    //Saldo extres;
                    $hextr=0.0;
                    //$horesmes=0    
                    $htreb = 0.0;
                    $hfeina = 0.0;
                    $inicihext = 0;
                    // Check si l'empresa arrodoneix les hores extres afegint mitja hora si passen +10 minuts de la darrera fracció (hora en punt, mitja hora en punt)
                    $arrodmitjahoraextra = $dto->getCampPerIdCampTaula("empresa",$idempresa,"arrodmitjahoraextra");
                    //for($i=1;$i<=$diesmes;$i++)
                        //{
                        //$horesmes += $dto->seleccionaHoresTeoriquesPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi);
                        //if($dto->treballaria($empleat["idempleat"],$any."-".$zmes."-".$zi)) $treballa=true;
                        //}
                    //if($horesmes>0.0)
                    //if($treballa)
                    //{
                        echo "<tr>";
                        echo '<td style="width:1%; white-space:nowrap;"><form method="get" style="display:inline">'
                    //.'<button type="submit" style="background-color:white; cursor:pointer; width:100%; border: none" formaction="AdminMarcatgesEmpleat.php" name="id" value="'.$empleat["idempleat"].'" title="'.$dto->__($lng,"Veure els marcatges de l'usuari").'"><strong>'.$empleat["nomempl"].' '.$empleat["cognom1"].', '.$empleat["cognom2"].'</strong></button></form></td>';
                    .'<button type="submit" style="background-color:white; cursor:pointer; width:100%; border: none" formaction="AdminMarcatgesEmpleat.php" name="id" value="'.$empleat[0].'" title="'.$dto->__($lng,"Veure els marcatges de l'usuari").'"><strong>'.$empleat[1].' '.$empleat[2].', '.$empleat[3].'</strong></button></form></td>';    
                        //$arrhfeina = [];
                        $arrhfeina = $dto->calculaHoresTreballadesPerIdMes($empleat[0],$any."-".$zmes."-01");//
                        for($i=1;$i<=$diesmes;$i++)
                        {
                            //if($mes<10)$zmes="0".$mes; else $zmes=$mes;
                            $zi = "";
                            if($i<10) {$zi="0".$i; }
                            else {$zi=$i;}
                            /*if($empleat["rotacio"]!=1) {
                                if($empleat["diesnat"]==1) {                                    
                                    //else $disponibles[$i-1]++;
                                    //$dto->seleccionaTipusTornPerIdDia($id,$any."-".$zmes."-".$zi,$lng);
                                    $disponibles[$i-1]+=$dto->imprimeixTipusDiaPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$dto->__($lng,$tipusexcep),$lng);
                                }
                            }                                
                            else*/
                            //$dispm[$i-1]+=$dto->getFracTornDiaPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$dto->__($lng,$tipusexcep),$lng,1);
                            //$dispt[$i-1]+=$dto->getFracTornDiaPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$dto->__($lng,$tipusexcep),$lng,2);
                            //$dispn[$i-1]+=$dto->getFracTornDiaPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$dto->__($lng,$tipusexcep),$lng,3);
                            //$disponibles[$i-1]+=$dto->imprimeixTipusDiaPerIdDia($empleat["idempleat"],$any."-".$zmes."-".$zi,$dto->__($lng,$tipusexcep),$lng);
                            
                            /*$rt = $dto->terotacio($empleat["idempleat"],$any."-".$zmes."-".$zi);
                            if(!empty($rt)){
                                $tr = $dto->getCampPerIdCampTaula("rotacio",$rt,"idtipustorn");
                                $tt = $dto->getCampPerIdCampTaula("tipustorn",$tr,"torn");
                                $htreb = $dto->getCampPerIdCampTaula("tipustorn",$tr,"horestreball");
                                if(($tt==4)||($tt==7)) {$htp+=$htreb;}
                                $n+=$dto->getCampPerIdCampTaula("tipustorn",$tr,"horesnit");//}
                                */
                            $htreb = $dto->seleccionaHoresTeoriquesPerIdDia($empleat[0],$any."-".$zmes."-".$zi);
                            //$htreb = 0;
                            //
                            // FER MÊTODE DE CALCUL D'HORES TREBALLADES PER MES PER TREBALLADOR, AQUÍ HI HA EL TEMPS A REDUIR DE CONSULTA
                            //$hfeina = $dto->calculaHoresTreballadesPerIdDia($empleat[0],$any."-".$zmes."-".$zi);
                            // CANVI D'UBICACIÓ DE LA CONSULTA PER A OBTENIR UN ARRAY AMB LES HORES TREBALLADES DE TOTS ELS DIES DEL MES
                            $hfeina = $arrhfeina[$i-1];
                            $toecho.=$hfeina.",";
                            //$hfeina = 0;
                            if($arrodmitjahoraextra==1){
                                $tb = $hfeina;
                                $to = $htreb;
                                if($tb>$to){
                                    $tex = $tb - $to;
                                    $tb = $to;
                                    $tsum = 0.0;
                                    while($tex>0.0){
                                        if($tex>=0.17){
                                            $tsum+=0.5;
                                        }                            
                                        $tex-=0.5;
                                    }
                                    $tb+=$tsum; 
                                }
                                $hfeina = $tb;
                                //if($htreb<$hfeina) {$hextr+= ($hfeina-$htreb);}
                            }
                                $htot+=$htreb;                                
                                $w = date('w',strtotime($any."-".$zmes."-".$zi));
                                switch($w){
                                    case 0: 
                                        if($dto->esFestiuPerIdDia($empleat[0],$any."-".$zmes."-".$zi)){$ff+=$hfeina;}
                                        else {$hfin+=$hfeina;} break;
                                    case 6: 
                                        if($dto->esFestiuPerIdDia($empleat[0],$any."-".$zmes."-".$zi)){$ff+=$hfeina;}
                                        else {$hfin+=$hfeina;} break;
                                    default: 
                                        if($dto->esFestiuPerIdDia($empleat[0],$any."-".$zmes."-".$zi)){$f+=$hfeina;}
                                        else {$hsem+=$hfeina;} break;
                                }
                            //}
                            $hteor += $htreb;
                            $hwrkd += $hfeina;                            
                            if(($arrodmitjahoraextra==0)||(($arrodmitjahoraextra==1)&&($htreb<$hfeina))) {$hextr+=($hfeina-$htreb);}
                        }
                        $toecho.='<br>';
                        //if($arrodmitjahoraextra==0){
                        //    $hextr = $hwrkd - $hteor;                            
                        //}
                        $rgbext = "";
                        if($hextr>0.0){$rgbext = "220,255,220";}
                        if($hextr<0.0){$valhextr = "";}
                        else {$valhextr = number_format($hextr,1,",",".");}
                        $cnvtrn = 0;
                        $rscnvtrn = $dto->getDb()->executarConsulta('select idcanvitorn from canvitorn where idempleat='.$empleat[0].' and year(datatorn)='.$any.' and month(datatorn)='.$mes);
                        foreach($rscnvtrn as $c){$cnvtrn++;}
                        //$f=$f*8;
                        //$n=$n/24;
                        echo '<td>'.number_format($htot,1,",",".").'</td>';
                        echo '<td>'.number_format($hwrkd,1,",",".").'</td>';
                        echo '<td>'.number_format($hsem,1,",",".").'</td>';
                        echo '<td>'.number_format($hfin,1,",",".").'</td>';
                        echo '<td>'.number_format($f,1,",",".").'</td>';
                        echo '<td>'.number_format($ff,1,",",".").'</td>'; /*FESTIVOS/HORAS</th>
                    <th>Movimiento de Turno</th>
                    <th>HORAS EXTRA</th>
                    <th>Nocturnidad, días</th>
                    <th>TURNO PARTIDO</th>
                    <th>Diferencia Puesto Trabajo, días</th>*/
                        if($cnvtrn==0) {$cnvtrn="";}
                        echo '<td>'.$cnvtrn.'</td>'; 
                        echo '<td style="background-color: rgb('.$rgbext.');">'.$valhextr.'</td>'; 
                        echo '<td>'.number_format($n,1,",",".").'</td>'; 
                        echo '<td>'.number_format($htp,1,",",".").'</td>'; 
                        echo '<td>'.null.'</td>'; 
                        echo "</tr>";
                    //}
                }
                ?>        
                <?php
                /*if($tipusexcep=="Tots")
                    {
                    // TORNS MATÍ
                    $bckm = "yellow";
                    $colm = "black";
                    $rstcm = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "M"');
                    if(!empty($rstcm)) { foreach($rstcm as $cm) {$bckm = $cm["colorbckg"]; $colm = $cm["colortxt"];} }
                    echo '<tr><th style="text-align: center; border: solid 1px; background-color: '.$bckm.'; color: '.$colm.';">'.$dto->__($lng,"Total Matí").'</th>';
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        if($dispm[$i-1]==0) echo '<td style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispm[$i-1]==1) echo '<td style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td style="border: solid 1px;">';
                        echo $dispm[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS TARDA
                    $bckt = "orangered";
                    $colt = "white";
                    $rstct = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "T"');
                    if(!empty($rstct)) { foreach($rstct as $ct) {$bckt = $ct["colorbckg"]; $colt = $ct["colortxt"];} }
                    echo '<tr><th style="text-align: center; border: solid 1px; background-color: '.$bckt.'; color: '.$colt.';">'.$dto->__($lng,"Total Tarda").'</th>';
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        if($dispt[$i-1]==0) echo '<td style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispt[$i-1]==1) echo '<td style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td style="border: solid 1px;">';
                        echo $dispt[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TORNS NIT
                    $bckn = "navy";
                    $coln = "white";
                    $rstcn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idempresa.' and abrv like "N"');
                    if(!empty($rstcn)) { foreach($rstcn as $cn) {$bckn = $cn["colorbckg"]; $coln = $cn["colortxt"];} }
                    echo '<tr><th style="text-align: center; border: solid 1px; background-color: '.$bckn.'; color: '.$coln.';">'.$dto->__($lng,"Total Nit").'</th>';
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        if($dispn[$i-1]==0) echo '<td style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($dispn[$i-1]==1) echo '<td style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td style="border: solid 1px;">';
                        echo $dispn[$i-1].'</td>';
                    }
                    echo '</tr>';
                    // TOTAL DISPONIBLES
                    echo '<tr><th style="text-align: center; border: solid 1px;">'.$dto->__($lng,"Total Disponibles").'</th>';
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        if($disponibles[$i-1]==0) echo '<td style="background-color: rgb(255,128,128); border: solid 1px;">';
                        else if($disponibles[$i-1]==1) echo '<td style="background-color: rgb(255,255,128); border: solid 1px;">';
                        else echo '<td style="border: solid 1px;">';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }
                else
                    {
                    echo '<tr><th style="text-align: center">'.$dto->__($lng,"Total de").' '.$dto->__($lng,$tipusexcep).'</th>';
                    $rgb = $dto->getExcepColors($tipusexcep);
                    for($i=1;$i<=$diesmes;$i++)
                    {
                        if($disponibles[$i-1]>0) echo '<td style="background-color: rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')">';
                        else echo '<td>';
                        echo $disponibles[$i-1].'</td>';
                    }
                    echo '</tr>';
                    }*/
                ?>
            </body>
            <tr></tr>
            
        </table>
                <br><?php //echo $toecho;?>
        </div><br>
        <div class="col-lg-l"></div>
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
    </body>
</html>
