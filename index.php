<?php 
try{
session_start();




include 'autoloader.php';
$dto = new AdminApiImpl();
$domini = $_SERVER["HTTP_HOST"];
$rsdom = $dto->getDb()->executarConsulta('select idempresa from empresa where website like "'.$domini.'"');

if(!empty($rsdom)) {foreach($rsdom as $dom) {$_SESSION["idempresa"] = $dom["idempresa"];}} 
else if(!isset($_SESSION["idempresa"])) {$_SESSION["idempresa"]=2;} 
$idempresa = $_SESSION["idempresa"];
$lng = $dto->getCampPerIdCampTaula("empresa",$idempresa,"ididiomadef");

if(!empty($lng)) $_SESSION["ididioma"]=$lng;
else if(!isset($_SESSION["ididioma"]))$_SESSION["ididioma"]=2; //Idioma per defecte Español 
include './Pantalles/HeadGeneric.html';

?>
<html>
    <head>

<style>
    /* Estilos para el contenedor personalizado del "select" */
    .custom-select-container {
        position: relative;
        display: inline-block;
    }

    /* Estilo personalizado para el "select" */
    .custom-select-button {
        width: 50px; /* Ajusta el tamaño del botón */
        height: 50px; /* Ajusta el tamaño del botón */
        background-color: #50a44c; /* Color de fondo */
        color: #fff; /* Color del texto */
        border: none;
        border-radius: 50%; /* Hace que el botón sea redondo */
        padding: 0;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s; /* Transición suave al cambiar el color */
    }

    .custom-select-button-red {
        width: 50px; /* Ajusta el tamaño del botón */
        height: 50px; /* Ajusta el tamaño del botón */
        background-color: #fc5c5c ; /* Color de fondo */
        color: #fff; /* Color del texto */
        border: none;
        border-radius: 50%; /* Hace que el botón sea redondo */
        padding: 0;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s; /* Transición suave al cambiar el color */
    }

    /* Cambia el color del botón al pasar el cursor sobre él */
    .custom-select-button:hover {
        background-color: #3d8740;
    }

    /* Estilo para la flecha hacia la derecha dentro del botón */
    .custom-select-arrow::before {
        content: "→";
        font-size: 24px; /* Ajusta el tamaño de la flecha */
        line-height: 1; /* Ajusta el espacio alrededor de la flecha */
    }

    /* Estilo para el "select" original */
    select#selE {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        cursor: pointer;
        /* Personaliza el estilo del menú desplegable */
        background-color: #fff; /* Color de fondo */
        border: 1px solid #ccc; /* Borde */
        border-radius: 5px; /* Borde redondeado */
        padding: 5px; /* Espaciado interno */
        color: #333; /* Color del texto */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra ligera */
    }

    /* Estilo para las opciones del menú desplegable */
    select#selE option {
        background-color: #fff; /* Color de fondo de las opciones */
        color: #333; /* Color del texto de las opciones */
        border: none; /* Borde de las opciones */
        padding: 5px 10px; /* Espaciado interno de las opciones */
    }

    /* Cambia el color de las opciones al pasar el cursor sobre ellas */
    select#selE option:hover {
        background-color: #f2f2f2;
    }



    /* Estilo para el fondo del modal (fondo semi-transparente) */
    .modal-backdrop {
        background-color: rgba(255, 255, 255, 0.6) !important; /* Fondo semi-transparente */
    }

    /* Estilo para el contenido del modal (efecto glassmorphism) */
    .modal-content {
        background: rgba(255, 255, 255, 0.15); /* Fondo semi-transparente */
        backdrop-filter: blur(10px); /* Efecto de desenfoque */
        border: none; /* Sin borde */
        border-radius: 10px; /* Esquinas redondeadas */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra */
        padding: 20px; /* Espaciado interno */
        color: #333; /* Color del texto */
    }

    /* Estilo para el encabezado del modal */
    .modal-header {
        background: none; /* Fondo transparente */
        border: none; /* Sin borde */
        padding-bottom: 0; /* Sin espacio en la parte inferior */
    }

    /* Estilo para el botón de cierre (X) */
    .close {
        color: #333; /* Color del icono de cierre */
        opacity: 1; /* Opacidad completa */
        text-shadow: none; /* Sin sombra de texto */
        font-size: 24px; /* Tamaño del icono de cierre */
    }

    /* Estilo para el botón de registro */
    .btn-primary {
        background-color: #007BFF; /* Color de fondo */
        border-color: #007BFF; /* Color del borde */
        color: #fff; /* Color del texto */
        transition: background-color 0.3s, border-color 0.3s; /* Transición suave */
    }

    /* Estilo para el botón de registro al pasar el ratón */
    .btn-primary:hover {
        background-color: #0056b3; /* Color de fondo al pasar el ratón */
        border-color: #0056b3; /* Color del borde al pasar el ratón */
    }

    /* Estilo para el botón de registro al hacer clic */
    .btn-primary:active {
        background-color: #004299; /* Color de fondo al hacer clic */
        border-color: #004299; /* Color del borde al hacer clic */
    }


    .close {
        color: #333; /* Color del icono de cierre */
        opacity: 1; /* Opacidad completa */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Sombra de texto */
        font-size: 24px; /* Tamaño del icono de cierre */
        transition: color 0.3s; /* Transición de color suave */
    }

    /* Estilo para el botón de cierre al pasar el ratón */
    .close:hover {
        color: #ff0000; /* Cambia el color al pasar el ratón (ejemplo: rojo) */
        
    }


    .imagen-transparente {
                opacity: 0.5;}



                    /* Estilo de la imagen */
