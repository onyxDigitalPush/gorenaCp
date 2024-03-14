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
    </head>
    <body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%;">
        <div class="modal fade" id="modLogo"></div>
        <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_SESSION["id"];
        $idempresa = $_SESSION["idempresa"];
        $d = strtotime("now");
        $undiames = new DateInterval('P1D');
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        if(!isset($_GET["setmana"]))$_GET["setmana"]=date("W",$d)+1;
        
        $setmana = $_GET["setmana"];
        if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));                
        $mes = $_GET["mes"];
        
        if($setmana!=$dto->__($lng,"Totes")){
            $diapopup = new DateTime();
            $diapopup->setISOdate($any,$setmana-1);
            $diapopup = $diapopup->format('Y-m-d');
        }
        else if($mes!=$dto->__($lng,"Tots")){$diapopup = $any."-".$mes."-01";}
        else if($any!=$dto->__($lng,"Tots")){$diapopup = date('Y-m-d',strtotime('today'));}
        $diateoriques = date('Y-m-d',strtotime($any."-01-01"));
        $horesteoany = 0.0;
        while(date('Y',strtotime($diateoriques))==$any) {
            $horesteoany += $dto->seleccionaHoresTeoriquesPerIdDia($id, $diateoriques);
            $diateoriques = date('Y-m-d',strtotime($diateoriques.' + 1 days'));
        }
        $horesteomes = $horesteoany/12;
        ?>
    <center>
        
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 well">
                <div class="col-lg-4"><h2 class="etiq"><?php echo $dto->__($lng,"Graella de Marcatges") ?></h2></div>  
                <div class="col-lg-4">
                    <h3 class="etiq"><?php echo $dto->mostraNomEmpPerId($id);?></h3>
                </div>
                <div class="col-lg-2">
                   
                    <button class="btn btn-success btn-lg" onclick="taulaAExcel('tblmarcatges','<?php echo $dto->__($lng,$dto->mostraNomMes($mes));?>','<?php echo $dto->__($lng,"Marcatges")." ".$dto->mostraNomEmpPerId($id)." ".$dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?>');" title="<?php echo $dto->__($lng,"Exportar a Excel");?>"><span class="glyphicon glyphicon-list-alt"></span></button>
                    <button class="btn btn-default btn-lg" onclick="printElem('fullmarcatges');" title="<?php echo $dto->__($lng,"Imprimir"); ?>"><span class="glyphicon glyphicon-print"></span></button>
                </div>
                <div class="col-lg-2">
                    <form method="get">
                        
<!--------------Cliente solicita eliminar botones, por el momento los dejo comentados por si mas adelante los desean nuevamente---------------

                    <button class="btn btn-default btn-lg" formaction="EmpleatFitxa.php" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Fitxa");?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button class="btn btn-info btn-lg" formaction="EmpleatCalendari.php" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Calendari Anual");?>"><span class="glyphicon glyphicon-calendar"></span></button>
                    <a class="btn btn-default btn-lg" href='index.php' title="<?php echo $dto->__($lng,"Inici");?>"><span class="glyphicon glyphicon-home"></span></a>
                
