<?php
include 'autoloader.php';
$dto = new AdminApiImpl();

switch ($_GET["action"])
{
    case "logarse":
        session_start();
        unset($_SESSION["filtidsubemp"]);
        unset($_SESSION["filtidsubempq"]);
        if (!empty($userdata = $dto->validaCredencials($_GET["user"], $_GET["pwd"]))) {
            foreach ($userdata as $user) {
                $_SESSION["username"] = $user["nom"]." ".$user["cognom1"]." ".$user["cognom2"];
                $_SESSION["idempresa"] = $user["idempresa"];
                $_SESSION["id"] = $user["idempleat"];
                $_SESSION["logoempresa"] = $dto->getRutaLogo($_SESSION["idempresa"]);
                $_SESSION["webempresa"] = $dto->getWebSite($_SESSION["idempresa"]);
                $_SESSION["ididioma"] = $dto->getIdioma($_SESSION["id"]);
        
                // Verificar si es encargado y redirigir según corresponda
                if ($dto->esEncargado($_SESSION["id"])) {
                    $_SESSION["encargado"] = 1;
                    header("Location: ViwerSolicExcep.php?View=1"); // Reemplaza 'ViwerSolicExcep.php?View=1' por la ruta que desees para los encargados
                    exit;
                }
        
                // Verificar si es master, admin o empleat
                if ($dto->esMaster($_SESSION["id"])) {
                    $_SESSION["master"] = 1;
                }
                if ($dto->esAdmin($_SESSION["id"])) {
                    $_SESSION["admin"] = 1;
                }
                if ($dto->esEmpleat($_SESSION["id"])) {
                    $_SESSION["empleat"] = 1;
                }
            }
        }
        else if(!empty($iniempresa = $dto->validaIniEmpresa($_GET["user"], $_GET["pwd"]))){
            foreach($iniempresa as $user)
            {
                $_SESSION["username"]="ADMINISTRADOR ".$user["nom"];
                $_SESSION["idempresa"]=$user["idempresa"];
                $_SESSION["id"]=0;
                $_SESSION["logoempresa"]=$dto->getRutaLogo($_SESSION["idempresa"]);
            }
            $_SESSION["admin"]=1;
        }
        
        else 
        {          
            http_response_code(404);
            if(isset($_SESSION["ididioma"])) $ididioma = $_SESSION["ididioma"];
            else $ididioma = 0;
            echo '<span class="glyphicon glyphicon-remove" style="color: red"></span> '.$dto->__($ididioma,"Login Incorrecte").'<br>';
        }                        
        break;
    case "changeSessionIdempresa":
        session_start();
        $_SESSION["idempresa"]=$_GET["1"];
        $_SESSION["logoempresa"]=$dto->getRutaLogo($_GET["1"]);
        break;
    case "actualitzaData":
        $msg = "";
        session_start();
        try{         
        $_SESSION["day"]=$_GET["day"];
        $_SESSION["month"]=$_GET["month"];
        $_SESSION["year"]=$_GET["year"];
        $d = strtotime('today');        
        $lng = $dto->getCampPerIdCampTaula("empresa",$_SESSION["idempresa"],"ididiomadef");
        $msg = $dto->__($lng,$dto->mostraNomDia((date("w",$d))))." ".abs(date("d", $d))." ".$dto->__($lng,$dto->mostraNomMes(date("m",$d)))." ".date("Y",$d);   
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;



    case "insereixAutomarcatge":
            session_start();
            $idemp = $_GET["id"];
            $idtipus = $_GET["idtipus"];
            $datahora = $_GET["datahora"];
            $lng = $_GET["lng"];
            $resposta = "";
            try
            {
                $strwebdate = strtotime(date('Y-m-d', strtotime($datahora)));
                $strtoday = strtotime(date('Y-m-d', strtotime('today')));
                $rsid = $dto->validaIdEmpMarcatge($idemp);
                if ((!empty($rsid) && (!empty($idemp))))
                {
                    $idempleat = $dto->mostraIdEmpPerIdentificador($idemp);
                    $idempresa = $dto->getCampPerIdCampTaula("empleat", $idempleat, "idempresa");
                    $inout_previo = $dto->getUltimMarcatgePerIdEmpleat($idempleat, "entsort");
                    $fecha = new DateTime($dto->getUltimMarcatgePerIdEmpleat($idempleat, "datahora"));
                    $today_date = new DateTime();
    
                    $diff = $fecha->diff($today_date);
    
                    if (is_numeric($inout_previo) && $inout_previo == 0)
                    {
                        $inout = 1;
                    }
                    else
                    {
                        $inout = 0;
                    }
                    $primer_marcatge_entrada = $dto->selectPrimerMarcatgeActiu($idempresa);
    
    
                    if ($diff->y != 0 || $diff->m != 0 || $diff->d != 0)
                    {
                        if ($primer_marcatge_entrada == 1 && date("H") > 5)
                        {
                            $inout = 0;
                        }
                    }
    
    
                    $data = date('Y-m-d', strtotime($datahora));
                    $hora = intval(date('H', strtotime($datahora)));
                    $dataahir = date('Y-m-d H:i', strtotime($datahora . ' - 1 days'));
                    // Comprovar que l'empresa no tingui marcat el check de no registrar els marcatges si el treballador no té torn aquell dia
                    // REVISAR QUE SI TE HORARI PERO AQUELL DIA NO ES LABORABLE, NO HA DE MARCAR!!!
    
                    if (
                        ($dto->getCampPerIdCampTaula("empresa", $idempresa, "noregmarcsensehorari") == 1) &&
                        ($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $data) == 0) &&
                        (
                            ($dto->esTornBidata($idempleat, $dataahir) == 0) ||
                            (($dto->esTornBidata($idempleat, $dataahir) == 1) && ($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir) == 0)) ||
                            (($dto->esTornBidata($idempleat, $dataahir) == 1) && ($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir) > 0) && ($hora > 7))
                        )
                    )
                    {
    
                        http_response_code(300);
                        
                        // MOSTRAR MISSATGES DE BENVINGUDA O COMIAT COM SI S'HAGÚES REGISTRAT EL MARCATGE
                        if ($inout == 0)
                        {
                            $resposta .= $dto->__($lng, $dto->welcome("Benvingut/da")) . ', ' . $dto->mostraNomEmpPerCodi($idemp);
                        } //$dto->getEmpSex($idemp)
                        if ($inout == 1)
                        {
                            $resposta .= $dto->__($lng, "Fins aviat") . ', ' . $dto->mostraNomEmpPerCodi($idemp);
                        }
                    }
                    else
                    {
                        $ipaddress = '';
                        if (getenv('HTTP_CLIENT_IP'))
                            $ipaddress = getenv('HTTP_CLIENT_IP');
                        else if (getenv('HTTP_X_FORWARDED_FOR'))
                            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                        else if (getenv('HTTP_X_FORWARDED'))
                            $ipaddress = getenv('HTTP_X_FORWARDED');
                        else if (getenv('HTTP_FORWARDED_FOR'))
                            $ipaddress = getenv('HTTP_FORWARDED_FOR');
                        else if (getenv('HTTP_FORWARDED'))
                            $ipaddress = getenv('HTTP_FORWARDED');
                        else if (getenv('REMOTE_ADDR'))
                            $ipaddress = getenv('REMOTE_ADDR');
                        else
                            $ipaddress = 'UNKNOWN';
                        $ip = $_SERVER['REMOTE_ADDR'];
    
                        $arrloc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
    
    
                        $dto->insereixMarcatgeComplet($idemp, $idtipus, $inout, $datahora, $ipaddress, $_GET["utm_x"], $_GET["utm_y"], $arrloc['geoplugin_city'], $arrloc['geoplugin_region'], $arrloc['geoplugin_country']);
    
                        if ($inout == 0)
                        {
                            $resposta .= $dto->__($lng, $dto->welcome("Benvingut/da")) . ', ' . $dto->mostraNomEmpPerCodi($idemp);
                        } 
                        if ($inout == 1)
                        {
                            $resposta .= $dto->__($lng, "Fins aviat") . ', ' . $dto->mostraNomEmpPerCodi($idemp);
                        }
                    }
                }
                else
                {
                    $resposta = '<span class="glyphicon glyphicon-remove" style="color: red"></span><br><br>' . $dto->__($lng, "Identificador Incorrecte") . '<br>';
                    http_response_code(404);
                }
            }
            catch (Exception $ex)
            {
                $resposta = $ex->getMessage();
                http_response_code(300);
            }
            echo $resposta;
            break;






    case "insereixMarcatge":
        session_start();
        $idemp = $_GET["id"];
        $idtipus = $_GET["idtipus"];
        $inout = $_GET["inout"];
        $datahora = $_GET["datahora"];
        $lng = $_GET["lng"];
        $resposta = "";
        try{            
        $strwebdate = strtotime(date('Y-m-d',strtotime($datahora)));
        $strtoday = strtotime(date('Y-m-d',strtotime('today')));        
        $rsid = $dto->validaIdEmpMarcatge($idemp);
        if((!empty($rsid)&&(!empty($idemp))))
            {
                 $idempleat = $dto->mostraIdEmpPerIdentificador($idemp);          
                        $idempresa = $dto->getCampPerIdCampTaula("empleat",$idempleat,"idempresa");
        
        
                        $fecha = date("Y-m-d", strtotime($dto->getUltimMarcatgePerIdEmpleat($idempleat, "datahora")));
                        $fecha = new DateTime($fecha);
                        $today_date = new DateTime();
                        $diff = $fecha->diff($today_date);
                        $primer_marcatge_entrada = $dto->selectPrimerMarcatgeActiu($idempresa);

							//CAMBIAR SI ES PRIMER MARCAJE DEL DIA A ENTRADA
                        if (($diff->y != 0 || $diff->m != 0 || $diff->d != 0) && $primer_marcatge_entrada == 1 && date("H") > 5) $inout = 0;
                       
        
                        $data = date('Y-m-d',strtotime($datahora));
                        $hora = intval(date('H',strtotime($datahora)));
                        $dataahir = date('Y-m-d H:i',strtotime($datahora.' - 1 days'));
                // Comprovar que l'empresa no tingui marcat el check de no registrar els marcatges si el treballador no té torn aquell dia
                
                // REVISAR QUE SI TE HORARI PERO AQUELL DIA NO ES LABORABLE, NO HA DE MARCAR!!!
                if(
                    ($dto->getCampPerIdCampTaula("empresa",$idempresa,"noregmarcsensehorari")==1)
                    &&
                    ($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $data)==0)
                    &&
                    (
                        ($dto->esTornBidata($idempleat, $dataahir)==0)
                        ||
                        (($dto->esTornBidata($idempleat, $dataahir)==1)&&($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)==0))
                        ||
                        (($dto->esTornBidata($idempleat, $dataahir)==1)&&($dto->seleccionaHoresTeoriquesPerIdDia($idempleat, $dataahir)>0)&&($hora>7))
                    )
                    
                )
                    {
                    http_response_code(300);
                   
                    // MOSTRAR MISSATGES DE BENVINGUDA O COMIAT COM SI S'HAGÚES REGISTRAT EL MARCATGE
                    if($inout==0){$resposta.= $dto->__($lng,$dto->welcome("Benvingut/da")).', '.$dto->mostraNomEmpPerCodi($idemp);}
                    if($inout==1){$resposta.= $dto->__($lng,"Fins aviat").', '.$dto->mostraNomEmpPerCodi($idemp);}
                }
                else{
                    $ipaddress = '';
                    if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
                    else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                    else if(getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
                    else if(getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    else if(getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
                    else if(getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
                    else $ipaddress = 'UNKNOWN';
                    $ip=$_SERVER['REMOTE_ADDR'];
                    $arrloc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));                
                    $dto->insereixMarcatgeComplet($idemp,$idtipus,$inout,$datahora,$ipaddress,$_GET["utm_x"],$_GET["utm_y"],$arrloc['geoplugin_city'],$arrloc['geoplugin_region'],$arrloc['geoplugin_country']);
                    if($inout==0){$resposta.= $dto->__($lng,$dto->welcome("Benvingut/da")).', '.$dto->mostraNomEmpPerCodi($idemp);}
                    if($inout==1){$resposta.= $dto->__($lng,"Fins aviat").', '.$dto->mostraNomEmpPerCodi($idemp);}
                }
            }
        else
        {
            $resposta = '<span class="glyphicon glyphicon-remove" style="color: red"></span><br><br>'.$dto->__($lng,"Identificador Incorrecte").'<br>';
            http_response_code(404);
        }        
        } catch (Exception $ex) {
            $resposta = $ex->getMessage();
            http_response_code(300);
        }
        echo $resposta;
        break;
    case "insereixMultiMarcatges":
        $msg = "";
        $id= $_GET["id"];
        $dataini= $_GET["dataini"];
        $horaini= $_GET["horaini"];
        $datafi= $_GET["datafi"];
        $horafi= $_GET["horafi"];
        $chkhrqd= $_GET["chkhrqd"];
        $chkhrrd= $_GET["chkhrrd"];
        try{
            $dto->eliminaMarcajesExistente($id, $dataini, $datafi);
           $dto->insereixMultiMarcatges($id,$dataini,$horaini,$datafi,$horafi,$chkhrqd,$chkhrrd); 
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "insereixMarcatgeObs":
        $msg = "Hola";
        
        echo $msg;
        break;
    case "insereixMarcatgeObs2":
        $msg = "";
        $id = $_GET["id"];
        $data = $_GET["data"];
        try{
        
            $dto->insereixMarcatgeObs($_GET["id"], $_GET["entsort"], $_GET["tipus"], $_GET["data"]." ".$_GET["hora"],$_GET["obs"]);
        //}
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "editaMarcatgeObs":
        $msg = "";
        try{
            $dto->editaMarcatgeObs($_GET["id"], $_GET["entsort"], $_GET["tipus"], $_GET["data"]." ".$_GET["hora"],$_GET["obs"]);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "actualitzaHoraMarc":
        $dto->actualitzaMarcatge($_GET["idmarcatge"], $_GET["novahora"]);
        break;
    case "actualitzaObsMarc":
        $dto->observacionsMarcatge($_GET["idmarcatge"],$_GET["observ"]);
        break;
    case "validaMarc":
        $llistaidmarc = explode("|",$_GET["idsmarcatges"]);
        foreach ($llistaidmarc as $idmarc) $dto->validaMarcatge($idmarc);
        break;
    case "desvalidaMarc":
        $llistaidmarc = explode("|",$_GET["idsmarcatges"]);
        foreach ($llistaidmarc as $idmarc) $dto->desValidaMarcatge($idmarc,$_GET["weekday"]);
        break;
    case "validaMarcDia":
        $llistaidmarc = explode("|",$_GET["idsmarcatges"]);
        foreach ($llistaidmarc as $idmarc) $dto->validaMarcatgesDia($idmarc,$_GET["weekday"]);
        break;
    case "eliminaMarcatge":
        $dto->eliminaMarcatge($_GET["idmarcatge"]);
        break;
    case "startFPcheck":
        $msg = "";
        try{
            
            exec("java -jar ./js/NBioBSPJNI.jar 2>&1", $output2);
            
            $msg.= print_r($output2);
            
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "afegeixUbicacio":
        $msg = "";
        session_start();
        $idempresa = $_SESSION["idempresa"];
        try{
            $dto->creaNovaUbicacio($idempresa, $_GET["1"],0,0,0,0);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "afegeixFestiuUbicacio":
        $msg = "";
        $anual = 1;
        $dia = $_GET["2"];
        $mes = $_GET["3"];
        $dataany = $_GET["4"];
        
        if((!empty($dataany))&&($dataany!="0000-00-00")) $anual = 0;
        try {
            $dto->afegeixFestiuUbicacio($_GET["1"], $dia, $mes, $dataany, $anual, $_GET["5"]);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "assignaUbicacio":
        $dto->assignaUbicacioPersona($_GET["id"], $_GET["idubicacio"], $_GET["datainici"], $_GET["datafi"]);
        break;    
    case "editaPeriodeUbicacio":
        $dto->editaPeriodeUbicacio($_GET["idsituat"], $_GET["idubicacio"], $_GET["dataini"], $_GET["datafi"]);
        break;
    case "eliminaPeriodeUbicacio":
        $dto->eliminaPeriodeUbicacio($_GET["idsituat"]);
        break;
    case "assignaHorariTipus":
        $dto->assignaHorariEmpPerPlantilla($_GET["id"], $_GET["idtipus"], $_GET["datainici"], $_GET["datafi"]);
        break;
    case "editaPeriodeHorari":
        $dto->editaPeriodeHorari($_GET["idquadrant"], $_GET["idtipus"], $_GET["dataini"], $_GET["datafi"]);
        break;
    case "eliminaPeriodeHorari":
        $dto->eliminaPeriodeHorari($_GET["idquadrant"]);
        break;
    case "assignaExcep":
        $dto->assignaExcepcio($_GET["id"], $_GET["idtipus"], $_GET["dataini"], $_GET["datafi"], $_GET["coment_excepcio"]);
        break;
    case "UpdateStateSolicExcep":
            $dto->UpdateStateSolicExcepcion($_GET["id"], $_GET["Obs"], $_GET["Type"], $_GET["utm_x"], $_GET["utm_y"]);
            break;
    case "Solicitexcep":
        $dto->Solicitexcepci($_GET["id"], $_GET["idtipus"], $_GET["dataini"], $_GET["datafi"],$_FILES,$_GET["idEncargado"], $_GET["coment_excepcio"]);
        break;
    case "ModSolicitexcep":
        $dto->ModSolicitexcep($_GET["id"], $_GET["idtipus"], $_GET["dataini"], $_GET["datafi"],$_FILES,$_GET["idEncargado"], $_GET["coment_excepcio"]);
        break;
    case "editaExcep":
		$dto->editException($_GET["idexcep"], $_GET["tipus"], $_GET["dataini"], $_GET["datafi"], $_GET["comentario"]);
        //$dto->editaExcepcio($_GET["idexcep"], $_GET["tipus"], $_GET["dataini"], $_GET["datafi"], $_GET["comentario"]);
        break;
    case "DeleteFile":
        $dto->DeleteFile($_GET["FilePath"]);
        break;
    case "eliminaExcep":
		$dto->deleteException($_GET["idexcep"]);
        //$dto->eliminaExcepcio($_GET["idexcep"]);
        break;
    case "assignaActivitat":
        $dto->assignaActivitat($_GET["id"], $_GET["idtipus"], $_GET["data"], $_GET["horaini"],$_GET["horafi"]);
        break;
    case "eliminaActivitat":
        $dto->eliminaActivitat($_GET["id"]);
        break;
    case "novaPersona":
        $msg = "";
        try{
            $dto->altaPersona($_GET["idempresa"],$_GET["cognom1"],$_GET["cognom2"],$_GET["nom"],$_GET["dni"],$_GET["datanaix"],$_GET["numafil"],$_GET["dpt"],$_GET["rol"],$_GET["subemp"],$_GET["respasg"]);            
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "creaRol":       
        session_start();
        $msg = "";
        try{
        $dto->crearRol($_GET["1"], $_SESSION["idempresa"], $_GET["2"], $_GET["3"], $_GET["4"]);    
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "editaRol":
        $msg = "";
        try{
        $dto->getDb()->executarSentencia('update rol set nom="'.$_GET["2"].'",esempleat='.$_GET["3"].',esadmin='.$_GET["4"].',esmaster='.$_GET["5"].' where idrol='.$_GET["1"]);    
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "generaTaulaRols":
        $msg = "";
        session_start();
        try{
            $rolstipus = $dto->mostraRols($_SESSION["idempresa"],$dto->esMaster($_SESSION["id"]));
            foreach ($rolstipus as $role) 
                $msg.= '<tr style="font-weight: bold"><td><input contenteditable data-old_value="'.$role["nom"].'" value="'.$role["nom"].'" title="'.$dto->__($_SESSION["ididioma"],"Clica per a editar nom").'"'
                    . 'onblur="actualitzaCampTaulaNR('."'rol','nom',".$role["idrol"].',this.getAttribute('."'data-old_value'".'),this.value);"></td><td>'
                    
                    . '<button class="btn btn-xs btn-warning" title="Edita Permisos" onclick="mostraEditaRol('.$role["idrol"].');">'
                    . '<span class="glyphicon glyphicon-pencil"></span></button>'
                    . '</tr>';
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "cessaPersona":
        $dto->cessarPersona($_GET["idpers"]);
        break;
    case "changeEncargVal":
            $dto->changeEncargVal($_GET["idempleat"],$_GET["newVal"]);
            break;
            
    case "changeAutoMarcaje":
                $dto->changeAutoMarcaje($_GET["idempleat"],$_GET["newVal"]);
                break;

    case "changeHoraElectVal":
        $dto->changeHoraElectVal($_GET["idtipusexcep"],$_GET["newVal"]);
        break;
    case "reactivaPersona":
        $dto->reactivarPersona($_GET["idpers"]);
        break;
    case "novaEmpresa":
        $msg = "";
        try{
        $idemp = 0;
        $nom = $_GET["2"];
        $nif = $_GET["3"];
        $ctreb = $_GET["4"];
        $ccc = $_GET["5"];
        $poblacio = $_GET["6"];
        // Crear Registre Realització Activitats Normal, Metge i Personal, per defecte a totes les noves empreses:
        $dto->getDb()->executarSentencia('insert into empresa (nom,cif,centre_treball,ccc,poblacio,activa,ididiomadef,numiconsesp,menuentsort,editselfprof,editiconlogo) values ("'.$nom.'","'.$nif.'","'.$ctreb.'","'.$ccc.'","'.$poblacio.'",1,2,2,0,1,1)');
        $rsemp = $dto->getDb()->executarConsulta('select max(idempresa) as idempresa from empresa where nom = "'.$nom.'"');
        foreach($rsemp as $e) {$idemp = $e["idempresa"];}
        $dto->getDb()->executarSentencia('insert into realitza (idempresa,idtipusactivitat,datainici,actiu) values ('.$idemp.',4,now(),1)');
        $dto->getDb()->executarSentencia('insert into realitza (idempresa,idtipusactivitat,datainici,actiu,ruta_logo_ent,ruta_logo_sort) values ('.$idemp.',5,now(),1,"./Pantalles/img/red_white_cross_case_green.jpg","./Pantalles/img/red_white_cross_case.jpg")');
        $dto->getDb()->executarSentencia('insert into realitza (idempresa,idtipusactivitat,datainici,actiu,ruta_logo_ent,ruta_logo_sort) values ('.$idemp.',6,now(),1,"./Pantalles/img/like_verd.jpg","./Pantalles/img/dislike_red.jpg")');
        $idact1 = 0;
        $idact2 = 0;
        $rsc1 = $dto->getDb()->executarConsulta('select idrealitza from realitza where idempresa='.$idemp.' and idtipusactivitat=5');
        foreach($rsc1 as $c1) {$idact1 = $c1["idrealitza"];}
        $rsc2 = $dto->getDb()->executarConsulta('select idrealitza from realitza where idempresa='.$idemp.' and idtipusactivitat=6');
        foreach($rsc2 as $c2) {$idact2 = $c2["idrealitza"];}
        $dto->getDb()->executarSentencia('update empresa set idconcepte1='.$idact1.',idconcepte2='.$idact2.' where idempresa='.$idemp);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "novaSubempresa":
        $msg = "";        
        try{
        $idempresa = $_GET["1"];
        $nom = $_GET["2"];
        $nif = $_GET["3"];
        $ctreb = $_GET["4"];
        $ccc = $_GET["5"];
        $poblacio = $_GET["6"];
            $dto->getDb()->executarSentencia('insert into subempresa (idempresa,nom,cif,centre_treball,ccc,poblacio) values ('.$idempresa.',"'.$nom.'","'.$nif.'","'.$ctreb.'","'.$ccc.'","'.$poblacio.'")');
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "actualitzaCampTaula":
        $msg = "";
        try{
        $dto->actualitzaCampTaula($_GET["taula"],$_GET["camp"],$_GET["idreg"],$_GET["valor"]);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "actualitzaChkExisteixCampTaula":
        session_start();
        $lng = $_SESSION["ididioma"];
        $msg = "";
        try{
            if($dto->chkExisteixValor($_GET["valor"],$_GET["camp"],$_GET["taula"])) {
                $msg = $dto->__($lng,"Aquest identificador ja està assignat a una altra persona");
                http_response_code(300);
                echo $msg;
                break;
            }
            else {
                $dto->actualitzaCampTaula($_GET["taula"],$_GET["camp"],$_GET["idreg"],$_GET["valor"]);
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "obteCampTaulaPerId":
        $res = "";
        $rs = $dto->getDb()->executarConsulta('select '.$_GET["camp"].' from '.$_GET["taula"].' where id'.$_GET["taula"].' ='.$_GET["idtaula"]);
        foreach($rs as $r) $res = $r[$_GET["camp"]];
        echo $res;
        break;
    case "assignaDpt":
        $dto->assignaDepartament($_GET["idemp"],$_GET["iddpt"]);
        break;
    case "assignaRol":
        $dto->assignaRol($_GET["idemp"],$_GET["idrol"]);
        break;
    case "assignaDatainiMultipers":
        $msg = "";
        try{
            $arridpers = explode(",",json_decode($_GET["stridpers"]));
            $datainirot = $_GET["2"];
            foreach($arridpers as $p){
                
                $dto->actualitzaCampTaula("empleat","ordredist",$p,$datainirot);
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;            
    case "creaRotacioPersonaDia":
        $msg = "";
        $p = $_GET["1"];
        $idtt = $_GET["2"];
        $data = $_GET["3"];
        $datafi = $_GET["4"];
        $repetir = $_GET["5"];
        try{
            if($repetir==0) {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}            
            if($repetir==1) {
                $dto->getDb()->executarSentencia('delete from rotacio where idempleat='.$p.' and data BETWEEN DATE("'.$data.'") AND DATE("'.$datafi.'")');
                while(strtotime($data)<=strtotime($datafi)) {
                    $dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');
                    $data = date('Y-m-d',strtotime($data.' + 1 days'));
                }
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "assignaRotacioMultipers":
        $msg = "";
        try{
            $arridpers = explode(",",json_decode($_GET["stridpers"]));
            $arrdatainirot = explode(",",json_decode($_GET["2"]));
            $datafi = $_GET["3"];
            //obtenir primer torn de nit de l'empresa amb la abreviació N
            session_start();
            $idemp = $_SESSION["idempresa"];
            $idtnn = 0;
            $rstnn = $dto->getDb()->executarConsulta('select * from tipustorn where idempresa='.$idemp.' and ((abrv like "N") or (torn=3)) limit 1');
            foreach($rstnn as $tn) {$idtnn=$tn["idtipustorn"];}
            $i = 0;
            foreach($arridpers as $p){
                $dataini = $arrdatainirot[$i];
                $dto->getDb()->executarSentencia('delete from rotacio where idempleat='.$p.' and data BETWEEN DATE("'.$dataini.'") AND DATE("'.$datafi.'")');
                $msg.="(".$p.")";
                $data = date('Y-m-d',strtotime($dataini));
                
                $sp = $dto->esSupervisor($p);                
                $idt1=$dto->getCampPerIdCampTaula("empleat",$p,"idhorari1");
                $idt2=$dto->getCampPerIdCampTaula("empleat",$p,"idhorari2");
                if(empty($idt2)) {$idt2=$idt1;}
                
                $dnat=$dto->getCampPerIdCampTaula("empleat",$p,"diesnat");
                $nits=$dto->getCampPerIdCampTaula("empleat",$p,"nits");
                $dnit=$dto->getCampPerIdCampTaula("empleat",$p,"dianit");
                $dlb1=$dto->getCampPerIdCampTaula("empleat",$p,"dieslabor");
                $dlb2=$dto->getCampPerIdCampTaula("empleat",$p,"dieslabor2");                
                $fm1=$dto->getCampPerIdCampTaula("empleat",$p,"festamesun");
                $idttt = 0; 
                $dlbtt = 0; 
                if($dto->getCampPerIdCampTaula("tipustorn",$idt1,"torn")==2) {$idttt = $idt1;}
                else {$idttt=$idt2;}
                $dlbtt=$dlb1;
                $rmix=1; 
                $dlbtot=$dlb1+$dlb2;
                if(!$dlb2>0) {$dlb2=$dlb1;$rmix=0;}
                $dfs=$dto->getCampPerIdCampTaula("empleat",$p,"diesfesta");
                $idtt=$idt1;
                $dlb=$dlb1;
                $tipusdia="L"; 
                $l=1;
                $f=1;
                $la=1; 
                $lb=1;
                $rotdn=1;
                $idt3=0;
                if($nits==1){
                    
                    $idt3 = $idtnn;
                }
                
                $nfest = 0; 
                while(strtotime($data)<=strtotime($datafi)) { 
                    if($rmix==0){
                        if(empty($dnat)||$dnat==0) {                            
                            if($dnit==0){
                                if($nits==0){                            
                                    if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                    if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt1; $dlb=$dlb1;} } else {$l++;} }
                                    if($tipusdia=="F") {
                                        if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}                                    
                                    }
                                }
                                else if ($nits==1){
                                    if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                    if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt3; $dlb=$dlb1;} else if($idtt==$idt3){$idtt=$idt1; $dlb=$dlb1;}} else {$l++;} }
                                    if($tipusdia=="F") {
                                        if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                                    }
                                }
                            }
                            if($dnit==1){ 
                                $tfrac = $dto->getCampPerIdCampTaula("tipustorn",$idtt,"torn");
                                if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                                              
                                if(($tipusdia=="L")&&($tfrac==1)&&(($rotdn%2==0)||($sp==1))) {if($la>=3) {$idtt=$idtnn;} else {$la++;}} //($rotdn>0)&&
                                if($tipusdia=="L") {if($l>=$dlb) {$l=1;$la=1;$tipusdia="F"; if($idtt==$idttt) {$rotdn++;} if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt1; $dlb=$dlb1;} else if($idtt==$idtnn){$idtt=$idttt; $dlb=$dlbtt;} }  else {$l++;} }
                                if($tipusdia=="F") {
                                        if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                                }
                            }
                        }
                        else if($dnat==1){
                            if($nits==0){
                                if(date('w',strtotime($data))==0) {$tipusdia="L";$l=1;$f=1;}
                                else if (date('w',strtotime($data))==6) {$tipusdia="F";$l=1;$f++;}
                                else {
                                    if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                    if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt1; $dlb=$dlb1;} } else {$l++;}}
                                    if($tipusdia=="F") {
                                        if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                                    }
                                }
                            }
                            else if ($nits==1){
                                if(date('w',strtotime($data))==0) {$tipusdia="L";$l=1;$f=1;}
                                else if (date('w',strtotime($data))==6) {$tipusdia="F";$l=1;$f++;}
                                else {
                                    if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                    if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt3; $dlb=$dlb1;} else if($idtt==$idt3){$idtt=$idt1; $dlb=$dlb1;} } else {$l++;}}
                                    if($tipusdia=="F") {if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                                    }
                                }
                            }
                        }
                    }
                    if($rmix==1){
                        if(empty($dnat)||$dnat==0) {
                            if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');} 
                            if($tipusdia=="L") {if($la>=$dlb1) {$idtt=$idt2;} else {$la++;}} 
                            if($tipusdia=="L") {if($l>=$dlbtot) {$l=1;$la=1;$tipusdia="F"; $idtt=$idt1;} else {$l++;}}  
                            if($tipusdia=="F") {if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                            }
                        }
                        else if($dnat==1){
                            if(date('w',strtotime($data))==0) {$tipusdia="L";$l=1;$f=1;}
                            else if (date('w',strtotime($data))==6) {$tipusdia="F";$l=1;$f++;}
                            else {
                                if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                if($tipusdia=="L") {if($la>=$dlb1) {$idtt=$idt2;} else {$la++;}} 
                                if($tipusdia=="L") {/*$l++;*/if($l>=$dlbtot) {$l=1;$la=1;$tipusdia="F"; $idtt=$idt1;} else {$l++;}}
                                if($tipusdia=="F") {if ($fm1==1) {
                                            if(($nfest%2)>0) {if($f>($dfs+1)) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            else {if($f>$dfs) {$f=1;$tipusdia="L";$nfest++;} else {$f++;}}
                                            }
                                        else {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                                }
                            }
                        }
                    }
                    $data = date('Y-m-d',strtotime($data.' + 1 days'));
                }
                $i++;
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg.= $ex->getMessage();
        }
        echo $msg;
        break;
        case "assignaRotacioMultipers3T":
        $msg = "";
        try{
            $arridpers = explode(",",json_decode($_GET["stridpers"]));
            $arrdatainirot = explode(",",json_decode($_GET["2"]));
            $datafi = $_GET["3"];
            //obtenir primer torn de nit de l'empresa amb la abreviació N
            session_start();
            $idemp = $_SESSION["idempresa"];
            $i = 0;
            foreach($arridpers as $p){
                $dataini = $arrdatainirot[$i];
                $dto->getDb()->executarSentencia('delete from rotacio where idempleat='.$p.' and data BETWEEN DATE("'.$dataini.'") AND DATE("'.$datafi.'")');
                $msg.="(".$p.")";
                $data = date('Y-m-d',strtotime($dataini));
              
                $sp = $dto->esSupervisor($p);                
                $idt1=$dto->getCampPerIdCampTaula("empleat",$p,"idhorari1");
                $idt2=$dto->getCampPerIdCampTaula("empleat",$p,"idhorari2");
                $idt3=$dto->getCampPerIdCampTaula("empleat",$p,"idhorari3");
                $tres=0;
                if(($idt1>0)&&($idt2>0)&&($idt3>0)) {$tres=1;}
                
                $dnat=$dto->getCampPerIdCampTaula("empleat",$p,"diesnat");
               
                $dlb1=$dto->getCampPerIdCampTaula("empleat",$p,"dieslabor");
                $dlb2=$dto->getCampPerIdCampTaula("empleat",$p,"dieslabor2");
                $dlb3=$dto->getCampPerIdCampTaula("empleat",$p,"dieslabor3");
                                
                $dfs=$dto->getCampPerIdCampTaula("empleat",$p,"diesfesta");
                $idtt=$idt1;
                $dlb=$dlb1;
                $tipusdia="L"; //Laborable
                $l=1;
                $f=1;
                $la=1; //dies primera part de la rotació mixta
                $lb=1;
                $stnat = 0;  //Variable per entrar per primer cop en rotació de dies naturals
                if($dnat==1){$stnat=1;}
                while(strtotime($data)<=strtotime($datafi)) {
                    if(empty($dnat)||$dnat==0) {
                        if(($tres==0)){                            
                            if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                            if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt1; $dlb=$dlb1;} } else {$l++;} }
                            if($tipusdia=="F") {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                        }
                        else if (($tres==1)){
                            if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                            if($tipusdia=="L") {if($l>=$dlb) {$l=1;$tipusdia="F"; if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt3; $dlb=$dlb3;} else if($idtt==$idt3){$idtt=$idt1; $dlb=$dlb1;}} else {$l++;} }
                            if($tipusdia=="F") {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                        }
                    }
                    else if($dnat==1){
                        if(($tres==0)){
                            if(date('w',strtotime($data))==0) {$tipusdia="L";$l=1;$f=1;}
                            else if (date('w',strtotime($data))==6) {$tipusdia="F";$l=1;$f++;if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt1; $dlb=$dlb1;}}
                            else {
                                if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                if($tipusdia=="L") {$l++;}
                                if($tipusdia=="F") {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                            }
                        }
                        else if (($tres==1)){
                            if(date('w',strtotime($data))==0) {$tipusdia="L";$l=1;$f=1;}
                            else if (date('w',strtotime($data))==6) {$tipusdia="F";$l=1;$f++;if($idtt==$idt1) {$idtt=$idt2; $dlb=$dlb2;} else if($idtt==$idt2){$idtt=$idt3; $dlb=$dlb3;} else if($idtt==$idt3){$idtt=$idt1; $dlb=$dlb1;}}
                            else {
                                if($tipusdia=="L") {$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$p.','.$idtt.',"'.$data.'")');}
                                if($tipusdia=="L") {$l++;}
                                if($tipusdia=="F") {if($f>$dfs) {$f=1;$tipusdia="L";} else {$f++;}}
                            }
                        }
                    }
                    $data = date('Y-m-d',strtotime($data.' + 1 days'));
                }
                $i++;
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg.= $ex->getMessage();
        }
        echo $msg;
        break;
    case "editaRotacioDia":
        $msg = "";
        $idrotacio = $_GET["1"];
        $idtipustorn = $_GET["2"];
        $datafi = $_GET["3"];
        $repetir = $_GET["4"];        
        try{
            $idempleat = $dto->getCampPerIdCampTaula("rotacio", $idrotacio,"idempleat");
            $data = $dto->getCampPerIdCampTaula("rotacio", $idrotacio,"data");
            $idtornfracini = $dto->getCampPerIdCampTaula("tipustorn", $dto->getCampPerIdCampTaula("rotacio", $idrotacio,"idtipustorn"), "torn");
            $idtornfracnou =$dto->getCampPerIdCampTaula("tipustorn", $idtipustorn, "torn");
            if($repetir==0) {                                
                $dto->actualitzaCampTaula("rotacio","idtipustorn",$idrotacio,$idtipustorn);
            }            
            if($repetir==1) {
                $dto->getDb()->executarSentencia('delete from rotacio where idempleat='.$idempleat.' and data BETWEEN DATE("'.$data.'") AND DATE("'.$datafi.'")');
                while(strtotime($data)<=strtotime($datafi)) {
                    $dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$idempleat.','.$idtipustorn.',"'.$data.'")');
                    $data = date('Y-m-d',strtotime($data.' + 1 days'));
                }
            }
            if(($idtornfracini==1)&&($idtornfracnou>1)){
                $dto->getDb()->executarSentencia('insert into canvitorn (idempleat,datatorn) values ('.$idempleat.',"'.$data.'")');
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "eliminaRotacioDia":
        $msg = "";
        $idrotacio = $_GET["1"];
        try{
            $dto->getDb()->executarSentencia('delete from rotacio where idrotacio='.$idrotacio);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "creaNecessitat":
        $msg = "";
        $idsubemp = $_GET["1"];
        $idtn = $_GET["2"];
        $idtt = $_GET["3"];
        $quant = $_GET["4"];
        try{
            $idnc = 0;
            $rscn = $dto->getDb()->executarConsulta('select * from necessitat where idsubempresa='.$idsubemp);
            if(!empty($rscn)){ 
                foreach($rscn as $n) { $idnc = $n["idnecessitat"]; }
            }
            else {
                $dto->getDb()->executarSentencia('insert into necessitat (idsubempresa,datacrea) values ('.$idsubemp.',now())');
                $rscn = $dto->getDb()->executarConsulta('select * from necessitat where idsubempresa='.$idsubemp.' order by idnecessitat desc limit 1');
                foreach($rscn as $n) { $idnc = $n["idnecessitat"]; }
            }
            $idtf = $dto->getCampPerIdCampTaula("tipustorn",$idtt,"torn");
            $dto->getDb()->executarSentencia('insert into tornnec (idnecessitat,idtipusnec,idtornfrac,idtipustorn,quantitat) values ('.$idnc.','.$idtn.','.$idtf.','.$idtt.','.$quant.')');
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "eliminaTornnec":
        $msg = "";
        $idtornnec = $_GET["1"];
        try{
            $dto->getDb()->executarSentencia('delete from tornnec where idtornnec='.$idtornnec);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "assignaHorariMultipers":
        $msg = "";
        try{
            $arridpers = [];
            $arridpers = json_decode($_GET["stridpers"]);
            $idhorari = $_GET["2"];
            $dataini = $_GET["3"];
            $datafi = $_GET["4"];
            foreach($arridpers as $p){
                $msg.="(".$p.")";
                $dto->getDb()->executarSentencia('insert into quadrant (idempleat,idhorari,datainici,datafi,actiu) values ('.$p.','.$idhorari.',"'.$dataini.'","'.$datafi.'",1)');
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg.= $ex->getMessage();
        }
        echo $msg;
        break;
    case "assignaUbicacioMultipers":
        $msg = "";
        try{
            $arridpers = [];
            $arridpers = json_decode($_GET["stridpers"]);
            $idloc = $_GET["2"];
            $dataini = $_GET["3"];
            foreach($arridpers as $p){
                $msg.="(".$p.")";
                $dto->getDb()->executarSentencia('insert into situat (idempleat,idlocalitzacio,datainici) values ('.$p.','.$idloc.',"'.$dataini.'")');
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg.= $ex->getMessage();
        }
        echo $msg;
        break;
    case "marcaLocAct":
        $msg = "";
        try{
            $idloc = $_GET["1"];
            $act = $_GET["2"];
            $dto->getDb()->executarSentencia('update localitzacio set activa='.$act.' where idlocalitzacio='.$idloc);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "generaTblUbicacions":
        session_start();
        $lng = $_SESSION["ididioma"];
        $rows = "";
        try{
        $idempresa = $_SESSION["idempresa"];
        $ubicacions = $dto->seleccionaUbicacionsPerIdEmpresa($idempresa);
        foreach ($ubicacions as $ubicat) {
            $chkact = "";
            if($ubicat["activa"]==1) $chkact = "checked";
            $rows.= '<tr><td title="Activa"><input id="chklocact'.$ubicat["idlocalitzacio"].'" type="checkbox" '.$chkact.' onclick="marcaLocAct('.$ubicat["idlocalitzacio"].');" style="width: 20px; height: 20px"></td><td><input contenteditable data-old_value="'.$ubicat["nom"].'" value="'.$ubicat["nom"].'" title="'.$dto->__($lng,"Clica per a editar nom").'"'
                . 'onblur="actualitzaCampTaula('."'localitzacio','nom',".$ubicat["idlocalitzacio"].',this.getAttribute('."'data-old_value'".'),this.value);"></td><td>'
                . '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Festius").'" onclick="mostraFestius('.$ubicat["idlocalitzacio"].')">'
                . '<span class="glyphicon glyphicon-zoom-in"></span></button>'
                . '<button class="btn btn-xs btn-warning" title="'.$dto->__($lng,"Editar Festius").'" onclick="mostraEditaFestius('.$ubicat["idlocalitzacio"].')">'
                . '<span class="glyphicon glyphicon-pencil"></span></button>'
                . '<a class="btn btn-xs btn-success" title="'.$dto->__($lng,"Afegeix Festiu").'" onclick="afegeixFestiu('.$ubicat["idlocalitzacio"].','."'".$dto->mostraNomUbicacio($ubicat["idlocalitzacio"])."'".');">'
                . '<span class="glyphicon glyphicon-plus"></span></a>'
                . '</tr>';
        }
        } catch (Exception $ex) {
            http_response_code(404);
            $rows = $ex->getMessage();
        }
        echo $rows;
        break;
    case "assignaMarcatgeMultipers":
        $msg = "";
        try{
           
            $arridpers = [];
            $arridpers = json_decode($_GET["stridpers"]);
            $data = date('Y-m-d',strtotime($_GET["2"]));
            foreach($arridpers as $p){
                $msg = "Eliminar: ".$dto->eliminaMarcatgesDataId($p,$data);
                $msg.= "Crear: ".$dto->insereixMarcatgesDataTornId($p,$data,1);
            }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg.= $ex->getMessage();
        }
        echo $msg;
        break;
    case "generaTblHoraris":
        session_start();
        $lng = $_SESSION["ididioma"];
        $rows = "";
        try{
        $idempresa = $_GET["1"];
        $horaristipus = $dto->seleccionaTipusHoraris($idempresa);
        foreach ($horaristipus as $horari) {                 
            $btnx = "";
            $rsht = $dto->getDb()->executarConsulta('select idhorari from quadrant where idhorari='.$horari["idhoraris"]);
            if(empty($rsht)) $btnx = '<button type="button" class="btn btn-xs btn-danger" title="'.$dto->__($lng,"Eliminar Horari").'" onclick="confElimHorari('.$horari["idhoraris"].','.$idempresa.');">'
                . '<span class="glyphicon glyphicon-remove"></span></button>';
            $rows.= '<tr><td><input contenteditable data-old_value="'.$horari["nom"].'" value="'.$horari["nom"].'" title="'.$dto->__($lng,"Clica per a editar nom").'"'
                . 'onblur="actualitzaCampTaula('."'horaris','nom',".$horari["idhoraris"].',this.getAttribute('."'data-old_value'".'),this.value);"></td><td>'
                . '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Torns").'" onclick="mostraTorns('.$horari["idhoraris"].')">'
                . '<span class="glyphicon glyphicon-zoom-in"></span>'
                . '<button type="button" class="btn btn-xs btn-warning" title="'.$dto->__($lng,"Editar Horari").'" onclick="mostraEditaHorari('.$horari["idhoraris"].')">'
                . '<span class="glyphicon glyphicon-pencil"></span>'.$btnx.'</button>'
                
                . '</tr>';
        }
        } catch (Exception $ex) {
            http_response_code(404);
            $rows = $ex->getMessage();
        }
        echo $rows;
        break;
    case "creaTipusTorn":
        $msg = "";
        $idempresa=$_GET["1"];
        $nom=$_GET["2"];
        $abr=$_GET["3"];
        $torn=$_GET["4"];
        $hora1=$_GET["5"];
        $hora2=$_GET["6"];
        $htreb=$_GET["7"];
        $hnoct=$_GET["8"];
        $hdesc=$_GET["9"];
        $colorbckg=$_GET["10"];
        $colortxt=$_GET["11"];
        $autsb=$_GET["12"];
        try{
            $dto->getDb()->executarSentencia('insert into tipustorn (idempresa,nom,abrv,torn,horaentrada,horasortida,horestreball,horesnit,horespausa,colortxt,colorbckg,buscasubst) '
                    . 'values ('.$idempresa.',"'.$nom.'","'.$abr.'","'.$torn.'","'.$hora1.'","'.$hora2.'","'.$htreb.'","'.$hnoct.'","'.$hdesc.'","'.$colortxt.'","'.$colorbckg.'",'.$autsb.')');
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "editaTipusTorn":
        session_start();
        $msg = $_SESSION["idempresa"];
        $idtipus=$_GET["1"];
        $nom=$_GET["2"];
        $abr=$_GET["3"];
        $torn=$_GET["4"];
        $hora1=$_GET["5"];
        $hora2=$_GET["6"];
        $htreb=$_GET["7"];
        $hnoct=$_GET["8"];
        $hdesc=$_GET["9"];
        $colorbckg=$_GET["10"];
        $colortxt=$_GET["11"];
        $autsb=$_GET["12"];
        try{
            $dto->getDb()->executarSentencia('update tipustorn set nom="'.$nom.'",abrv="'.$abr.'",torn="'.$torn.'",horaentrada="'.$hora1.'",horasortida="'.$hora2.'",horestreball="'.$htreb.'",horesnit="'.$hnoct.'",horespausa="'.$hdesc.'",colortxt="'.$colortxt.'",colorbckg="'.$colorbckg.'",buscasubst='.$autsb.' where idtipustorn='.$idtipus);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "generaTblTipustorn":
        $rows = "";
        $idemp = $_GET["1"];
        try{
            $dto->generaTblTipustorn($idemp);
        } catch (Exception $ex) {
            $rows = $ex->getMessage();
            http_response_code(404);
        }
        echo $rows;
        break;
    case "eliminaHorari":
        $msg = "";
        $idhorari = $_GET["1"];
        try{
        
        $dto->getDb()->executarSentencia('delete from horaris where idhoraris='.$idhorari);    
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "eliminaTipustorn":
        $msg = "";
        $idtipustorn = $_GET["1"];
        try{
       
        $dto->getDb()->executarSentencia('delete from tipustorn where idtipustorn='.$idtipustorn);    
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "desaHoresAny":
        $msg = "";
        try{
           $idemp = $_GET["1"];
           $any = $_GET["2"];
           $hores = $_GET["3"];
           $rsq = $dto->getDb()->executarConsulta('select * from horesany where idempleat='.$idemp.' and anylab='.$any);
           if(empty($rsq)){$dto->getDb()->executarSentencia('insert into horesany (idempleat,anylab,hores) values ('.$idemp.','.$any.',"'.$hores.'")');}
           else {
               $idhoresany = 0;
               foreach($rsq as $r) {$idhoresany = $r["idhoresany"];}
               $dto->getDb()->executarSentencia('update horesany set hores="'.$hores.'" where idhoresany='.$idhoresany);
           }
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "enganxaNecessitat":
        $msg = "Entrem Funció";
       
        $any = $_GET["1"];
        $mes = $_GET["2"];
        $idsubemp = $_GET["5"];
        try{
          
            $arrnm = array_fill(0,3,0);
            $arrnt = array_fill(0,3,0);
            $arrnn = array_fill(0,3,0);
            $arrnmt = array_fill(0,3,0);
            $rstn = $dto->getDb()->executarConsulta('select * from tornnec where idnecessitat='.$_GET["0"]);
            $msg.= "Consulta Necessitats Feta";
            foreach($rstn as $tn) {
                switch($tn["idtornfrac"]){
                    case 1: $arrnm[$tn["idtipusnec"]-1]+=$tn["quantitat"];break;
                    case 2: $arrnt[$tn["idtipusnec"]-1]+=$tn["quantitat"];break;
                    case 3: $arrnn[$tn["idtipusnec"]-1]+=$tn["quantitat"];break;
                    case 4: $arrnmt[$tn["idtipusnec"]-1]+=$tn["quantitat"];break;
                }
            }
            $msg.= "Arrays Creats";
            
            $zmes = "";
            if($mes<10)$zmes = "0".$mes;
            else $zmes = $mes;
            $date = date('Y-m-d',strtotime($any."-".$zmes."-01"));
            $sqldianec6 = "("; //string per a indicar els dies dissabtes del mes, a aplicar necessitats de dissabte (als 4 arrays)
            $sqldianec0 = "("; //string per a indicar els dies diumenges del mes, a aplicar necessitats de diumenge (als 4 arrays)
            for($i=1;date('m',strtotime($date))==$mes;$i++){
                $w = date('w',strtotime($date));
                if($sqldianec6=="("){$or6="";} else{$or6=" or ";}
                if($sqldianec0=="("){$or0="";} else{$or0=" or ";}
                switch($w){
                    case 6: $sqldianec6.=$or6."(dianec=".$i.")";break;
                    case 0: $sqldianec0.=$or0."(dianec=".$i.")";break;
                }
                $date = date('Y-m-d',strtotime($date." + 1 days"));
            }
            $sqldianec6.=")";
            $sqldianec0.=")";
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnm[0].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=1');
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnmt[0].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=4');
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnt[0].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=2');
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnn[0].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=3');
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnm[1].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=1 and '.$sqldianec6);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnmt[1].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=4 and '.$sqldianec6);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnt[1].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=2 and '.$sqldianec6);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnn[1].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=3 and '.$sqldianec6);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnm[2].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=1 and '.$sqldianec0);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnmt[2].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=4 and '.$sqldianec0);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnt[2].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=2 and '.$sqldianec0);
            $dto->getDb()->executarSentencia('update necsubmes set empleats='.$arrnn[2].' where idsubempresa='.$idsubemp.' and anynec='.$any.' and mesnec='.$mes.' and idtornfrac=3 and '.$sqldianec0);
            $msg.= "Updates Fets";            
        } catch (Exception $ex) {
            $msg.= $ex->getMessage();
            http_response_code(404);
        }
        echo $msg;
        break;
    case "processaExcelPujat":
        require_once './PHPExcel/IOFactory.php';
        session_start();
        $idemp = $_SESSION["idempresa"];
        $data = $_GET["1"];
        $rutadoc = "";
        $rsrd = $dto->getDb()->executarConsulta('select rutadoc from pujadaemp where idempresa='.$idemp.' and dataact=date("'.$data.'") order by idpujadaemp desc limit 1');//
        foreach($rsrd as $r) {$rutadoc = $r["rutadoc"];}
        $msg = "";
        try{
            $arrex = [];
            $arrdown = [];
            $rsex = $dto->getDb()->executarConsulta('select idempleat, nom, cognom1, cognom2, dni, enplantilla, numafiliacio from empleat where idempresa='.$idemp);
            foreach($rsex as $e) {
                $arrparex = array_fill(0,4,"");
                $arrparex[0] = $e["idempleat"];
                $arrparex[1] = $e["nom"]." ".$e["cognom1"].", ".$e["cognom2"];
                $arrparex[2] = $e["dni"];
                $arrparex[3] = $e["numafiliacio"];
                if($e["enplantilla"]==1){$arrex[] = $arrparex;}
                else{$arrdown[] = $arrparex;}
            }
            $arrup = [];
            $msg.= '<table class="table table-bordered"><tr><td colspan="3">Trabajadores Existentes</td></tr>';
            $row = 0;
            $obj = PHPExcel_IOFactory::load($rutadoc);
           
            foreach($obj->getWorksheetIterator() as $wksh)
            {
                $hr = $wksh->getHighestRow();
                $apuntar = 0;
                $trb = 0;
                for($row=0;$row<=$hr;$row++){
                    $nom = $wksh->getCellByColumnAndRow(0,$row)->getValue();
                    $abrvnom = substr($nom,0,11);
                    switch($abrvnom){
                        case "APELLIDOS Y": $apuntar = 1; break;
                        case "": break;
                        case "* FIN DE INFORME *": break;
                        case "REFERENCIA:": $apuntar = 0; break;
                        default:
                            if($apuntar==1){
                                $arrpar = array_fill(0,3,"");
                                $niss = $wksh->getCellByColumnAndRow(8,$row)->getValue();
                                $nif = substr($wksh->getCellByColumnAndRow(12,$row)->getValue(),3,(strlen($wksh->getCellByColumnAndRow(12,$row)->getValue())-3));
                                $arrpar[0] = $nom;
                                $arrpar[1] = $niss;
                                $arrpar[2] = $nif;
                                $arrup[]=$arrpar;
                               
                                $trb++;
                            }
                            break;
                    }            
                }
            }
            
            $arrnew=[];
            $msg.= '<table class="table table-bordered"><thead><tr><th style="text-align: center" colspan="3">'.$dto->__($lng,"Treballadors Nous").'</th></tr>'
                    . '<tr><th>'.$dto->__($lng,"Nom").'</th><th>'.$dto->__($lng,"NIF").'</th><th>'.$dto->__($lng,"NISS").'</th></tr></thead></tr>';
            foreach($arrup as $a){
                $found = 0;
                foreach($arrex as $ex){
                    if($a[2]==$ex[2]) {$found = 1;}
                }
                if($found==0){
                    $arrpar = array_fill(0,3,"");
                    $arrpar[0] = $a[0];
                    $arrpar[1] = $a[1];
                    $arrpar[2] = $a[2];
                    $arrnew[] = $arrpar;
                    $msg.='<tr>'
                    . '<td>'.$a[0].'</td>'
                    . '<td>'.$a[2].'</td>'
                    . '<td>'.$a[1].'</td>'
                    . '</tr>';
                }
            }
            $arract = [];
            $msg.= '</table><br><table class="table table-bordered"><thead><tr><th style="text-align: center" colspan="3">'.$dto->__($lng,"Treballadors Anteriors Reactivats").'</th></tr>'
                    . '<tr><th>'.$dto->__($lng,"Nom").'</th><th>'.$dto->__($lng,"NIF").'</th><th>'.$dto->__($lng,"NISS").'</th></tr></thead></tr>';
            foreach($arrdown as $d){
            $found = 0;
            foreach($arrup as $up){
                if($d[2]==$up[2]) {$found = 1;}
            }
                if($found==1){
                    $arrpar = array_fill(0,3,"");
                    $arrpar[0] = $d[0];
                    $arrpar[1] = $d[1];
                    $arrpar[2] = $d[2];
                    $arract[] = $arrpar;
                    $msg.='<tr>'
                    . '<td>'.$d[1].'</td>'
                    . '<td>'.$d[2].'</td>'
                    . '<td>'.$d[3].'</td>'
                    . '</tr>';
                }
            }
            $arrmiss=[];
            $msg.= '</table><br><table class="table table-bordered"><tr><thead><th style="text-align: center" colspan="3">'.$dto->__($lng,"Treballadors Anteriors Donats de Baixa").'</th></tr>'
                    . '<tr><th>'.$dto->__($lng,"Nom").'</th><th>'.$dto->__($lng,"NIF").'</th><th>'.$dto->__($lng,"NISS").'</th></tr></thead></tr>';
            foreach($arrex as $ex){
                $found = 0;
                foreach($arrup as $a){
                    if($a[2]==$ex[2]) {$found = 1;}
                }
                if($found==0){
                    $arrpar = array_fill(0,3,"");
                    $arrpar[0] = $ex[0];
                    $arrpar[1] = $ex[1];
                    $arrpar[2] = $ex[2];
                    $arrmiss[] = $arrpar;$msg.='<tr>'
                    . '<td>'.$ex[1].'</td>'
                    . '<td>'.$ex[2].'</td>'
                    . '<td>'.$ex[3].'</td>'
                    . '</tr>';
                }
            }
            $msg.= '</table><br><table class="table table-bordered"><tr><thead><th style="text-align: center" colspan="3">'.$dto->__($lng,"Total Treballadors Carregats").' ('.$trb.')</th></tr>'
                    . '<tr><th>'.$dto->__($lng,"Nom").'</th><th>'.$dto->__($lng,"NIF").'</th><th>'.$dto->__($lng,"NISS").'</th></tr></thead></tr>';
            foreach($arrup as $a){
                $msg.='<tr>'
                    . '<td>'.$a[0].'</td>'
                    . '<td>'.$a[2].'</td>'
                    . '<td>'.$a[1].'</td>'
                    . '</tr>';                
            }
            $msg.='</table>';
            $dto->cessaNoPujats($arrmiss,$data);
            $dto->comprovaPujatsActius($arrup,$data,$idemp);
            $dto->reactivaPujatsCessats($arract,$data,$idemp);
            $dto->altaPujatsNoExistents($arrnew,$data,$idemp);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "processaQuadrantPujat":
        require_once './PHPExcel/IOFactory.php';
        session_start();
        $idemp = $_SESSION["idempresa"];
        $any = $_GET["1"];
        $mes = $_GET["2"];
        $idsubemp = $_GET["3"];
        $rutadoc = "";
        $zmes = "";
        if($mes<10){$zmes="0".$mes;}
        else $zmes = $mes;
        $diesmes = 0;
        $dia = new DateTime();
        $dia->setISODate($any,0);
        $undiames = new DateInterval('P1D');
        while($dia->format('Y')<$any)$dia->add($undiames);
        while($dia->format('m')<$mes)$dia->add($undiames);
        for($i=1;(($dia->format('m')==$mes));$i++){$dia->add($undiames);$diesmes++;}
        $rsrd = $dto->getDb()->executarConsulta('select rutadoc from pujadaquad where idsubempresa='.$idsubemp.' order by idpujadaquad desc limit 1');
        foreach($rsrd as $r) {$rutadoc = $r["rutadoc"];}
        $msg = "Inicialitzat<br>";
       
        try{
            $arrex = [];
            $arrdown = [];
            $rsex = $dto->getDb()->executarConsulta('select idempleat, nom, cognom1, cognom2, dni, enplantilla, numafiliacio from empleat where idempresa='.$idemp);
            foreach($rsex as $e) {
                $arrparex = array_fill(0,4,"");
                $arrparex[0] = $e["idempleat"];
                $arrparex[1] = $e["nom"]." ".$e["cognom1"].", ".$e["cognom2"];
                $arrparex[2] = $e["dni"];
                $arrparex[3] = $e["numafiliacio"];
                if($e["enplantilla"]==1){$arrex[] = $arrparex;}
                else{$arrdown[] = $arrparex;}
            }
            $msg.="Array Existents<br>";
            $arrup = [];
           
            $obj = PHPExcel_IOFactory::load($rutadoc);
            
            $msg.="PHPExcel Cridat<br>";
            foreach($obj->getWorksheetIterator() as $wksh)
            {
                $hr = $wksh->getHighestRow();
                for($row=2;$row<=$hr;$row++){
                    $dni = $wksh->getCellByColumnAndRow(0,$row)->getValue();
                    if($dni!=""){
                        $arrpar = array_fill(0,32,"");
                        $arrpar[0] = $dni;
                        $msg.=$dni."->";
                        for($i=1;$i<=31;$i++){                                    
                            $arrpar[$i] = $wksh->getCellByColumnAndRow((1+$i),$row)->getValue();
                            $msg.= $wksh->getCellByColumnAndRow((1+$i),$row)->getValue().",";
                        }
                        $msg.="<br>";
                        $arrup[]=$arrpar;
                    }
                }
            }
            $msg.="Excel Pujat Capturat<br>";
           
            $arrttorn = [];
            $rstt = $dto->getDb()->executarConsulta('select idtipustorn, abrv from tipustorn where idempresa='.$idemp);
            foreach($rstt as $tt) {$ttidabrv = array_fill(0,2,0); $ttidabrv[0]=$tt["idtipustorn"];$ttidabrv[1]=$tt["abrv"];$arrttorn[]=$ttidabrv;}
            $nwarrup=[];
            foreach($arrup as $up){
                $nwchr = array_fill(0,32,0);
                $rsidempl = $dto->getDb()->executarConsulta('select idempleat from empleat where dni like "'.$up[0].'" and idempresa='.$idemp);
                foreach($rsidempl as $id) {$nwchr[0] = $id["idempleat"];}
                for($i=1;$i<=31;$i++){
                    $idtorn = 0;                    
                    $notfound = 1;
                    if($up[$i]!=""){
                        foreach($arrttorn as $tt){
                                if($tt[1]==$up[$i]){$nwchr[$i]=$tt[0];$notfound=0;}
                        }
                        if($notfound==1){
                            $idtornadef = 0;
                            foreach($arrttorn as $tt){
                                if(($tt[1]=="?")||($tt[1]=="M?")||($tt[1]=="T?")||($tt[1]=="N?")||($tt[1]=="??")) {$nwchr[$i]=$tt[0];}
                            }
                        }
                    }
                }
                $nwarrup[]=$nwchr;
            }
            $msg.="Array Processat<br>";
            $dataini = date('Y-m-d',strtotime($any.'-'.$zmes.'-01'));
            // Realitzar les operacions a la bdd (eliminar rotacions del mes per a cada treballador trobat i introduir les noves pujades)
            foreach($nwarrup as $nw){
                $dto->getDb()->executarSentencia('delete from rotacio where idempleat='.$nw[0].' and data BETWEEN DATE("'.$any.'-'.$zmes.'-01") AND DATE ("'.$any.'-'.$zmes.'-'.$diesmes.'")');
                $data = $dataini;
                for($i=1;$i<=31;$i++){
                    if(!empty($nw[$i])){
                        $dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$nw[0].','.$nw[$i].',"'.$data.'")');
                    }
                    $data = date('Y-m-d',strtotime($data.' + 1 days'));
                }
            }
            $msg.="Base de dades Actualitzada<br>";
            
        } catch (Exception $ex) {
            http_response_code(404);
           
        }
        echo $msg;
        break;
    case "afegeixTraduccio":
        $dto->afegeixTraduccio($_GET["idenunciat"],$_GET["ididioma"],$_GET["traduccio"]);
        break;
    case "nouEnunciat":
        $dto->nouEnunciat($_GET["text"]);
        break;
    case "traduirWeb":
        session_start();
        unset($_SESSION["ididioma"]);
        $_SESSION["ididioma"]=$_GET["ididioma"];
        break;
    case "automarcatges":
        $msg = "";
        try{        
            $dto->automarcatges($_GET["1"]);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "carregaInicial":
        $msg = "";
        try{        
            $dto->carregaInicial($_GET["1"]);
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "intercanviTorns":
        $msg = "";
        try{
            $data = $_GET["1"];
            $idemp1 = $_GET["2"];
            $idemp2 = $_GET["3"];
            $tipus = $_GET["4"];
            $idtt1 = 0;
            $rsrot1 = $dto->getDb()->executarConsulta('select * from rotacio where idempleat='.$idemp1.' and data=date("'.$data.'")');
            foreach($rsrot1 as $r1){
                $idtt1 = $r1["idtipustorn"];
            }
            $idtt2 = 0;
            $rsrot2 = $dto->getDb()->executarConsulta('select * from rotacio where idempleat='.$idemp2.' and data=date("'.$data.'")');
            foreach($rsrot2 as $r2){
                $idtt2 = $r2["idtipustorn"];                    
            }
            $dto->getDb()->executarSentencia('delete from rotacio where (idempleat='.$idemp1.' or idempleat='.$idemp2.') and data=date("'.$data.'")');
            $dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$idemp2.','.$idtt1.',"'.$data.'")');
            if($tipus=="inter"){$dto->getDb()->executarSentencia('insert into rotacio (idempleat,idtipustorn,data) values ('.$idemp1.','.$idtt2.',"'.$data.'")');}            
        } catch (Exception $ex) {
            http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
    case "marcaInformeDisp":
        $msg = "";
        try{
            $idemp = $_GET["1"];
            $idinforme = $_GET["2"];
            $chk = $_GET["3"];
            $rsinfemp = $dto->getDb()->executarConsulta('select * from informeempresa where idempresa='.$idemp.' and idtipusinforme='.$idinforme);
            $idinfemp = 0;
            if(empty($rsinfemp)){
                $dto->getDb()->executarSentencia('insert into informeempresa (idempresa,idtipusinforme,checked) values ('.$idemp.','.$idinforme.',1)');
            }
            else{
                foreach($rsinfemp as $ie){
                    $idinfemp = $ie["idinformeempresa"];
                    $dto->getDb()->executarSentencia('update informeempresa set checked='.$chk.' where idinformeempresa='.$idinfemp);
                }
            }
        } catch (Exception $ex) {
          http_response_code(404);
            $msg = $ex->getMessage();
        }
        echo $msg;
        break;
        }
        if(isset($_POST["accio"])) {
        switch($_POST["accio"]){    
            case "creaHorari":
                $j=0;
                if(isset($_POST["nomhorari"]))
                {
                    $torns = new ArrayObject();
                    for($i=1;$i<=7;$i++)
                    {
                            
                    if(!isset($_POST[$i."f0"])) $_POST[$i."f0"]=0; else $_POST[$i."f0"]=1;
                    if(!isset($_POST[$i."f5"])) $_POST[$i."f5"]=0; else $_POST[$i."f5"]=1;
                    if(!isset($_POST[$i."f6"])) $_POST[$i."f6"]=0; else $_POST[$i."f6"]=1;
                    $torn = new Torn($i, $_POST[$i."f1"], $_POST[$i."f2"], $_POST[$i."f3"], $_POST[$i."f4"], $_POST[$i."f5"], $_POST[$i."f6"], $_POST[$i."f0"]);
                    $torns->append($torn); 
                //     }
            }
            if($j==0)$dto->creaNouHorari($_POST["idempresa"], $_POST["nomhorari"], $torns);
            $j++;
        }
        unset($_POST);
        break;
    case "editaHorari":
        if(isset($_POST["idhorari"]))
        {
            $torns = new ArrayObject();
            for($i=1;$i<=7;$i++)
            {
                         
                    if(!isset($_POST[$i."f0"])) $_POST[$i."f0"]=0; else $_POST[$i."f0"]=1;
                    if(!isset($_POST[$i."f5"])) $_POST[$i."f5"]=0; else $_POST[$i."f5"]=1;
                    if(!isset($_POST[$i."f6"])) $_POST[$i."f6"]=0; else $_POST[$i."f6"]=1;
                    $torn = new Torn($i, $_POST[$i."f1"], $_POST[$i."f2"], $_POST[$i."f3"], $_POST[$i."f4"], $_POST[$i."f5"], $_POST[$i."f6"], $_POST[$i."f0"]);
                    $torns->append($torn); 
                //     }
            }
            $dto->editaHorari($_POST["idhorari"],$_POST["nomhorari"], $torns);
        }
        unset($_POST);
        break;
}
}