/* Estilo de la imagen */
.imagen {
   
   height: auto;
   transition: transform 0.3s ease, opacity 0.3s ease; /* Transiciones suaves para transform y opacidad */
}

/* Efecto de hover para la imagen */
.imagen:hover {
   transform: scale(1.1); /* Aumenta la imagen en un 10% */
   opacity: 0.7; /* Reduce la opacidad al 70% */
}

.row {
  display: flex;
  flex-direction: row;
}

@media screen and (max-width: 768px) {
  .row {
    flex-direction: column;
  }
}



</style>

<script>
        jQuery.fn.simulateKeyPress = function(character) {
            jQuery(this).trigger({
                type: 'keypress',
                which: character.charCodeAt(0)
            });
        };


        document.onkeypress = function(e) {

            e = e || window.event;
            var charCode = (typeof e.which == "number") ? e.which : e.keyCode;
            // store it , in this example, i use localstorage
            if (localStorage.getItem("card") && localStorage.getItem("card") != 'null') {
                // append on every keypress
                localStorage.setItem("card", localStorage.getItem("card") + String.fromCharCode(charCode));
            } else {
                // remove localstorage if it takes 300 ms (you can set it)
                localStorage.setItem("card", String.fromCharCode(charCode));
                setTimeout(function() {
                    if (localStorage.getItem("card").length != 8) {
                        localStorage.removeItem("card");
                    }
                }, 300);
            }
            // when reach on certain length within 300 ms, it is not typed by a human being
            if (localStorage.getItem("card").length == 10) {
                // do some validation
                var cardString = localStorage.getItem('card');

                insereixAutomarcatge(cardString, 4, 2);
            }
        }


        function insereixAutomarcatge(id, tipus, lng) {

            var avui = new Date();
            var any = avui.getFullYear();
            var mes = checkTime(avui.getMonth() + 1);
            var dia = checkTime(avui.getDate());
            var hora = checkTime(avui.getHours());
            var minut = checkTime(avui.getMinutes());
            var sec = checkTime(avui.getSeconds());
            var datahora = any + "-" + mes + "-" + dia + " " + hora + ":" + minut + ":" + sec  ; 

            document.getElementById('idEmp').value = "";
            $modal = $('#modMarcatge');
            $modal.modal('hide');

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    popupokhtml(this.responseText);
                }
                if (this.readyState == 4 && this.status == 300) {

                    popupokhtml(this.responseText);
                }
                if (this.readyState == 4 && this.status == 404) {
                    popupkohtml(this.responseText);
                }
            };
            xmlhttp.open("GET", "Serveis.php?action=insereixAutomarcatge&id=" + id + "&idtipus=" + tipus + "&datahora=" + datahora + "&lng=" + lng, true);
            xmlhttp.send();
        }

        var update_date = 30;

        function automarcatges(idempresa) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {

                }
                if (this.readyState === 4 && this.status === 404) {
                    popuphtml(this.responseText);
                }
            };
            xmlhttp.open("GET", "Serveis.php?action=automarcatges&1=" + idempresa, true);
            xmlhttp.send();
        }








        function carregaInicial(idempresa){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {

                }
                if (this.readyState === 4 && this.status === 404) {
                    popuphtml(this.responseText);
                }
            };
            xmlhttp.open("GET", "Serveis.php?action=carregaInicial&1="+idempresa, true);
            xmlhttp.send();
        }
        function logarse(user,password)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    window.location.reload(window.location);
                }
                if (this.readyState === 4 && this.status === 404) {
                    popupkohtml(this.responseText);
                }
            };
            xmlhttp.open("GET", "Serveis.php?action=logarse&user=" + user + "&pwd=" + password, true);
            xmlhttp.send();
        }
        function startTime(day,month,year) {
            try{
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                var d = today.getDate();
                var n = today.getMonth()+1;
                var y = today.getFullYear();
                if((h===0)&&(m===0)&&(s===0)){
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {

                            document.getElementById('datadia').innerHTML = this.responseText;
                        }
                        if (this.readyState === 4 && this.status === 404) {
                            popuphtml(this.responseText);
                        }
                    };
                    xmlhttp.open("GET", "Serveis.php?action=actualitzaData&day="+d+"&month="+n+"&year="+y, true);
                    xmlhttp.send();
                }
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('hora').innerHTML = h + ":" + m + ":" + s;

                //Update Date
                var data_dia = document.getElementById("datadia");
                if(typeof(data_dia) !== 'undefined' && data_dia !== null){
                    var date_text = data_dia.innerHTML;
                    var regex = /([a-zA-ZÀ-ÿ]*)(\s)(\d*)\s/gi;
                    match = regex.exec(date_text);
                    if( match[3] < d )
                    {
                        if(update_date <= 1)
                        {
                            window.location.reload(window.location);//Force reload to update date when day changes
                        }
                        else
                        {
                             update_date--;
                        }
                    }
                }

                setTimeout(function () {startTime(d,n,y);}, 500);

            }catch(err){alert(err);}
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        function insereixMarcatge(id,tipus,inout,lng)
        {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var avui = new Date();
                    var any = avui.getFullYear();
                    var mes = checkTime(avui.getMonth()+1);
                    var dia = checkTime(avui.getDate());
                    var hora = checkTime(avui.getHours());
                    var minut = checkTime(avui.getMinutes());
                    var sec = checkTime(avui.getSeconds());
                    var datahora = any + "-" + mes + "-" + dia + " " + hora + ":" + minut + ":" + sec  ; 

                    var lati = pos['lat'];
                    var long = pos['lng'];
                    document.getElementById('idEmp').value = "";
                    $modal = $('#modMarcatge');
                    $modal.modal('hide');

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            popupokhtml(this.responseText);
                        }
                        if (this.readyState == 4 && this.status == 300) {

                            popupokhtml(this.responseText);
                        }
                        if (this.readyState == 4 && this.status == 404) {
                            popupkohtml(this.responseText);
                        }
                    };
                    xmlhttp.open("GET", "Serveis.php?action=insereixMarcatge&id=" +id+ "&idtipus=" +tipus+ "&inout=" +inout+ "&datahora=" +datahora+ "&lng=" +lng+ "&utm_x=" +lati+ "&utm_y=" +long, true);
                    xmlhttp.send();
                }, function() {

                    navigator.permissions.query({name:'geolocation'})
                        .then(function(permissionStatus) {
                            popuphtml('geolocation permission state is ', permissionStatus.state);

                            permissionStatus.onchange = function() {
                                popuphtml('geolocation permission state has changed to ', this.state);
                            };
                        });
                });
            }
        }
        function popupokhtml(innerhtml)
        {
            document.getElementById("msgOk").innerHTML = innerhtml;
            $modal = $('#modMsgOk');
            $modal.modal('show');
            setTimeout(function() { $('#modMsgOk').modal('hide'); }, 4500);
        }
        function popupkohtml(innerhtml)
        {
            document.getElementById("msgKo").innerHTML = innerhtml;
            $modal = $('#modMsgKo');
            $modal.modal('show');
        }
        function popuphtml(innerhtml)
        {
            document.getElementById("msgConsole").innerHTML = innerhtml;
            $modal = $('#modConsole');
            $modal.modal('show');
        }
        function get_location()
        {

            navigator.permissions.query({name:'geolocation'})
                .then(function(permissionStatus) {
                    console.log('geolocation permission state is ', permissionStatus.state);

                    permissionStatus.onchange = function() {
                        console.log('geolocation permission state has changed to ', this.state);
                    };
                });
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };


                    window.open('https://www.google.com/maps/search/?api=1&query='+pos['lat']+","+pos['lng']);
                }, function() {

                    navigator.permissions.query({name:'geolocation'})
                        .then(function(permissionStatus) {
                            popuphtml('geolocation permission state is ', permissionStatus.state);

                            permissionStatus.onchange = function() {
                                popuphtml('geolocation permission state has changed to ', this.state);
                            };
                        });
                });
            } else {
                // Browser doesn't support Geolocation
                popuphtml('Error: The Geolocation service failed.');
            }
            //return pos;
        }
        function fpstartcheck(tipus,entsort,lng)
        {
            try{

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        popuphtml(this.responseText);

                    }
                    if (this.readyState == 4 && this.status == 404) {
                        popupkohtml(this.responseText);
                    }
                };
                xmlhttp.open("GET", "Serveis.php?action=startFPcheck", true);
                xmlhttp.send();
            }catch(err) {popuphtml(err);}
        }

        function sendMailRRHH (permitted)
        {
			if(permitted == 1)
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);

                    }
                    if (this.readyState == 4 && this.status == 404) {
                        console.log(this.responseText);
                    }
                };
                xmlhttp.open("GET", "Serveis.php?action=sendMailRRHH", true);
                xmlhttp.send();
            }
        }

    </script>


        
