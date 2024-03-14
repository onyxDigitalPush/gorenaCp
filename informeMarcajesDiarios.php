<!DOCTYPE html>
<html>
<head>
    <?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();
$dto->navResolver();
include 'Conexion.php';
?>

    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 150%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 3px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
            margin-left: 30px;
        }

        input[type="date"] {
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 8px 12px;
            margin-left: 10px;
            border: none;
            background-color: #4caf50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        a.button {
            display: inline-block;
            padding: 8px 12px;
            border: none;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a.button:hover {
            background-color: #2980b9;
        }



        .btn-green {
            position: relative; /* Necesario para el posicionamiento de los elementos internos */
            padding: 10px 20px;
            background-color:rgb(0,205,0,0.7) ; /* Fondo transparente */
            color: white; /* Texto transparente */
            border:2px solid rgba(0, 0, 0, 0.3); 
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease; /* Animación suave en todos los cambios */
        }

        .btn-green .icon-arrow-right {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 84px; /* Tamaño de la flecha */
            color: #007bff; /* Color de la flecha antes del hover */
            transition: color 0.3s ease; /* Animación de cambio de color de la flecha */
        }

        .btn-green .btn-text {
            position: relative;
            z-index: 1; /* Coloca el texto del botón sobre la flecha */
        }

        .btn-green:hover {
            background-color: #00cd00; /* Cambia el color de fondo durante el hover */
            color: #fff; /* Cambia el color del texto durante el hover */
            transform: scale(1.1); /* Aumenta ligeramente el tamaño durante el hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Agrega una sombra durante el hover */
        }




    </style>




</head>
<body>
    <div class="container">


    <?php
$lng = 0;

$idempresa = $_SESSION["idempresa"];
if (!isset($_GET["idsubemp"])) {
    if (isset($_SESSION["filtidsubempq"])) {
        $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
    } else if (isset($_SESSION["idsubempresa"])) {
        $_GET["idsubemp"] = $_SESSION["idsubempresa"];
    } else {
        $_GET["idsubemp"] = "Totes";
    }

}
$idsubemp = $_GET["idsubemp"];
$_SESSION["filtidsubempq"] = $idsubemp;
$d = strtotime("now");

?>

<?php

// Establecer la conexión a la base de datos

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Variables para el filtrado por fechas
$fechaInicial = "";
$fechaFinal = "";
$idSubempresa = "";

// Verificar si se recibieron los valores de fecha
if (isset($_POST['fecha_inicial']) && isset($_POST['fecha_final']) && isset($_GET['idsubemp'])) {
    $fechaInicial = $_POST['fecha_inicial'];
    $fechaFinal = $_POST['fecha_final'];
    $idSubempresa = $_GET['idsubemp'];

// Ajustar la fecha final para incluir todo el día
	$fechaFinal_aux = $fechaFinal;
    $fechaFinal = date('Y-m-d', strtotime($fechaFinal . ' +1 day'));

}
// Calcular el total de horas trabajadas

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

// Supongamos que tienes el valor de la subempresa seleccionada almacenado en $idSubempresa
// Asegúrate de escapar y validar el valor adecuadamente antes de utilizarlo en la consulta.

// Supongamos que tienes el valor de la subempresa seleccionada almacenado en $idSubempresa
// Asegúrate de escapar y validar el valor adecuadamente antes de utilizarlo en la consulta.

$sql = "SELECT e.nom, e.cognom1, e.cognom2,
DATE(t1.datahora) AS fecha,
TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 1 THEN t1.datahora END)) AS entrada1,
TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 1 THEN t1.datahora END)) AS salida1,
TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 2 THEN t1.datahora END)) AS entrada2,
TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 2 THEN t1.datahora END)) AS salida2,
TIME(MAX(CASE WHEN t1.entsort = 0 AND t1.row_number = 3 THEN t1.datahora END)) AS entrada3,
TIME(MAX(CASE WHEN t1.entsort = 1 AND t1.row_number = 3 THEN t1.datahora END)) AS salida3,
GROUP_CONCAT(DISTINCT t1.observacions SEPARATOR ' / ') AS observacions,
tt.horestreball AS horas_teoricas
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
LEFT JOIN rotacio AS r ON e.idempleat = r.idempleat
LEFT JOIN tipustorn AS tt ON r.idtipustorn = tt.idtipustorn
GROUP BY t1.id_emp, DATE(t1.datahora)";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>


    <div class="row">
            <div class="col-lg-12 well">
            <div class="col-lg-3"><h3><?php echo $dto->__($lng, "Informe marcajes diarios"); ?></h3></div>
            <div class="col-lg-2">

                <form method="GET" action="">
                        <label><?php echo $dto->__($lng, "Subempresa"); ?>:</label>
                    <?php
