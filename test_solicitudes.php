<?php
// Conexión a la base de datos
include 'Conexion.php';


$idEmpleado = 147; // Reemplazar con el ID del empleado

// Consulta SQL para obtener las excepciones aceptadas con el nombre del tipo de excepción
$sql = "SELECT tipusexcep.idtipusexcep, tipusexcep.nom AS tipusexcepnom, SUM(DATEDIFF(excepcio.datafinal, excepcio.datainici)) AS totalDias
FROM excepcio
INNER JOIN tipusexcep ON tipusexcep.idtipusexcep = excepcio.idtipusexcep
WHERE excepcio.idempleat = $idEmpleado AND excepcio.aprobada = 1
GROUP BY tipusexcep.idtipusexcep, tipusexcepnom";


// Ejecutar la consulta y obtener el resultado
$result = $conn->query($sql);

// Recorrer los registros del resultado
while ($row = $result->fetch_assoc()) {
    $idTipoExcepcion = $row['idtipusexcep'];
    $nombreTipoExcepcion = $row['tipusexcepnom'];
    $totalDias = $row['totalDias'];
    
    // Hacer algo con los datos obtenidos, por ejemplo, imprimirlos
    echo "ID de Tipo de Excepción: $idTipoExcepcion, Tipo de Excepción: $nombreTipoExcepcion, Total de Días: $totalDias <br>";
}

// Cerrar la conexión con la base de datos y otras tareas de limpieza

?>
