


<!DOCTYPE html>
<html>
<?php
include 'autoloader.php';
$dto = new AdminApiImpl();
$lng = 0;
session_start();
if (isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
$id = intval($_GET['id']);
include 'Conexion.php';

?>
 <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Confirmar el envío de información al empleado"); ?></h3><br>
                    <form method="post" name="" action="process_correo_user.php">
                            
                    
                    <input type="hidden" name="id_empleat" value="<?php echo $id; ?>">

<?php

echo "esto es un test para identificar id:" . $id;



?>


                            <button type="submit" class="btn btn-success">Enviar</button>


                            <br><br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                   </form> 
                </div>
              </div>
            </div>
            </center>

</html>
