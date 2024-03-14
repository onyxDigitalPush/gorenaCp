<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes solicitud periodo</title>

    <?php 
    
   include 'Conexion.php';
    session_start();
    
    include './Pantalles/HeadGeneric.html';
    include 'autoloader.php';

    $dto = new AdminApiImpl();
    $dto->navResolver();
    $idexcep = $_GET["idexcepcio"];
    ?>



<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
}

form {
  margin-bottom: 20px;
}

textarea {
  width: 100%;
  height: 100px;
  resize: vertical;
  background-color: rgba(255, 255, 255, 0.5);
  border: none;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

input[type="submit"] {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.comentario {
  background-color: rgba(255, 255, 255, 0.9);
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.comentario p {
  margin: 0;
}

.comentario .fecha {
  font-size: 12px;
  color: #666;
}

.comentario .enviado-por {
  font-size: 14px;
  font-weight: bold;
  margin-top: 5px;
}

.username {
  font-weight: bold;
  margin-top: 20px;
}

.link-empleado {
  display: inline-block;
  margin-top: 20px;
  text-decoration: underline;
  color: #4CAF50;
}




.glass-table {
    border-collapse: collapse;
    width: 100%;
}

.glass-table th,
.glass-table td {
    padding: 8px;
    text-align: left;
}

.glass-table th {
    background-color: rgba(0, 174, 255, 0.5);
    backdrop-filter: blur(10px);
    color: #fff;
}

.glass-table td {
    background-color: rgba(0, 174, 255, 0.3);
    backdrop-filter: blur(10px);
    color: #fff;
}

.glass-table tr:nth-child(even) td {
    background-color: rgba(0, 174, 255, 0.2);
}

.glass-table tr:hover td {
    background-color: rgba(0, 174, 255, 0.7);
    color: #000;
}






    </style>


</head>
<body>
    
<div class="container">
  <div class="row">
    <div class="col-sm-6">
<form action="" method="POST">
  <textarea name="comentario" placeholder="Escribe tu comentario"></textarea>
  <input type="hidden" name="idexcepcio" value="<?php echo $_GET['idexcepcio']; ?>">
  <input type="hidden" name="idempleat" value="<?php echo $_GET['idempleat']; ?>">
  <input type="submit" value="Enviar comentario">



<br><br><br><br><br>

<?php

// Consulta SQL para obtener los datos de excepción de acuerdo al idexcep y el nombre de la excepción
$sql_actual = "SELECT e.idempleat, te.nom, e.datainici, e.datafinal, e.comentario, CONCAT(em.nom, ' ', em.cognom1) AS nombre_completo FROM excepcio e JOIN empleat em ON e.idempleat = em.idempleat JOIN tipusexcep te ON e.idtipusexcep = te.idtipusexcep WHERE e.idexcepcio = ?";
$stmt_actual = $conn->prepare($sql_actual);
$stmt_actual->bind_param("i", $idexcep); // El tipo de dato "i" indica que el idexcep es un entero
$stmt_actual->execute();
$stmt_actual->bind_result($idempleat, $nombre_excepcion, $datainici, $datafinal, $comentario, $nombre_completo);

// Crear un array para almacenar los datos
$datos = array();

while ($stmt_actual->fetch()) {
    $fila = array(
        "idempleat" => $idempleat,
        "nombre_excepcion" => $nombre_excepcion,
        "datainici" => $datainici,
        "datafinal" => $datafinal,
        "comentario" => $comentario,
        "nombre_completo" => $nombre_completo
    );
    $datos[] = $fila;
}

$stmt_actual->close();

?>











<table class="glass-table">
        <tr>
            <th>Empleado</th>
            <th>Tipo Excepción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <th>Comentario</th>
        </tr>
        <?php foreach ($datos as $fila) { ?>
        <tr>
            <td><?php echo $fila['nombre_completo']; ?></td>
            <td><?php echo $fila['nombre_excepcion']; ?></td>
            <td><?php echo $fila['datainici']; ?></td>
            <td><?php echo $fila['datafinal']; ?></td>
            <td><?php echo $fila['comentario']; ?></td>
        </tr>
        <?php } ?>
    </table>


<br>






</form>

<?php



$idempresa=$_SESSION["idempresa"];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_excepcio = $_POST['idexcepcio']; // Obtén el valor de idexcepcio desde el formulario
  $id_empleado = $_POST['idempleat']; // Obtén el valor de idempleat desde el formulario
  $comentario = $_POST['comentario']; // Obtén el valor del comentario desde el formulario

  
  if ($id_empleado == 0) {
    $id_empleado = $_SESSION['idempresa']; // Asignar el valor de idempresa
  }





  $sql = "INSERT INTO comentario (id_excepcio, id_empleado, mensaje, fecha) VALUES (?, ?, ?, NOW())";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'iis', $id_excepcio, $id_empleado, $comentario);

  if (mysqli_stmt_execute($stmt)) {
    echo "Comentario agregado exitosamente."; // Agrega este mensaje para verificar si se llega a esta parte del código
} else {
    echo "Error al agregar el comentario: ";
    // Muestra el mensaje de error de la consulta preparada
}


  mysqli_stmt_close($stmt);
}

// Consulta los comentarios con el mismo idexcepcio
$id_excepcio = $_GET['idexcepcio'];
$sql = "SELECT * FROM comentario WHERE id_excepcio = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id_excepcio);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);



// Mostrar los comentarios
while ($row = mysqli_fetch_assoc($resultado)) {
  echo '<div class="comentario">';
  echo '<p class="fecha">Fecha: ' . $row['fecha'] . '</p>';

  // Obtener el ID del empleado
  $id_empleado = $row['id_empleado'];

  if ($id_empleado == 7) {
    $nombre_empleado = "Frapont";
  } else {
    // Consultar la base de datos para obtener el nombre del empleado si el ID no es 7
    $sql_empleado = "SELECT nom FROM empleat WHERE idempleat = ?";
    $stmt_empleado = mysqli_prepare($conn, $sql_empleado);
    mysqli_stmt_bind_param($stmt_empleado, 'i', $id_empleado);
    mysqli_stmt_execute($stmt_empleado);
    $resultado_empleado = mysqli_stmt_get_result($stmt_empleado);
    $row_empleado = mysqli_fetch_assoc($resultado_empleado);
    $nombre_empleado = $row_empleado['nom'];

    mysqli_stmt_close($stmt_empleado);
  }

  echo '<p class="enviado-por">Enviado por: ' . $nombre_empleado . '</p>';
  echo '<p class="mensaje">' . $row['mensaje'] . '</p>';
 
  echo '</div>';
}

    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
    
    <p class="username"><?php echo $_SESSION["username"]; ?></p>
    








    </div>
    </div>
    </div>
    <!--aca debe ir el link para devolver a la pagina principal para ver las solicitudes de periodo-->
</body>
</html>



