<!DOCTYPE html>
<html>
<?php
include 'autoloader.php';
$dto = new AdminApiImpl();
$lng = 0;
session_start();
if (isset($_SESSION["ididioma"])) {
    $lng = $_SESSION["ididioma"];
}

$id = $_GET['1'];
$data = $_GET["2"];
$idempresa = $dto->getCampPerIdCampTaula("empleat", $id, "idempresa");
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
          background-color: rgba(72, 90, 255, 0.9); /* Color de fondo con transparencia */
          border: none; /* Sin borde */
          color: white; /* Color del texto */
          border-radius: 5px; /* Borde redondeado */
          margin-right: 10px; /* Espaciado entre botones */
      }

      /* Estilo para los botones cuando están en hover */
      .btn_modal:hover {
          background-color: rgba(81, 209, 246, 0.7); /* Cambia el color de fondo durante el hover */
          color: white; /* Cambia el color del texto durante el hover */
      }


      /* Estilo para el título del modal */
      .modal-body h3 {
          color: white; /* Color del texto del título */
          text-align: center; /* Alineación del texto del título */
      }


      /* Estilo para el select */
      .mi-select {
          width: 100%; /* Ancho del select, puedes ajustarlo según tus necesidades */
          padding: 10px; /* Espaciado interno */
          font-size: 16px; /* Tamaño de fuente */
          border: 1px solid #ccc; /* Borde del select */
          border-radius: 10px; /* Borde redondeado */
          background-color: #fff; /* Color de fondo */
          color: #333; /* Color del texto */
      }

      /* Estilo para el select cuando está en hover (opcional) */
      .mi-select:hover {
          border-color: #007bff; /* Cambia el color del borde al pasar el mouse sobre él */
      }

      /* Estilo para el select cuando está enfocado (opcional) */
      .mi-select:focus {
          border-color: #007bff; /* Cambia el color del borde cuando el select está enfocado */
          outline: none; /* Elimina el contorno predeterminado al hacer clic en el select */
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Agrega una sombra suave cuando el select está enfocado */
      }


</style>

<center>
    <div class="modal-dialog glassmorphism">
        <div class="modal-content glassmorphism">
            <div class="glassmorphism">
                
                <h3 style="color:white;"><?php echo "Registrar Nuevo Marcaje para"?></h3>
            </div>
            <form name="noumarc">
                <div class="modal-body">
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-6">
                            <label><?php echo $dto->__($lng, "Data");?>:</label><input type="date" name="data"
                                value="<?php echo $data;?>" required>
                        </div>
                        <div class="col-lg-4">
                            <label><?php echo $dto->__($lng, "Hora");?>:</label><input type="time" name="hora">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <label><?php echo $dto->__($lng, "Tipus");?>:</label>
                            <select name="entsort">
                                <option value="0"><?php echo $dto->__($lng, "Entrada");?></option>
                                <option value="1"><?php echo $dto->__($lng, "Sortida");?></option>
                            </select>
                            <select name="tipus" onchange="asignarValorObservacions()">
                                <?php
                                $tipus = $dto->mostraTipusActivitats();
                                foreach ($tipus as $valor) {
                                    echo '<option value="' . $valor["idtipusactivitat"] . '">' . $dto->__($lng, $valor["nom"]) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-2">
                            <label><?php echo $dto->__($lng, "Observacions");?>:</label>
                        </div>
                        <div class="col-lg-8"><input type="text" name="obs" id="observacions" style="height: 50px"></div>
                    </div>
                    <br>
                </div>
            </form>
            <div class="">
                <button type="button" class="btn_modal" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng, "Cancel·lar");?></button>
                <button type="button" class="btn_modal" data-dismiss="modal"
                    onclick="insereixMarcatgeObs(noumarc.id.value,noumarc.entsort.value,noumarc.tipus.value,noumarc.data.value,noumarc.hora.value,document.getElementById('observacions').value);"><span
                        class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng, "Registrar");?></button>
            </div>
        </div>
    </div>
</center>

<script>
    // Función para asignar el valor seleccionado en "Tipus" a "Observacions"
    function asignarValorObservacions() {
        var tipusSelect = document.getElementsByName("tipus")[0];
        var observacionsInput = document.getElementById("observacions");
        observacionsInput.value = tipusSelect.options[tipusSelect.selectedIndex].text;
    }
</script>

</html>