<?php
       
        $dto->navResolver();
        if(isset($_GET["idEmp"])) unset($_GET["idEmp"]);
        if(isset($_GET["idTipus"])) unset($_GET["idTipus"]); 
        $day = date('d',strtotime("today"));
        if(isset($_SESSION["day"])) $day = $_SESSION["day"];
        $month = date('m',strtotime("today"));
        if(isset($_SESSION["month"])) $month = $_SESSION["month"];
        $year = date('Y',strtotime("today"))-1;
       
        $d=strtotime("today");
?>

    </head>
    <body onload="startTime(<?php echo $day.",".$month.",".$year;?>);automarcatges(<?php echo $idempresa;?>);carregaInicial(<?php echo $idempresa;?>);" style="display: table; width: 100%; background-size: cover">
    






    <h2 id="datadia"><?php
    echo '<div style="margin-left: 53px;">' . $dto->__($lng, $dto->mostraNomDia((date("w", $d)))) . ", " . abs(date("d", $d)) . " " . $dto->__($lng, $dto->mostraNomMes(date("m", $d))) . " " . (date("Y", $d)) . "" . "  " . '<span id="hora"></span></div>';
?>
</h2>
       
<div style="width: 100%; text-align: center;">
    <hr style="border: 0.1px solid #d3d3d3; width: 95%; margin-top: 10px; margin-bottom: 100px;">
