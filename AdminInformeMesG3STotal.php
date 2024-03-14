<!DOCTYPE html>
<html>
<head>
    <?php include './Pantalles/HeadGeneric.html';?>
    <script type="text/javascript">
        function GeneraPDF() {
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
include 'Conexion.php';
$idemp = $_SESSION["idempresa"];
$idempresa = $idemp;
$lng = 0;
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}
$dto->navResolver();
$any = intval($_GET['any']);
$mes = intval($_GET['mes']);
	$dpt = intval($_GET['dpt']);
$taulaemp = 'empresa';
$idsubemp = $dto->getCampPerIdCampTaula("empleat", $id, "idsubempresa");
if (!empty($idsubemp)) {
    $idemp = $idsubemp;
    $taulaemp = 'subempresa';
}
$nomemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "nom");
$cifemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "cif");
$ctremp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "centre_treball");
$cccemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "ccc");
$pobemp = $dto->getCampPerIdCampTaula($taulaemp, $idemp, "poblacio");
$idtreballadorsemp = $dto->getTreballadorsIdEmpresaMarcatge($any, $mes,$dpt);
 $zmes = $mes;
if($mes<10) $zmes = "0".$mes;
$datafi = date('Y-m-d',strtotime($any."-".$zmes."-01"));
while(date('m',strtotime($datafi))==$zmes) {$datafi = date('Y-m-d',strtotime($datafi." + 1 days"));}
$diafi = date('d',strtotime($datafi." - 1 days"));


?>

<center>
    <div class="row">
        <div class="col-lg-2">
            <form method="get" action="AdminPersones.php">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo abs($mes); ?>">
                <button type="submit" class="btn btn-default hidden-print" onclick="this.form.submit()">
                    <span class="glyphicon glyphicon-repeat" style="height: 15px; width: 15px"></span> <?php echo $dto->__($lng, "Tornar"); ?></button>
            </form>
            <button class="btn btn-primary" onclick="printElem('print');"><span class="glyphicon glyphicon-print"></span> <?php echo $dto->__($lng, "Imprimir"); ?></button>
            <br><br>
        </div>
        <div class="col-lg-8" id="print" style="border: solid 1px; border-radius: 3px;">
            <?php
foreach ($idtreballadorsemp as $idtreballador) {
    $id = $idtreballador['id_emp'];
// Inicializa los arrays para las entradas y salidas
    $entradas = array();
    $salidas = array();

// Inicializa el total de horas trabajadas
    $totalHoras = 0.0;

// Itera sobre los días del mes
    for ($i = 1; $i <= 31; $i++) {
        $fechaActual = date("Y-m-d", strtotime("$any-$mes-$i"));

        // Realiza la consulta para obtener las horas de entrada y salida para el empleado y la fecha actual
        $sqlMarcajes = "SELECT
        GROUP_CONCAT(IF(entsort = 0, DATE_FORMAT(datahora, '%H:%i'), NULL) ORDER BY datahora ASC) AS entradas,
        GROUP_CONCAT(IF(entsort = 1, DATE_FORMAT(datahora, '%H:%i'), NULL) ORDER BY datahora ASC) AS salidas
        FROM marcatges
        WHERE id_emp = $id AND DATE(datahora) = '$fechaActual'";

        $resultMarcajes = mysqli_query($conn, $sqlMarcajes);
        $rowMarcaje = mysqli_fetch_assoc($resultMarcajes);

        // Obtiene las horas de entrada y salida para la fecha actual y las almacena en arrays
        $entradas[$i] = explode(',', $rowMarcaje['entradas']);
        $salidas[$i] = explode(',', $rowMarcaje['salidas']);
		$observacions = $idtreballador['observacions'];

        if (!empty($entradas[$i]) && !empty($salidas[$i])) {
            $entradaHora = strtotime($entradas[$i][0]);
            $salidaHora = strtotime($salidas[$i][count($salidas[$i]) - 1]);
            if ($entradaHora !== false && $salidaHora !== false) {
                $horasTrabajadas = round(($salidaHora - $entradaHora) / 3600, 2);
            } else {
                // Si hay un error al calcular las horas, establecer $horasTrabajadas en 0.
                $horasTrabajadas = 0;
            }
        } else {
            // Si $entradaHora o $salidaHora está vacío, establecer $horasTrabajadas en 0.
            $horasTrabajadas = 0;
        }
        $totalHoras += $horasTrabajadas;
        
        
    }

// Al final del bucle, $totalHoras contendrá el total de horas trabajadas para el mes

    ?>
                <div>
                    <div style="margin-top:30px" id="contingut">
                        <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng, "Llistat Resum mensual del registre de jornada (complet)"); ?></h3>
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
                                        <td style="border: solid 1px">	<?php echo $pobemp; ?> </td>
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
                        <table border="1" class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                            <thead>
                                <tr style="background-color: white; color: black">
                                    <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "DIA"); ?></th>
                                    <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORA ENTRADA"); ?></th>
                                    <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORA SALIDA"); ?></th>
                                    <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORAS TRABAJADAS"); ?></th>
									 <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "OBSERVACIONES"); ?></th>


                                </tr>
                            </thead>
                            <tbody>
                            <?php
