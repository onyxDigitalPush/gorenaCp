<!DOCTYPE html>
<html>
<?php
include 'autoloader.php';
$dto = new AdminApiImpl();
$lng = 0;
session_start();
if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];

$idubicacio = intval($_GET['idubicacio']);
$holiday = $dto->dataDeleteHoliday($idubicacio);
$holiday = $holiday[0];
?>


<style>


    /* Estilo para el fondo del modal */
    .modal-content.glassmorphism {
        background: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
        backdrop-filter: blur(10px); /* Efecto de desenfoque */
        border: 1px solid rgba(255, 255, 255, 0.125); /* Borde con transparencia */
        border-radius: 10px; /* Borde redondeado */
    }

    /* Estilo para el cuerpo del modal */
    .modal-body {
        background: rgba(255, 255, 255, 0.1); /* Color de fondo con transparencia */
        padding: 20px; /* Espaciado interior */
    }

    /* Estilo para los botones dentro del modal */
    .btn_modal {
        background-color: rgba(255, 255, 255, 0.2); /* Color de fondo con transparencia */
        border: none; /* Sin borde */
        color: white; /* Color del texto */
        border-radius: 5px; /* Borde redondeado */
        margin-right: 10px; /* Espaciado entre botones */
    }

    /* Estilo para los botones cuando están en hover */
    .btn_modal:hover {
        background-color: rgba(81, 209, 246, 0.3); /* Cambia el color de fondo durante el hover */
        color: white; /* Cambia el color del texto durante el hover */
    }

    /* Estilo para el título del modal */
    .modal-body h3 {
        color: white; /* Color del texto del título */
        text-align: center; /* Alineación del texto del título */
    }

</style>


<div class="modal-dialog">
    <div class="modal-content glassmorphism">
        <div class="glassmorphism"><button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 style="color:white; text-align: center;"><?php echo $dto->__($lng,"Eliminar Festivo"); ?></h3>
        </div>
        <div class="modal-body">
            <h4 class="text-center"> Seguro que dese eliminar el festivo <?php echo $holiday['description']; ?> </h4>
            <br>

            <div class="text-center">
                <button type="submit" form="form_delete_holiday" class="btn btn-primary">Borrar</button>
                <button type="button" class="btn btn-danger">Cancelar</button>
            </div>

            <br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
        </div>
    </div>
</div>
</center>

<form id="form_delete_holiday" action="eliminarFestivo.php" method="POST">
    <?php echo '<input type="hidden" name="id" value="' . $holiday["id_holiday"] . '">'; ?>
</form>

</html>
