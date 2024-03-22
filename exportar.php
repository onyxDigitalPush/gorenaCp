<?php
require 'vendor/autoload.php';  // Asegúrate de que la ruta sea correcta
include 'Conexion.php';  // Incluye la conexión a la base de datos

// Variables para el filtrado por fechas
$fechaInicial = $_GET['fecha_inicial'];
$fechaFinal = $_GET['fecha_final'];
$idSubempresa = $_GET['idsubemp'];

// Establecer la conexión a la base de datos (asegúrate de que esta parte sea igual que en tu página principal)
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta SQL para obtener los datos
$sql = "SELECT e.numafiliacio, e.nom, e.cognom1, e.cognom2,
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
        INNER JOIN empleat AS e ON m.id_emp = e.idempleat
        WHERE m.datahora >= '$fechaInicial' AND m.datahora <= '$fechaFinal'";

// Si se selecciona "Totes", no filtramos por subempresa
if ($idSubempresa != "Totes") {
    $sql .= " AND e.idsubempresa = '$idSubempresa'";
}

$sql .= ") AS t1
    LEFT JOIN empleat AS e ON t1.id_emp = e.idempleat
    GROUP BY t1.id_emp, DATE(t1.datahora) ORDER BY e.numafiliacio";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}


//FUNCION PARA CALCULAR HORAS TRABAJADAS
function calcularTotalHoras($entrada1, $salida1, $entrada2, $salida2, $entrada3, $salida3)
{
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

// Devolver el total de horas y minutos trabajados
    return $totalFormato;
}

function restaHoras($hora1, $hora2) {

    $data = [];

    $hora1 = strtotime($hora1);
    $hora2 = strtotime($hora2);

    $diferencia = $hora1 - $hora2;

    // Convierte la diferencia en formato HH:mm
    $diferenciaHoras = gmdate("H:i", abs($diferencia));

    if (isset($diferenciaHoras)) {
        if ($diferencia < 0) $data = ['horasAusente'  => $diferenciaHoras];
        if ($diferencia > 0) $data = ['horasExtras'  => $diferenciaHoras];
    }


    return $data;

}


// Crear una instancia de la hoja de cálculo
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de columna
$sheet->setCellValue('A1', 'Número de afiliación');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Fecha');
$sheet->setCellValue('D1', 'Entrada 1');
$sheet->setCellValue('E1', 'Salida 1');
$sheet->setCellValue('F1', 'Entrada 2');
$sheet->setCellValue('G1', 'Salida 2');
$sheet->setCellValue('H1', 'Entrada 3');
$sheet->setCellValue('I1', 'Salida 3');
$sheet->setCellValue('J1', 'Horas trabajadas');
$sheet->setCellValue('K1', 'Observaciones');
$rowNumber = 2;

while ($row = mysqli_fetch_assoc($result)) {

    $horas_trabajadas = calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'], $row['entrada3'], $row['salida3']);

   

    $sheet->setCellValueExplicit('A' . $rowNumber, $row['numafiliacio'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue('B' . $rowNumber, $row['nom'] . ' ' . $row['cognom1'] . ' ' . $row['cognom2']);
    $sheet->setCellValue('C' . $rowNumber, $row['fecha']);
    $sheet->setCellValue('D' . $rowNumber, $row['entrada1']);
    $sheet->setCellValue('E' . $rowNumber, $row['salida1']);
    $sheet->setCellValue('F' . $rowNumber, $row['entrada2']);
    $sheet->setCellValue('G' . $rowNumber, $row['salida2']);
    $sheet->setCellValue('H' . $rowNumber, $row['entrada3']);
    $sheet->setCellValue('I' . $rowNumber, $row['salida3']);
    $sheet->setCellValue('J' . $rowNumber, $horas_trabajadas);
    $sheet->setCellValue('K' . $rowNumber, $row['observacions']);

    $rowNumber++;
}

// Establecer estilos para los encabezados de columna
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'fill' => [
        'fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'EFEFEF',
        ],
    ],
];

$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

// Establecer estilos para el contenido de las celdas
$contentStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle('A2:K2' . ($rowNumber - 1))->applyFromArray($contentStyle);

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'K') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Guardar el archivo como Excel
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$filename = 'marcajes-diarios.xlsx';
$writer->save($filename);

// Descargar el archivo
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile($filename);

// Eliminar el archivo después de la descarga
unlink($filename);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