</div>

    <div class="row container" style="display: flex; width: 100%; background-size: cover ">
       <div class="col-xs-1"></div >
        <div class="col-xs-4" style="align-content: center">
            <center>
                <input class="imagen" type="image" id="entr1" entsort="0" <?php echo 'title='.'"'.$dto->__($lng,"Entrada Normal").'"'; ?> style="cursor:pointer" src="./Pantalles/img/powbutgreen.png" value="4" margin="0-auto" width="270px"><br><br><br>
           
                <table>
    <tbody>
        <?php
        if ($dto->getLogoidRealitza($idempresa, 1) != 0): ?>
            <tr>
                <td style="height: 55px; width: 98px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="0" title="<?= $dto->__($lng, "Tornada de") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 1))) ?>" style="cursor:pointer" src="<?= $dto->getLogoIn($idempresa, $dto->getLogoidRealitza($idempresa, 1)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 1) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 1))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 2) != 0): ?>
            <tr>
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="0" title="<?= $dto->__($lng, "Tornada de") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 2))) ?>" style="cursor:pointer" src="<?= $dto->getLogoIn($idempresa, $dto->getLogoidRealitza($idempresa, 2)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 2) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 2))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 3) != 0): ?>
            <tr>
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="0" title="<?= $dto->__($lng, "Tornada de") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 3))) ?>" style="cursor:pointer" src="<?= $dto->getLogoIn($idempresa, $dto->getLogoidRealitza($idempresa, 3)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 3) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 3))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 4) != 0): ?>
            <tr>  
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="0" title="<?= $dto->__($lng, "Tornada de") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 4))) ?>" style="cursor:pointer" src="<?= $dto->getLogoIn($idempresa, $dto->getLogoidRealitza($idempresa, 4)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 4) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 4))) ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table><br>
<br>

