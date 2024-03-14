<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["empleat"]);
unset($_SESSION["admin"]);
unset($_SESSION["master"]);
unset($_SESSION["ididioma"]);
unset($_SESSION["idempresa"]);
header("Location: index.php");
?>