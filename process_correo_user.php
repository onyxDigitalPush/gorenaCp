



<?php
include 'Conexion.php';
require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;







if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT user, contrasenya, email, nom, cognom1 FROM empleat WHERE idempleat = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $usuario = $row['user'];
        $contrasenya = $row['contrasenya'];
        $correoEmpleado = $row['email'];
        $nombreEmpleado = $row['nom'];
        $apellidoEmpleado = $row['cognom1'];

        $msg = sendUserAndPasswordEmail($correoEmpleado, $usuario, $contrasenya,  $nombreEmpleado );

        
        $nombreCompleto = $nombreEmpleado . ' ' . $apellidoEmpleado;
        header("Location: AdminFitxaEmpleat.php?id=" . $id . "&correo_enviado=1&nombre_empleado=" . urlencode($nombreCompleto));
        exit;
    } else {
        echo "No se encontró información para el empleado con ID: $id";
    }
}



function sendUserAndPasswordEmail($to, $user, $password,  $nombreEmpleado )
{
   

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587; // Utiliza el puerto 587 para TLS o 465 para SSL
    $mail->SMTPSecure = 'tls'; // Puedes cambiar a 'ssl' si es necesario
    $mail->SMTPAuth = true;
    $mail->Username = 'permisos.frapont@gmail.com'; // Reemplaza esto con tu dirección de correo de Gmail
    $mail->Password = 'rzgqnymkkcouxcfg'; // Reemplaza esto con tu contraseña de Gmail
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->setFrom('permisos.frapont@gmail.com', 'Usuario y Contraseña'); // Reemplaza esto con el nombre de tu aplicación
    $mail->addAddress($to);
    $mail->Subject = 'Información de usuario y contraseña';

    // Configurar el contenido del correo con formato HTML
    $mail->isHTML(true);
    $mensaje = "<p>Hola  $nombreEmpleado ,</p>";
    $mensaje .= "<p>Te enviamos la siguiente información para ingresar al Portal del Empleado:</p>";
    $mensaje .= "<ul>";
    $mensaje .= "<li><strong>Usuario:</strong> $user</li>";
    $mensaje .= "<li><strong>Contraseña:</strong> $password</li>";
    $mensaje .= "</ul>";
    $mensaje .= "<strong>Para ingresar al Portal del Empleado por favor da click en el siguiente enlace e ingresa las credenciales:</strong> <a href ='frapont.controlpresencia.online'>Portal del Empleado</a>";
    $mensaje .= '

    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:11pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">Si tienes cualquier duda, podr&iacute;as ponerte en contacto con tu responsable de departamento.</span></span></span></span></span></span></p>
    
    <p>&nbsp;</p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#0d0d0d"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">Plataforma Portal del empleado</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#0d0d0d"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">Ciutat d&rsquo;Asunci&oacute;n, 32&nbsp;_08030 Barcelona</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:11pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:9pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none"><span style="border:none"><span style="display:inline-block"><span style="overflow:hidden"><span style="width:236px"><span style="height:55px"><img alt="Icono
    
    Descripción generada automáticamente con confianza baja" height="55" src="https://lh6.googleusercontent.com/C6tzr_jJQrDVCDUw45bJ-btukKD0nrZAU0UkkR57J12St_6F4GRP-0Wkp6VUCVQBVOcSdZQTE4iCjLep5BjNC80iXcu5ZjmT33fn2fR2lAvwEiyyxvGoeqUf24cW745vX6SaDyhkGvmi" width="236" /></span></span></span></span></span></span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:12pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">BARCELONA</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;_</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f7fe1b"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">PARIS</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;_</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f7fe1b"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">LONDON</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;_&nbsp;</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">COPENHAGEN</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;_</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f7fe1b"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">OSLO</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;_&nbsp;</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000206"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">STOCKHOLM</span></span></span></span></span></span><span style="font-size:10.5pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#f5ee4e"><span style="font-weight:700"><span style="font-style:normal"><span style="text-decoration:none">_</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:11pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#808080"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">La informaci&oacute;n contenida en este mensaje y/o archivo(s) adjunto(s), enviada desde Frapont, S.A , es confidencial/privilegiada y est&aacute; destinada a ser le&iacute;da s&oacute;lo por la(s) persona(s) a la(s) que va dirigida.&nbsp; Le recordamos que&nbsp; sus datos han sido incorporados en el sistema&nbsp; de&nbsp; tratamiento de&nbsp; Frapont, S.A y&nbsp; que siempre y cuando&nbsp; se cumplan los requisitos exigidos por la normativa, usted podr&aacute; ejercer sus derechos de acceso,&nbsp;rectificaci&oacute;n, limitaci&oacute;n de tratamiento, supresi&oacute;n, portabilidad y oposici&oacute;n/revocaci&oacute;n, en los t&eacute;rminos&nbsp;que&nbsp;establece la normativa vigente en materia de protecci&oacute;n de datos, dirigiendo su&nbsp;petici&oacute;n a la direcci&oacute;n postal Ciudad de Asunci&oacute;n 32, BARCELONA o bien a trav&eacute;s de correo electr&oacute;nico</span></span></span></span></span></span><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none"> </span></span></span></span></span></span><a href="mailto:frapont@frapont.com" style="text-decoration:none"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#0563c1"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:underline"><span style="-webkit-text-decoration-skip:none"><span style="text-decoration-skip-ink:none">frapont@frapont.com</span></span></span></span></span></span></span></span></a></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#808080"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">Si&nbsp; usted&nbsp; lee este mensaje y&nbsp; no&nbsp; es el&nbsp; destinatario se&ntilde;alado, el empleado o el&nbsp;agente responsable de&nbsp;entregar&nbsp;el&nbsp;mensaje&nbsp;al destinatario, o&nbsp;ha&nbsp;recibido&nbsp;esta&nbsp;comunicaci&oacute;n&nbsp;por&nbsp;error, le informamos que&nbsp;est&aacute;&nbsp; totalmente&nbsp;prohibida,&nbsp;y&nbsp;puede ser ilegal, cualquier&nbsp;divulgaci&oacute;n, distribuci&oacute;n o reproducci&oacute;n&nbsp;de esta comunicaci&oacute;n, y&nbsp;le rogamos que nos lo notifique inmediatamente y nos&nbsp;devuelva el mensaje original a la direcci&oacute;n arriba mencionada. Gracias.</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">&nbsp;</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; margin-bottom:11px"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#000000"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none"><span style="border:none"><span style="display:inline-block"><span style="overflow:hidden"><span style="width:17px"><span style="height:17px"><img alt="Icono
    
    Descripción generada automáticamente" height="17" src="https://lh3.googleusercontent.com/43ucILel3so9tSbFubhSIC3vuPiu0oT1u-UVxj9LoWEcJCtHxbJ8mEwi3EeKhZm95aSlWzPFjaM3OKWtjTYC73GZ8VX6quMTJyrYvQZIrL5-maLWrUsTnXhGgXd_27elsg4y-vaQ66sa" width="17" /></span></span></span></span></span></span></span></span></span></span></span><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#a8d08d"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">Antes de imprimir este mail, aseg&uacute;rese de que es necesario.&nbsp;</span></span></span></span></span></span></p>
    
    <p style="line-height:1.295; border-bottom:solid #000000 0.75pt; margin-bottom:11px; padding:0pt 0pt 1pt 0pt"><span style="font-size:8pt; font-variant:normal; white-space:pre-wrap"><span style="font-family:Calibri,sans-serif"><span style="color:#a8d08d"><span style="font-weight:400"><span style="font-style:normal"><span style="text-decoration:none">El medio ambiente esta en nuestras manos. Abans d&rsquo;imprimir aquest missatge, asseguris&nbsp;de que &eacute;s necessari. El medi ambient est&agrave; a la nostra m&agrave;.</span></span></span></span></span></span></p>
    
    <p>&nbsp;</p>
    ';


    $mail->Body = $mensaje;

    if (!$mail->send()) {
        return 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        return 'Message sent!';
    }
}

?>
