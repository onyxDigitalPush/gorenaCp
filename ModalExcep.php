<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h3><?php echo $dto->__($lng,"Editar Període Especial"); ?></h3></div>
                <div class="modal-body">
                    <h3></h3><br>
                    <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Dia"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Entrada"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Sortida"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Hores"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Automarcatge"); ?></th>
                        </thead>
                        <tbody>
                            <?php
                            $id = intval($_GET['id']);
                            $idhorari = intval($_GET['idhorari']);
                            $horari = $dto->seleccionaTornsEmpPerHorari($id,$idhorari);
                            foreach($horari as $dia)
                            {
                                echo '<tr>';
                                echo '<td>'.$dto->mostraNomDia($dia["diasetmana"]).'</td>';
                                echo '<td>'.substr($dia["horaentrada"],0,5).'</td>';
                                echo '<td>'.substr($dia["horasortida"],0,5).'</td>';
                                echo '<td>'.$dia["horestreball"].'</td>';
                                echo '<td>'.$dto->dirsiono($dia["marcautomatic"]).'<td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <br><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>
                </div>
              </div>
            </div>
            </center>
</html>
