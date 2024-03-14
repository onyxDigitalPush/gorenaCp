<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    include 'Conexion.php';
    include 'autoloader.php';
    include './Pantalles/HeadGeneric.html';
    $dto = new AdminApiImpl();
    $dto->navResolver();
    
    $id = $_GET["id"];
     
   
  



    ?>

<style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4a4a4a;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4a4a4a;
        }
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
            transition: background-color 0.3s;
        }
        input:focus {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            outline: none;
        }
        input[type="submit"] {
            cursor: pointer;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0078d4;
        }
    </style>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Presencia</title>
</head>
<body>


<div class="container">
        <h2>Cambio de Contraseña</h2>
        <form action="process_cambio_contraseña.php" method="post">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>
            <label for="dni">Usuario:</label>
            <input type="text" id="user" name="user" required>
            <label for="contrasena_nueva">Contraseña Nueva:</label>
            <input type="password" id="contrasena_nueva" name="contrasena_nueva" required>
            <input type="hidden" name="id_empleado" value="<?php echo $id; ?>">


            <input type="submit" value="Cambiar Contraseña">
        </form>
    </div>
    




</body>
</html>