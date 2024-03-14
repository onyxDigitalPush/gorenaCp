<?php
// Incluir el archivo de conexión
include 'Conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el valor seleccionado del select
    $idEmpleadoEncargado = $_POST['idresp'];
    $id_empleat = $_POST["id_empleat"];

    // Imprimir el valor de las variables para verificar
    echo "Valor de idEmpleadoEncargado: " . $idEmpleadoEncargado . "<br>";
    echo "Valor de id_empleat: " . $id_empleat . "<br>";

    // Borrar el valor existente en idresp para el empleado específico
    $borrarConsulta = "UPDATE empleat SET idresp = NULL WHERE idempleat = $id_empleat";
    mysqli_query($conn, $borrarConsulta);

    // Asignar el valor seleccionado a la columna idresp para el empleado específico
    $asignarConsulta = "UPDATE empleat SET idresp = $idEmpleadoEncargado WHERE idempleat = $id_empleat";
    mysqli_query($conn, $asignarConsulta);

    // Verificar si hubo algún error en las consultas
    if (mysqli_error($conn)) {
        echo "Error: " . mysqli_error($conn);
    } else {
        header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
        exit();
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
