<?php
require 'autoloader.php';
require 'Conexion.php';
require 'vendor/autoload.php'; // Cargar la librería de PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$fechaInicial = "";
$fechaFinal = "";

// Verificar si se recibieron los valores de fecha
if (isset($_POST['fecha_inicial']) && isset($_POST['fecha_final'])) {
    $fechaInicial = $_POST['fecha_inicial'];
    $fechaFinal = $_POST['fecha_final'];

    // Ajustar la fecha final para incluir todo el día
    $fechaFinal = date('Y-m-d', strtotime($fechaFinal . ' +1 day'));
}

// Calcular el total de horas trabajadas
function calcularTotalHoras($entrada1, $salida1, $entrada2, $salida2, $entrada3, $salida3) {
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

    // Calcular el total de horas en formato decimal
    $totalHorasDecimal = round($totalSegundos / 3600, 1);

    return $totalHorasDecimal;
}

function calcularHorasExtras($totalHorasTrabajadas, $horasTeoricas) {
    // Calcular las horas extras
    $horasExtras = $totalHorasTrabajadas - $horasTeoricas;

    // Redondear las horas extras a un decimal
    $horasExtrasDecimal = round($horasExtras, 1);

    return $horasExtrasDecimal;
}

$sql = "SELECT 
    CONCAT(e.nom, ' ', e.cognom1, ' ', e.cognom2) AS nombre_completo,
    e.idsubempresa,
    se.nom AS nombre_subempresa,
    DATE(t1.datahora) AS fecha,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 1 THEN t1.datahora END)) AS entrada1,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 1 THEN t1.datahora END)) AS salida1,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 2 THEN t1.datahora END)) AS entrada2,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 2 THEN t1.datahora END)) AS salida2,
    TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 3 THEN t1.datahora END)) AS entrada3,
    TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 3 THEN t1.datahora END)) AS salida3,
    GROUP_CONCAT(DISTINCT t1.observacions SEPARATOR ' / ') AS observacions,
    tt.horestreball AS horas_teoricas,
    d.nom AS nombre_departamento