<div class="custom-select-container">
    <button class="well-sm custom-select-button" title="<?php echo $dto->__($lng, "Totes les Entrades"); ?>">
        <div class="custom-select-arrow"></div>
    </button>
    <select id="selE">
        <option disabled selected><?php echo $dto->__($lng, "Totes les Entrades"); ?></option>
        <?php
        if ($dto->teMenuActivitats($idempresa)) {
            $entrades = $dto->mostraTipusActivitatsEspecialsPerEmpresa($idempresa);
            foreach ($entrades as $entrada) {
                echo '<option value="' . $entrada["idtipusactivitat"] . '" nom="' . $dto->__($lng, $dto->getCampPerIdCampTaula("tipusactivitat", $entrada["idtipusactivitat"], "descripcio")) . '" data-toggle="modal" data-target="#modMarcatge">' . $dto->__($lng, $dto->getCampPerIdCampTaula("tipusactivitat", $entrada["idtipusactivitat"], "descripcio")) . '</option>';
            }
        }
        ?>
    </select>
</div>
            </center> 
       
        </div>





<div class="col-xs-2 hidden-xs" style="display: flex; justify-content: center; align-items: flex-start; padding-left: 20px; padding-right: 20px; margin-left: 20px; margin-right: 20px;">
<image class="imagen-transparente" src="./Pantalles/img/gorena.png" style=" width: 250px; height: auto;">

