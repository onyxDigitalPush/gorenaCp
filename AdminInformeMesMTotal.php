

<!DOCTYPE html>
<html>

<head>
    <?php include './Pantalles/HeadGeneric.html'; ?>
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
if (isset($_SESSION["ididioma"]))
    $lng = $_SESSION["ididioma"];
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
$diafi = date('d', strtotime($datafi . " - 1 days"));
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
            if (isset($_GET['any']) && isset($_GET['mes'])) {
                $any = mysqli_real_escape_string($conn, $_GET['any']);
                $mes = mysqli_real_escape_string($conn, $_GET['mes']);


                // Construye la consulta SQL con los valores del formulario
                $sql = "SELECT e.idempleat, e.nom, e.cognom1, e.cognom2,
    DATE(t1.datahora) AS fecha,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 1 THEN t1.datahora END)) AS entrada1,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 1 THEN t1.datahora END)) AS salida1,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 2 THEN t1.datahora END)) AS entrada2,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 2 THEN t1.datahora END)) AS salida2,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 3 THEN t1.datahora END)) AS entrada3,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 3 THEN t1.datahora END)) AS salida3,
    GROUP_CONCAT(DISTINCT t1.observacions SEPARATOR ' / ') AS observacions
FROM (
    SELECT m.id_emp,
    m.datahora,
    m.entsort,
    m.observacions,
    ROW_NUMBER() OVER (PARTITION BY m.id_emp, DATE(m.datahora), m.entsort ORDER BY m.datahora) AS row_number
    FROM marcatges AS m
    WHERE YEAR(m.datahora) = '$any' AND MONTH(m.datahora) = '$mes' 
) AS t1
LEFT JOIN empleat AS e ON t1.id_emp = e.idempleat
GROUP BY t1.id_emp, DATE(t1.datahora)";



                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Error en la consulta: " . mysqli_error($conn));
                }
                mysqli_close($conn);

            }



            function calcularTotalHoras($entrada1, $salida1, $entrada2, $salida2, $entrada3, $salida3,$id,$fecha) {
                // Inicializar el total de segundos en 0
                $totalSegundos = 0;

                // Calcular la diferencia en segundos para cada entrada con salida correspondiente
                if ($entrada1 && $salida1) {
                    $entrada1_segundos = strtotime($entrada1);
                    $salida1_segundos = strtotime($salida1);
                    $totalSegundos += $salida1_segundos - $entrada1_segundos;
                }

                if ($entrada2 && $salida2) {
                    $entrada2_segundos = strtotime($entrada2);
                    $salida2_segundos = strtotime($salida2);
                    $totalSegundos += $salida2_segundos - $entrada2_segundos;
                }

                if ($entrada3 && $salida3) {
                    $entrada3_segundos = strtotime($entrada3);
                    $salida3_segundos = strtotime($salida3);
                    $totalSegundos += $salida3_segundos - $entrada3_segundos;
                }

                // Calcular el total de horas y minutos
                $totalHoras = floor($totalSegundos / 3600);
                $totalMinutos = floor(($totalSegundos % 3600) / 60);

                // Formatear el total de horas y minutos
                $totalFormato = sprintf("%02d:%02d", $totalHoras, $totalMinutos);
                //print_r($totalFormato);


                /* The above code is checking if the variable  is empty and if it is, it will print " */


                if (isset($totalHoras, $totalMinutos)) {
                    $data = [
                        'horas' => $totalHoras,
                        'minutos' => $totalMinutos,
                        'totalFormato' => $totalFormato
                    ];

                      //resto las horas que se deben restar por turno
                      $dto = new AdminApiImpl();
                      $RestaHorasTurnos = $dto->seleccionaHoresPausaPerIdDia($id, $fecha);
                    
                  // Convertir el tiempo en formato "horas:minutos" a minutos totales
                 list($horas, $minutos) = explode(':', $data['totalFormato']);
                 $totalMinutos = ($horas * 60) + $minutos;    
                
            // Convertir la cadena de horas a un número de punto flotante (float)
            $horasFloat = floatval($RestaHorasTurnos);

                // Restar los minutos equivalentes al turno
                $minutosRestados = $horasFloat * 60;
                $totalMinutos -= $minutosRestados;

                // Convertir el total de minutos nuevamente a formato "horas:minutos"
            $nuevasHoras = floor($totalMinutos / 60);
            $nuevosMinutos = $totalMinutos % 60;
            $nuevoTotalFormato = sprintf("%02d:%02d", $nuevasHoras, $nuevosMinutos);


           //asigno el valor de la resta 

            $data['totalFormato']= $nuevoTotalFormato;


                    return $data;
                }



            }

            function restaHoras($hora1, $hora2) {
                $hora1 = strtotime($hora1);
                $hora2 = strtotime($hora2);

                $diferencia = $hora1 - $hora2;

                // Convierte la diferencia en formato HH:mm
                $diferenciaHoras = gmdate("H:i", abs($diferencia));

                if ($diferencia < 0) {
                    // Si la diferencia es negativa, coloca un signo negativo en el resultado
                    $diferenciaHoras = '-' . $diferenciaHoras;
                }

                if (isset($diferenciaHoras)) {
                    $data = [
                        'horasDiferencia' => floor(abs($diferencia) / 3600),
                        'minutosDiferencia' => floor((abs($diferencia) % 3600) / 60),
                        'totalFormatoDiferencia' => $diferenciaHoras
                    ];
                    return $data;
                }
            }

            ?>






            <?php
            foreach ($idtreballadorsemp as $key => $idtreballador) {
                $idtreballadorsemp[$key]['rows'] = [];
                foreach ($result as $row) {
                    if ($idtreballador['id_emp'] == $row['idempleat']) {
                        array_push($idtreballadorsemp[$key]['rows'], $row);
                    }
                }
            }


            ?>
            <?php foreach ($idtreballadorsemp as $key => $idtreballador) : ?>
                <?php
                $id = $idtreballador['id_emp'];
                $teorique_hours = $dto->seeHourTeorique($id, $any, $mes);
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
                                        <th style="border: solid 1px"><?php echo $dto->__($lng, "Poblacio"); ?>:</th>
                                        <td style="border: solid 1px"><?php echo $pobemp; ?></td>
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
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "ENTRADA 1"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "SALIDA 1"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "ENTRADA 2"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "SALIDA 2"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "ENTRADA 3"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "SALIDA 3"); ?></th>
                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORES ORDINÀRIES"); ?></th>
                                <th colspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "HORES COMPLEMENTÀRIES"); ?></th>

                                <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "OBSERVACIONS"); ?></th>
                            </tr>


                            <tr style="background-color: white; color: black">

                                <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "PACTADES"); ?></th>
                                <th style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng, "VOLUNTÀRIES"); ?></th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            // Obtener el primer día del mes y el último día del mes
                            $primerDia = date("Y-m-01", strtotime("$any-$mes-01"));
                            $ultimoDia = date("Y-m-t", strtotime("$any-$mes-01"));

                            // Convertir los valores a objetos DateTime
                            $fechaInicio = new DateTime($primerDia);
                            $fechaFin = new DateTime($ultimoDia);


                            $totalHoras_final = [];
                            $totalMinutos_final = [];


                            $totalHoras_diferencia =[];
                            $totalMinutos_diferencia =[];


                            $diferenciaHoras_format = [];

                            // Bucle para crear filas para cada día del mes
                            while ($fechaInicio <= $fechaFin) {
                                $diaActual = $fechaInicio->format("d");

                                // Inicializa variables para los registros de entrada y salida
                                $entrada1 = "";
                                $salida1 = "";
                                $entrada2 = "";
                                $salida2 = "";
                                $entrada3 = "";
                                $salida3 = "";
                                $totalHoras = "";
                                $horesteoriques = "";
                                $diferenciaHoras = "";
                                $observacions = "";




                                $horasRegistradas = false;
                                $horasDiferencia = false;

                                //HORAS TEORICAS

                                $fechaActual = $fechaInicio->format('Y-m-d');
                                foreach ($teorique_hours as $teorique_hour)
                                    if ($fechaActual == $teorique_hour['data'])
                                        $horesteoriques = $dto->decimalsToTimeFormat($teorique_hour['horestreball']);


                                // Recorre los registros para ver si hay datos para este día
                                foreach ($idtreballador['rows'] as $row) {
                                    // Verificar si la fecha del registro coincide con el día actual
                                    $fechaRegistro = date("d", strtotime($row['fecha']));
                                    if ($diaActual == $fechaRegistro) {
                                        // Verificar las salidas sin llenar y aplicar el estilo en rojo
                                        $salida1 = !$row['salida1'] && $row['entrada1'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida1'];
                                        $salida2 = !$row['salida2'] && $row['entrada2'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida2'];
                                        $salida3 = !$row['salida3'] && $row['entrada3'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida3'];

                                        $entrada1 = !$row['entrada1'] && $row['salida1'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada1'];
                                        $entrada2 = !$row['entrada2'] && $row['salida2'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada2'];
                                        $entrada3 = !$row['entrada3'] && $row['salida3'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada3'];

                                        $fechaRegistroData = $row['fecha'];

                                        // Puedes usar las variables $row['entrada1'], $row['salida1'], etc., para acceder a los datos del registro.
                                        $data_time= calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'], $row['entrada3'], $row['salida3'],$id,$fechaRegistroData);


                                        $totalHoras_test_2 = intval($data_time['horas']);
                                        $totalMinutos_test_2 =  intval($data_time['minutos']);


                                        $observacions = $row['observacions'];

                                        $diferenciaHoras = restaHoras($data_time['totalFormato'], $horesteoriques);

                                        $totalHoras_diferencia_2 = intval($diferenciaHoras['horasDiferencia']);
                                        $totalMinutos_diferencia_2 =  intval($diferenciaHoras['minutosDiferencia']);



                                        



                                        if ($row['entrada1'] && $row['salida1'] || $row['entrada2'] && $row['salida2'] || $row['entrada3'] && $row['salida3']) {
                                            $horasRegistradas = true;
                                            $horasDiferencia = true;

                                        }
                                    }

                                }

                                if(!empty($totalHoras_test_2)) $totalHoras_final[] = $totalHoras_test_2;
                                if(!empty($totalMinutos_test_2)) $totalMinutos_final[] = $totalMinutos_test_2;

                                if(!empty($totalHoras_diferencia_2)) $totalHoras_diferencia[] = $totalHoras_diferencia_2;
                                if(!empty($totalMinutos_diferencia_2)) $totalMinutos_diferencia[] = $totalMinutos_diferencia_2;


                                //if(!empty($totalHoras_test_2)) array_sum($totalHoras_test_2);
                                //if(!empty($totalMinutos_test_2)) array_sum($totalMinutos_test_2);





                                $totalHoras_test_2 = [];
                                $totalMinutos_test_2 = [];




                                $totalHoras_diferencia_2 = [];
                                $totalMinutos_diferencia_2 = [];







                                // Mostrar los datos en los <td>
                                echo "<tr>";
                                echo "<td>$diaActual</td>";
                                echo "<td>" . $entrada1 . "</td>";
                                echo "<td>" . $salida1 . "</td>";
                                echo "<td>" . $entrada2 . "</td>";
                                echo "<td>" . $salida2 . "</td>";
                                echo "<td>" . $entrada3 . "</td>";
                                echo "<td>" . $salida3 . "</td>";
                                echo "<td>" . ($horasRegistradas ? $data_time['totalFormato'] : "0:00") . "</td>";
                                echo "<td>" . $horesteoriques . "</td>";

                                echo "<td>" . ($horasDiferencia ? $diferenciaHoras['totalFormatoDiferencia'] : "0:00") . "</td>";

                                echo "<td>" . $observacions . "</td>";
                                echo "</tr>";


                                if ($horasDiferencia) $diferenciaHoras_format[] = $diferenciaHoras['totalFormatoDiferencia'];

                                // Avanzar al siguiente día
                                $fechaInicio->modify("+1 day");
                            }



                            /* *** PORCION SEBAS INICIO */

                            $formato_valido = "/^-?\d{2}:\d{2}$/";
                            $totales_a_restar = [];
                            foreach ($diferenciaHoras_format as $item)
                            {
                                if (preg_match($formato_valido, $item)) $totales_a_restar[] = $item;
                            }

                            $horas_minutos_diferencia = [];
                            foreach ($totales_a_restar as $total_restar)
                            {
                                $partes = explode(':', $total_restar);
                                $horas = (int)$partes[0];
                                $minutos = (int)$partes[1];
                                $minutos = (int)$partes[1];
                                if (substr($partes[0], 0, 1) === "-") $minutos = -1 * (int)$partes[1];
                                $horas_minutos_diferencia[] = ['horas' => $horas, 'minutos' => $minutos];
                            }

                            $horas_totales_diferencia = 0;
                            $minutos_totales_diferencia = 0;

                            foreach ($horas_minutos_diferencia as $tiempo) {
                                $horas_totales_diferencia += $tiempo['horas'];
                                $minutos_totales_diferencia += $tiempo['minutos'];
                            }

                            // Asegurarse de que los minutos sean positivos
                            if ($minutos_totales_diferencia < 0) {
                                $horas_totales_diferencia--;  // Restar una hora
                                $minutos_totales_diferencia += 60;  // Convertir los minutos negativos en positivos
                            }

                            // Asegurarse de que los minutos no superen 59
                            $horas_totales_diferencia += floor($minutos_totales_diferencia / 60);
                            $minutos_totales_diferencia %= 60;

                            // Formatear la diferencia en un formato hh:mm
                            $resultado_totales_diferencia = sprintf("%d:%02d", $horas_totales_diferencia, $minutos_totales_diferencia);

                            /* *** PORCION SEBAS FINAL ***/


                            if(!empty($totalHoras_final)) $horas = array_sum($totalHoras_final);
                            if(!empty($totalMinutos_final)) $minutos = array_sum($totalMinutos_final);


                            if(!empty($totalHoras_diferencia)) $horasDiferencia = array_sum($totalHoras_diferencia);
                            if(!empty($totalMinutos_diferencia)) $minutosDiferencia = array_sum($totalMinutos_diferencia);







                            // Mostrar los totales al final de la tabla
                            echo "<tr>";
                            echo "<td colspan='7'><strong>Total Horas:</strong></td>";

                            // Supongamos que tienes los minutos y las horas en dos variables separadas, $horas y $minutos.



                            // Ajusta los minutos si superan los 60 y suma a las horas
                            if ($minutos >= 60) {
                                $horas += floor($minutos / 60); // Suma las horas completas
                                $minutos = $minutos % 60; // Mantén los minutos restantes
                            }

                            // Formatea el resultado en "HH:MM"
                            $resultado = sprintf("%02d:%02d", $horas, $minutos);

                            echo "<td><strong>" . $resultado . "</strong></td>";

                            echo "<td></td>";

                            // Supongamos que tienes los minutos y las horas en dos variables separadas, $horas y $minutos.


                            // Inicializa las variables en 0
                            $horasDiferencia = 0;
                            $minutosDiferencia = 0;


                            foreach ($totalHoras_diferencia as $horas) {
                                $horasDiferencia += $horas;
                            }

                            foreach ($totalMinutos_diferencia as $minutos) {
                                $minutosDiferencia += $minutos;
                            }

                            // Ajusta los minutos si superan los 60 y suma/resta a las horas según sea necesario
                            if ($minutosDiferencia >= 60) {
                                $horasDiferencia += floor($minutosDiferencia / 60); // Suma las horas completas
                                $minutosDiferencia = $minutosDiferencia % 60; // Mantén los minutos restantes
                            } elseif ($minutosDiferencia <= -60) {
                                $horasDiferencia -= floor(abs($minutosDiferencia) / 60); // Resta las horas completas (negativo)
                                $minutosDiferencia = abs($minutosDiferencia) % 60; // Mantén los minutos restantes (positivo)
                            }

                            if ($horasDiferencia < 0) {
                                $resultadoDiferencia = "-" . sprintf("%02d:%02d", abs($horasDiferencia), abs($minutosDiferencia));
                            } else {
                                $resultadoDiferencia = sprintf("%02d:%02d", $horasDiferencia, $minutosDiferencia);
                            }

                            echo "<td><strong>" . $resultado_totales_diferencia . "</strong></td>";



                            echo "<td></td>";
                            echo "<td></td>";

                            echo "<td></td>";
                            echo "</tr>";
                            ?>
                            </tbody>




                        </table>
                        <br>
                        <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng, "Firma de l'empresa"); ?>:</section>
                        <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng, "Firma del treballador"); ?>:</section>
                        <br>
                        <p style="font-size: 18px;"><?php echo $dto->__($lng, "A "); ?> <?php echo $pobemp; ?>, <?php echo $dto->__($lng, "a"); ?> <?php echo $diafi; ?> <?php echo $dto->__($lng, "de"); ?> <?php echo $dto->__($lng, $dto->mostraNomMes($mes)); ?> <?php echo $dto->__($lng, "de"); ?> <?php echo $any; ?></p>
                    </div>
                    <br>
                    <br>
                    <center>
                        <p style="font-size: 9px; text-align: left">
                            Registro realizado en cumplimiento de la letra h) del artículo 1 del R.D.-Ley 16/2013, de 20 de diciembre por el que se modifica el artículo 12.5 del E.T., por el que se establece que "La<br>
                            jornada de los trabajadores a tiempo parcial se registrará día a día y se totalizará mensualmente, entregando copia al trabajador, junto con el recibo de salarios, del resumen de todas las<br>
                            horas realizadas en cada mes, tanto de las ordinarias como de las complementarias en sus distintas modalidades.
                            El empresario deberá conservar los resúmenes mensuales de los registros de jornada durante un período mínimo de cuatro años. El incumplimiento empresarial de estas obligaciones de<br>
                            registro tendrá por consecuencia jurídica la de que el contrato se presuma celebrado a jornada completa, salvo prueba en contrario que acredite el carácter parcial de los servicios.
                        </p>
                    </center>
                    <div id="editor"></div>
                </div>
                <div style="page-break-before: always;"> </div>
            <?php endforeach; ?>
            <br><br>
        </div>
    </div>
</center>

</body>

</html>