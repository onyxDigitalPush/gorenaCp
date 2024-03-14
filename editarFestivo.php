<?php
session_start();
include './Pantalles/HeadGeneric.html';
include 'autoloader.php';
$dto = new AdminApiImpl();

// Obtener los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];

// Realizar la conexión a la base de datos utilizando el archivo de conexión
include 'Conexion.php';

// Preparar y ejecutar la consulta de actualización
$stmt = $conn->prepare("UPDATE festiu SET descripcio = ? WHERE idfestiu = ?");
$stmt->bind_param("si", $nombre, $id);


// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    // Redireccionar a la página deseada después de la actualización
    header("Location: adminEmpresa.php");
    exit; // Asegurar que el código se detenga después de la redirección
} else {
    echo "Error al actualizar el festivo: " . $stmt->error;
}

// Cerrar la conexión y liberar los recursos
$stmt->close();
$conn->close();
?>
