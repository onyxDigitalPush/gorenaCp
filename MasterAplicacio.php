<!DOCTYPE html>
<html><?php session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        $dto->navResolver();
        ?>
    <head>
    <script>
    </script>
    </head> 
    <body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%; overflow-x: hidden; overflow-y: hidden;">
        <div class="modal fade" id="modLogo"></div>      
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
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
        <div class="modal fade" id="modFlash"></div>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> 
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $idempresa = 0;
        if(isset($_SESSION["idempresa"])) $idempresa = $_SESSION["idempresa"];
        ?>
    <center>
    <div class="row" style="font-size: 12px">
    <div class="col-lg-1"></div>
    <div class="col-lg-10 well" style="height: 800px; overflow-x: auto; overflow-y: auto;">        
        <h3><?php echo $dto->__($lng,"Ajustaments Aplicació"); ?></h3>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#empreses"><?php echo $dto->__($lng,"Empreses i Subempreses");?></a></li>
           
        </ul>
        <div class="tab-content">
          <div id="empreses" class="tab-pane fade in active">
            <br><h3><?php echo $dto->__($lng,"Empreses i Subempreses");?> <button type="button" class="btn btn-lg btn-success" title="<?php echo $dto->__($lng,"Crear Nova Empresa");?>" onclick="mostraNovaEmpresa();"><span class="glyphicon glyphicon-plus"></span></button></h3><br>
            <div style="height: 550px; overflow-x: auto; overflow-y: auto;">
            <table class="" style=""> 
            <thead>
                <th colspan="3"><?php echo $dto->__($lng,"Empreses");?></th>
                <th colspan="3"><?php echo $dto->__($lng,"Subempreses");?></th>
            </thead>
            <tbody style="background-color: white; height: 300px; overflow-y: scroll">
                <?php
                $rse = $dto->mostraEmpreses();
                $l = 0;
                foreach ($rse as $empr) {
                    $l++;
                    $activeemp = "";
                    $btnsetemp = "";
                    $titlesetemp = "";
                    $cursorsetemp = "";
                    if($idempresa==$empr["idempresa"]) $activeemp = '<span class="glyphicon glyphicon-ok" title="Empresa de la Sessió Actual" style="height: 25px; width: 25px; color: green"></span>';
                    else {$btnsetemp = 'onclick="changeSessionIdempresa('.$empr["idempresa"].');"';$titlesetemp= 'title="Establir com a Empresa de la Sessió"';$cursorsetemp='cursor: pointer;';}
                    $rss = $dto->getDb()->executarConsulta('select * from subempresa where idempresa='.$empr["idempresa"]);
                    $nsb = 1;
                    $tdsbe1 = "";
                    $tdsbeZ = "";
                    $btnxe = "";
                    $style = "";
                    if($l%2==0) $style= 'style="background-color: lightgray"';
                    $i = 0;
                    foreach($rss as $sbe) {
                        $i++;
                        $btnxs = '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Descripció").'" onclick="mostraDescripcio('.$sbe["idsubempresa"].')">'
                            . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
                            . '<a class="btn btn-xs btn-warning" title="'.$dto->__($lng,"Edita Subempresa").'" onclick="editaSubemp"('.$sbe["idsubempresa"].');">'
                            . '<span class="glyphicon glyphicon-pencil"></span></a>';
                        if($i>1) {$nsb++;}
                        $logosbe = '<button class="btn btn-default btn-lg" title="'.$dto->__($lng,"Afegir Logo").'" onclick="mostraAfegirLogoSubemp"('.$sbe["idsubempresa"].');">'
                            . '<span class="glyphicon glyphicon-plus"></span></a>';
                        if(!empty($sbe["ruta_logo"])) $logosbe = '<img src="'.$sbe["ruta_logo"].'" style="height: 100px; width: 200px">';
                        $rsste = $dto->getDb()->executarConsulta('select idempleat from empleat where idsubempresa='.$sbe["idsubempresa"]);
                        if(empty($rsste)) $btnxs.= '<button class="btn btn-danger btn-xs" onclick="confElimSubemp('.$sbe["idsubempresa"].');" title="'.$dto->__($lng,"Elimina Subempresa").'"><span class="glyphicon glyphicon-remove"></span></button>'; 
                        $tdsbe = '<label style="background-color: white; border: solid 1px; border-radius: 5px; padding: 3px">'.$sbe["nom"].'</label>';
                        if($nsb==1) {$tdsbe1 = '<td>'.$tdsbe.'</td><td>'.$logosbe.'</td><td>'.$btnxs.'</td>';}
                        else {$tdsbeZ.= '<tr '.$style.'><td>'.$tdsbe.'</td><td>'.$logosbe.'</td><td>'.$btnxs.'</td></tr>';}
                    }
                    
                    $logoemp = '<a onclick="mostraEditaLogo('."'logoemp".$empr["idempresa"]."','empresa',".$empr["idempresa"].",'ruta_logo'".');"><image id="logoemp'.$empr["idempresa"].'" src="'.$dto->getRutaLogo($empr["idempresa"]).'" title="'.$dto->__($lng,"Click per a canviar el logo de l'empresa").'" alt="Logo '.$dto->mostraNomEmpresa($empr["idempresa"]).'" style="width: 200px; border: solid 1px; cursor: pointer"></a>';
                   
                    if(empty($rss)) $btnxe = '<button class="btn btn-danger btn-xs" onclick="confElimEmp('.$empr["idempresa"].');" title="'.$dto->__($lng,"Elimina Empresa").'"><span class="glyphicon glyphicon-remove"></span></button>'; 
                    echo '<tr rowspan="'.$nsb.'" '.$style.'>'
                        . '<td rowspan="'.$nsb.'">'
                            . '<label style="background-color: white; border: solid 1px; border-radius: 5px; padding: 3px; '.$cursorsetemp.'" '.$titlesetemp.' '.$btnsetemp.'>'.$empr["nom"].'</label> '.$activeemp
                        . '</td>'
                            . '<td rowspan="'.$nsb.'">'.$logoemp.'</td>'
                        . '<td rowspan="'.$nsb.'">'
                            . '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Descripció").'" onclick="mostraDescripcio('.$empr["idempresa"].')">'
                            . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
                            . '<a class="btn btn-xs btn-primary" title="'.$dto->__($lng,"Edita Administrador").'" onclick="mostraEditaAdminEmp('.$empr["idempresa"].');">'
                            . '<span class="glyphicon glyphicon-user"></span></a>'
                            . '<button type="button" class="btn btn-xs btn-success" title="'.$dto->__($lng,"Crear Subempresa").'" onclick="mostraNovaSubemp('.$empr["idempresa"].');">'
                            . '<span class="glyphicon glyphicon-plus"></span></button>'
                            . '<a class="btn btn-xs btn-warning" title="'.$dto->__($lng,"Edita Empresa").'" onclick="mostraEditaEmp('.$empr["idempresa"].');">'
                            . '<span class="glyphicon glyphicon-pencil"></span></a>'
                            . $btnxe
                        . '</td>'
                        . $tdsbe1
                        . '</tr>'.$tdsbeZ;
                    
                }
                ?>
            </tbody>
            </table>
            </div>
        <br>
        </div>
        <div id="conceptes" class="tab-pane fade in">
            <div class="row">
                <div class="col-lg-6">
            <?php
            if($dto->teEdicioConceptes($idempresa))
            {
           
                echo ''
            .'<br><h4 title="'.$dto->__($lng,"Veure, editar i Crear Logos de la pantalla de marcatges").'">'.$dto->__($lng,"Logos Marcatges").'</h4><br>'
                    .'<table class="table-hover table-bordered table-condensed">'
                    .'<thead><th colspan="2" style="text-align: center">'.$dto->__($lng,"Activitats").'</thead>'
                    .'<tbody>';
            $activitats = $dto->mostraTipusActivitatsPerEmpresa($idempresa);
            foreach ($activitats as $entrada)
            {
                echo '<tr><td title="'.$dto->__($lng,$entrada["descripcio"]).'">'.$dto->__($lng,$entrada["nom"]).'</td>'
                        . '<td><img src="'.$dto->getLogoIn($idempresa,$entrada["idtipusactivitat"]).'" style="width: 30px; height: 30px"></td>'
                        . '<td><img src="'.$dto->getLogoOut($idempresa,$entrada["idtipusactivitat"]).'" style="width: 30px; height: 30px"></td>';
            }
            echo '</tbody></table><br><br>';
            }
            ?>
                </div>
                <div class="col-lg-6">
            <?php    
            if($dto->teEdicioConceptes($idempresa))
            {
              
                echo ''
                    .'<br><label>'.$dto->__($lng,"Seleccionar Conceptes Especials d´Entrada i Sortida").'</label><br>'
                    .'<label>'.$dto->__($lng,"Veure desplegable de Conceptes").' </label> <input type="checkbox" style="height: 25px; width: 25px"/><br>';
                $tipusico = $dto->mostraTipusActivitatsEspecialsPerEmpresa($idempresa);
                echo '<br>Logo 1<br>'
                    .'<select>'
                    .'<option>'.$dto->__($lng,"Cap").'</option>';
                foreach($tipusico as $icon)
                echo '<option value="'.$icon["idrealitza"].'">'.$dto->__($lng,$icon["nom"]).'</option>';
                echo '</select><br>'
                    .'<br>Logo 2<br>'
                    .'<select>'
                    .'<option>'.$dto->__($lng,"Cap").'</option>';
                foreach($tipusico as $icon)
                echo '<option value="'.$icon["idrealitza"].'">'.$dto->__($lng,$icon["nom"]).'</option>';
                echo '</select><br>'
                    .'<br>Logo 3<br>'
                    .'<select>'
                    .'<option>'.$dto->__($lng,"Cap").'</option>';
                foreach($tipusico as $icon)
                echo '<option value="'.$icon["idrealitza"].'">'.$dto->__($lng,$icon["nom"]).'</option>';
                echo '</select><br>'
                    .'<br><br>'
                    .'';
            }
            ?>
                    </div>
            </div>
        </div>
            <div id="periodes" class="tab-pane fade in">
            
        </div>
        <div id="idiomes" class="tab-pane fade in">    
            <br><label><?php echo $dto->__($lng,"Gestionar Idiomes");?></label><br><br>
            <table class="table-hover table-bordered table-condensed">
            <thead>
            <th><?php echo $dto->__($lng,"Idioma");?></th>
            <th <?php echo 'title="'.$dto->__($lng,"Abreviació").'">'.$dto->__($lng,"Abr.");?></th>
            <th><?php echo $dto->__($lng,"Bandera");?></th>
            </thead>
            <tbody>
                <?php
                $idiomes = $dto->mostraTotsIdiomes();
                foreach($idiomes as $i) echo '<tr><td><input data-old_value="'.$i["nom"].'" value="'.$i["nom"].'" title="'.$dto->__($lng,"Clica per a editar nom").'"'
                    . 'onblur="actualitzaCampTaula('."'idioma','nom',".$i["ididioma"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>'
                    . '<td><input style="width: 35px" data-old_value="'.$i["abrev"].'" value="'.$i["abrev"].'" title="'.$dto->__($lng,"Clica per a editar nom").'"'
                    . 'onblur="actualitzaCampTaula('."'idioma','abrev',".$i["ididioma"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>'
                    . '<td><img src="'.$i["ruta_bandera"].'" style="witdh: 20px; height: 20px"></td>'
                    . '</tr>'
                ?>
            </tbody>
            </table><br><br>
            <label></label><br><br>
            <?php
            if($dto->teEdicioIdioma($idempresa))
            {
                
                echo ''
                    .'<br><label>'.$dto->__($lng,"Definir Preferències de sistema").'</label><br><br>'
                    .'<table class="table-hover table-bordered table-condensed">'
                    .'<thead><th colspan="2" style="text-align: center">'.$dto->__($lng,"Idiomes").'</thead>'
                    .'<tbody>';
                $idiomes = $dto->mostraIdiomesEmp($idempresa);
                foreach ($idiomes as $idioma)
                {
                    echo '<tr><td>'.$dto->__($lng,$idioma["nom"]).'</td>'
                    . '<td><button class="btn btn-success btn-xs" title="'.$dto->__($lng,"Predefinir").'"><span class="glyphicon glyphicon-ok"></span></button></tr>';
                }
                echo '</tbody></table><br><br>';
            }
            ?>
        </div>
    </div>
    </div>
    </div>
        <div class="modal fade" id="modNovaSubempresa" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
              <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Alta de Subempresa Nova");?></h3></div>
            <div class="modal-body">
                <h3 id="nomempacrearsub"></h3><br>
                <form name="subempresanova" onsubmit="event.preventDefault();">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"Nom");?> </label>                  
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="nomsubemp">                   
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"C.I.F/N.I.F");?> </label>                    
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="cifnif">                    
                    </div>
                </div>
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"Centre de Treball");?> </label>                    
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ctreb">                   
                    </div>
                </div>  
                    <br>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4" style="text-align: right">
                    <label><?php echo $dto->__($lng,"C.C.C.");?> </label>                   
                    </div>
                    <div class="col-lg-6" style="text-align: left">
                    <input type="text" name="ccc">                   
                    </div>
                </div>
                    <input type="hidden" name="idempacrearsub" id="idempacrearsub">
                    <br>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="button" class="btn btn-success" onclick="novaSubempresa(subempresanova.idempacrearsub.value,subempresanova.nomsubemp.value,subempresanova.cifnif.value,subempresanova.ctreb.value,subempresanova.ccc.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Crear");?></button>
                </form>
                </div>
          </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimSubEmp" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3><?php echo $dto->__($lng,"Eliminar Subempresa");?></h3>
                  </div>
                <div class="modal-body"> 
                    <form name="cessasubemp">
                    <input type="hidden" id="idsubempacessar" name="idsubempacessar">                   
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar aquesta subempresa?");?>:</h4>
                    <h3 id="nomsubempacessar"></h3><br><br>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaSubempresa(cessasubemp.idsubempacessar.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form></div>                    
                </div>
              </div>
            </div>
                
            </center>
    </div>
        <div class="modal fade" id="modMessage" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 28px"></label><br><br>
                    <button type="button" class="btn btn-default" autofocus data-dismiss="modal"><?php echo "Aceptar";?></button>                     
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
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Cerrar";?></button>                     
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
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Aceptar";?></button>                     
                    </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modLoad" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 28px">Subiendo...</label><br>
                                    
                </div>
              </div>
            </div>                
            </center>
        </div>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    </center>
    </body>
</html>
