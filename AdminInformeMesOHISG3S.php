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
                    <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng,"Llistat Resum mensual del registre de jornada (complet)"); ?></h3>
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
                    <br>
                    <table class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                        <thead>
                            <tr style="background-color: white; color: black">
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"DIA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES TREBALLADES"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES TEÒRIQUES"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"OBSERVACIONS"); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            if($mes<10)$mes = "0".$mes;
                            for($i=1;$i<=$diafi;$i++)
                            {
                                echo '<tr>';
                                echo '<td style="border: solid 1px">'.$i.'</td>';
                                $j = "";
                                if($i<10)$j = "0".$i;
                                else $j = $i;
                                $data = $any."-".$mes."-".$j;
                                $bi = $dto->esTornBidata($id, $data);
                                $marc1 = "";
                                $marc2 = "";
                                $hora1 = "";
                                $hora2 = "";
                                if($bi==0){
                                    $marc1 = $dto->getPrimerMarcatgeEntradaPerIdDia($id, $data);
                                    foreach ($marc1 as $entrada) {if($entrada["entsort"]==0) {$hora1=substr($entrada["fitx"],11,5);}}
                                    echo '<td style="border: solid 1px">'.$hora1.'</td>';
                                    $marc2 = $dto->getUltimMarcatgeSortidaPerIdDia($id, $data);
                                    foreach ($marc2 as $sortida) {if($hora1!="") {$hora2=substr($sortida["fitx"],11,5);}}
                                    echo '<td style="border: solid 1px">'.$hora2.'</td>';
                                }
                                else {
                                    $marc1 = $dto->getUltimMarcatgeEntradaPerIdDia($id, $data);
                                    foreach ($marc1 as $entrada) {if($entrada["entsort"]==0) {$hora1=substr($entrada["fitx"],11,5);}}
                                    echo '<td style="border: solid 1px">'.$hora1.'</td>';
                                    $diaseg = date('Y-m-d',strtotime($data.' + 1 days'));
                                    $marc2 = $dto->getPrimerMarcatgeSortidaPerIdDia($id, $diaseg);
                                    foreach ($marc2 as $sortida) {if($hora1!="") {$hora2=substr($sortida["fitx"],11,5);}}
                                    echo '<td style="border: solid 1px">'.$hora2.'</td>';
                                }
                                $observacions = $dto->getObservacionsPorEmpleadoYDia($id, $data);
                                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $data);
                                $teoriquesmes+=$hteor;
                                $hores = 0;
                                $horesmed = 0;
                                // COMENTAT Que només calculi hores treballades en laborables
                               
                                $hdesc = 0.0;
                                $nummarc = 0;
                                $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'"');
                                foreach($rsm as $n) {$nummarc = $n["nummarc"];}
                                // PER A OPTICA HISPANO NO APLICAREM HORES DE DESCANS JA QUE MARQUEN SEMPRE QUE SURTEN
                               
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id,$data);                                    
                                
                                $hores-=$hdesc;
                                                             
                                if($hores>0) {
                                    // JA NOMÉS CAL DESCOMPTAR LES HORES ESPECIALS SI HI HA MÉS DE 4 MARCATGES
                                    if($nummarc>4) $hores-=$dto->calculaHoresActivitatsAdescomptarPerIdDia($id, $data);;
                                    $treballades += $hores;
                                    echo '<td style="border: solid 1px">'.number_format($hores,2,",",".").'</td>';
                                }                                    
                                else echo '<td style="border: solid 1px">'.'</td>';
                                
                                if($hteor==0) {$hteor = "";}
                                else {$hteor=number_format($hteor,2,",",".");}
                                echo '<td style="border: solid 1px">'.$hteor.'</td>';

                                echo '<td style="border: solid 1px">';
                                foreach ($observacions as $observacion) {
                                    echo $observacion . '<br>';
                                }
                                echo '</td>';

                                echo '</tr>';                                
                            }
                            ?>
                            <tr></tr><td style="border: solid 1px"></td><td colspan="2" style="border: solid 1px"><?php echo $dto->__($lng,"TOTAL"); ?> <?php echo $dto->__($lng,"HORES"); ?></td><td style="border: solid 1px"><?php echo number_format($treballades,2,",","."); ?></td><td style="border: solid 1px"><?php echo number_format($teoriquesmes,2,",","."); ?></td><td style="border: solid 1px"></td>
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
