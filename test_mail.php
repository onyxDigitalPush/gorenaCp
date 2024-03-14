<?php
require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendUserAndPasswordEmail($to, $user, $password)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // Utiliza el puerto 587 para TLS o 465 para SSL
    $mail->SMTPSecure = 'tls'; // Puedes cambiar a 'ssl' si es necesario
    $mail->SMTPAuth = true;
    $mail->Username = 'miguelangel.onyx@gmail.com'; // Reemplaza esto con tu dirección de correo de Gmail
    $mail->Password = 'ballkqkoqjokcfhk'; // Reemplaza esto con tu contraseña de Gmail
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->setFrom('miguelangel.onyx@gmail.com', 'Tu Aplicación'); // Reemplaza esto con el nombre de tu aplicación
    $mail->addAddress($to);
    $mail->Subject = 'Información de usuario y contraseña';
    $mail->Body = "Usuario: $user \nContraseña: $password";

    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 'Message sent!';
    }
}

// Obtener el ID del empleado desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Realizar la consulta a la base de datos para obtener la información de usuario y contraseña
    // Supongamos que la tabla se llama 'empleados' y los campos son 'usuario' y 'contrasenya'
    $query = "SELECT usuario, contrasenya, correo FROM empleados WHERE id = $id";
    $result = mysqli_query($tuConexion, $query); // $tuConexion es tu objeto de conexión a la base de datos

    // Verificar si se encontraron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener la información de usuario, contraseña y correo del empleado
        $row = mysqli_fetch_assoc($result);
        $usuario = $row['usuario'];
        $contrasenya = $row['contrasenya'];
        $correoEmpleado = $row['correo'];

        // Enviar el correo con la información de usuario y contraseña
        $msg = sendUserAndPasswordEmail($correoEmpleado, $usuario, $contrasenya);
        echo $msg; // Muestra el mensaje de éxito o error en pantalla
    } else {
        echo "No se encontró información para el empleado con ID: $id";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PHPMailer Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .response-msg {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Contact us</h1>
    <?php if (empty($msg)) { ?>
        <form method="post">
            <label for="to">Send to:</label>
            <select name="to" id="to">
                <option value="support" selected="selected">Support</option>
            </select><br>
            <label for="subject">Subject: <input type="text" name="subject" id="subject" maxlength="255"></label><br>
            <label for="name">Your name: <input type="text" name="name" id="name" maxlength="255"></label><br>
            <label for="email">Your email address: <input type="email" name="email" id="email" maxlength="255"></label><br>
            <label for="query">Your question:</label><br>
            <textarea cols="30" rows="8" name="query" id="query" placeholder="Your question"></textarea><br>
            <input type="submit" value="Submit">
        </form>
    <?php } else { ?>
        <div class="response-msg">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</body>
</html>
