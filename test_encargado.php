<?php
// Conexión a la base de datos
include 'Conexion.php';


// Consulta SQL para obtener los empleados encargados
$sql = "SELECT * FROM empleat WHERE isEncargado = 1";
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Recorrer los resultados y mostrar los empleados encargados
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["idempleat"] . ", Nombre: " . $row["nom"] . "<br>";
        // Puedes acceder a otros campos del empleado utilizando $row["nombre_del_campo"]
    }
} else {
    echo "No se encontraron empleados encargados.";
}

// Cerrar la conexión a la base de datos
$conn->close();

?>