</div>


        <div class="col-xs-4">
        
            <center>
            <input class="imagen" type="image" id="sort1" entsort="1" <?php echo 'title='.'"'.$dto->__($lng,"Sortida Normal").'"'; ?> style="cursor:pointer" src="./Pantalles/img/powbutred.png" value="4" margin="0-auto" width="270px">

              
                <table>
                <br><br><br>
                    <tbody>
                    <tr>

                    <?php
        if ($dto->getLogoidRealitza($idempresa, 1) != 0): ?>
            <tr>
                <td style="height: 55px; width: 98px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="1" title="<?= $dto->__($lng, "Sortida per") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 1))) ?>" style="cursor:pointer" src="<?= $dto->getLogoOut($idempresa, $dto->getLogoidRealitza($idempresa, 1)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 1) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 1))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 2) != 0): ?>
            <tr>
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="1" title="<?= $dto->__($lng, "Sortida per") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 2))) ?>" style="cursor:pointer" src="<?= $dto->getLogoOut($idempresa, $dto->getLogoidRealitza($idempresa, 2)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 2) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 2))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 3) != 0): ?>
            <tr>
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="1" title="<?= $dto->__($lng, "Sortida per") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 3))) ?>" style="cursor:pointer" src="<?= $dto->getLogoOut($idempresa, $dto->getLogoidRealitza($idempresa, 3)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 3) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 3))) ?></td>
            </tr>
        <?php endif; ?>

        <?php
        if ($dto->getLogoidRealitza($idempresa, 4) != 0): ?>
            <tr>  
                <td style="height: 55px; width: 55px; text-align: center">
                    <input class="imagen" type="image" id="entr3" entsort="1" title="<?= $dto->__($lng, "Sortida per") . ' ' . $dto->__($lng, $dto->getDescidActivitat($dto->getLogoidRealitza($idempresa, 4))) ?>" style="cursor:pointer" src="<?= $dto->getLogoOut($idempresa, $dto->getLogoidRealitza($idempresa, 4)) ?>" value="<?= $dto->getidActivitatidRealitza($idempresa, 4) ?>" width="65px">
                </td>
                <td><?= $dto->__($lng, $dto->getNomidRealitza($dto->getLogoidRealitza($idempresa, 4))) ?></td>
            </tr>
        <?php endif; ?>
                    </tbody>
                </table><br><br>


                
                <?php 
                if($dto->teMenuActivitats($idempresa))
                {
                   
                }
}catch (Exception $ex) {echo $ex->getMessage;}
                ?> 


<div class="custom-select-container">
    <button class="well-sm custom-select-button-red" title="<?php echo $dto->__($lng, "Totes les Sortides"); ?>">
        <div class="custom-select-arrow"></div>
    </button>
    <select id="selE">
        <option disabled selected><?php echo $dto->__($lng, "Totes les Sortides"); ?></option>
        <?php
        if ($dto->teMenuActivitats($idempresa)) {
            $sortides = $dto->mostraTipusActivitatsEspecialsPerEmpresa($idempresa);
            foreach ($sortides as $sortida) {
                echo '<option value="' . $sortida["idtipusactivitat"] . '" nom="' . $dto->__($lng, $dto->getCampPerIdCampTaula("tipusactivitat", $sortida["idtipusactivitat"], "descripcio")) . '" data-toggle="modal" data-target="#modMarcatge">' . $dto->__($lng, $dto->getCampPerIdCampTaula("tipusactivitat", $sortida["idtipusactivitat"], "descripcio")) . '</option>';
            }
        }
        ?>
    </select>