FROM (
    SELECT m.id_emp,
           m.datahora,
           m.entsort,
           m.observacions,
           ROW_NUMBER() OVER (PARTITION BY m.id_emp, DATE(m.datahora), m.entsort ORDER BY m.datahora) AS row_number
    FROM marcatges AS m
    WHERE m.datahora >= '$fechaInicial' AND m.datahora <= '$fechaFinal'
) AS t1
LEFT JOIN empleat AS e ON t1.id_emp = e.idempleat
LEFT JOIN rotacio AS r ON e.idempleat = r.idempleat
LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
LEFT JOIN subempresa AS se ON e.idsubempresa = se.idsubempresa
LEFT JOIN pertany AS p ON e.idempleat = p.id_emp
LEFT JOIN departament AS d ON p.id_dep = d.iddepartament
GROUP BY t1.id_emp, DATE(t1.datahora)";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('NÓMINAS DETALLE');

    // Agregar encabezados
    $sheet->setCellValue('A1', 'EMPRESA');
    $sheet->setCellValue('B1', 'DEPARTAMENTO');
    $sheet->setCellValue('C1', 'NOMBRE EMPLEADO');
    $sheet->setCellValue('D1', 'FECHA');
    $sheet->setCellValue('E1', 'TOTAL HORAS');
    $sheet->setCellValue('F1', 'TOTAL EXTRAS');
    $sheet->setCellValue('G1', 'BAJA AT');
    $sheet->setCellValue('H1', 'BAJA IT');
    $sheet->setCellValue('I1', 'UBICACIÓN');

    // Fijar la fila 1
    $sheet->freezePane('A2');

    // Establecer estilos para los encabezados
    // Establecer el color de fondo para las celdas de encabezado
    // Aplicar color de fondo a las celdas A1 a D1
    $sheet->getStyle('A1:D1')->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'ffd880', // Cambia 'CCE5FF' al color deseado en formato RGB
            ],
        ],
    ]);

    // Aplicar color de fondo a las celdas E1 y F1
    $sheet->getStyle('E1:F1')->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'ffc134', // Cambia 'FFCCCB' al color deseado en formato RGB
            ],
        ],
    ]);

    // Aplicar color de fondo a las celdas G1 y H1
    $sheet->getStyle('G1:H1')->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '6fbc73', // Cambia 'FFCCCB' al color deseado en formato RGB
            ],
        ],
    ]);

    // Aplicar formato en negrita a las celdas con títulos
    $boldFontStyle = [
        'bold' => true,
    ];
    $sheet->getStyle('A1:I1')->applyFromArray(['font' => $boldFontStyle]);

    // Establecer estilos para los encabezados
    $styleHeader = [
        'font' => [
            'bold' => true,
            'size' => 12,
            'color' => ['rgb' => '333333'], // Color de texto (negro)
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F2F2F2'], // Color de fondo (gris claro)
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];

    // Aplicar el estilo a las celdas de encabezado
    $sheet->getStyle('A1:G1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

    // Ajustar el ancho de las columnas
    $sheet->getColumnDimension('A')->setWidth(20); // Ancho de la columna A
    $sheet->getColumnDimension('B')->setWidth(20); // Ancho de la columna B
    $sheet->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
    $sheet->getColumnDimension('D')->setWidth(12); // Ancho de la columna D
    $sheet->getColumnDimension('E')->setWidth(20); // Ancho de la columna E
    $sheet->getColumnDimension('F')->setWidth(20); // Ancho de la columna F
    $sheet->getColumnDimension('G')->setWidth(10); // Ancho de la columna G
    $sheet->getColumnDimension('H')->setWidth(10); // Ancho de la columna H
    $sheet->getColumnDimension('I')->setWidth(15); // Ancho de la columna I

    $sheet->getRowDimension(1)->setRowHeight(30);

    // Llenar la hoja con los datos obtenidos
    $row = 2;
    $fechaActual = null;
    $encontradoIdTipus5 = false; // Variable para rastrear si se ha encontrado un registro con id_tipus igual a 5

    while ($row_data = mysqli_fetch_assoc($result)) {
        $fecha = $row_data['fecha'];

        // Si la fecha es diferente de la fecha actual, avanzar a la siguiente fila
        if ($fecha !== $fechaActual) {
            // Calcular el total de horas trabajadas para esta fila
            $totalHoras = calcularTotalHoras(
                $row_data['entrada1'],
                $row_data['salida1'],
                $row_data['entrada2'],
                $row_data['salida2'],
                $row_data['entrada3'],
                $row_data['salida3']
            );

            $horasExtras = calcularHorasExtras($totalHoras, $row_data['horas_teoricas']);

            // Verificar la condición de id_tipus igual a 5
            if ($row_data['id_tipus'] == 5) {
                // Si cumple la condición, establecer $totalHoras en la fila de "BAJA IT"
                $sheet->setCellValue('H1', 'BAJA IT'); // Establecer el encabezado "BAJA IT" en la celda H1
                $sheet->setCellValue('H' . $row, $totalHoras); // Colocar $totalHoras en la fila de "BAJA IT"
                $encontradoIdTipus5 = true; // Marcar como encontrado
            }

            // Imprimir los datos en la hoja de detalles
            $sheet->setCellValue('A' . $row, $row_data['nombre_subempresa']);
            $sheet->setCellValue('B' . $row, $row_data['nombre_departamento']);
            $sheet->setCellValue('C' . $row, $row_data['nombre_completo']);
            $sheet->setCellValue('D' . $row, $fecha);
            $sheet->setCellValue('E' . $row, $totalHoras);
            $sheet->setCellValue('F' . $row, $horasExtras);

            // Otras columnas...
            $fechaActual = $fecha;
            $row++;
        }
    }

   



// Crear una segunda hoja
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('NÓMINAS CONSOLIDADO');

// Agregar encabezados para la segunda hoja (deben coincidir con la Hoja 1)
$sheet2->setCellValue('A1', 'EMPRESA');
$sheet2->setCellValue('B1', 'DEPARTAMENTO');
$sheet2->setCellValue('C1', 'NOMBRE EMPLEADO');
$sheet2->setCellValue('D1', 'FECHA');
$sheet2->setCellValue('E1', 'TOTAL HORAS');
$sheet2->setCellValue('F1', 'TOTAL EXTRAS');
$sheet2->setCellValue('G1', 'BAJA AT');
$sheet2->setCellValue('H1', 'BAJA IT');
$sheet2->setCellValue('I1', 'UBICACIÓN');

// Fijar la fila 1
$sheet2->freezePane('A2');

// Aplicar estilos a los encabezados de la segunda hoja (igual que la Hoja 1)





// Establecer el color de fondo para las celdas de encabezado
// Aplicar color de fondo a las celdas A1 a D1
$sheet2->getStyle('A1:D1')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'ffd880', // Cambia 'CCE5FF' al color deseado en formato RGB
        ],
    ],
]);

// Aplicar color de fondo a las celdas E1 y F1
$sheet2->getStyle('E1:F1')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'ffc134', // Cambia 'FFCCCB' al color deseado en formato RGB
        ],
    ],
]);

