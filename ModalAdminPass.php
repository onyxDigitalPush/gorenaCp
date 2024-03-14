<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $id = intval($_GET['id']);
    ?>
    <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Definir Contrasenya"); ?></h3><br>
                        <form method="post" name="pwds">
                            <input type="password" name="pwd1" placeholder="<?php echo $dto->__($lng,"Nova Contrasenya");?>">
                            <br><br><input type="password" name="pwd2" placeholder="<?php echo $dto->__($lng,"Repetir Contrasenya");?>">
                            <br><br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                    <button type="button" class="btn btn-danger" onclick="assignaContrasenya(<?php echo $id; ?>,pwds.pwd1.value,pwds.pwd2.value)"><?php echo $dto->__($lng,"Assignar"); ?></button>
                   </form> 
                </div>
              </div>
            </div>
            </center>
</html>
