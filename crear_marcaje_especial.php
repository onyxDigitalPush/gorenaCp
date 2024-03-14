<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener los datos del formulario
$nombre = $_POST['nombre'];

$descripcion = $nombre;
$treball = 1;
$actividad = 1;
$global = 1;

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

// Preparar y ejecutar la consulta de inserción
// Preparar y ejecutar la consulta de inserción en la tabla tipusactivitat
$stmt = $conn->prepare("INSERT INTO tipusactivitat (nom, treball, descripcio, activa, global) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisii", $nombre, $treball, $descripcio, $actividad, $global);

// Establecer los valores de los parámetros
$treball = 1;
$descripcio = $nombre;
$actividad = 1;
$global = 1;

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    // Obtener el ID generado automáticamente en la inserción anterior
    $idtipusactivitat = mysqli_insert_id($conn);

    // Preparar y ejecutar la segunda consulta de inserción en la tabla realitza
    $stmt2 = $conn->prepare("INSERT INTO realitza (idempresa, idtipusactivitat, descripcio) VALUES (?, ?, ?)");
    $stmt2->bind_param("iis", $idempresa, $idtipusactivitat, $descripcio);

    // Establecer los valores de los parámetros
    $idempresa = 7;

    // Ejecutar la segunda consulta y verificar el resultado
    if ($stmt2->execute()) {
        header("Location: AdminEmpresa.php");
        exit;
    } else {
        echo "Error al crear el marcaje especial: " . $stmt2->error;
    }

    // Cerrar la segunda consulta
    $stmt2->close();
} else {
    echo "Error al crear el período: " . $stmt->error;
}

// Cerrar la primera consulta
$stmt->close();
$conn->close();

?>
