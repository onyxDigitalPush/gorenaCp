<?php

include 'autoloader.php';

$fichero = urldecode($_GET["File"]);
$excepcioID = $_GET["Idexcepcio"];

$root = $_SERVER["DOCUMENT_ROOT"];


if (strpos($root,'/') === false) {
    $sep = "\\";
}else{
    $sep = "/";
}

$micarpeta = $root.$sep.'excepciFiles';
$fichero = $micarpeta.$sep.$excepcioID.$sep.$fichero;

if (file_exists($fichero)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fichero));
    readfile($fichero);
    exit;
}
?>