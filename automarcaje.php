
<?php
include 'Conexion.php';

session_start(); 

include 'autoloader.php';
$dto = new AdminApiImpl();

$idempresa = $_SESSION["idempresa"];
$id = $_SESSION["id"];

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos enviados por AJAX
  $idempresa = $_POST["idempresa"];
  $valor = $_POST["valor"];

  // Realizar la lógica de actualización en la base de datos
  // ...

  // Ejemplo de actualización en la base de datos
  // Establecer la conexión con la base de datos


  // Verificar si la conexión fue exitosa
  if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
  }

  // Actualizar el valor en la base de datos
  $sql = "UPDATE empresa SET automarcaje = $valor WHERE idempresa = $idempresa";

  if ($conn->query($sql) === TRUE) {
    echo "Actualización exitosa";
  } else {
    echo "Error en la actualización: " . $conn->error;
  }

  // Cerrar la conexión
  $conn->close();
} else {
  echo "Acceso denegado";
}
?>
