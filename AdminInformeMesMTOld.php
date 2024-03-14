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
                    <span class="glyphicon glyphicon-repeat" style="height: 15px; width: 15px"></span> <?php echo $dto->__($lng,"Tornar"); ?></button></form>
                        <button class="btn btn-primary" onclick="printElem('resumhores');"><span class="glyphicon glyphicon-print"></span> <?php echo $dto->__($lng,"Imprimir"); ?></button>
            </div>
            <div class="col-lg-8" id="resumhores" style="border: solid 1px; border-radius: 3px;">
              <div id="contingut">
                    <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng,"Llistat Resum mensual del registre de jornadaASDFSDF (complet)"); ?></h3>
                    <div>
                    <section style="width:50%; float:left;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                                <tr><th style="border: solid 1px"><?php echo $dto->__($lng,"Empresa"); ?>:</th><td style="border: solid 1px"><?php echo $nomemp; ?></td></tr>
                                <tr><th style="border: solid 1px">C.I.F./N.I.F.:</th><td style="border: solid 1px"><?php echo $cifemp; ?></td></tr>
                                <tr><th style="border: solid 1px"><?php echo $dto->__($lng,"Centre de Treball"); ?>:</th><td style="border: solid 1px"><?php echo $ctremp; ?></td></tr>
                            <tr><th style="border: solid 1px">C.C.C.:</th><td style="border: solid 1px"><?php echo $cccemp; ?></td></tr>
                            </tbody>
                        </table>
                    </section>
                    <section style="width:50%; float:right;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                            <tr><th style="border: solid 1px"><?php echo $dto->__($lng,"Treballador"); ?>:</th><td style="border: solid 1px"><?php echo $dto->mostraNomEmpPerId($id); ?></td></tr>
                            <tr><th style="border: solid 1px">N.I.F.:</th><td style="border: solid 1px"><?php echo $dto->getEmpDni($id); ?></td></tr>
                            <tr><th style="border: solid 1px"><?php echo $dto->__($lng,"Nº Afiliació"); ?>:</th><td style="border: solid 1px"><?php echo $dto->getEmpAfil($id); ?></td></tr>
                            <tr><th style="border: solid 1px"><?php echo $dto->__($lng,"Mes i any"); ?>:</th><td style="border: solid 1px"><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?></td></tr>
                            </tbody>                        
                    </table>
                    </section>
                    </div>
                    <br><br>
                    <table class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                        <thead>
                            <tr style="background-color: white; color: black">
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"DIA"); ?></th>
                        <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"MATÍ"); ?></th>
                        <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"TARDA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES ORDINÀRIES"); ?></th>
                        <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES COMPLEMENTÀRIES"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"FIRMA TRABAJADOR"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"OBSERVACIONEEEEEEES"); ?></th>
                        </tr>
                        <tr style="background-color: white; color: black">                        
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"PACTADES"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"VOLUNTÀRIES"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            $marc1 = "";
                            $marc2 = "";
                            $marc3 = "";
                            $marc4 = "";
                            $entsort = 0;
                            $nummarc = 0;
                            $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'"');
                            foreach($rsm as $n) {$nummarc = $n["nummarc"];}
                            if($mes<10)$mes = "0".$mes;
                            for($i=1;$i<=$diafi;$i++)
                            {
                                try{
                                echo '<tr>';
                                echo '<td style="border: solid 1px">'.$i.'</td>';
                                $j = "";
                                if($i<10)$j = "0".$i;
                                else $j = $i;
                                $data = $any."-".$mes."-".$j;
                                
                                $hora1 = "";
                                $hora2 = "";
                                $hora3 = "";
                                $hora4 = "";
                                $entsort = 0;                                
                                
                                $n = 0;
                                $entrada = 0;
                                $mcs = $dto->getMarcatgesPerIdDiaTorn($id, $data);
                                foreach($mcs as $mc) {
                                   
                                    if(($n==0)&&($mc->getEntsort()==1)) {}
                                    else {
                                        if(($mc->getEntsort()==0)&&($entrada==0)){
                                            if($hora1=="") {$hora1=date('H:i',strtotime($mc->getDatahora()));$entrada=1;}
                                            else {$hora3=date('H:i',strtotime($mc->getDatahora()));$entrada=1;}
                                        }
                                        else {
                                        if($hora2=="") {$hora2=date('H:i',strtotime($mc->getDatahora()));if($entrada==1) {$entrada=0;} }
                                        else {$hora4=date('H:i',strtotime($mc->getDatahora()));if($entrada==1) {$entrada=0;} }
                                        }
                                    }
                                    $n++;
                                   
                                }

                                foreach
                                //Revisar per si de cas si hi havia torn de nit sense indicar o marcatge suelto de sortida sense aparellar al principi del dia següent (festiu treballat de nit)
                                if(($entrada==1)){                                    
                                    $dataseg = date('Y-m-d',strtotime($data.' + 1 days'));                                    
                                    $mcex = $dto->getPrimerMarcatgePerIdDia($id, $dataseg);
                                    if($n<=2){foreach($mcex as $mx){ if($mx["entsort"]==1){$hora2 = date('H:i',strtotime($mx["fitx"]));} } }
                                    if($n>2){foreach($mcex as $mx){ if($mx["entsort"]==1){$hora4 = date('H:i',strtotime($mx["fitx"]));} } }                                        
                                }
                                echo '<td style="border: solid 1px">'.$hora1.'</td>';
                                if($hora1=="") {$hora2=="";}
                                echo '<td style="border: solid 1px">'.$hora2.'</td>';
                                if($hora2=="") {$hora3=="";}
                                echo '<td style="border: solid 1px">'.$hora3.'</td>';
                                if($hora3=="") {$hora4=="";}
                                echo '<td style="border: solid 1px">'.$hora4.'</td>';
                               
                                }catch(Exception $ex){echo $ex->getMessage();}
                                // FI MARCATGES TARDA
                                //
                                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $data);                                                                
                                $hores = 0;
                                $horesmed = 0;
                                // COMENTAT Que només calculi hores treballades en laborables
                               
                                $hdesc = 0.0;
                                $nummarc = 0;
                                $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'"');
                                foreach($rsm as $n) {$nummarc = $n["nummarc"];}
                                if($nummarc<=2) {$hdesc = $dto->seleccionaHoresPausaPerIdDia($id, $data);}
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id,$data);                                    
                                
                                $tipusexcep = "";
                                $rse = $dto->esExcepcioPerIdDia($id, $data);
                                if(!empty($rse)) {
                                    foreach($rse as $e){$tipusexcep = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusexcep",$e["idtipusexcep"],"nom"));}
                                }
                                //Excés d'hores treballades passen a ser hores extres voluntaries
                                $hvol = 0;                                
                                if($hores>0) {
                                    if($nummarc>4)$hores-=$dto->calculaHoresActivitatsAdescomptarPerIdDia($id, $data);;
                                    if($hores>$hteor){$hvol = $hores-$hteor;$hores=$hteor;}
                                    $treballades += $hores;
                                    $voluntaries += $hvol;
                                    echo '<td style="border: solid 1px">'.$hores.'</td>';
                                }                                    
                                else echo '<td style="border: solid 1px">'.$tipusexcep.'</td>';
                               
                                if($hvol==0) {$hvol = "";}
                                else {$hvol=number_format($hvol,2,",",".");}
                                echo '<td style="border: solid 1px">'.'</td><td style="border: solid 1px">'.$hvol.'</td>';
                                echo '<td style="border: solid 1px">'.'</td><td style="border: solid 1px">'.'</td>';
                                echo '</tr>';                                
                            }
                            ?>
                            <tr></tr><td></td><td colspan="4" style="border: solid 1px"><?php echo $dto->__($lng,"TOTAL HORAS TRABAJADAS"); ?></td><td style="border: solid 1px"><?php echo $treballades; ?></td><td style="border: solid 1px"></td><td style="border: solid 1px"><?php echo $voluntaries; ?></td>
                        </tbody>
                    </table><br>
                    <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng,"Firma de l'empresa"); ?>:</section>
                    <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng,"Firma del treballador"); ?>:</section>                    
                    <br><p style="font-size: 18px;"><?php echo $dto->__($lng,"En"); ?> <?php echo $pobemp;?>, <?php echo $dto->__($lng,"a"); ?> <?php echo $diafi;?> <?php echo $dto->__($lng,"de"); ?> <?php echo $dto->__($lng,$dto->mostraNomMes($mes));?> <?php echo $dto->__($lng,"de"); ?> <?php echo $any;?></p>
                </div>
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
    </div>
          </center>
</body>
</html>
