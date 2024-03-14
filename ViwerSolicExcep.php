<!DOCTYPE html>
<html>
    <head id="header">
    
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

</style>


        <script type="text/javascript">
            function CahngeStateSolcExepct(ObserData,SolictID,type,MSJobligt){
            
                if (ObserData.value == '') {
                    alert(MSJobligt)
                    return;
                }
    
                if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                };
                var lati = pos['lat'];
                var long = pos['lng'];
                
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    window.location.reload(window.location);
                }
                };
                
                ObserData = encodeURI(ObserData.value)
    
                xmlhttp.open("GET", "Serveis.php?action=UpdateStateSolicExcep&id=" + SolictID + "&Obs=" + ObserData + "&Type=" + type+ "&utm_x=" + lati+ "&utm_y=" + long, true);
                xmlhttp.send();
    
                }, function() {
                       
                        navigator.permissions.query({name:'geolocation'})
                                .then(function(permissionStatus) {
                                    popuphtml('geolocation permission state is ', permissionStatus.state);
            
                                    permissionStatus.onchange = function() {
                                    popuphtml('geolocation permission state has changed to ', this.state);
                                    };
                                });
                        });
                    }  
            
                        
                }
        </script>
    </head> 
  
    <body class="well">
    <div class="modal fade" id="modContent"></div>
       <?php
        $idemp = $_SESSION["idempresa"];
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_SESSION["id"];
        $master = $dto->esMaster($id);
        $idempresa = $idemp;
        $idsubempdef = 0;
        $rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa='.$idemp.' limit 1');
        foreach($rssbe as $se) {$idsubempdef = $se["idsubempresa"];}
        if(!isset($_GET["idsubemp"])){
            if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
            else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
            else $_GET["idsubemp"]=$idsubempdef;
        }
        $idsubemp = $_GET["idsubemp"];
        $TypeView = $_GET["View"];
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

        if($TypeView != '957'){
            $FilterTable = "excepcio.idresp = ".$id;
        }else {
            $FilterTable = "excepcio.idresp is not null";
        }

        $result = $dto->getDb()->executarConsulta('SELECT excepcio.idresp,excepcio.idtipusexcep,excepcio.idexcepcio, empleado.nom as empleatnom,empleado.cognom1 as empleadocognom1, empleado.cognom2 as empleadocognom2, tipusexcep.nom as tipusexcepnom , datainici , datafinal'
            .' , excepcio.observacions ,empleRespns.cognom1 as empleRespnscognom1 ,empleRespns.cognom2 as empleRespnscognom2, empleRespns.nom as empleRespnsnom , aprobada , dataaprovacio , excepcio.idempleat '
            .' FROM excepcio left join empleat as empleado on empleado.idempleat = excepcio.idempleat '
            .' left join tipusexcep on tipusexcep.idtipusexcep = excepcio.idtipusexcep '
            .' left join empleat as empleRespns on empleRespns.idempleat = excepcio.idresp '
            .'where '.$FilterTable
        );
        
        $tblpers = "";
        $i = 0;
            foreach ($result as $row)
            {

                    $stateExept = $dto->__($lng,"pendiente");
                    if($row["aprobada"] == '1') $stateExept = $dto->__($lng,"aprobada");
                    else if($row["aprobada"] == '0') $stateExept = $dto->__($lng,"Denegada");
                    
                    $tblpers.= "<tr>"
                      ."<td>".$row["empleatnom"]. " " .$row["empleadocognom1"]." ".$row["empleadocognom2"].   "</td>"
                      ."<td>".$dto->__($lng,$row["tipusexcepnom"])."</td>"
                      ."<td>".$row["datainici"]."</td>"
                      ."<td>".$row["datafinal"]."</td>"
                      ."<td>".$stateExept."</td>";

                    if($TypeView == '957'){
                        $tblpers.="<td>".$row["empleRespnsnom"]." ".$row["empleRespnscognom1"]." ".$row["empleRespnscognom2"]."    </td>";
                    }

                      
                    $tblpers .= '<td style="background-color: rgb(255,255,255)">
              <button class="btn-blue" onclick="VerSolicExcep('.$row["idexcepcio"].','.$row["idtipusexcep"].",'".$row["datainici"]."','".$row["datafinal"]."'".','.$row["idresp"].','.$id.');">
                <i class="fa fa-eye"></i>'.'
              </button>';

                              
                      if( is_null($row["aprobada"])){
                          
                        $tblpers .= '<button class="btn-green" onclick="CahngeStateSolicExep('.$row["idexcepcio"].',1,'.$row["idempleat"].');">'
            .'<i class="fa fa-check-circle"></i> '.$dto->__($lng, "Aceptar").'</button>'



                          .'<button class="btn-red" onclick="CahngeStateSolicExep('.$row["idexcepcio"].',0,'.$row["idempleat"].');">'
                          .'<i class="fa fa-times-circle"></i> '.$dto->__($lng, "Denegar").'</button>'




                          .'<a href="comentario.php?idexcepcio=' . $row["idexcepcio"] . '&idempleat=' . $_SESSION["id"] . '" class="btn-blue" target="_blank>'
                          . '<i class="fa fa-user"></i> '.$dto->__($lng, "Chat").'</a>';
                          

                          
                      }

                      $tblpers.= "</td></tr>";
            }
        ?>
        <center>
            <br>    
        <div class="row" id="FiltresEmpleats">
           
            <div class="col-lg-12">            
                <div class="col-lg-3"><h2><?php echo $dto->__($lng,"Solicitud de periodos") ?></h2>
                </div>
            </div>
        </div>            
          <br><br>
        <div class="row">
    <div class="col-lg-12">
        <form id="tblpers" onsubmit="event.preventDefault();">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr style="background-color: #f5f5f5; color: black; font-size:large;">
                            <td class="col-lg-2"><?php echo $dto->__($lng,"Empleado");?></td>
                            <th class="col-lg-1"><?php echo $dto->__($lng,"Tipus");?></th>
                            <th class="col-lg-2"><?php echo $dto->__($lng,"Inici");?></th>
                            <th class="col-lg-1"><?php echo $dto->__($lng,"Final");?></th>
                            <th class="col-lg-2"><?php echo $dto->__($lng,"Estado");?></th>
                            <?php
                            if($TypeView == '957'){
                                echo '<th style="font-size:medium">'.$dto->__($lng,"Responsable").'</th>';
                            }   
                            ?> 
                            <th class="col-lg-2" style='font-size:medium'><?php echo $dto->__($lng,"Acciones");?></th>
                        </tr>
                    </thead>
        <tbody style="background-color: white; overflow-y: auto">
            <?php
            echo $tblpers;
        ?>       
        </tbody>
        </table>
            </form>
        
        </div>        
       
            </div>
            </center>
        </div>
            
    </body>
    
</html>