</div>


            
            </center>
        <!--/section-->
        </div>




        <div class="modal fade" id="modMarcatge" role="dialog">
            <center>
            <div class="modal-dialog">                
              <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3  style="color:#333" name="tipus" id="tipus"></h3>
                </div>
                  <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Introdueixi el seu DNI o identificador o acosti la seva targeta al lector"); ?></h3><br>
                    <form name="marcacio" onsubmit="event.preventDefault();">
                    <label class="ui-hidden-accessible"><?php echo $dto->__($lng,"Identificador"); ?>:</label>
                    
                    <input type="hidden" name="idTipus" id="idTipus">
                    <input type="hidden" name="entsort" id="entsort">
                    <input type="password" name="idEmp" id="idEmp" value="" autofocus placeholder="<?php echo $dto->__($lng,"Identificador"); ?>" onkeydown="if (event.key === 'Enter') { try{insereixMarcatge(marcacio.idEmp.value,marcacio.idTipus.value,marcacio.entsort.value,<?php echo $lng;?>);}catch(err){alert(err);} return false; }" autocomplete="off"><br>
                    <br><a class="btn btn-primary" onclick="try{insereixMarcatge(marcacio.idEmp.value,marcacio.idTipus.value,marcacio.entsort.value,<?php echo $lng;?>);}catch(err){alert(err);}"><?php echo $dto->__($lng,"Registrar");?> <span class="glyphicon glyphicon-ok"></span></a>
                    <br>
                    </form>
                </div>
              </div>
            </div>
            </center>
        </div>
    </div>
    <script>
    $("#entr1, #entr2, #entr3, #entr4, #sort1, #sort2, #sort3, #sort4").on("click", function () {        
        var tipusMarcatge = $(this).attr("title");
        var idtipus = $(this).val();
        var entsort = $(this).attr("entsort");
        var element1 = document.getElementById("tipus");
        element1.innerHTML = tipusMarcatge;
        $('#idTipus').val(idtipus);
        $('#entsort').val(entsort);
        $modal = $('#modMarcatge');
        $modal.modal('show');
        });
    
    $("#selE").on("change", mostrapopup0);
    $("#selS").on("change", mostrapopup1);
    
    function mostrapopup0() {        
        var tipusMarcatge = $('option:selected', this).attr('nom');
        var idtipus = $(this).val();
        var element1 = document.getElementById("tipus");
        element1.innerHTML = tipusMarcatge;
        $('#idTipus').val(idtipus);
        $('#entsort').val(0);
        $modal = $('#modMarcatge');
        $modal.modal('show');
        }
        
    function mostrapopup1() {        
        var tipusMarcatge = $('option:selected', this).attr('nom');
        var idtipus = $(this).val();
        var element1 = document.getElementById("tipus");
        element1.innerHTML = tipusMarcatge;
        $('#idTipus').val(idtipus);
        $('#entsort').val(1);
        $modal = $('#modMarcatge');
        $modal.modal('show');
        }
        
    $('#modMarcatge').on('shown.bs.modal', function(){
  $('#idEmp').focus();
});
    </script>
    <div class="modal fade" id="modMsgOk" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <h3 style="font-size: 28px"><span class="glyphicon glyphicon-ok" style="color: green;"></span><br><br><?php echo $dto->__($lng,"Marcatge Correcte");?></h3><br><br>
                    <p id="msgOk" style="font-size: 20px"></p><br>                   
                </div>
              </div>
            </div>                
            </center>
    </div>
    <div class="modal fade" id="modMsgKo" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgKo" style="font-size: 28px"></label><br><br>
                    <?php echo $dto->__($lng,"Torneu-ho a provar o contacteu amb Recursos Humans");?><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 28px"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    <div class="modal fade" id="modContent"></div>
        <div class="modal fade" id="modContentAux"></div>
        <div class="modal fade" id="modFlash"></div>
        <div class="modal fade" id="modMessage" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 28px"></label><br><br>
                    <button type="button" class="btn btn-default" autofocus data-dismiss="modal"><?php echo "Aceptar";?></button>                     
                </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modInfo" role="dialog">
            <center>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style='background-color: lavender'>
                        <div class="row">
                            <div class="col-lg-2"><img src="./img/g3sminilogo.jpg" style="witdh: 100%; max-height: 80px"/></div>
                            <div class="col-lg-8"><h3><span class="glyphicon glyphicon-info-sign"></span> Información</h3></div>
                            <div class="col-lg-2"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label style="font-size: large" id="msgInfo"></label><br><br>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Cerrar";?></button>                     
                    </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modWait" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    
                    <div class="modal-body">
                        <h1>Cargando</h1>
                        <img src="./img/Loading_icon.gif" style="height: 200px; width: 280px">
                                    
                    </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modWaitMsg" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  
                    <div class="modal-body">
                        <h1 id="waitMsg"></h1>
                        <img src="./img/Loading_icon.gif" style="height: 200px; width: 280px">
                                
                    </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modExpire" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  
                    <div class="modal-body">
                        <h3>La sesión ha expirado!</h3>                        
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Aceptar";?></button>                     
                    </div>
              </div>
            </div>                
            </center>
        </div>
        <div class="modal fade" id="modLoad" role="dialog">
            <center>
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole" style="font-size: 28px">Subiendo...</label><br>
                                  
                </div>
              </div>
            </div>                
            </center>
        </div>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>






    </body>
</html>