// Aplicar color de fondo a las celdas G1 y H1
$sheet2->getStyle('G1:H1')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '6fbc73', // Cambia 'FFCCCB' al color deseado en formato RGB
        ],
    ],
]);


    // Aplicar formato en negrita a las celdas con títulos
    $boldFontStyle = [
        'bold' => true,
    ];
    $sheet2->getStyle('A1:I1')->applyFromArray(['font' => $boldFontStyle]);

// Establecer estilos para los encabezados


// Aplicar el estilo a las celdas de encabezado
$sheet2->getStyle('A1:G1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);






// Ajustar el ancho de las columnas (igual que la Hoja 1)
$sheet2->getColumnDimension('A')->setWidth(20); // Ancho de la columna A
$sheet2->getColumnDimension('B')->setWidth(20); // Ancho de la columna B
$sheet2->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
$sheet2->getColumnDimension('D')->setWidth(12); // Ancho de la columna D
$sheet2->getColumnDimension('E')->setWidth(20); // Ancho de la columna E
$sheet2->getColumnDimension('F')->setWidth(20); // Ancho de la columna F
$sheet2->getColumnDimension('G')->setWidth(10); // Ancho de la columna G
$sheet2->getColumnDimension('H')->setWidth(10); // Ancho de la columna H
$sheet2->getColumnDimension('I')->setWidth(15); // Ancho de la columna I

$sheet2->getRowDimension(1)->setRowHeight(30);
// Llenar la hoja 2 con los datos modificados
$row = 2;
$fechaActual = null;

// Establecer el idioma local en español
setlocale(LC_TIME, 'es_ES.utf8');

mysqli_data_seek($result, 0); // Reiniciar el puntero del resultado

while ($row_data = mysqli_fetch_assoc($result)) {
    $fecha = $row_data['fecha'];
    $nombreMes = strftime('%B', strtotime($fecha)); // Obtener el nombre del mes en español

    // Si la fecha es diferente de la fecha actual, avanzar a la siguiente fila
    if ($fecha !== $fechaActual) {
        // Calcular el total de horas trabajadas para esta fila
        $totalHoras = calcularTotalHoras(
            $row_data['entrada1'],
            $row_data['salida1'],
            $row_data['entrada2'],
            $row_data['salida2'],
            $row_data['entrada3'],
            $row_data['salida3']
        );

        $horasExtras = calcularHorasExtras($totalHoras, $row_data['horas_teoricas']);

        // Imprimir los datos en la hoja de consolidado
        $sheet2->setCellValue('A' . $row, $row_data['nombre_subempresa']);
        $sheet2->setCellValue('B' . $row, $row_data['nombre_departamento']);
        $sheet2->setCellValue('C' . $row, $row_data['nombre_completo']);
       
        
        $sheet2->setCellValue('D' . $row, $nombreMes); // Usar el nombre del mes en español
        $sheet2->setCellValue('E' . $row, $totalHoras);
        $sheet2->setCellValue('F' . $row, $horasExtras);

        // Otras columnas...
        $fechaActual = $fecha;
        $row++;
    }
}
// Calcular totales de horas trabajadas por empleado
$horasTrabajadasPorEmpleado = [];
$infoPorEmpleado = []; // Nuevo arreglo para almacenar la información de empresa, departamento y horas extras por empleado

// Reiniciar el puntero del resultado
mysqli_data_seek($result, 0);

while ($row_data = mysqli_fetch_assoc($result)) {
    $nombreEmpleado = $row_data['nombre_completo'];

    // Si el empleado aún no está en el arreglo, inicializar su información
    if (!isset($infoPorEmpleado[$nombreEmpleado])) {
        $infoPorEmpleado[$nombreEmpleado] = [
            'empresa' => $row_data['nombre_subempresa'],
            'departamento' => $row_data['nombre_departamento'],
            'horasExtras' => 0, // Inicializar las horas extras a 0
        ];
    }

    // Calcular el total de horas trabajadas para esta fila
    $totalHoras = calcularTotalHoras(
        $row_data['entrada1'],
        $row_data['salida1'],
        $row_data['entrada2'],
        $row_data['salida2'],
        $row_data['entrada3'],
        $row_data['salida3']
    );

    // Sumar las horas trabajadas de esta fila al total del empleado
    $horasTrabajadasPorEmpleado[$nombreEmpleado] += $totalHoras;

    // Calcular las horas extras para esta fila
    $horasExtras = calcularHorasExtras($totalHoras, $row_data['horas_teoricas']);

    // Sumar las horas extras de esta fila al total del empleado
    $infoPorEmpleado[$nombreEmpleado]['horasExtras'] += $horasExtras;
}

// Llenar la segunda hoja con la información de empresa, departamento y horas extras por empleado
$row = 2;
foreach ($horasTrabajadasPorEmpleado as $nombreEmpleado => $totalHoras) {
    $sheet2->setCellValue('A' . $row, $infoPorEmpleado[$nombreEmpleado]['empresa']);
    $sheet2->setCellValue('B' . $row, $infoPorEmpleado[$nombreEmpleado]['departamento']);
    $sheet2->setCellValue('C' . $row, $nombreEmpleado);
    
    
    $sheet2->setCellValue('D' . $row, $nombreMes); // Usar el nombre del mes en español
    $sheet2->setCellValue('E' . $row, $totalHoras);
    $sheet2->setCellValue('F' . $row, $infoPorEmpleado[$nombreEmpleado]['horasExtras']);
    $row++;
}





// Crear una tercera hoja
$sheet3 = $spreadsheet->createSheet();
$sheet3->setTitle('ABSENTISMO');

// Agregar encabezados para la segunda hoja (deben coincidir con la Hoja 1)
$sheet3->setCellValue('A1', 'EMPRESA');
$sheet3->setCellValue('B1', 'DEPARTAMENTO');
$sheet3->setCellValue('C1', 'NOMBRE');
$sheet3->setCellValue('D1', 'FECHA');
$sheet3->setCellValue('E1', 'TIPO DE AUSENCIA');
$sheet3->setCellValue('F1', 'HORAS');
$sheet3->setCellValue('G1', 'OBSERVACIONES');


// Fijar la fila 1
$sheet3->freezePane('A2');

// Aplicar estilos a los encabezados de la segunda hoja (igual que la Hoja 1)

    // Establecer estilos para los encabezados
    $sheet3->getStyle('A1:G1')->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'ffff00', // Cambia 'FFCCCB' al color deseado en formato RGB
            ],
        ],
    ]);

    // Aplicar el estilo a las celdas de encabezado
    $sheet3->getStyle('A1:G1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);


// Ajustar el ancho de las columnas (igual que la Hoja 1)
$sheet3->getColumnDimension('A')->setWidth(20); // Ancho de la columna A
$sheet3->getColumnDimension('B')->setWidth(20); // Ancho de la columna B
$sheet3->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
$sheet3->getColumnDimension('D')->setWidth(12); // Ancho de la columna D
$sheet3->getColumnDimension('E')->setWidth(20); // Ancho de la columna E
$sheet3->getColumnDimension('F')->setWidth(20); // Ancho de la columna F
$sheet3->getColumnDimension('G')->setWidth(20); // Ancho de la columna G

$sheet3->getRowDimension(1)->setRowHeight(30);




// Crear una CUARTA hoja
$sheet4 = $spreadsheet->createSheet();
$sheet4->setTitle('VACACIONES');

// Agregar encabezados para la segunda hoja (deben coincidir con la Hoja 1)
$sheet4->setCellValue('A1', 'EMPRESA');
$sheet4->setCellValue('B1', 'DEPARTAMENTO');
$sheet4->setCellValue('C1', 'NOMBRE');
$sheet4->setCellValue('D1', 'DÍAS PLANIFICADOS');
$sheet4->setCellValue('E1', 'DÍAS DISFRUTADOS');
$sheet4->setCellValue('F1', 'DÍAS PENDIENTES');



// Fijar la fila 1
$sheet4->freezePane('A2');

// Aplicar estilos a los encabezados de la segunda hoja (igual que la Hoja 1)

    // Establecer estilos para los encabezados
    $sheet4->getStyle('A1:G1')->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'ffff00', // Cambia 'FFCCCB' al color deseado en formato RGB
            ],
        ],
    ]);

    // Aplicar el estilo a las celdas de encabezado
    $sheet4->getStyle('A1:G1')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);


// Ajustar el ancho de las columnas (igual que la Hoja 1)
$sheet4->getColumnDimension('A')->setWidth(20); // Ancho de la columna A
$sheet4->getColumnDimension('B')->setWidth(20); // Ancho de la columna B
$sheet4->getColumnDimension('C')->setWidth(40); // Ancho de la columna C
$sheet4->getColumnDimension('D')->setWidth(20); // Ancho de la columna D
$sheet4->getColumnDimension('E')->setWidth(20); // Ancho de la columna E
$sheet4->getColumnDimension('F')->setWidth(20); // Ancho de la columna F


$sheet4->getRowDimension(1)->setRowHeight(30);





// Crear el archivo Excel y enviarlo como respuesta
$writer = new Xlsx($spreadsheet);

// Establecer la hoja activa en la primera hoja
$spreadsheet->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Informe_Absentismo.xlsx"');
$writer->save('php://output');
} else {
    echo "Error en la consulta SQL: " . mysqli_error($conn);
}

// Liberar recursos y cerrar conexión a la base de datos
mysqli_free_result($result);
mysqli_close($conn);
?>
