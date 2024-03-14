<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $id = intval($_GET['id']);
    $type = $_GET['type'];
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Selecciona l'Arxiu"); ?></h3><br>
                        <form action="AdminFitxaEmpleat.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="file" name="fileToUpload" id="fileToUpload" style="border: solid 1px">
                        <br><br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                    <button type="submit" class="btn btn-success"><?php echo $dto->__($lng,"Desar"); ?></button>
                   </form> 
                </div>
              </div>
            </div>
    </center>
</html>