echo '<select name="idsubemp" onchange="this.form.submit();">
                        <option hidden selected value="' . $idsubemp . '">';
if ($idsubemp == "Totes") {
    echo $dto->__($lng, $idsubemp);
} else {
    echo $dto->mostraNomSubempresa($idsubemp);
}

echo '</option><option value="Totes">' . $dto->__($lng, "Totes") . '</option>';
$resemp = $dto->mostraSubempreses($idempresa);
foreach ($resemp as $emp) {
    echo '<option value="' . $emp["idsubempresa"] . '">' . $emp["nom"] . '</option>';
}
echo '</select>';
?>
                    <input type="hidden" name="tipusexcep" value="<?php echo $tipusexcep; ?>">
                <input type="hidden" name="dpt" value="<?php echo $dpt; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">

            </div>

            </form>




  <!-- Formulario para el filtrado de fechas -->

  <form method="POST" action="">

            <label for="fecha_inicial">Fecha inicial:</label>
            <input type="date" id="fecha_inicial" name="fecha_inicial" value="<?php echo $fechaInicial; ?>" required>

            <label for="fecha_final">Fecha final:</label>
            <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $fechaFinal_aux; ?>" required>

            <button type="submit">Filtrar</button>
        </form>
            </div>



   <!-- Botón de exportar -->
   <a class="btn-green" href="exportar.php?fecha_inicial=<?php echo $fechaInicial; ?>&fecha_final=<?php echo $fechaFinal; ?>&idsubemp=<?php echo $idsubemp; ?>">Exportar a Excel</a>


        </div>



<?php

// Imprimir la tabla con los datos

echo "</tr>";

echo "<table>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Fecha</th>";
echo "<th>Entrada 1</th>";
echo "<th>Salida 1</th>";
echo "<th>Entrada 2</th>";
echo "<th>Salida 2</th>";
echo "<th>Entrada 3</th>";
echo "<th>Salida 3</th>";
echo "<th>Horas trabajadas</th>";
echo "<th>Horas teóricas</th>";
echo "<th>Observaciones</th>";
echo "</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['nom'] . ' ' . $row['cognom1'] . ' ' . "</td>";
    echo "<td>" . $row['fecha'] . "</td>";

    // Verificar las salidas sin llenar y aplicar el estilo en rojo
    $salida1 = !$row['salida1'] && $row['entrada1'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida1'];
    $salida2 = !$row['salida2'] && $row['entrada2'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida2'];
    $salida3 = !$row['salida3'] && $row['entrada3'] ? "<span style='color: red;'>Sin marcar salida</span>" : $row['salida3'];

    $entrada1 = !$row['entrada1'] && $row['salida1'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada1'];
    $entrada2 = !$row['entrada2'] && $row['salida2'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada2'];
    $entrada3 = !$row['entrada3'] && $row['salida3'] ? "<span style='color: blue;'>Sin marcar entrada</span>" : $row['entrada3'];

    echo "<td>" . $entrada1 . "</td>";
    echo "<td>" . $salida1 . "</td>";
    echo "<td>" . $entrada2 . "</td>";
    echo "<td>" . $salida2 . "</td>";
    echo "<td>" . $entrada3 . "</td>";
    echo "<td>" . $salida3 . "</td>";

    // Calcular el total de horas trabajadas
    $totalHoras = calcularTotalHoras($row['entrada1'], $row['salida1'], $row['entrada2'], $row['salida2'], $row['entrada3'], $row['salida3']);

    echo "<td>" . $totalHoras . "</td>";
    // Imprimir las horas teóricas
    // Formatear las horas teóricas en el formato HH:MM horas
    $horasTeoricas = $row['horas_teoricas'];
    $horasTeoricasFormateadas = sprintf("%02d:%02d", floor($horasTeoricas), ($horasTeoricas - floor($horasTeoricas)) * 60);
    echo "<td>" . $horasTeoricasFormateadas . "</td>";
    echo "<td>" . $row['observacions'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>




    </div>
</body>
</html>
