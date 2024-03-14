<!DOCTYPE html>
<html lang="en">

<?php
    include 'autoloader.php';
    include './Pantalles/HeadGeneric.html';
    $dto = new AdminApiImpl();
    $lng = 0;
    session_start();
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $id = intval($_GET['id']);
    include 'Conexion.php';
    $dto->navResolver();
    
  
    ?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Nuevo Periodo</title>




    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
   
</head>





<style>
/* Estilo para el fondo de pantalla principal (body) */
body {
    background: #f2f2f2; /* Color de fondo gris claro */
  /* Fondo degradado */
}

/* Estilo para el contenedor del modal */
.container {
    background: #fff; /* Color de fondo blanco para el modal */
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 4px rgba(0, 0, 0, 0.06);
}

/* Estilo para el título del modal y otros elementos */
.container h4.modal-title,
.container h5 {
    color: #000; /* Cambia el color del texto del título si es necesario */
    text-align: center;
}

/* Estilo para los campos de entrada y etiquetas */
form {
    max-width: 500px;
    margin: 0 auto;
}

label {
    color: #000; /* Cambia el color del texto de las etiquetas si es necesario */
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    background: #fff; /* Cambia el fondo de los campos de entrada a blanco */
    border: 1px solid #ccc; /* Cambia el borde de los campos de entrada */
    border-radius: 5px;
    color: #000; /* Cambia el color del texto en los campos de entrada si es necesario */
}

textarea {
    resize: vertical;
}

/* Estilo para el botón de enviar */
input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

/* Estilo para el mensaje de respuesta */
.response-msg {
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
}



</style>


















<body >
<?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_GET["id"];
        $idempresa=$_SESSION["idempresa"];
        $anys = $dto->mostraAnysContractePerId($id);
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];   
?> 








