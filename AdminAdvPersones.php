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
        background-color: rgba(72, 90, 255, 0.9); /* Color de fondo con transparencia */
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
    <body class="well" onload="var width = $(window).width();document.getElementById('cnttbl').style.width = width+'px';width-=20;document.getElementById('divtbl').style.width = width+'px';DoubleScroll(document.getElementById('divtbl'),20);">
        
        <div id="content">
        <?php
        $idemp = $_SESSION["idempresa"];
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_SESSION["id"];
        $master = $dto->esMaster($id);
        $idempresa = $idemp;
        if(!isset($_GET["idsubemp"])){
            if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
            else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
            else $_GET["idsubemp"]=0;
        }
        $idsubemp = $_GET["idsubemp"];
        $_SESSION["filtidsubemp"] = $idsubemp;
        if(!isset($_GET["dpt"])) $_GET["dpt"]=0;
        $dpt = $_GET["dpt"];
        $nomdpt = $dto->__($lng,"Tots");
        if($dpt!=0) $nomdpt = $dto->__($lng,$dto->getCampPerIdCampTaula("departament",$dpt,"nom"));
        if(!isset($_GET["rol"])) $_GET["rol"]=0;
        $rol = $_GET["rol"];
        $nomrol = $dto->__($lng,"Tots");
        if($rol!=0) $nomrol = $dto->__($lng,$dto->getCampPerIdCampTaula("rol",$rol,"nom"));
        if(!isset($_GET["situacio"])) $_GET["situacio"]=1;
        $situacio = $_GET["situacio"];
        $nomsituacio = "En Plantilla";
        switch($situacio){
            case 0: $nomsituacio = "Cessat"; break;
            case 2: $nomsituacio = "Totes"; break;
        }
        $tblpers = "";
        $tipustornopt = '<option value=""></option>';
        $rstr = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idemp);
        foreach($rstr as $tr) {$tipustornopt.='<option value="'.$tr["idtipustorn"].'">'.$tr["nom"].'</option>';}
        $i = 0;
        $sqlsubemp = '';
        if($idsubemp!=0) $sqlsubemp = 'and e.idsubempresa='.$idsubemp;
        $sqljoindpt = '';
        $sqlnomdpt = '';
        if($dpt!=0) {
            $sqljoindpt = 'join pertany as p on p.id_emp = e.idempleat join departament as d on d.iddepartament = p.id_dep';
            $sqlnomdpt = 'and d.iddepartament like "'.$dpt.'"';
        }
        $sqljoinrol = '';
        $sqljoinrol = 'join assignat as a on a.id_emp = e.idempleat join rol as ro on ro.idrol = a.id_rol';
        $sqlnomrol = '';
        if($rol!=0) {
            $sqlnomrol = 'and ro.idrol='.$rol;                   
        }
        $sqlenplant = '';
        if($situacio!=2) $sqlenplant = 'and e.enplantilla='.$situacio;
        
        $result = $dto->getDb()->executarConsulta('select *, e.nom as nomempl '
                . 'from empleat as e '.$sqljoinrol.' '.$sqljoindpt.' '
                . 'where e.idempresa='.$idempresa.' and ro.esempleat=1 and a.actiu=1 '.$sqlsubemp.' '.$sqlnomdpt.' '.$sqlnomrol.' '.$sqlenplant.' order by e.cognom1, e.cognom2, e.nom');
            foreach ($result as $r)
            {
                $i++;
                $subemp = '';
                $chkrot = '';
                $chkalt = '';
                $chktmp = '';
                $chknat = '';
                $chknit = '';
                $chkdnt = '';
                $chksbs = '';
                $chkfm1 = '';
                if($r["rotacio"]==1) {$chkrot = 'checked';}
                if($r["alta"]==1) {$chkalt = 'checked';}
                if($r["temporal"]==1) {$chktmp = 'checked';}
                if($r["diesnat"]==1) {$chknat = 'checked';}
                if($r["nits"]==1) {$chknit = 'checked';}
                if($r["dianit"]==1) {$chkdnt = 'checked';}
                if($r["substsuperv"]==1) {$chksbs = 'checked';}
                if($r["festamesun"]==1) {$chkfm1 = 'checked';}
                $rolpers = $dto->getRolActiuPerId($r["idempleat"]);                
                $idsbeemp = $dto->getCampPerIdCampTaula("empleat",$r["idempleat"],"idsubempresa");
                if(!empty($idsbeemp)) {$subemp = $dto->getCampPerIdCampTaula("subempresa",$idsbeemp,"nom");}
               
                    $tblpers.= "<tr>"
                   ."<td>".$r["cognom1"]." ".$r["cognom2"]."</td>"
                   ."<td>".$r["nomempl"]."</td>"
                   .'<td><form method="get" action="AdminFitxaEmpleat.php"><button type="submit" title="'.$dto->__($lng,"Veure Fitxa").'" class="btn btn-default btn-xs" name="id" value="'.$r["idempleat"].'"><span class="glyphicon glyphicon-user"></span></button></form></td>'
                   .'<td>'.$rolpers.'</td>'
                   .'<td><input type="date" id="datainirot'.$i.'" value="'.$r["ordredist"].'" onchange="actualitzaNCampTaulaNR('."'empleat','ordredist',".$r["idempleat"].',this.value);" style=""></td>'
                   .'<td><input value="'.$r["torndist"].'" onblur="actualitzaNCampTaulaNR('."'empleat','torndist',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chkrot.' onchange="actualitzaChkCampTaula('."'rotacio','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chkalt.' onchange="actualitzaChkCampTaula('."'alta','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chktmp.' onchange="actualitzaChkCampTaula('."'temporal','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chknat.' onchange="actualitzaChkCampTaula('."'diesnat','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chknit.' onchange="actualitzaChkCampTaula('."'nits','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chkdnt.' onchange="actualitzaChkCampTaula('."'dianit','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td style="text-align: center"><input type="checkbox" '.$chksbs.' onchange="actualitzaChkCampTaula('."'substsuperv','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>'
                   .'<td>'
                            .'<select onchange="actualitzaNCampTaulaNR('."'empleat','idhorari1',".$r["idempleat"].',this.value);" style="width: 125px; height: 25px;">'
                            . '<option hidden selected value="'.$r["idhorari1"].'">'.$dto->getCampPerIdCampTaula("tipustorn",$r["idhorari1"],"nom").'</option>'
                            .$tipustornopt.'</select>'
                   .'</td>'
                   .'<td>'
                            . '<select onchange="actualitzaNCampTaulaNR('."'empleat','idhorari2',".$r["idempleat"].',this.value);" style="width: 125px; height: 25px;">'
                            . '<option hidden selected value="'.$r["idhorari2"].'">'.$dto->getCampPerIdCampTaula("tipustorn",$r["idhorari2"],"nom").'</option>'
                            .$tipustornopt.'</select>'
                   .'</td>'
                   .'<td><input value="'.$r["dieslabor"].'" onchange="actualitzaNCampTaulaNR('."'empleat','dieslabor',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td><input value="'.$r["dieslabor2"].'" onchange="actualitzaNCampTaulaNR('."'empleat','dieslabor2',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                   .'<td><input value="'.$r["diesfesta"].'" onchange="actualitzaNCampTaulaNR('."'empleat','diesfesta',".$r["idempleat"].',this.value);" style="width: 45px; height: 25px;"></td>'
                    .'<td style="text-align: center"><input type="checkbox" '.$chkfm1.' onchange="actualitzaChkCampTaula('."'festamesun','empleat',".$r["idempleat"].',this.checked);" style="width: 25px; height: 25px;"></td>';
                  
                $nomcomplet = "";
                $nomcomplet = $r["nom"]." ".$r["cognom1"]." ".$r["cognom2"];
                $btnx = "";
                $tblpers.= "<td><input type='hidden' id='nompers".$i."' value='".$nomcomplet."'><input type='hidden' id='idpers".$i."' value='".$r["idempleat"]."'><input id='pers".$i."' type='checkbox' style='height: 20px; width: 20px'></td>".'<td style="text-align: center">'.$btnx.'</td></tr>';
                //}
            }
        ?>
        <center>
            
        <div class="row" id="FiltresEmpleats">
            <div class="col-lg-12" style="margin-bottom: 50px;">            
                <div class="col-lg-3"><h2><?php echo $dto->__($lng,"Gestió de Persones")?></h2>
                </div>




             
        <div class="col-lg-9 text-right">
          <h3 >  <a href="" style="color: black">
                <p  data-toggle="collapse" href="#filtroCollapse" aria-expanded="false" aria-controls="filtroCollapse">
                    Filtrar
                    <i class="filtro-icon fas fa-chevron-down"></i>
                </p>
            </a></h3>
            <div class="collapse" id="filtroCollapse">
                <div class="filtro-content" style="background-color: #f5f5f5">



                <div id="filtroCollapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="filtroHeading">
                    <div class="panel-body">





                <div class="col-lg-2"><form method="GET" id="LlistaEmpreses" action="AdminAdvPersones.php">
                <label><?php echo $dto->__($lng,"Subempresa");?>:</label><br>
                <div class = "custom-select-container glass-container">
                   
                        <select class="glass-select" name="idsubemp" onchange="this.form.submit();">
                    <?php
                        echo '<option hidden selected value="'.$idsubemp.'">';
                        if($idsubemp==0) echo $dto->__($lng,"Totes");
                        else echo $dto->mostraNomSubempresa($idsubemp);
                        echo '</option>'
                        . '<option value="0">'.$dto->__($lng,"Totes").'</option>';                        
                        $resemp = $dto->mostraSubempreses($idemp);
                        foreach ($resemp as $emp)
                        {
                        echo '<option value="'.$emp["idsubempresa"].'">'.$emp["nom"].'</option>';
                        }                        
                        echo '</select>';
                    ?>
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">   
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                    
                    </div>
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaRols" action="AdminAdvPersones.php">
                    <label><?php echo $dto->__($lng,"Perfil"); ?>:</label><br>
                    <div class = "custom-select-container glass-container">
                      
                        <select class="glass-select" name="rol" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $rol; ?>"><?php echo $nomrol; ?></option>
                            <option value="0"><?php echo $dto->__($lng,"Tots");?></option>
                            <?php
                                $resrol = $dto->mostraRols($idempresa,$master);
                                foreach ($resrol as $rol)
                                {
                                echo '<option value="'.$rol["idrol"].'">'.$rol["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaDpts" action="AdminAdvPersones.php">
                    <label><?php echo $dto->__($lng,"Departament"); ?>:</label><br>
                    <div class = "custom-select-container glass-container">
                        
                        <select class="glass-select" name="dpt" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $dpt; ?>"><?php echo $nomdpt; ?></option>
                            <option value="0"><?php echo $dto->__($lng,"Tots");?></option>  
                            <?php
                                $resdpt = $dto->mostraNomsDpt($idempresa);
                                foreach ($resdpt as $dpt)
                                {
                                echo '<option value="'.$dpt["iddepartament"].'">'.$dpt["nom"].'</option>';
                                }
                            ?>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="situacio" value="<?php echo $situacio; ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    </form>
                </div>
                <div class="col-lg-2">
                    <form method="GET" id="LlistaSituacions" action="AdminAdvPersones.php">
                    <label><?php echo $dto->__($lng,"Situació"); ?>:</label><br>
                    <div class = "custom-select-container glass-container">
                      
                        <select class="glass-select" name="situacio" onchange="this.form.submit();">
                            <option hidden selected value="<?php echo $situacio;?>"><?php echo $dto->__($lng,$nomsituacio); ?></option>
                            <option value="2"><?php echo $dto->__($lng,"Totes");?></option>  
                            <option value="1"><?php echo $dto->__($lng,"En plantilla");?></option>
                            <option value="0"><?php echo $dto->__($lng,"Cessat");?></option>
                    </select>
                    <input type="hidden" name="idsubemp" value="<?php echo $idsubemp; ?>">
                    <input type="hidden" name="rol" value="<?php echo $rol; ?>">
                    <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                    <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
        
                </div>
            </div>
        </div>
            </div>
        </div>
        
        
        
        
        <!br>       
        <div class="row">
           
        <div class="col-lg-12">        
        <div id="divtbl" class="divtbl" style="padding: 0; margin-left: 0px; margin-right: 20px;">
            
        <table class="table table-striped table-hover table-condensed" style="border-collapse: collapse; border-spacing: 0; background-color: white; text-align:center; align-self: flex-end">
        <thead>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;" ><?php echo $dto->__($lng,"Cognoms");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Nom");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Fitxa");?></th>                
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Perfil");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Data Ini. Dist.");?> <button class="btn btn-primary btn-xs" onclick="asgMultDataini(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Assignar Data Inici Rotació a Múltiples Persones");?>"><span class="glyphicon glyphicon-calendar"></span></button></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Torn Dist.");?></th>
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:small;"><?php echo $dto->__($lng,"Rotació");?></th>
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:small;"><?php echo $dto->__($lng,"Alta");?></th>
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Temporal");?></th>
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:medium;"><span class="glyphicon glyphicon-info-sign" title="<?php echo $dto->__($lng,"Si se marca, sólo se asignarán turnos de rotación entre lunes y viernes, saltando siempre sábados y domingos. Es necesario especificar igualmente los días laborables del turno principal, ya que si son inferiores a 5, entonces asignará los días de fiesta y el cambio al turno alterno también entre semana.");?>"></span> <?php echo $dto->__($lng,"Dies Nat.");?></th>
                <!--Si es marca, només s’assignaran torns de rotació entre dilluns i divendres, saltant sempre els dissabtes i diumenges. Cal especificar igualment els 5 dies laborables del torn principal si es vol que els torns siguin de dilluns a divendres, ja que si no, fa el canvi de torn a mitja setmana i aplica els dies festius entremig.-->                
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:medium;"><span class="glyphicon glyphicon-info-sign" title="<?php echo $dto->__($lng,"Si se marca, añade un tercer horario de rotación despues de aplicar los días de fiesta tras el segundo. Se utiliza el primer turno de tipo Noche (N) que tenga definido la empresa, aplicándole los mismos días laborables del turno principal, y a continuación asigna los días de fiesta y vuelve a empezar con el primer horario.");?>"></span> <?php echo $dto->__($lng,"Nits");?></th>
                <!--Si es marca, afegeix un tercer horari de rotació a continuació dels dies de festa del segon, agafant el primer torn de tipus Nit (N) que tingui definit l’empresa, li aplica els mateixos díes que al torn principal, i després torna a assignar els dies de festa i els dies de l’horari principal.-->                 
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:medium;"><span class="glyphicon glyphicon-info-sign" title="<?php echo $dto->__($lng,"Si se marca, a partir de la segunda rotación, convierte una semana sí y una no el turno de tipo Mañana (M) que encuentre en un turno mixto en el cual los primeros tres días se mantendrá el de Mañana y los siguientes asignará el primer turno de tipo Noche (N) que tenga especificado la empresa, hasta completar los días.");?>"></span> <?php echo $dto->__($lng,"Dia/Nit");?></th>
                <!--Si es marca, a partir de la segona rotació, converteix una setmana sí i una no el torn de matí que trobi en un torn mixte en què els primers tres díes mantindrà aquell torn, i els següents fins a la festa, assignarà el primer torn de tipus Nit (N) que tingui definit l’empresa.-->
                
                <th style="text-align: center; background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Subst. Sup.");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;" ><?php echo $dto->__($lng,"Horari");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><?php echo $dto->__($lng,"Horari Secundari");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;" title="<?php echo $dto->__($lng,"Dies Laborables de l´Horari Principal de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"D.Lab.P");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><span class="glyphicon glyphicon-info-sign" title="<?php echo $dto->__($lng,"Dies Laborables de l´Horari Secundari de Rotació").': '.$dto->__($lng,"Si tiene un valor mayor que cero, convierte la rotación en mixta, asignando los días laborables del turno principal y a continuación este número de días de turno secundario sin separación de festivos, que se aplicarán justo después.");?>"></span> <?php echo $dto->__($lng,"D.Lab.S");?></th>
                <!--Si té un valor major que zero converteix la rotació en mixta fent que s’assignin els dies laborables del torn principal i a continuació aquest nombre de dies de torn secundari, i després aplica els dies de festa especificats entre torns.-->
                
                <th style="background-color: #f5f5f5; color: black; font-size:medium;" title="<?php echo $dto->__($lng,"Dies de Festa entre Torns de Rotació");?>"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $dto->__($lng,"Dies Fes.");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><span class="glyphicon glyphicon-info-sign" title="<?php echo $dto->__($lng,"Dia Festiu Adicional Alternativament").': '.$dto->__($lng,"Si se marca, aplica un día adicional de descanso cada dos cambios o alternancias de turno.");?>"></span> <?php echo $dto->__($lng,"D.Fes+1");?></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;"><input type='checkbox' id="chkallpers" style='height: 20px; width: 20px' onclick="chkAllPers(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Marcar/Desmarcar Tots");?>"></th>
                <th style="background-color: #f5f5f5; color: black; font-size:medium;" title="<?php echo $dto->__($lng,"Opcions");?>"><button class="btn btn-primary btn-xs" onclick="asgMultRot(<?php echo $i;?>);" title="<?php echo $dto->__($lng,"Assignar Rotació a Múltiples Persones");?>"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-calendar"></span></button></th>
        </thead>
        <tbody style="background-color: white">
            <?php
            echo $tblpers;
        ?>       
        </tbody>
        </table>
           
        </div>
        </div>        
        </div>
    </div>
    </center>
    <div class="modal fade" id="modAsgMultDataini" role="dialog">
    <center>
    <div class="modal-dialog">
      <div class="modal-content glassmorphism">
          <div class="glassmorphism">
              <h3 style="color:white;"><?php echo $dto->__($lng,"Assignar Data Inici de Rotació per a Múltiples Persones");?></h3>
          </div>
        <div class="modal-body">
            <form name="datapersona" onsubmit="event.preventDefault();">
            <input type="hidden" id="stridpersonadate" name="stridpersonadate">
            <h4><?php echo $dto->__($lng,"Confirmeu Persones i Data Inicial de Rotació");?>:</h4><br>
            <div class="row"><div class="col-lg-2"></div><div class="col-lg-8"><table id="nomspers" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;"></table></div><div class="col-lg-2"></div></div><br>
            <div class="row">
                <div class="col-lg-2"></div>                        
                <div class="col-lg-4"><label><?php echo $dto->__($lng,"Data Inici Rotació");?>:</label></div>
                <div class="col-lg-3"><input type="date" name="dataini" value="<?php echo date('Y-m-d',strtotime('today'));?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
            </div><br><br></form>                    
        </div>
        <div class="">
        <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
        <button type="button" class="btn_modal" data-dismiss="modal" onclick="assignaDatainiMultipers(datapersona.stridpersonadate.value,datapersona.dataini.value);"><span class="glyphicon glyphicon-calendar"></span> <?php echo $dto->__($lng,"Assignar");?></button>
        </div>
      </div>
    </div>
    </center>
    </div>
    <div class="modal fade" id="modAsgMultRot" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content glassmorphism">
                  <div class="glassmorphism">
                      <h3 style="color:white;"><?php echo $dto->__($lng,"Crear Rotació per a Múltiples Persones");?></h3>
                  </div>
                <div class="modal-body">
                    <form name="rotapersona" onsubmit="event.preventDefault();">
                    <input type="hidden" id="stridpersona" name="stridpersona">
                    <input type="hidden" id="strdataini" name="strdataini">
                    <h4><?php echo $dto->__($lng,"Confirmeu Persones i Data Final de Rotació");?>:</h4><br>
                    <div class="row"><div class="col-lg-2"></div><div class="col-lg-8"><table id="nomspers" class="table table-bordered table-striped" style="text-align: left; font-size: 22px;"></table></div><div class="col-lg-2"></div></div><br>
                    <div class="row">
                        <div class="col-lg-2"></div>                        
                        <div class="col-lg-4"><label><?php echo $dto->__($lng,"Data Final Rotació");?>:</label></div>
                        <div class="col-lg-3"><input type="date" name="datafi" value="<?php echo date('Y-m-d',strtotime(date('Y',strtotime('today')).'-12-31'));?>" style="padding-top: 6px; padding-bottom: 6px;"></div>
                    </div><br><br></form>                    
                </div>
                <div class="">
                <button type="button" class="btn_modal" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn_modal" data-dismiss="modal" onclick="assignaRotacioMultipers(rotapersona.stridpersona.value,rotapersona.strdataini.value,rotapersona.datafi.value);"><span class="glyphicon glyphicon-calendar"></span> <?php echo $dto->__($lng,"Crear");?></button>
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
    <div class="modal fade" id="modErrSelect" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 25px"><?php echo $dto->__($lng,"No hi ha cap Persona seleccionada"); ?></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
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
                        <img src="./Pantalles/img/Loading_icon.gif" style="height: 200px; width: 280px">
                                       
                    </div>
              </div>
            </div>                
            </center>
        </div>

        <script>        
        function chkAllPers(numpers)
        {
           
            if(numpers>0) {
                if(document.getElementById('chkallpers').checked === true) {
                    for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = true;
                }
                else for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = false;
            }
        }
        function asgMultDataini(numpers)
        {
           
            var anychk = 0;
            var stridpers = [];
            var nompers = "<tbody>";
            for(var i=1;i<=numpers;i++) {
                if(document.getElementById('pers'+i).checked === true) {                    
                    anychk=1;
                    stridpers.push(document.getElementById("idpers"+i).value);
                    nompers+="<tr><td>"+document.getElementById('nompers'+i).value+"</td></tr>";
                }
            }
            nompers+="</tbody>";
                
            if(anychk===1) {
                document.getElementById('stridpersonadate').value = stridpers;
                document.getElementById('nomspers').innerHTML = nompers;
                $modal = $('#modAsgMultDataini');
                $modal.modal('show');
            }
            else {
                $modal = $('#modErrSelect');
                $modal.modal('show');
            }
        }
        function assignaDatainiMultipers(stridpers,dataini)
        {
            
            popupwait();
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                popdownwait();
                window.location.reload(window.location);
                
            }
            if (this.readyState === 4 && this.status === 404) {
                popdownwait();
                popuphtml(this.responseText);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaDatainiMultipers&stridpers=" + JSON.stringify(stridpers) + "&2=" + dataini, true);
            xmlhttp.send();
        }
        function asgMultRot(numpers)
        {
            
            var anychk = 0;
            var stridpers = [];
            var strdataini = [];
            var nompers = "<tbody>";
            for(var i=1;i<=numpers;i++) {
                if(document.getElementById('pers'+i).checked === true) {
                    var data = new Date(document.getElementById('datainirot'+i).value);
                    var dd = data.getDate();
                    if(dd<10) { dd = "0"+dd; }
                    var mm = data.getMonth()+1;
                    if(mm<10) { mm = "0"+mm; }
                    var datacomp = dd+"/"+mm+"/"+data.getFullYear();
                    anychk=1;
                    stridpers.push(document.getElementById("idpers"+i).value);
                    strdataini.push(document.getElementById("datainirot"+i).value);
                    nompers+="<tr><td>"+document.getElementById('nompers'+i).value+"</td><td>"+datacomp+"</td></tr>";
                }
            }
            nompers+="</tbody>";
                    
            if(anychk===1) {
                document.getElementById('stridpersona').value = stridpers;
                document.getElementById('strdataini').value = strdataini;
                document.getElementById('nomspers').innerHTML = nompers;
                $modal = $('#modAsgMultRot');
                $modal.modal('show');
            }
            else {
                $modal = $('#modErrSelect');
                $modal.modal('show');
            }
        }
        function assignaRotacioMultipers(stridpers,strdataini,datafi)
        {
           
            popupwait();
            var data = new Date(datafi);
            var mm = data.getMonth()+1;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                popdownwait();
                window.location.replace("/AdminQuadrants.php?mes="+mm);
               
            }
            if (this.readyState === 4 && this.status === 404) {
                popdownwait();
                popuphtml(this.responseText);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaRotacioMultipers&stridpers=" + JSON.stringify(stridpers) + "&2=" + JSON.stringify(strdataini) + "&3=" + datafi, true);
            xmlhttp.send();
        }
        </script>
		
		
		

    </body>
   
</html>