// Mostrar aquí las horas de entrada y salida para este empleado
    for ($i = 1; $i <= 31; $i++) {
        // Calcula la fecha actual en formato 'Y-m-d'
        $fechaActual = date("Y-m-d", strtotime("$any-$mes-$i"));

        // Obtiene las horas de entrada y salida para la fecha actual
        $entradasDia = $entradas[$i];
        $salidasDia = $salidas[$i];

        // Imprime una fila para cada día del mes
        echo '<tr>';
        echo '<td>' . $i . '</td>';

        // Muestra la primera entrada si existe
        echo '<td>';
        if (!empty($entradasDia)) {
            echo $entradasDia[0]; // Primera hora de entrada
        }
        echo '</td>';

        // Muestra la última salida si existe
        echo '<td>';
        if (!empty($salidasDia)) {
            $lastIndex = count($salidasDia) - 1;
            echo $salidasDia[$lastIndex]; // Última hora de salida
        }
        echo '</td>';

        // Calcula y muestra las horas trabajadas si hay entradas y salidas válidas
        echo '<td>';
if (!empty($entradasDia) && !empty($salidasDia)) {
    $entradaHora = strtotime($entradasDia[0]);
    $salidaHora = strtotime($salidasDia[$lastIndex]);
    if ($entradaHora !== false && $salidaHora !== false) {
        $horasTrabajadas = round(($salidaHora - $entradaHora) / 3600, 2); // Calcula las horas trabajadas
        //CONVERTIMOS DE DECIMAL A FORMATO HORA EL TOTAL DE HORAS TRABAJADAS
        $hora_trabajadas_aux = floor($horasTrabajadas);
        $minutos_trabajadas_aux = ($horasTrabajadas - $hora_trabajadas_aux) * 60;
        $horas_trabajadas_formato = sprintf('%02d:%02d', $hora_trabajadas_aux, $minutos_trabajadas_aux);

    } else {
        // Si hay un error al calcular las horas, establecer $horasTrabajadas en 0.
        $horas_trabajadas_formato = "";
    }
} else {
    // Si falta la entrada o la salida, establecer $horasTrabajadas en 0.
    $horas_trabajadas_formato = 0;
}


echo $horas_trabajadas_formato;
echo '</td>';

       //TRAIGO OBSERVACIONES TIPOEXCEP
			 $data1 = "";
                                        $diaActual = $i;
                                            $j = "";
                                            if($i<10)$j = "0".$i;
                                            else $j = $i;
                                            $data1 = $any."-".$mes."-".$j;
                                           
                                            if($diaActual == $i){
                                            $tipusexcep = "";
                                            $rse = $dto->esExcepcioPerIdDia($id, $data1);
                                            //print_r($rse);
                                            
                                            if(!empty($rse)) {
                                                foreach($rse as $e){$tipusexcep = $dto->__($lng,$dto->getCampPerIdCampTaula("tipusexcep",$e["idtipusexcep"],"nom"));}                                                
                                                echo '<td>'.$tipusexcep.'</td>';                                                
                                            }  else {
												 if($entradasDia[0]== "" && $observacions == "Treball normal"){ echo '<td>'."".'</td>';}
												else {echo '<td>'.$observacions.'</td>';}
														

                                            }
											}               
						
        echo '</tr>';
    }
    ?>
<td></td>
                            <?php
                            $totalHora_aux = floor($totalHoras);
                            $totalMinutos_aux = ($totalHoras - $totalHora_aux) * 60;
                            $totalHoras_formato = sprintf('%02d:%02d', $totalHora_aux, $totalMinutos_aux);

                            ?>
                            <td> TOTAL HORAS TRABAJAS</td>
                            <td></td><td><?php echo $totalHoras_formato; ?></td>
                            </tbody>
                        </table>
                        <br>

                        <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng, "Firma de l'empresa"); ?>:</section>
                        <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng, "Firma del treballador"); ?>:</section>
                        <br><p style="font-size: 18px;"><?php echo $dto->__($lng, "A "); ?> <?php echo $pobemp; ?>, <?php echo $dto->__($lng, "a"); ?> <?php echo $diafi; ?> <?php echo $dto->__($lng, "de"); ?> <?php echo $dto->__($lng, $dto->mostraNomMes($mes)); ?> <?php echo $dto->__($lng, "de"); ?> <?php echo $any; ?></p>
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
                <div style="page-break-before: always;"> </div>
                <?php
}
?>
            <br><br>
        </div>
    </div>
</center>

</body>
</html>
