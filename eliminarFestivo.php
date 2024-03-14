<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener el ID del período a eliminar
$id = $_POST['id'];

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

// Preparar y ejecutar la consulta de eliminación
$stmt = $conn->prepare("DELETE FROM festiu WHERE idfestiu = ?");
$stmt->bind_param("i", $id);

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    header("Location: adminEmpresa.php");
    exit;
} else {
    echo "Error al eliminar el festivo: " . $stmt->error;
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conn->close();
?>
