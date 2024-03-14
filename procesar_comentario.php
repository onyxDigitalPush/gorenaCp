<?php
// ... Aquí va el código de conexión a la base de datos ...
require_once 'conexion.php';
session_start();



$id_excepcio = $_POST['idexcepcio']; // Obtén el valor de idexcepcio desde el formulario
$id_empleado = $_POST['idempleat']; // Obtén el valor de idempleat desde el formulario
$comentario = $_POST['comentario']; // Obtén el valor del comentario desde el formulario

$sql = "INSERT INTO comentario (id_excepcio, id_empleado, mensaje, fecha) VALUES (?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'iis', $id_excepcio, $id_empleado, $comentario);

if (mysqli_stmt_execute($stmt)) {
  // El comentario se insertó correctamente en la base de datos
  echo "Comentario agregado exitosamente.";
} else {
  // Hubo un error al insertar el comentario
  echo "Error al agregar el comentario: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);

// Consulta los comentarios con el mismo idexcepcio
$sql = "SELECT * FROM comentario WHERE id_excepcio = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id_excepcio);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// Mostrar los comentarios
while ($row = mysqli_fetch_assoc($resultado)) {
  echo "Comentario: " . $row['mensaje'] . "<br>";
  echo "Fecha: " . $row['fecha'] . "<br>";
  // Puedes mostrar otros datos del comentario si lo deseas
  echo "<br>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>







<?php
        echo '<br>';
        echo $_SESSION["username"];
        ?>



<a href="./">link empleado</a>