<div class="container">
       
   
                      <h4 class="modal-title"><?php echo $dto->mostraNomEmpPerId($id);?></h4> 
                    <center> <h5 class=''> Vas a solicitar un nuevo periodo especial</h5> </center> 
                     
                     
                  
                    <div class="form-container">
        <form name="assignaexcep" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <br><br>
            <center>
                <div class="form-group">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label>
                    <input type="date" class="form-control" name="datainici" required>
                </div>

                <div class="form-group">
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label>
                    <input type="date" class="form-control" name="datafi" required>
                </div>
                <div class="form-group">
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select class="form-control" name="idtipusexcep" required>
                        <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            $tipusData = $valor["idtipusexcep"]."|".$valor["DocFileReq"];
                            echo '<option value="'.$tipusData.'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="MSJrequiredDoc" value="<?php echo $dto->__($lng,"Archivo requerido"); ?>">
                <input type="hidden" name="MSJDatesInvalid" value="<?php echo $dto->__($lng,"Periodo invalido"); ?>">
                <div class="form-group">
                    <label><?php echo $dto->__($lng,"Encargado");?>:</label>
                    <select class="form-control" name="idempleat"  id="mySelect"  required>





                              
                        <?php
   

                          // Valor del parámetro idempleat
                          $idempleat = $_GET["id"]; // Reemplaza con el valor adecuado de idempleat

                          // Consulta para obtener el nombre completo de idresp
                          $consultaNombre = "SELECT CONCAT(nom, ' ', cognom1) AS nombre_completo FROM empleat WHERE idempleat = (SELECT idresp FROM empleat WHERE idempleat = " . $idempleat . ")";
      
                          // Ejecutar la consulta
                          $resultadoNombre = mysqli_query($conn, $consultaNombre);
      
                          if ($resultadoNombre) {
                              if ($filaNombre = mysqli_fetch_assoc($resultadoNombre)) {
                                  $nombreCompleto = $filaNombre['nombre_completo'];
      
                                  // Imprimir la opción seleccionada con el nombre completo
                                  echo '<option value="' . $idempleat . '" selected>' . $nombreCompleto . '</option>';
      
                                  // Obtener el valor de idresp correspondiente al nombre completo
                                  $consultaIdResp = "SELECT idempleat FROM empleat WHERE CONCAT(nom, ' ', cognom1) = '" . $nombreCompleto . "'";
                                  $resultadoIdResp = mysqli_query($conn, $consultaIdResp);
      
                                  if ($resultadoIdResp && mysqli_num_rows($resultadoIdResp) > 0) {
                                      $filaIdResp = mysqli_fetch_assoc($resultadoIdResp);
                                      $idresp = $filaIdResp['idempleat'];
      
                                      // Utilizar el valor de idresp según sea necesario
                                      echo 'Valor de idresp: ' . $idresp;
                                  } else {
                                      echo 'No se encontró ningún valor para idresp.';
                                  }
      
                                  // Liberar el resultado de idresp (opcional, si ya no se necesita más adelante)
                                  mysqli_free_result($resultadoIdResp);
                              } else {
                                  echo 'No se encontró ningún valor para el nombre completo.';
                              }
      
                              // Liberar el resultado de nombre completo (opcional, si ya no se necesita más adelante)
                              mysqli_free_result($resultadoNombre);
                          } else {
                              echo 'Error en la consulta: ' . mysqli_error($conn);
                          }
      
                          // Cerrar la conexión a la base de datos (opcional, si ya no se necesita más adelante)
                          mysqli_close($conn);
                          ?>
                       </select>
                </div>
                <div class="form-group">
                    <label>Comentario:</label>
                    <textarea class="form-control" name="coment_excepcio"></textarea>
                </div>
            </center>
            <br>
            <div class="form-group">
                <label><?php echo $dto->__($lng,"Archivos");?>:</label>
                <input type="file" name="inpFile[]" id="FilesSelect" multiple>
            </div>
            <br><br>
            <div class="button-group">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                <button type="submit" id="btnSolicitar" role="button" class="btn btn-primary" onclick="window.location.href='EmpleatCalendari.php?id=<?php echo $_SESSION['id'];  ?>'"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Solicitar");?></button>
            </div>
            <br><br>
        </form>
          </div>
        </div>
      </div>
      


      



      <div class="modal fade" id="modSolictNouPeriodeEspecial" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
           
                    <script type="text/javascript">
                        assignaexcep.addEventListener('submit', e => {
                            // disable default action
                            e.preventDefault()

                             // collect files
                            const inpFile = assignaexcep.querySelector('[id="FilesSelect"]').files
                            const id = assignaexcep.querySelector('[name="id"]').value
                           
                            const tipusdata = assignaexcep.querySelector('[name="idtipusexcep"]').value
                    
                            const tipus =  tipusdata.split('|',2)
        
                            if (tipus[1] == '1'){
                               if(inpFile.length == 0){
                                alert(assignaexcep.querySelector('[name="MSJrequiredDoc"]').value)
                                return
                               } 
                            }

                            const dataini = assignaexcep.querySelector('[name="datainici"]').value
                            const datafi = assignaexcep.querySelector('[name="datafi"]').value
                            const idempleat = assignaexcep.querySelector('[name="idempleat"]').value
                            const coment_excepcio = assignaexcep.querySelector('[name="coment_excepcio"]').value; // Obtener el valor del campo de texto
                          
                            const formData = new FormData()

                            const dini = new Date(dataini);
                            const dfin = new Date(datafi);

                            if(dfin<dini){
                                alert(assignaexcep.querySelector('[name="MSJDatesInvalid"]').value)
                                return
                            }

                            for (const file of inpFile) {
                                formData.append("myFiles[]",file)
                            }

                          
                            // post form data
                            const xhr = new XMLHttpRequest()

                            xhr.onreadystatechange = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                window.location.reload(window.location);
                            }
                            };

                            // log response
                            xhr.onload = () => {
                                console.log(xhr.responseText)
                            }

                            // create and send the reqeust
                            xhr.open('POST', "Serveis.php?action=Solicitexcep&id=" + id + "&idtipus=" + tipus[0] + "&dataini=" + dataini + "&datafi=" + datafi+ "&idEncargado=" + <?php echo $idresp; ?>+ "&coment_excepcio=" + encodeURIComponent(coment_excepcio), true)
                            xhr.send(formData)


                            })








                    </script>
                </div>
              </div>
            </div>

            </center>
</div>


            <script>
    const menu = document.querySelector('.menu');
    const submenu = document.querySelector('.submenu');

    menu.addEventListener('click', () => {
        submenu.classList.toggle('show');
    });
</script>

<script>
document.getElementById("btnSolicitar").addEventListener("click", function() {
    window.alert("Su solicitud ha sido enviada.");
    // O si prefieres utilizar SweetAlert2:
    // Swal.fire("¡Solicitud enviada!", "", "success");
});
</script>





</body>
</html>


  