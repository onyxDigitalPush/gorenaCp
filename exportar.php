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
$sql = "SELECT e.nom, e.cognom1, e.cognom2,
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
    GROUP BY t1.id_emp, DATE(t1.datahora)";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Crear una instancia de la hoja de cálculo
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Definir los encabezados de columna
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Fecha');
$sheet->setCellValue('C1', 'Entrada 1');
$sheet->setCellValue('D1', 'Salida 1');
$sheet->setCellValue('E1', 'Entrada 2');
$sheet->setCellValue('F1', 'Salida 2');
$sheet->setCellValue('G1', 'Entrada 3');
$sheet->setCellValue('H1', 'Salida 3');
$sheet->setCellValue('I1', 'Observaciones');

$rowNumber = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNumber, $row['nom'] . ' ' . $row['cognom1'] . ' ' . $row['cognom2']);
    $sheet->setCellValue('B' . $rowNumber, $row['fecha']);
    $sheet->setCellValue('C' . $rowNumber, $row['entrada1']);
    $sheet->setCellValue('D' . $rowNumber, $row['salida1']);
    $sheet->setCellValue('E' . $rowNumber, $row['entrada2']);
    $sheet->setCellValue('F' . $rowNumber, $row['salida2']);
    $sheet->setCellValue('G' . $rowNumber, $row['entrada3']);
    $sheet->setCellValue('H' . $rowNumber, $row['salida3']);
    $sheet->setCellValue('I' . $rowNumber, $row['observacions']);

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

$sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

// Establecer estilos para el contenido de las celdas
$contentStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle('A2:I' . ($rowNumber - 1))->applyFromArray($contentStyle);

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'I') as $column) {
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
