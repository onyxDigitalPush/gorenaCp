<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener el ID del registro a eliminar
$idtipusactivitat = $_POST['id'];

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

// Preparar y ejecutar la consulta de eliminación en la tabla tipusactivitat
$stmt = $conn->prepare("DELETE FROM tipusactivitat WHERE idtipusactivitat = ?");
$stmt->bind_param("i", $idtipusactivitat);

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    // Eliminar el registro correspondiente en la tabla realitza
    $stmt2 = $conn->prepare("DELETE FROM realitza WHERE idtipusactivitat = ?");
    $stmt2->bind_param("i", $idtipusactivitat);

    if ($stmt2->execute()) {
        header("Location: AdminEmpresa.php");
        exit;
    } else {
        echo "Error al eliminar el marcaje especial en la tabla realitza: " . $stmt2->error;
    }

    // Cerrar la segunda consulta
    $stmt2->close();
} else {
    echo "Error al eliminar el marcaje especial: " . $stmt->error;
}

// Cerrar la primera consulta
$stmt->close();
$conn->close();
?>
