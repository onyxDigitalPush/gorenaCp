<?php
include 'autoloader.php';
$dto = new AdminApiImpl();

$id = $_POST["id"];
$pwd = $_POST["pwd"];

if (!empty($userdata = $dto->validaCredencials($id, $pwd)))
{
    foreach($userdata as $user) $_SESSION["username"]=$user["nom"];
    $_SESSION["id"]=$id;
}
else "Login Incorrecte";
if ($dto->esAdmin($id)) $_SESSION["admin"]=1;




