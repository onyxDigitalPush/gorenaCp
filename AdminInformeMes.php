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
    $lng=0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];    
    $dto->navResolver();
    $id = intval($_GET['id']);
    $any = intval($_GET['any']);
    $mes = intval($_GET['mes']);
    $setmana = $_GET['setmana'];
    $treballades = 0;
    $mediquesmes = 0;
    ?>
    <center>
            <div class="container">
              <div id="contingut">
                    <h4><?php echo $dto->__($lng,"Resum mensual del registre de jornada"); ?></h4><br>
                    <section style="width:50%; float:left;">
                        <table class="table table-striped table-bordered table-condensed" style="text-align: left">
                            <tbody>
                                <tr><th><?php echo $dto->__($lng,"Empresa"); ?>:</th><td><?php echo $dto->mostraNomEmpresa($_SESSION["idempresa"]); ?></td></tr>
                                <tr><th>C.I.F./N.I.F.:</th><td><?php echo $dto->mostraCifEmpresa($_SESSION["idempresa"]); ?></td></tr>
                                <tr><th><?php echo $dto->__($lng,"Centre de Treball"); ?>:</th><td><?php echo $dto->mostraCTreballEmpresa($_SESSION["idempresa"]); ?></td></tr>
                            <tr><th>C.C.C.:</th><td><?php echo $dto->mostraCccEmpresa($_SESSION["idempresa"]); ?></td></tr>
                            </tbody>
                        </table>
                    </section>
                    <section style="width:50%; float:right;">
                        <table class="table table-striped table-bordered table-condensed" style="text-align: left">
                            <tbody>
                            <tr><th><?php echo $dto->__($lng,"Treballador"); ?>:</th><td><?php echo $dto->mostraNomEmpPerId($id); ?></td></tr>
                            <tr><th>N.I.F.:</th><td><?php echo $dto->getEmpDni($id); ?></td></tr>
                            <tr><th><?php echo $dto->__($lng,"Nº Afiliació"); ?>:</th><td><?php echo $dto->getEmpAfil($id); ?></td></tr>
                            <tr><th><?php echo $dto->__($lng,"Mes i any"); ?>:</th><td><?php echo $dto->__($lng,$dto->mostraNomMes($mes))." ".$any; ?></td></tr>
                            </tbody>                        
                    </table>
                        </section>
                    <table class="table table-striped table-bordered table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Dia"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Entrada"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Sortida"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Hores Treballades"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Hores Mèdiques"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Complementàries"); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            if($mes<10)$mes = "0".$mes;
                            for($i=1;$i<=31;$i++)
                            {
                                echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                $j = "";
                                if($i<10)$j = "0".$i;
                                else $j = $i;
                                $data = $any."-".$mes."-".$j;
                                $marc1 = $dto->getPrimerMarcatgePerIdDia($id, $data);
                                $hora1 = "";
                                foreach ($marc1 as $entrada) $hora1=substr($entrada["fitx"],11,5);
                                echo '<td>'.$hora1.'</td>';
                                $marc2 = $dto->getUltimMarcatgePerIdDia($id, $data);
                                $hora2 = "";
                                foreach ($marc2 as $sortida) $hora2=substr($sortida["fitx"],11,5);
                                echo '<td>'.$hora2.'</td>';
                                $hteor = $dto->seleccionaHoresTeoriquesPerIdDia($id, $data);                                                                
                                $hores = 0;
                                $horesmed = 0;                                
                                if($hteor>0) 
                                {
                                    $hdesc = $dto->seleccionaHoresPausaPerIdDia($id, $data);                                    
                                    $hores = $dto->calculaHoresTreballadesPerIdDia($id,$data);                                    
                                    if($hores>($hteor-0.5)) $hores-=$hdesc;
                                }                                
                                if($hores>0) {
                                    $hores-=$dto->calculaHoresActivitatsAdescomptarPerIdDia($id, $data);;
                                    $treballades += $hores;
                                    echo '<td>'.$hores.'</td>';
                                }                                    
                                else echo '<td>'.'</td>';
                                $horesmed = $dto->calculaHoresActivitatPerIdDiaIdtipus($id,$data,5);
                                if($horesmed>0) {
                                    $mediquesmes += $horesmed;
                                    echo '<td>'.$horesmed.'</td>';
                                }
                                else echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '</tr>';                                
                            }
                            ?>
                            <tr></tr><td><?php echo $dto->__($lng,"TOTAL"); ?><br><?php echo $dto->__($lng,"HORES"); ?></td><td></td><td></td><td><?php echo $treballades; ?></td><td><?php echo $mediquesmes; ?></td><td></td>
                        </tbody>
                    </table><br>
                    <section style="width:50%; float:left; height: 120px;"><?php echo $dto->__($lng,"Firma de l'empresa"); ?>:</section>
                    <section style="width:50%; float:right; height: 120px;"><?php echo $dto->__($lng,"Firma del treballador"); ?>:</section>                    
                    <br><br><br><p>A _________________________ , a _____ de _____________________ de _________</p>
                </div>
                <br><br>
                <div id="editor"></div>
                <form method="get" action="AdminMarcatgesEmpleat.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="any" value="<?php echo $any; ?>">
                    <input type="hidden" name="mes" value="<?php echo abs($mes); ?>">
                    <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                    <button type="submit" class="btn btn-default hidden-print" onclick="this.form.submit()">
                        <span class="glyphicon glyphicon-repeat" style="height: 15px; width: 15px"></span> <?php echo $dto->__($lng,"Tornar"); ?></button>                
                    
                </form>    
                    <br><br>
              </div>
          </center>
</body>
</html>
