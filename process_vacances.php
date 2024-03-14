<?php
include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $any = $_POST["any"];
    $numero = $_POST["numero"];
    $id_empleat = $_POST["id_empleat"];

    // Preparar y ejecutar la consulta SQL de eliminación
    $sqlDelete = "DELETE FROM vacances WHERE idempleat = ? AND any = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ss", $id_empleat, $any);

    if ($stmtDelete) {
        if ($stmtDelete->execute()) {
            // Preparar y ejecutar la consulta SQL de inserción
            $sqlInsert = "INSERT INTO vacances (idempleat, any, total_dias) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("isi", $id_empleat, $any, $numero);

            if ($stmtInsert->execute()) {
                $stmtDelete->close();
                $stmtInsert->close();
                
                // Redirigir a la sección específica con el valor de $id_empleat
                header("Location: AdminFitxaEmpleat.php?id=" . $id_empleat);
                exit();
            } else {
                $error = "Error al ejecutar la consulta de inserción: " . $stmtInsert->error;
            }
        } else {
            $error = "Error al ejecutar la consulta de eliminación: " . $stmtDelete->error;
        }
    } else {
        $error = "Error en la preparación de la consulta de eliminación: " . $conn->error;
    }

    // Manejo de errores
    if (isset($error)) {
        echo $error;
    }
}
?>
