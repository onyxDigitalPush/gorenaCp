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
    $teoriques = 0;
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
                    <br><br>
                    <table class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                        <thead>
                            <tr style="background-color: white; color: black">
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"DIA"); ?></th>
                        <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"MATÍ"); ?></th>
                        <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"TARDA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES TREBALLADES"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORES TEÒRIQUES"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"OBSERVACIONS"); ?></th>
                        </tr>
                        <tr style="background-color: white; color: black">                        
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            $marc1 = "";
                            $marc2 = "";
                            $marc3 = "";
                            $marc4 = "";
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
                                $bi = $dto->esTornBidata($id, $data);
                                if($bi==0){
                                    $marc1 = $dto->getPrimerMarcatgePerIdDia($id, $data);
                                    $idm1 = 0;
                                    foreach($marc1 as $m1) {$idm1 = $m1["pmc"];}
                                    $marc2 = $dto->getMarcatgeParella($id, $data, $idm1);
                                    
                                    $marc4 = $dto->getUltimMarcatgeSortidaPerIdDia($id, $data);
                                    $idm4 = 0;
                                    foreach($marc4 as $m4) {$idm4 = $m4["umc"];}
                                    if(!empty($idm4))$marc3 = $dto->getMarcatgeParellaInvers($id, $data, $idm4);
                                }
                                else {
                                    $marc1 = $dto->getPrimerMarcatgeEntradaPerIdDia($id, $data);
                                    $idm1 = 0;
                                    foreach($marc1 as $m1) {$idm1 = $m1["pmc"];}
                                    $marc2 = $dto->getMarcatgeParella($id, $data, $idm1);
                                    $idm2 = 0;
                                    foreach($marc2 as $m2) {$idm2 = $m2["pmc"];}
                                    $marc3 = $dto->getMarcatgeParella($id, $data, $idm2);
                                    $diaseg = date('Y-m-d',strtotime($data.' + 1 days'));
                                    $marc4 = $dto->getPrimerMarcatgeSortidaPerIdDia($id, $diaseg);
                                }
                               
                                
                                $hora1 = "";
                                foreach ($marc1 as $entrada) {
                                    $hora1=substr($entrada["fitx"],11,5);
                                    if(strtotime($hora1)>strtotime('14:00')){
                                        $marc3 = $marc1;
                                        $marc4 = $marc2;
                                        $hora1 = "";
                                    }
                                }
                                echo '<td style="border: solid 1px">'.$hora1.'</td>';
                                
                               
                                
                                $hora2 = "";
                                if($hora1!="") {foreach ($marc2 as $sortida) $hora2=substr($sortida["fitx"],11,5);}
                                echo '<td style="border: solid 1px">'.$hora2.'</td>';
                                
                                // MARCATGES TARDA
                                
                                $hora3 = "";
                                if(($hora2!="")||(!empty($marc3))) { foreach ($marc3 as $m3)$hora3=substr($m3["fitx"],11,5);}
                                $marc3 = null;
                                if($hora3==$hora1){$hora3="";}
                                echo '<td style="border: solid 1px">'.$hora3.'</td>';
                                $hora4 = "";
                                if($hora3!="") {foreach ($marc4 as $m4) $hora4=substr($m4["fitx"],11,5);}
                                echo '<td style="border: solid 1px">'.$hora4.'</td>';
                                }catch(Exception $ex){echo $ex->getMessage();}
                                // FI MARCATGES TARDA
                                
                                $htreb = "";
                                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $data);                                                                
                                $hores = 0;
                                $horesmed = 0;
                                // COMENTAT Que només calculi hores treballades en laborables
                              
                                $hdesc = 0.0;
                                $nummarc = 0;
                                $rsm = $dto->getDb()->executarConsulta('select count(idmarcatges) as nummarc from marcatges where id_emp like "'.$id.'" and date(datahora) like "'.$data.'"');
                                foreach($rsm as $n) {$nummarc = $n["nummarc"];}
                                // PER A OPTICA HISPANO NO APLICAREM HORES DE DESCANS JA QUE MARQUEN SEMPRE QUE SURTEN
                               
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id,$data);                                    
                                $observacions = $dto->getObservacionsPorEmpleadoYDia($id, $data);
                                $hores-=$hdesc;
                                                               
                                if($hores>0) {
                                    if($nummarc>4)$hores-=$dto->calculaHoresActivitatsAdescomptarPerIdDia($id, $data);;
                                    $treballades += $hores;
                                    $htreb = number_format($hores,2,",",".");
                                }
                                $teoriques += $hteor;
                                if($hteor==0){$hteor="";}
                                else{$hteor=number_format($hteor,2,",",".");}
                                echo '<td style="border: solid 1px">'.$htreb.'</td><td style="border: solid 1px">'.$hteor.'</td>';
                               
                               
                                echo '<td style="border: solid 1px">';
                                foreach ($observacions as $observacion) {
                                    echo $observacion . '<br>';
                                }
                                echo '</td>';
                                       
                                echo '</tr>';                                
                            }
                            ?>
                            <tr></tr><td></td><td colspan="4" style="border: solid 1px"><?php echo $dto->__($lng,"TOTAL HORAS TRABAJADAS"); ?></td><td style="border: solid 1px"><?php echo number_format($treballades,2,",","."); ?></td><td style="border: solid 1px"><?php echo number_format($teoriques,2,",","."); ?></td><!--td style="border: solid 1px"></td-->
                        </tbody>
                    </table><br>
                    <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng,"Firma de l'empresa"); ?>:</section>
                    <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng,"Firma del treballador"); ?>:</section>                    
                    <br><p style="font-size: 18px;"><?php echo "A"; ?> <?php echo $pobemp;?>, <?php echo $dto->__($lng,"a"); ?> <?php echo $diafi;?> <?php echo $dto->__($lng,"de"); ?> <?php echo $dto->__($lng,$dto->mostraNomMes($mes));?> <?php echo $dto->__($lng,"de"); ?> <?php echo $any;?></p>
                </div>
                <br>
                <p style="font-size: 9px; text-align: left">
                    Registre realitzat en complimient de la lletra h) de l'article 1 del R.D.-Ley 16/2013, de 20 de desembre pel que es modifica l'artícle 12.5 de l'E.T., pel que s'estableix que "La<br>
                    jornada dels treballadors a temps parcial es registrarà dia a dia i es totalitzarà mensualment, entregant còpia al treballador, juntament amb el rebut de salaris, del resum de totes les<br>
                    hores realitzades cada mes, tant les ordinàries com les complementàries en les seves diferents modalitats.
                    L'empresari haurà de conservar els resums mensuals dels registres de jornada durant un períodoe mínim de quatre anys. L'incompliment empresarial d'aquestes obligacions de<br>
                    registre tindrà per conseqüència jurídica que el contratcte es consideri celebrat a jornada complerta, excepte prova contrària que acrediti el caràcter parcial dels serveis.
                </p>
                <div id="editor"></div>
               
              </div>
    </div>
          </center>
</body>
</html>
