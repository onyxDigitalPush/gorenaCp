<!DOCTYPE html>
<html>
    <?php
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    
    $idubicacio = intval($_GET['idubicacio']);
    $ubicacio = $dto->seleccionaFestiusPerUbicacio($idubicacio);
    echo '<h4>'.$dto->mostraNomUbicacio($idubicacio).'</h4>';
    ?>
    <center>
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h3><?php echo $dto->__($lng,"Editar Festius de l'any"); ?></h3>
                  </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Dia"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Mes"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Any"); ?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Descripció"); ?></th>
                        </thead>
                        <tbody>
                        <?php    
                            foreach($ubicacio as $dia)
                            {
                                echo '<tr>';
                                echo '<td>'.$dia["dia"].'</td>';
                                echo '<td>'.$dto->__($lng,$dto->mostraNomMes($dia["mes"])).'</td>';
                                if($dia["dataany"]!="") $any = substr($dia["dataany"],0,4);
                                else $any = $dto->__($lng,"Cada any");
                                echo '<td>'.$any.'</td>';
                                echo '<td><input style="text-align: center" data-old_value="'.$dia["descripcio"].'" value="'.$dia["descripcio"].'" '
                                . 'title="'.$dto->__($lng,"Clica per a editar festivitat").'" onblur="actualitzaCampTaulaNR('."'festiu','descripcio',".$dia["idfestiu"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>';
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
