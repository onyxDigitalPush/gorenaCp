<?php
// Conexión a la base de datos (reemplaza 'tu_host', 'tu_usuario', 'tu_contraseña' y 'tu_base_de_datos' con tus valores)
include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $dni = $_POST['dni'];
    $contrasena_nueva = $_POST['contrasena_nueva'];
    $id_empleado = $_POST['id_empleado'];
    $user = $_POST['user'];

    // Consulta para actualizar la contraseña en la base de datos
    $sql_update = "UPDATE empleat SET contrasenya = '$contrasena_nueva' WHERE idempleat = '$id_empleado' AND DNI = '$dni' AND user = '$user'";

    if (mysqli_query($conn, $sql_update)) {
        // Verificar si se afectó alguna fila en la base de datos
        if (mysqli_affected_rows($conn) > 0) {
            // Cambio de contraseña exitoso
            echo '<script>alert("Cambio de contraseña exitoso. Tu contraseña ha sido actualizada.");</script>';

            // Redirigir a la página de éxito después de 5 segundos
            echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 100);</script>';
        } else {
            // Error al actualizar la contraseña en la base de datos
            $urlCambioContrasena = "CambioContraseña.php?id=" . $id_empleado;
            echo '<script>alert("Error al actualizar la contraseña, verifica tus datos: ' . mysqli_error($conn) . '");</script>';
            echo '<script>setTimeout(function(){ window.location.href = "' . $urlCambioContrasena . '"; }, 100);</script>';
        }
    } else {
        // Error al ejecutar la consul
        $urlCambioContrasena = "CambioContraseña.php?id=" . $id_empleado;
        echo '<script>alert("Error al actualizar la contraseña, verifica tus datos: ' . mysqli_error($conn) . '");</script>';
        echo '<script>setTimeout(function(){ window.location.href = "' . $urlCambioContrasena . '"; }, 10);</script>';
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
