<!DOCTYPE html>
<html>
    <?php include '.\Pantalles\HeadGeneric.html'; ?> 
    <script type="text/javascript">
        function GeneraPDF()
        {
            var doc = new jsPDF('p', 'pt', 'letter');
            doc.fromHTML($('#contingut').html());
            $modal = $('#modInforme');
            $modal.modal('hide');
            doc.save('Informe.pdf');
        }
    </script>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $id = intval($_GET['id']);
    $any = intval($_GET['any']);
    $mes = intval($_GET['mes']);
    $treballades = 0;
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">Generar Informe<button type="button" class="close" data-dismiss="modal">&times;</button></div>
                <div id="contingut" class="modal-body">
                    <h4>Resum mensual del registre de jornada</h4><br>
                    <table class="table table-striped table-bordered table-condensed" style="text-align: left">
                        <tbody>
                        <tr><th>Empresa:</th><td>Fundació Acollida i Esperança</td><th>Treballador:</th><td><?php echo $dto->mostraNomEmpPerId($id); ?></td></tr>
                        <tr><th>C.I.F./N.I.F.:</th><td></td><th>N.I.F.:</th><td></td></tr>
                        <tr><th>Centre de Treball:</th><td></td><th>Nº Afiliació:</th><td></td></tr>
                        <tr><th>C.C.C.:</th><td></td><th>Mes i any:</th><td><?php echo $mes."/".$any; ?></td></tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center">Dia</th>
                        <th style="text-align: center">Entrada</th>
                        <th style="text-align: center">Sortida</th>
                        <th style="text-align: center">Hores</th>
                        <th style="text-align: center">Complementàries</th>
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
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id, $data);
                                if($hores>0.0) echo '<td>'.$hores.'</td>';
                                else echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '</tr>';
                                $treballades += $hores;
                            }
                            ?>
                            <tr></tr><td>TOTAL<br>HORES</td><td></td><td></td><td><?php echo $treballades; ?></td><td></td>
                        </tbody>
                    </table>
                    <section style="width:50%; float:left; height: 120px;">Firma de l'empresa:</section>
                    <section style="width:50%; float:right; height: 120px;">Firma del treballador:</section>
                    <p>A _______________________ a ____ de ____________________ de _________</p>
                </div><div id="editor"></div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tornar</button>
                    <button id="generar" class="btn btn-primary" onclick="GeneraPDF();">Generar PDF</button>
                    
                    <br><br>
              </div>
            </div>
            </center>
    <div class="modal fade" id="modInformeMes" role="dialog">
           <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">Generar Informe<button type="button" class="close" data-dismiss="modal">&times;</button></div>
                <div id="contingut" class="modal-body">
                    <h4>Resum mensual del registre de jornada</h4><br>
                    <table class="table table-striped table-bordered table-condensed" style="text-align: left">
                        <tbody>
                        <tr><th>Empresa:</th><td>Fundació Acollida i Esperança</td><th>Treballador:</th><td><?php echo $dto->mostraNomEmpPerId($id); ?></td></tr>
                        <tr><th>C.I.F./N.I.F.:</th><td></td><th>N.I.F.:</th><td></td></tr>
                        <tr><th>Centre de Treball:</th><td></td><th>Nº Afiliació:</th><td></td></tr>
                        <tr><th>C.C.C.:</th><td></td><th>Mes i any:</th><td><?php echo $mes."/".$any; ?></td></tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center">Dia</th>
                        <th style="text-align: center">Entrada</th>
                        <th style="text-align: center">Sortida</th>
                        <th style="text-align: center">Hores</th>
                        <th style="text-align: center">Complementàries</th>
                        </thead>
                        <tbody>
                            <?php
                            $data = "";
                            $treballades = 0;
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
                                $hores = $dto->calculaHoresTreballadesPerIdDia($id, $data)-$dto->seleccionaHoresPausaPerIdDia($id, $data);
                                if($hores>0.0) echo '<td>'.$hores.'</td>';
                                else echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '</tr>';
                                $treballades += $hores;
                            }
                            ?>
                            <tr></tr><td>TOTAL<br>HORES</td><td></td><td></td><td><?php echo $treballades; ?></td><td></td>
                        </tbody>
                    </table>
                    <section style="width:50%; float:left; height: 120px;">Firma de l'empresa:</section>
                    <section style="width:50%; float:right; height: 120px;">Firma del treballador:</section>
                    <p>A _______________________ a ____ de ____________________ de _________</p>
                </div><div id="editor"></div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tornar</button>
                    <button id="generar" class="btn btn-primary" onclick="GeneraPDF();">Generar PDF</button>
                    
                    <br><br>
              </div>
            </div>
            </center>
    </div>
</html>