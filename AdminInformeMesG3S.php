<!DOCTYPE html>
<html>
        <head>
        <?php include './Pantalles/HeadGeneric.html'; ?> 
    <script type="text/javascript">
        function GeneraPDF()
        {
            var doc = new jsPDF('p', 'pt', 'letter');
            doc.fromHTML($('#contingut').html());
            doc.save('Informe.pdf');
        }
    </script>
        </head>
        <body>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    session_start();
    $idemp = $_SESSION["idempresa"];
    $idempresa = $idemp;
    $lng=0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];    
    $dto->navResolver();
    $id = intval($_GET['id']);
    $any = intval($_GET['any']);
    $mes = intval($_GET['mes']);
    $setmana = $_GET['setmana'];
    $taulaemp = 'empresa';
    $idsubemp = $dto->getCampPerIdCampTaula("empleat",$id,"idsubempresa");
    if(!empty($idsubemp)) {$idemp = $idsubemp; $taulaemp = 'subempresa';}
    $nomemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"nom");
    $cifemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"cif");
    $ctremp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"centre_treball");
    $cccemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"ccc");
    $pobemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"poblacio");
    $treballades = 0;
    $voluntaries = 0;
    $mediquesmes = 0;
    $zmes = $mes;
    if($mes<10) $zmes = "0".$mes;
    $datafi = date('Y-m-d',strtotime($any."-".$zmes."-01"));
    while(date('m',strtotime($datafi))==$zmes) {$datafi = date('Y-m-d',strtotime($datafi." + 1 days"));}
    $diafi = date('d',strtotime($datafi." - 1 days"));
    $chkdec = "";
    $chkmin = "";
    $dispcomp = "";
    $chkhcp = "";
    if(!isset($_GET["chkhmin"])) {$chkdec = "checked";}
    else{
        if($_GET["chkhmin"]=="min") {$chkmin = "checked";}
        else {$chkdec = "checked";}
    }
    if(!isset($_GET["chkhcp"])) {$dispcomp = "none";}
    else {$chkhcp = "checked";}
    ?>
    <center>
        <div class="row">
            <div class="col-lg-2">
            <form method="get" action="AdminMarcatgesEmpleat.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo abs($mes); ?>">
                    <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                <button type="submit" class="btn btn-default hidden-print" onclick="this.form.submit()">
                    <span class="glyphicon glyphicon-repeat" style="height: 15px; width: 15px"></span> <?php echo $dto->__($lng,"Tornar"); ?></button>
            </form>
            <button class="btn btn-primary" onclick="printElem('resumhores');"><span class="glyphicon glyphicon-print"></span> <?php echo $dto->__($lng,"Imprimir"); ?></button>
            <br><br>            
            <form method="get" action="AdminInformeMesG3S.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo abs($mes); ?>">
                <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                <h4><?php echo $dto->__($lng,"Horas Decimales");?> <input type="radio" name="chkhmin" value="dec" <?php echo $chkdec;?> onclick="this.form.submit();" style="width: 25px; height: 25px"></h4>
                <h4><?php echo $dto->__($lng,"Horas y Minutos");?> <input type="radio" name="chkhmin" value="min" <?php echo $chkmin;?> onclick="this.form.submit();" style="width: 25px; height: 25px"></h4>
                <h4><?php echo $dto->__($lng,"Horas Complementarias");?> <input type="checkbox" name="chkhcp" <?php echo $chkhcp;?> onclick="this.form.submit();" style="width: 25px; height: 25px"></h4>
            </form>
            </div>
            <div class="col-lg-8" id="resumhores" style="border: solid 1px; border-radius: 3px;">
              <div id="contingut">
                    <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng,"Llistat Resum mensual del registre de jornada (complet)"); ?></h3>
                    <div>
                    <section style="width:50%; float:left;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Empresa"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $nomemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">C.I.F./N.I.F.:</th>
                                <td style="border: solid 1px"><?php echo $cifemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Centre de Treball"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $ctremp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">C.C.C.:</th>
                                <td style="border: solid 1px"><?php echo $cccemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Población"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $pobemp; ?> </td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                    <section style="width:50%; float:right;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Treballador"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->mostraNomEmpPerId($id); ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">N.I.F.:</th>
                                <td style="border: solid 1px"><?php echo $dto->getEmpDni($id); ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Nº Afiliació"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->getEmpAfil($id); ?></td>
                            </tr>

                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Departament"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->mostraNomDptPerIdEmp($id); ?></td>
                            </tr>

                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Mes i any"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->__($lng, $dto->mostraNomMes($mes)) . " " . $any; ?></td>
                            </tr>
                            </tbody>                        
                    </table>
                    </section>
                    </div>
                    <br>
                    <table  border="1" class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                        <thead>
                            <tr style="background-color: white; color: black">
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"DIA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORAS TRABAJADAS"); ?></th>
                        <th colspan="2" style="display:<?php echo $dispcomp;?>; text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES COMPLEMENTÀRIES"); ?></th>
                        </tr>
                        <tr style="background-color: white; color: black">
                        <th style="display:<?php echo $dispcomp;?>; text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"PACTADES"); ?></th>
                        <th style="display:<?php echo $dispcomp;?>; text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"VOLUNTÀRIES"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            if($mes<10)$mes = "0".$mes;
                            for($i=1;$i<=$diafi;$i++)
                            {
                                echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                $j = "";
                                if($i<10)$j = "0".$i;
                                else $j = $i;
                                $data = $any."-".$mes."-".$j;
                                
                                $hora1 = "";
                                $hora2 = "";
                                $entsort = 0;                                
                               
                                $n = 0;
                                $entrada = 0;
                                $mcs = $dto->getMarcatgesPerIdDiaTorn($id, $data);
                                foreach($mcs as $mc) {
                                   
                                    if(($n==0)&&($mc->getEntsort()==1)) {}
                                    else {
                                        if(($mc->getEntsort()==0)&&($entrada==0)){$hora1=date('H:i',strtotime($mc->getDatahora()));$entrada=1;}
                                        else {$hora2=date('H:i',strtotime($mc->getDatahora()));if($entrada==1) {$entrada=0;} }
                                    }
                                    $n++;
                                   
                                }
                               
                                if(($entrada==1)){
                                    $dataseg = date('Y-m-d',strtotime($data.' + 1 days'));
                                    $mcex = $dto->getPrimerMarcatgePerIdDia($id, $dataseg);
                                    foreach($mcex as $mx){ if($mx["entsort"]==1){$hora2 = date('H:i',strtotime($mx["fitx"]));} }
                                }
                                echo '<td>'.$hora1.'</td>';
                                if($hora1=="") {$hora2=="";}
                                echo '<td>'.$hora2.'</td>';
                               
                                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $data);                                                                
                                $hores = 0;
                                $horesmed = 0;
                                
                                // COMENTAT Que només calculi hores treballades en laborables
                                
                                $hdesc = 0.0;
                                $nummarc = 0;
                                $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'"');
                                foreach($rsm as $n) {$nummarc = $n["nummarc"];}
                               
                                
                                // HORES EN DECIMALS
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id,$data);                                    
                                // HORES I MINUTS
                                $minuts = $dto->calculaMinutsTreballatsPerIdDia($id,$data);
                                $horesmins = "";
                                if($minuts>($hteor*3600)){
                                    $horesmins = date('H:i',($hteor*3600));
                                }
                                else $horesmins = date('H:i',$minuts);
                                
                               
                                $tipusexcep = "";
                                $rse = $dto->esExcepcioPerIdDia($id, $data);
                                if(!empty($rse)) {
                                    foreach($rse as $e){$tipusexcep = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusexcep",$e["idtipusexcep"],"nom"));}
                                }
                                
                                $arrodmitjahoraextra = $dto->getCampPerIdCampTaula("empresa",$idempresa,"arrodmitjahoraextra");
                                
                                
                                $hvol = 0;                                
                                if($hores>0) {
                                    // JA NOMÉS CAL DESCOMPTAR LES HORES ESPECIALS SI HI HA MÉS DE 4 MARCATGES
                                    if($nummarc>4) $hores-=$dto->calculaHoresActivitatsAdescomptarPerIdDia($id, $data);
                                    if($arrodmitjahoraextra==1){
                                        $tb = $hores;
                                        $to = $hteor;
                                        if($tb>$to){
                                            $tex = $tb - $to;
                                            $tb = $to;
                                            $tsum = 0.0;
                                            while($tex>0.0){
                                                if($tex >= 0.17){
                                                    $tsum+= 0.5;
                                                }                            
                                                $tex-=0.5;
                                            }
                                            $tb+=$tsum; 
                                        }
                                        $hores=$tb;
                                    }
                                    $hvol = $hores-$hteor;
                                    if($hores>$hteor){$hores=$hteor;}
                                    $treballades += $hores;
                                    $voluntaries += $hvol;
                                    
                            
                                    // HORES EN DECIMALS
                                    if($chkdec=="checked" ) {
										if($hores == "0"){
											$hores = $tipusexcep;
										}
										
										echo '<td>'.$hores.'</td>';}
                                    // HORES I MINUTS
                                    
                                   
                                    if($chkmin=="checked")  {echo '<td>'.$horesmins.'</td>';}
                                }                                    
                                else echo '<td>'.$tipusexcep.'</td>';
   
                                
                                if($hvol==0) {$hvol = "";}
                                else {
                                    if($_GET["chkhmin"]=="min") {
                                        $sign = "";
                                        if($minuts<($hteor*3600)){$hvol = "-".date('H:i',(($hteor*3600)-$minuts));}
                                        else{
                                           
                                            $hvol = date('H:i',(($hvol*3600)));//$minuts
                                        
                                        }
                                    }
                                    else {$hvol=number_format($hvol,2,",",".");}
                              
                                }
                                
                               
                                if($hteor==0) {$hteor = "";}
                                else {$hteor=number_format($hteor,2,",",".");}                                    
                                
                                echo '<td style="display: '.$dispcomp.';">'.''.'</td>';
                                echo '<td style="display: '.$dispcomp.';">'.$hvol.'</td>';
                                echo '</tr>';                                 
                                
                            }
                            if($_GET["chkhmin"]=="min") {
                                $trebcompl = $treballades;
                                $trebhours = intval($treballades);
                                $trebmins = ($trebcompl-$trebhours)*60;                                
                                $signt = "";
                                if($treballades<0){$signt="-";}
                                $treballades = $signt.abs($trebhours)." h, ".abs(intval($trebmins))." min.";
                                
                                $volcompl = $voluntaries;
                                $volhours = intval($voluntaries);
                                $volmins = ($volcompl-$volhours)*60;
                                $sign = "";
                                if($voluntaries<0){$sign="-";}
                                $voluntaries = $sign.abs($volhours)." h, ".abs(intval($volmins))." min.";
                            }
                            ?>
                            <tr></tr><td></td><td colspan="2"><?php echo $dto->__($lng,"TOTAL"); ?> <?php echo $dto->__($lng,"HORES"); ?></td><td><?php echo $treballades; ?></td><td style="display:<?php echo $dispcomp;?>;"></td><td style="display:<?php echo $dispcomp;?>;"><?php echo $voluntaries; ?></td>
                        </tbody>
                    </table><br>
                    <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng,"Firma de l'empresa"); ?>:</section>
                    <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng,"Firma del treballador"); ?>:</section>                    
                    <br><p style="font-size: 18px;"><?php echo $dto->__($lng,"A "); ?> <?php echo $pobemp;?>, <?php echo $dto->__($lng,"a"); ?> <?php echo $diafi;?> <?php echo $dto->__($lng,"de"); ?> <?php echo $dto->__($lng,$dto->mostraNomMes($mes));?> <?php echo $dto->__($lng,"de"); ?> <?php echo $any;?></p>
                </div>
                <br>
                <br>
                <p style="font-size: 9px; text-align: left">
                    Registro realizado en cumplimiento de la letra h) del artículo 1 del R.D.-Ley 16/2013, de 20 de diciembre por el que se modifica el artículo 12.5 del E.T., por el que se establece que "La<br>
                    jornada de los trabajadores a tiempo parcial se registrará día a día y se totalizará mensualmente, entregando copia al trabajador, junto con el recibo de salarios, del resumen de todas las<br>
                    horas realizadas en cada mes, tanto de las ordinarias como de las complementarias en sus distintas modalidades.
                    El empresario deberá conservar los resúmenes mensuales de los registros de jornada durante un período mínimo de cuatro años. El incumplimiento empresarial de estas obligaciones de<br>
                    registro tendrá por consecuencia jurídica la de que el contrato se presuma celebrado a jornada completa, salvo prueba en contrario que acredite el carácter parcial de los servicios.
                </p>
                <div id="editor"></div>
              
              </div> 
            <br><br>
    </div>
          </center>
</body>
</html>