------------------------------------------------------------------------------------------------------------------------------------------>

                    </form>                                        
                </div>
            </div>
        </div>
        <!br>
        <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-2 well" style="margin-right: 15px;">
            <?php $dto->imprimeixMesPerIdAnyMes($id,$any,$mes,100,$lng); ?>
            <br><br>
            <label class="smtag"><?php echo $dto->__($lng,"Hores")." ".$dto->__($lng,"Teòriques")." ".$dto->__($lng,"mes");?>:</label> <strong class="smtag"><?php echo number_format($horesteomes,1,",",".");?> h</strong><br>(<?php echo $dto->__($lng,"Any").": ".number_format($horesteoany,1,",",".");?> h)
        </div>
        <div class="col-lg-8 well" id="fullmarcatges">
            <div class="row">
                <div class="col-lg-4">
                    <label><?php echo $dto->__($lng,"Persona"); ?>: </label> <span class="smtag"><?php echo $dto->mostraNomEmpPerId($id);?></span>
                </div>
                <div class="col-lg-1"></div>
                    <div class="col-lg-2">
                        <form action="EmpleatMarcatges.php" method="GET"><label><?php echo $dto->__($lng,"Any");?>:</label> 
                    <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                  
                    <?php
                    $anys = $dto->mostraAnysContractePerId($id);
                    $toyear = date('Y',strtotime('today'));
                    for($year=2017;$year<=($toyear+1);$year++)
                    
                    {
                        echo '<option value:"'.$year.'">'.$year.'</option>';
                    }
                    ?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="mes" value="<?php echo $dto->__($lng,$mes);?>">
                    <input type="hidden" name="setmana" value="<?php echo $dto->__($lng,"Totes");?>">
                    </form>
                    </div>
                    <div class="col-lg-2">
                        <form action="EmpleatMarcatges.php" method="GET"><label><?php echo $dto->__($lng,"Mes");?>:</label> 
                    <select name="mes" id="LlistaMesos" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $dto->__($lng,$dto->mostraNomMes($mes)); ?></option>
                    
                    <?php
                    if($any!=$dto->__($lng,"Tots")) 
                    {
                       
                        for($month=1;$month<=12;$month++)
                        {
                            echo '<option value="'.$month.'">'.$dto->__($lng,$dto->mostraNomMes($month)).'</option>';
                        }
                    }
                    ?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $dto->__($lng,$any); ?>">
                    <input type="hidden" name="setmana" value="<?php echo $dto->__($lng,"Totes");?>">
                    </form>
                    </div>
                    <div class="col-lg-3">
                        <form action="EmpleatMarcatges.php" method="GET"><label><?php echo $dto->__($lng,"Setmana");?>:</label> 
                    <select name="setmana" id="LlistaSetmanes" onchange="this.form.submit()">
                    <option hidden selected value>
                        <?php 
                            if($setmana!=$dto->__($lng,"Totes"))
                            {
                                $dia = new DateTime();
                                $dia->setISODate($any, $setmana-1);
                                echo ($setmana).' ('.$dia->format('d-M-Y').')';
                            }
                            else echo $setmana;
                        ?>
                    </option>';
                    <option value=<?php echo $dto->__($lng,"Totes").'>'.$dto->__($lng,"Totes"); ?></option>
                    <?php
                    if($any!=$dto->__($lng,"Tots")&&$mes!=$dto->__($lng,"Tots")) $setmanes = $dto->mostraSetmanesMarcatgesPerIdAnyMes($id, $any, $mes);
                    else if ($any!=$dto->__($lng,"Tots")) 
                    {
                        $setmanes = $dto->mostraSetmanesMarcatgesPerIdAny($id, $any);
                    }
                    foreach($setmanes as $week)
                    {
                        $dia = new DateTime();
                        $dia->setISODate($any, $week["setmanes"]+1);
                        echo '<option value="'.($week["setmanes"]+2).'">'.($week["setmanes"]+2).' ('.$dia->format('d-M-Y').')</option>';
                    }
                    ?>
                    </select>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $dto->__($lng,$any); ?>">
                    <input type="hidden" name="mes" value="<?php echo $dto->__($lng,$mes); ?>">
                    </form>
                    </div>
            </div><br>
        <table id="tblmarcatges" class="table table-striped table-hover table-condensed" style="text-align: center; border: solid 1px;">
            <?php
            // PREPARAR VARIABLES I ARRAYS            
            $idsMarcatges = [];
            $datesMarcatges = [];
            $diesvistos = [];
            $numdiesvistos = 0;
            $marcatgesfets = array_fill(0,7,0);
            $marcatgesvalidats = array_fill(0,7,0);
            $treballades = array_fill(0,7,0);
            $teoriques = array_fill(0,7,0);
            $avui = strtotime("now");            
            if($setmana!=$dto->__($lng,"Totes")&&$any!=$dto->__($lng,"Tots"))
                {                
                $primerdiasetmana = new DateTime();
                $primerdiasetmana->setISODate($any, $setmana-1);
                $diessetmana = [];
                for($i=0;$i<7;$i++)
                    {
                    $diesvistos[$numdiesvistos]=$primerdiasetmana->format('Y-m-d');
                    $numdiesvistos++;
                    $diessetmana[$i]=$primerdiasetmana->format('Y-m-d');
                    $primerdiasetmana->add($undiames);                    
                    }
                for($i=0;$i<=6&&($avui>=strtotime($diessetmana[$i]));$i++)
                    {
                        if(abs(substr($diessetmana[$i],5,2))==$mes) $teoriques[$i+1] = $dto->seleccionaHoresTeoriquesPerIdDia($id, $diessetmana[$i]);
                    }
                    if(abs(substr($diessetmana[0],5,2))==$mes) $teoriques[0] = $dto->seleccionaHoresTeoriquesPerIdDia($id, $diessetmana[6]);
                }
            if($mes!=$dto->__($lng,"Tots")&&$setmana==$dto->__($lng,"Totes"))
            {
                $primerdiames = new DateTime();                
                $primerdiames->setISODate($any,0);
                while($primerdiames->format('Y')<$any)$primerdiames->add($undiames);
                while($primerdiames->format('m')<$mes)$primerdiames->add($undiames);
                $diesmes = [];
                for($i=0;((date("m",strtotime($primerdiames->format('Y-m-d')))==$mes));$i++)
                    {
                    $diesvistos[$numdiesvistos]=$primerdiames->format('Y-m-d');
                    $numdiesvistos++;
                    $diesmes[$i]=$primerdiames->format('Y-m-d');
                    $primerdiames->add($undiames);
                    }
                for($i=0;(($i<count($diesmes))&&($avui>=strtotime($diesmes[$i])));$i++)
                    {
                    $weekday = date('w',strtotime($diesmes[$i]));    
                    if(empty($dto->esExcepcioPerIdDia($id, $diesmes[$i])))
                    $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($id, $diesmes[$i]);
                    }
            }
            if($any!=$dto->__($lng,"Tots")&&$mes==$dto->__($lng,"Tots")&&$setmana==$dto->__($lng,"Totes"))
                {                
                $primerdiaany = new DateTime();
                $primerdiaany->setISODate($any, 0,date("w",strtotime(($any."-01-01"))));
                $diesany = [];
                for($i=0;$i<366;$i++)
                    {
                    $diesvistos[$numdiesvistos]=$primerdiaany->format('Y-m-d');
                    $numdiesvistos++;
                    $diesany[$i]=$primerdiaany->format('Y-m-d');
                    $primerdiaany->add($undiames);
                    }
                for($i=0;$i<366&&($avui>=strtotime($diesany[$i]));$i++)
                    {
                        $weekday = date('w',strtotime($diesany[$i]));
                        $teoriques[$weekday] += $dto->seleccionaHoresTeoriquesPerIdDia($id, $diesany[$i]);
                    }
                }            
            $hihaespecial = 0;
            $horesespecials = new ArrayObject();
            $bodymarcatges = "";
            for($d=0;$d<$numdiesvistos;$d++)
            {
                $dia = $diesvistos[$d];
                $weekday = date('w',strtotime($dia));
                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $dia);
                if($hteor>0)
                {
                    $htreb = $dto->calculaHoresTreballadesPerIdDia($id, $dia);
                    $hdesc = $dto->seleccionaHoresPausaPerIdDia($id, $dia);
                    if($htreb<($hteor-0.5)) $hdesc=0;
                    if($htreb>=$hdesc) $treballades[$weekday] += $htreb-$hdesc;                
                }
                $marcatgesdia = $dto->seleccionaMarcatgesPerIdDia($id, $diesvistos[$d]);
                if((empty($marcatgesdia))&&($dto->seleccionaHoresTeoriquesPerIdDia($id, $diesvistos[$d])>0))
                {
                    $bodymarcatges.= '<tr><td title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($id,$dia,$lng).'"> '.date('d-m-Y',strtotime($diesvistos[$d])).''
                            . ' <span class="glyphicon glyphicon-question-sign" title="'.$dto->__($lng,"Dia laborable sense marcatges").'" style="color: red;"></span></td>';
                    for($c=1;$c<8;$c++)$bodymarcatges.= '<td>-</td>';
                    $bodymarcatges.= '<td></td></tr>';
                }
                else
                {
                    $contradicc = 0;
                    $llistamarcdia = new ArrayObject();
                    $nummarcdia = 0;
                    foreach ($marcatgesdia as $rg)
                    {
                        $marcatge = new Marcatge(substr($rg["datahora"],11,5), $rg["id_tipus"], $rg["entsort"]);
                        $llistamarcdia->append($marcatge);
                        $nummarcdia++;
                    }
                    if($nummarcdia==1)$contradicc++;
                    // FUNCIO CALCUL HORES ESPECIALS AMB MARCATGES                    
                    for ($a=0;$a<$nummarcdia;$a++)
                    {
                        if(($llistamarcdia[$a]->getIdtipus()<>4))
                        {
                            $hihaespecial++;
                            $exist=0;
                            $nomactivitat = $dto->getNomidTipusActivitat($llistamarcdia[$a]->getIdtipus());
                            foreach($horesespecials as $h) if($h->getConcepte()==$nomactivitat) $exist=1;
                            
                            if(($a==0))
                            {                                
                                if($exist<>1) {$horesconcepteespecial=new Horesresum($nomactivitat);
                                    $horesconcepteespecial->setHores($weekday, $dto->calculaHoresActivitatsPerIdDiaIdtipusInici($id, $dia, $llistamarcdia[$a]->getHora()));
                                    $horesespecials->append($horesconcepteespecial);}
                                if ($exist==1)
                                        foreach($horesespecials as $h)
                                            if($h->getConcepte()==$nomactivitat)
                                                $h->setHores($weekday,($h->getHores($weekday)+$dto->calculaHoresActivitatsPerIdDiaIdtipusInici($id, $dia, $llistamarcdia[$a]->getHora())));
                                if($llistamarcdia[$a]->getEntsort()==1)$contradicc++;
                            }
                            else if(($a>0)&&($llistamarcdia[$a]->getEntsort()==0))
                            {
                                $horesact = $dto->calculaHoresActivitatsPerInterval($llistamarcdia[$a-1]->getHora(),$llistamarcdia[$a]->getHora());
                                if($exist<>1) {$horesconcepteespecial=new Horesresum($nomactivitat);
                                    $horesconcepteespecial->setHores($weekday, $horesact);
                                    $horesespecials->append($horesconcepteespecial);}
                                if ($exist==1)
                                        foreach($horesespecials as $h)
                                            if($h->getConcepte()==$nomactivitat)
                                                $h->setHores($weekday,($h->getHores($weekday)+$horesact));                                                                
                                $treballades[$weekday] -= $horesact;
                            }
                            else if($a==($nummarcdia-1))
                            {
                                if($exist<>1) {$horesconcepteespecial=new Horesresum($nomactivitat);
                                    $horesconcepteespecial->setHores($weekday, $dto->calculaHoresActivitatsPerIdDiaIdtipusFinal($id, $dia, $llistamarcdia[$a]->getHora()));
                                    $horesespecials->append($horesconcepteespecial);}
                                if ($exist==1)
                                        foreach($horesespecials as $h)
                                            if($h->getConcepte()==$nomactivitat)
                                                $h->setHores($weekday,($h->getHores($weekday)+$dto->calculaHoresActivitatsPerIdDiaIdtipusFinal($id, $dia, $llistamarcdia[$a]->getHora())));
                                if($llistamarcdia[$a]->getEntsort()==0)$contradicc++;
                            }
                        }
                    }
                    // FI FUNCIO CALCUL HORES ESPECIALS AMB MARCATGES
                    foreach ($marcatgesdia as $marcatge)
                    {                
                        $idsMarcatges[]=($marcatge["idmarcatges"]);
                        $diamarcatge = date('d-m-Y',strtotime($marcatge["datahora"]));
                        $hora = substr($marcatge["datahora"],11,5);
                        $bodymarcatges.= '<tr><td title="'.$dto->__($lng,"Horari").': '.$dto->seleccionaTipusHorariPerIdDia($id,$dia,$lng).'">';
                        $bodymarcatges.= $diamarcatge;
                        if($contradicc>0)$bodymarcatges.= ' <span class="glyphicon glyphicon-exclamation-sign" title="'.$dto->__($lng,"Dia amb marcatges desaparellats").'" style="color: red;"></span>';
                        $bodymarcatges.= '</td>';
                        for ($i=1;$i<=6;$i++)
                        {
                            switch ($weekday)
                            {
                                case $i:
                                if($marcatge["validat"]==1)
                                {
                                    $bodymarcatges.= '<td id="marcatge" style="background-color:rgb(128,255,128)" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'">'.$hora.'</td>';
                                    $marcatgesfets[$i]++;
                                    $marcatgesvalidats[$i]++;
                                }
                                else
                                {
                                    $bodymarcatges.= '<td>'
                                    . '<label style="border: solid 1px; border-radius: 5px; padding: 3px; background-color: white;" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'">'.$hora.'</label>'
                                   
                                            . '</td>';
                                    $marcatgesfets[$i]++;                            
                                }
                                break;
                                default:
                                    $bodymarcatges.= '<td>-</td>';
                            }
                        }
                        switch($weekday)
                        {
                           case 0:
                            if($marcatge["validat"]==1)
                            {
                                $bodymarcatges.= '<td id="marcatge" style="background-color:rgb(128,255,128)" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'">'.$hora.'</td>';
                                $marcatgesfets[0]++;
                                $marcatgesvalidats[0]++;                        
                            }
                            else
                            {
                                $bodymarcatges.= '<td>'
                                    . '<label style="border: solid 1px; border-radius: 5px; padding: 3px; background-color: white;" title="'.$dto->__($lng,$dto->direntsort($marcatge["entsort"])).": ".$marcatge["tipus"].'">'.$hora.'</label>'
                                
                                        . '</td>';
                                $marcatgesfets[0]++;                        
                            }
                            break;
                                default:
                                    $bodymarcatges.= '<td>-</td>';                    
                        }
                    if($marcatge["validat"]==1){
                        $obs = $marcatge["observacions"];
                        if(empty($obs)) $obs = $dto->__($lng,"Validat");
                        $bodymarcatges.= '<td style="background-color:rgb(128,255,128)">'.$obs.'</td>';
                    }
                    else
                    {
                        $bodymarcatges.= '<td>'.$marcatge["observacions"].'</td>';
                    }
                    $bodymarcatges.= '</tr>';
                    }
                }
            }
            $stridsmarc = "";
            foreach($idsMarcatges as $idmarc) $stridsmarc = $stridsmarc.$idmarc."|"; 
            if($setmana!=$dto->__($lng,"Totes"))
            {
                $bodymarcatges.= '<tr style="background-color: rgb(255,255,255)"><th></th>';
                for ($j=1;$j<=6;$j++)
                {
                    $bodymarcatges.= '<td></td>';
                }
                if($marcatgesfets[0]>0)
                    {
                        $bodymarcatges.= '<td></td>';                        
                    }
                else $bodymarcatges.= '<td></td>';
                $bodymarcatges.= '<td></td></tr>';
            }
            $bodymarcatges.= "</tbody>";
            // IMPRIMIR RESUM HORES PERIODE            
            if($any!=$dto->__($lng,"Tots"))
            {
                echo "<thead>";
                echo '<th style="text-align: center">'.$dto->__($lng,"Hores").'</th>';
                for ($j=1;$j<=7;$j++)
                {
                    echo '<th></th>';
                }
                echo '<th style="text-align: center">'.$dto->__($lng,"Total Hores").'</th>';
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";
                echo '<td>'.$dto->__($lng,"Treballades").'</td>';
                for ($j=1;$j<=6;$j++)
                {
                    echo '<td>'.$treballades[$j].'</td>';
                }
                echo '<td>'.$treballades[0].'</td>';
                $totaltreballades = 0;
                for ($k=0;$k<=6;$k++) $totaltreballades += $treballades[$k]; 
                echo '<td>'.$totaltreballades.'</td>';
                echo '</tr>';
                echo "<tr>";
                echo '<td>'.$dto->__($lng,"Teòriques").'</td>';
                for ($j=1;$j<=6;$j++)
                {
                    echo '<td>'.$teoriques[$j].'</td>';
                }
                echo '<td>'.$teoriques[0].'</td>';
                $totalteoriques = 0;
                for ($k=0;$k<=6;$k++) $totalteoriques += $teoriques[$k]; 
                echo '<td>'.$totalteoriques.'</td>';
                echo '</tr>';
                echo "<tr>";
                echo '<td>'.$dto->__($lng,"Diferència").'</td>';
                for ($j=1;$j<=6;$j++)
                {
                    $deficit = $treballades[$j]-$teoriques[$j];
                    if ($deficit>0||(($deficit==0)&&($teoriques[$j]>0))) echo '<td style="background-color:rgb(128,255,128)">'.number_format((float)$deficit,1).'</td>';
                    else if ($deficit<0&&$deficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.number_format((float)$deficit,1).'</td>';
                    else if ($deficit==0) echo '<td>'.number_format((float)$deficit,1).'</td>';
                    else echo '<td style="background-color:rgb(255,128,128)">'.number_format((float)$deficit,1).'</td>';
                }
                $deficit = $treballades[0]-$teoriques[0];
                    if ($deficit>0||(($deficit==0)&&($teoriques[0]>0))) echo '<td style="background-color:rgb(128,255,128)">'.number_format((float)$deficit,1).'</td>';
                    else if ($deficit<0&&$deficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.number_format((float)$deficit,1).'</td>';
                    else if ($deficit==0) echo '<td>'.number_format((float)$deficit,1).'</td>';
                    else echo '<td style="background-color:rgb(255,128,128)">'.number_format((float)$deficit,1).'</td>';
                $totaldeficit = $totaltreballades-$totalteoriques;
                if ($totaldeficit>=0) echo '<td style="background-color:rgb(128,255,128)">'.number_format((float)$totaldeficit,1).'</td>';
                else if ($totaldeficit<0&&$totaldeficit>-1) echo '<td style="background-color:rgb(255,255,128)">'.number_format((float)$totaldeficit,1).'</td>';
                else echo '<td style="background-color:rgb(255,128,128)">'.number_format((float)$totaldeficit,1).'</td>';
                echo '</tr>';
                echo '</tbody>';
                //------ Hores Especials (ara metge)
                if($hihaespecial>0)
                {
                    echo "<thead>";
                    echo '<th style="text-align: center">'.$dto->__($lng,"Hores Especials").'</th>';
                    for ($j=1;$j<=7;$j++)
                    {
                        echo '<th></th>';
                    }
                    echo '<th style="text-align: center">'.$dto->__($lng,"Total Hores").'</th>';
                    echo "</thead>";
                    echo "<tbody>";
                    foreach($horesespecials as $hs)
                    {
                    echo "<tr>";
                    echo '<td>'.$dto->__($lng,$hs->getConcepte()).'</td>';
                    for ($j=1;$j<=6;$j++)
                    {
                        if($hs->getHores($j)>0) echo '<td style="background-color: yellow">';
                        else if($hs->getHores($j)<0) echo '<td title="'.$dto->__($lng,"Marcatges d´hores especials fora de l´horari de treball").'"><span class="glyphicon glyphicon-exclamation-sign" style="color: red"></span>';
                        else echo '<td>';
                        echo number_format((float)$hs->getHores($j),1).'</td>';
                    }
                    echo '<td>'.number_format((float)$hs->getHores(0),1).'</td>';
                    $totalespecials = 0;
                    for ($k=0;$k<=6;$k++) $totalespecials += $hs->getHores($k); 
                    echo '<td>'.number_format((float)$hs->getHtotals(),1).'</td>';
                    echo '</tr>';
                    }
                    echo "</tbody>";
                }
            }
            ?>
            <thead>
            <strong>
            <th style="text-align: center"><?php echo $dto->__($lng,"Data");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dilluns");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dimarts");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dimecres");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dijous");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Divendres");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Dissabte");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Diumenge");?></th>
            <th style="text-align: center"><?php echo $dto->__($lng,"Observacions");?></strong></th>
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
        <br><br>
    </center>
    <div class="modal-fade" id="modContent"></div>            
    </div>
    <div class="modal fade" id="modCalendariMes" role="dialog">
           <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header"><h3><?php echo $dto->__($lng,"Calendari Mensual");?><button type="button" class="close" data-dismiss="modal">&times;</button></h3></div>
                <div id="contingut" class="modal-body">
                    <div>
                    <?php $dto->imprimeixMesPerIdAnyMes($id,$any,$mes,100,$lng); ?>
                </div>
                </div>  
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
</html>
