<!DOCTYPE html>
<html>
    <head>
        <?php 
        session_start();
        include './Pantalles/HeadGeneric.html';
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        $dto->navResolver(); 
        ?>
    <script type="text/javascript">
        function mostraTornsPerId(id,idhorari)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("modTorns").innerHTML = this.responseText;
                $modal = $('#modTorns');
                $modal.modal('show'); 
            }
            };
            xmlhttp.open("GET", "ModalTorns.php?id=" + id + "&idhorari=" + idhorari, true);
            xmlhttp.send();
        }
        
        function assignaHorariTipus(id,idtipus,datainici,datafi)
        {   
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaHorariTipus&id=" + id + "&idtipus=" + idtipus + "&datainici=" + datainici + "&datafi=" + datafi, true);
            xmlhttp.send();
        }
        
        function editaPeriodeHorari(idquadrant,idtipus,novadataini,novadatafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=editaPeriodeHorari&idquadrant=" + idquadrant + "&idtipus=" + idtipus + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
            xmlhttp.send();
        }        
        
        function mostraPeriodeHorari(idquadrant,idtipus,dataini,datafi) 
        {        
        $('#datainici').val(dataString(dataini));
        $('#datafi').val(dataString(datafi));
        $('#idnouhorari').val(idtipus);
        $('#idquadrant').val(idquadrant);
        $modal = $('#modEditaPeriodeHorariTipus');
        $modal.modal('show');
        }
        
        function confElimPeriodeHorari(idquadrant,nomhorari) 
        {
           
        document.getElementById("tipushorariaelim").innerHTML = nomhorari+"?";
        $('#idhorariaelim').val(idquadrant);
        $modal = $('#modConfElimPeriodeHorari');
        $modal.modal('show');
        }
        
        function eliminaPeriodeHorari(idquadrant)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaPeriodeHorari&idquadrant=" + idquadrant, true);
            xmlhttp.send();
        }
    
        
        
        function assignaExcep(id,idtipus,dataini,datafi)
        {
           
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=assignaExcep&id=" + id + "&idtipus=" + idtipus + "&dataini=" + dataini + "&datafi=" + datafi, true);
            xmlhttp.send();
        }

        function ModSolcExepct(formCont,SolictID)
        {

            try {
                const inpFile = formCont.querySelector('[id="FilesSelect2"]').files
                const tipusdata = formCont.querySelector('[name="tipusExcepM"]').value
                    
                const tipus =  tipusdata.split('|',2)

                const cantFiles  = formCont.querySelector('[id="TableFiles"]').rows.length

                if (tipus[1] == '1'){
                    if(inpFile.length == 0) {
                        if ( cantFiles == '1'){
                            alert(formCont.querySelector('[name="MSJrequiredDoc"]').value)
                            return
                        }
                    
                    } 
                }

                const dataini = formCont.querySelector('[name="datainiexcepM"]').value
                const datafi = formCont.querySelector('[name="datafiexcepM"]').value
                const idempleat = formCont.querySelector('[name="idempleat"]').value
                const formData = new FormData()

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
                xhr.open('POST', "Serveis.php?action=ModSolicitexcep&id=" + SolictID + "&idtipus=" + tipus[0] + "&dataini=" + dataini + "&datafi=" + datafi+ "&idEncargado=" + idempleat, true)
                xhr.send(formData)

            } catch (error) {
                alert(error);
            }
            
           
        }

        function DeleteDocument(File,ctrlthis){

            try {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "Serveis.php?action=DeleteFile&FilePath=" + File, true);
                xmlhttp.send();
                
                row = ctrlthis.parentNode;
                row = row.parentNode;
                row.parentNode.removeChild(row);

            } catch (error) {
                alert(error);
            }

            
            return false;

        }
        
        function editaExcep(idexcep,noutipus,novadataini,novadatafi)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=editaExcep&idexcep=" + idexcep + "&tipus=" + noutipus + "&dataini=" + novadataini + "&datafi=" + novadatafi, true);
            xmlhttp.send();
        }
        
        function confElimExcep(idexcep) 
        {
        var nomexcep = document.getElementById("nomexcep"+idexcep+"").innerHTML;
        document.getElementById("tipusexcepaelim").innerHTML = nomexcep+"?";
        $('#idexcepaelim').val(idexcep);
        $modal = $('#modConfElimExcep');
        $modal.modal('show');
        }
        
        function eliminaExcep(idexcep)
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                window.location.reload(window.location);
            }
            };
            xmlhttp.open("GET", "Serveis.php?action=eliminaExcep&idexcep=" + idexcep, true);
            xmlhttp.send();
        }
        
        


    </script>


    </head>
    <body style="display: table; position: absolute; top: 0px; bottom: 0px; margin: 0; width: 100%; height: 100%;">
        <div class="modal fade" id="modContent"></div>
        <?php
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $id = $_GET["id"];
        $idempresa=$_SESSION["idempresa"];
        $anys = $dto->mostraAnysContractePerId($id);
        $d = strtotime("now");
        if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
        $any = $_GET["any"];
        $diesespecials1s = array_fill(0,4,0);
        $diesespecials2s = array_fill(0,4,0);
        $diesespecialsmes1s = array_fill(0,4,0);
        $diesespecialsmes2s = array_fill(0,4,0);
        ?>
        <center>            
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 well">
                <div class="col-lg-4" style="text-align: left">
                    <form action="EmpleatCalendari.php" method="GET">
                    <h2 class="etiq"><?php echo $dto->__($lng,"Calendari Anual"); ?> <select name="any" id="LlistaAnys" onchange="this.form.submit()">
                    <option hidden selected value><?php echo $any; ?></option>
                    <?php
                    $toyear = date('Y',strtotime('today'));
                    for($year=2017;$year<=($toyear+1);$year++)
                    
                    {
                        echo '<option value:"'.$year.'">'.$year.'</option>';
                    }
                    $horesteoany = 0.0;
                    $year = $any;
                    $datateoriques = date('Y-m-d',strtotime($year.'-01-01'));
                    while(date('Y',strtotime($datateoriques))==$year) {
                        $horesteoany += $dto->seleccionaHoresTeoriquesPerIdDia($id, $datateoriques);
                        $datateoriques = date('Y-m-d',strtotime($datateoriques.' + 1 days'));
                    }
                    ?>
                    </select></h2>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    </form>            
                </div>
                <div class="col-lg-4">
                    <h3 class="etiq"><?php echo $dto->mostraNomEmpPerId($id);?></h3><br><br>
                    <label class="smtag"><?php echo $dto->__($lng,"Hores")." ".$dto->__($lng,"Teòriques")." ".$dto->__($lng,"any")." ".$year;?>:</label> <strong class="smtag"><?php echo number_format($horesteoany,1,",",".");?> h</strong>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3" style="text-align: right">
                    <form method="get">
<!-------------------------------------Comento esta seccion por peticios del cliente de eliminar estos botones, pero lo comento por si mas adelante los necesitan nuevamente  

                    <button type="submit" formaction="EmpleatFitxa.php" class="btn btn-default btn-lg" name="id" value="<?php echo $id;?>" title="<?php echo $dto->__($lng,"Fitxa");?>"><span class="glyphicon glyphicon-user"></span></button>
                    <button type="submit" formaction="EmpleatMarcatges.php" class="btn btn-warning btn-lg" name="id" value="<?php echo $id; ?>" title="<?php echo $dto->__($lng,"Marcatges");?>"><span class="glyphicon glyphicon-list"></span></button>
                    <a class="btn btn-default btn-lg" href='index.php' title="<?php echo $dto->__($lng,"Inici");?>"><span class="glyphicon glyphicon-home"></span></a>

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                </form>
                </div>
            </div>
        </div>   
        
        
        <div class="row" style="position: absolute; top: 100%; display: none;">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 well">
            <div class="container"  style="min-width: 1200px;">  
                <?php for($i=1;$i<=6;$i++) {$diesespecialsmes1s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                        $diesespecials1s[0]+=$diesespecialsmes1s[0];
                        $diesespecials1s[1]+=$diesespecialsmes1s[1];
                        $diesespecials1s[2]+=$diesespecialsmes1s[2];
                        $diesespecials1s[3]+=$diesespecialsmes1s[3];}
                ?>       
            </div><br>
            <div class="container" style="min-width: 1200px;">
                <?php for($i=7;$i<=12;$i++) {$diesespecialsmes2s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                        $diesespecials2s[0]+=$diesespecialsmes2s[0];
                        $diesespecials2s[1]+=$diesespecialsmes2s[1];
                        $diesespecials2s[2]+=$diesespecialsmes2s[2];
                        $diesespecials2s[3]+=$diesespecialsmes2s[3];}            
                ?>        
            </div><!br>
            </div>
        </div>



      








        <div class="container well" style="min-width: 1200px; position: relative;">
        <section style="width:50%; float:left; ">
            <center>
                <label class="etiq"><?php echo $dto->__($lng,"Històric d'Horaris");?>:</label><br><br>               
                <div style="border:solid grey 1px">
                <table class="table table-striped table-hover table-condensed" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Inici");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Final");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Hr/St");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Tipus");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Vigent");?></th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?php
                            $horari = $dto->seleccionaHorarisEmpPerId($id);
                            foreach($horari as $period)
                            {
                                echo '<tr>';
                                echo '<td>'.date('d/m/Y',strtotime($period["datainici"])).'</td>';
                                echo '<td>'.date('d/m/Y',strtotime($period["datafi"])).'</td>';
                                echo '<td>'.$period["horesetmana"].'</td>';
                                echo '<td>'.$period["nom"].'</td>';
                                echo '<td>'.$dto->__($lng,$dto->dirsiono($period["actiu"])).'</td>';
                                echo '<td>'
                                    . '<button type="button" class="btn btn-xs btn-default" title="'.$dto->__($lng,"Veure Torns").'" onclick="mostraTornsPerId('.$id.','.$period["idhorari"].')">'
                                    . '<span class="glyphicon glyphicon-zoom-in"></span></button>';
                                    
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div><br>
               
        </center>
        </section>
            <section style="width:45%; float:right">
                <center>
                    <label class="etiq"><?php echo $dto->__($lng,"Períodes Especials");?>:</label><br><br>
                    <div style="border:solid grey 1px">
                <table class="table table-condensed table-striped table-hover" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Inici");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Final");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Tipus");?></th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?php
                            $excepcions = $dto->seleccionaExcepcionsEmpPerId($id);
                            foreach($excepcions as $periode)
                            {
                                $tipus = $periode["nom"];
                                $inicial = substr($periode["nom"],0,4);
                                if($tipus=="Vacances") echo '<tr style="background-color: rgb(128,255,255)">';
                                else if($inicial=="Baix") echo '<tr style="background-color: rgb(255,128,128)">';
                                else if(($inicial=="Perm")||($inicial=="Exce")) echo '<tr style="background-color: rgb(128,255,128)">';
                                else if(($inicial=="Assu")||($inicial=="Mala")) echo '<tr style="background-color: rgb(255,255,128)">'; // verde
                                else echo '<tr>';
                                echo '<td>'.date('d/m/Y',strtotime($periode["datainici"])).'</td>';
                                echo '<td>'.date('d/m/Y',strtotime($periode["datafinal"])).'</td>';
                                echo '<td id="nomexcep'.$periode["idexcepcio"].'">'.$dto->__($lng,$tipus).'</td>';
                               
                                echo '</tr>'; 
                            }
                           
                            ?>
                        </tbody>
                    </table>
                    </div><br>
                    </center>
            </section>

            <section style="width:45%; float:right">
                <center>
                    <label class="etiq"><?php echo $dto->__($lng,"Periodos Solicitados");?>:</label><br><br>
                    <div style="border:solid grey 1px">
                <table class="table table-condensed table-striped table-hover" style="text-align: center">
                        <thead>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Inici");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Final");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Tipus");?></th>
                        <th style="text-align: center"><?php echo $dto->__($lng,"Estado");?></th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?php
                            $excepcions = $dto->seleccionaSolictExcepcionsEmpPerId($id);
                            $excepcions = $dto->seleccionaSolictExcepcionsEmpPerId($id);
                            foreach($excepcions as $periode)
                            {
                                $tipus = $periode["nom"];
                                $inicial = substr($periode["nom"],0,3);
                                $datafi = "";
                                if(strtotime($periode["datafinal"])>=strtotime($periode["datainici"])) $datafi = date('d/m/Y',strtotime($periode["datafinal"]));
                            
                                $estado = $dto->__($lng, "Pendiente");
                                if($periode["aprobada"] == '1') $estado = $dto->__($lng, "aprobada");
                                else if($periode["aprobada"] == '0') $estado = $dto->__($lng, "Denegada");
                            
                                $background_color = "";
                                if($estado == $dto->__($lng, "aprobada")) $background_color = "background-color: rgb(128,255,128)";//verde
                                else if($estado == $dto->__($lng, "Pendiente")) $background_color = "background-color: rgb(255,135,50)";//naranja
                                else if($estado == $dto->__($lng, "Denegada")) $background_color = "background-color: rgb(255,56,36)";//rojo
                               
                            
                                echo '<tr style="'.$background_color.'">';
                                echo '<td>'.date('d/m/Y',strtotime($periode["datainici"])).'</td>';
                                echo '<td>'.$datafi.'</td>';
                                echo '<td id="nomexcep'.$periode["idexcepcio"].'">'.$dto->__($lng,$tipus).'</td>';
                                echo '<td>'.$dto->__($lng,$estado).'</td>';
                                echo '<td style="background-color: rgb(255,255,255)">';
                                echo '<button class="btn btn-xs btn-default" onclick="VerSolicExcep('.$periode["idexcepcio"].','.$periode["idtipusexcep"].",'".$periode["datainici"]."','".$periode["datafinal"]."'".','.$periode["idresp"].','.$id.');"><span class="glyphicon glyphicon-eye-open"  title="'.$dto->__($lng,"Ver solicitud de periodo").'"></span></button>';
                                if(is_null($periode["aprobada"])){
                                    echo '<button class="btn btn-xs btn-default" onclick="EditSolicExcep('.$periode["idexcepcio"].','.$periode["idtipusexcep"].",'".$periode["datainici"]."','".$periode["datafinal"]."'".','.$periode["idresp"].');">';
                                    echo '<span class="glyphicon glyphicon-pencil" style="color:black" title="'.$dto->__($lng,"Editar solicitud Període").'"></span></button>';
                                    echo '<button class="btn btn-xs btn-default" onclick="confElimExcep('.$periode["idexcepcio"].');"><span class="glyphicon glyphicon-remove" style="color:red" title="'.$dto->__($lng,"Eliminar solicitud Període").'"></span></button>';
                                }
                                echo '</td></tr>';
                            }
                            
                        
                            ?>
                        </tbody>
                    </table>
                    </div><br>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#modSolictNouPeriodeEspecial"><span class="glyphicon glyphicon-plus"></span> <?php echo $dto->__($lng,"Solicitar Nuevo");?></a>
                </center>
            </section>

        </div>




        <?php 
        $diesbaixa = $diesespecials1s[0]+$diesespecials2s[0];
        if($diesbaixa>0) echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb(255,128,128)"></span> '.$dto->__($lng,"Dies de baixa any").' '.$any.' (1S: '.$diesespecials1s[0].' / 2S: '.$diesespecials2s[0].') Total: '.$diesbaixa.'</label><br>';
        $diesvacances = $diesespecials1s[1]+$diesespecials2s[1];
        if($diesvacances>0) echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb(128,255,255)"></span> '.$dto->__($lng,"Dies de vacances any").' '.$any.' (1S: '.$diesespecials1s[1].' / 2S: '.$diesespecials2s[1].') Total: '.$diesvacances.'</label><br>';
        $diespermis = $diesespecials1s[2]+$diesespecials2s[2];
        if($diespermis>0) echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb(128,255,128)"></span> '.$dto->__($lng,"Dies de permís any").' '.$any.' (1S: '.$diesespecials1s[2].' / 2S: '.$diesespecials2s[2].') Total: '.$diespermis.'</label><br>';
        $diespersonals = $diesespecials1s[3]+$diesespecials2s[3];
        if($diespersonals>0) echo '<label><span class="glyphicon glyphicon-stop" style="color: rgb(255,255,128)"></span> '.$dto->__($lng,"Dies personals any").' '.$any.' (1S: '.$diesespecials1s[3].' / 2S: '.$diesespecials2s[3].') Total: '.$diespersonals.'</label><br>'; 
        ?>        
        <!--br><br><br-->
        </center>


        <!br>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 well">
            <div class="container"  style="min-width: 1200px;">  
                <?php for($i=1;$i<=6;$i++) {$diesespecialsmes1s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                        $diesespecials1s[0]+=$diesespecialsmes1s[0];
                        $diesespecials1s[1]+=$diesespecialsmes1s[1];
                        $diesespecials1s[2]+=$diesespecialsmes1s[2];
                        $diesespecials1s[3]+=$diesespecialsmes1s[3];}
                ?>       
            </div><br>
            <div class="container" style="min-width: 1200px;">
                <?php for($i=7;$i<=12;$i++) {$diesespecialsmes2s=$dto->imprimeixMesPerIdAnyMes($id,$any,$i,16.66,$lng); 
                        $diesespecials2s[0]+=$diesespecialsmes2s[0];
                        $diesespecials2s[1]+=$diesespecialsmes2s[1];
                        $diesespecials2s[2]+=$diesespecialsmes2s[2];
                        $diesespecials2s[3]+=$diesespecialsmes2s[3];}            
                ?>        
            </div><!br>
            </div>
        </div>        
            <br>
            <center>    
            <form method="get" action="EmpleatFitxa.php">
                <button type="submit" class="btn btn-default" name="id" value="<?php echo $id;?>"><span class="glyphicon glyphicon-user"></span> <?php echo $dto->__($lng,"Fitxa");?></button>
            </form>
            <br>
        </center>
    <div class="modal fade" id="modTorns" role="dialog">
            
    </div>        
    <div class="modal fade" id="modAssignaNouHorariTipus" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Assignar Nou Horari per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="assignahoraritipus">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" name="datainici" required>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select name="idnouhorari">
                    <?php
                        $tipus = $dto->seleccionaHorarisActiusEmpresa($idempresa);
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="assignaHorariTipus(<?php echo $id; ?>,assignahoraritipus.idnouhorari.value,assignahoraritipus.datainici.value,assignahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Assignar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modEditaPeriodeHorariTipus" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Editar Període Horari per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editahoraritipus">
                    <input type="hidden" id="idquadrant" name="idquadrant">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainici" name="datainici" required>
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafi" name="datafi"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select id="idnouhorari" name="idnouhorari">
                    <?php
                        $tipus = $dto->seleccionaTipusHoraris($idempresa);
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idhoraris"].'">'.$valor["nom"].'</option>';
                        }
                    ?>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="editaPeriodeHorari(editahoraritipus.idquadrant.value,editahoraritipus.idnouhorari.value,editahoraritipus.datainici.value,editahoraritipus.datafi.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
  


<?php
if(isset($_GET['openModal']) && $_GET['openModal'] == 'true'){
    echo "<script>$(document).ready(function() { $('#modSolictNouPeriodeEspecial').modal('show'); });</script>";
}
?>




<div class="modal fade" id="modSolictNouPeriodeEspecial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <h4 class="modal-title"><?php echo $dto->__($lng,"Solicitar nuevo periodo especial");?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="assignaexcep" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
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
                        <select class="form-control" name="idempleat" required>
                            <?php
                            $tipus = $dto->seleccionaEncargadosDep($id);
                            foreach($tipus as $valor)
                            {
                                echo '<option value="'.$valor["idempleat"].'">'.$valor["nom"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?php echo $dto->__($lng,"Archivos");?>:</label>
                        <input type="file" name="inpFile[]" id="FilesSelect" multiple>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span



 class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="submit" role="button" class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Solicitar");?></button>
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
                            xhr.open('POST', "Serveis.php?action=Solicitexcep&id=" + id + "&idtipus=" + tipus[0] + "&dataini=" + dataini + "&datafi=" + datafi+ "&idEncargado=" + idempleat, true)
                            xhr.send(formData)


                            })
                    </script>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimPeriodeHorari" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Eliminar Període Horari");?></h3><br>
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar aquest període horari de");?> <span id="tipushorariaelim"></span></h4>
                    <br><br>
                    <form name="eliminaperiodehorari">
                    <input type="hidden" id="idhorariaelim" name="idhorariaelim">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaPeriodeHorari(eliminaperiodehorari.idhorariaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    <div class="modal fade" id="modExcep" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $dto->__($lng,"Editar Període Especial per a");?>:</h4>
                    <h3><?php echo $dto->mostraNomEmpPerId($id);?></h3><br>
                    <form name="editaexcep">
                    <input type="hidden" id="idExcep" name="idExcep">
                    <label><?php echo $dto->__($lng,"Data Inici");?>:</label><input type="date" id="datainiexcep" name="datainiexcep">
                    <label><?php echo $dto->__($lng,"Data Fi");?>:</label><input type="date" id="datafiexcep" name="datafiexcep"><br><br>
                    <label><?php echo $dto->__($lng,"Tipus");?>:</label>
                    <select id="tipusExcep" name="tipusExcep">
                    <?php
                        $tipus = $dto->seleccionaTipusExcepcions();
                        foreach($tipus as $valor)
                        {
                            echo '<option value="'.$valor["idtipusexcep"].'">'.$dto->__($lng,$valor["nom"]).'</option>';
                        }
                    ?>
                    </select>
                    <br><br><button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="editaExcep(editaexcep.idExcep.value,editaexcep.tipusExcep.value,editaexcep.datainiexcep.value,editaexcep.datafiexcep.value);"><span class="glyphicon glyphicon-ok"></span> <?php echo $dto->__($lng,"Modificar");?></button>
                    </form>
                </div>
              </div>
            </div>
            </center>
    </div>
    <div class="modal fade" id="modConfElimExcep" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3><?php echo $dto->__($lng,"Eliminar solicitud de periodo");?></h3><br>
                    <h4><?php echo $dto->__($lng,"Està segur d'eliminar solicitud de periodo de");?> <span id="tipusexcepaelim"></span></h4>
                    <br><br>
                    <form name="eliminaexcep">
                    <input type="hidden" id="idexcepaelim" name="idexcepaelim">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Cancel·lar");?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="eliminaExcep(eliminaexcep.idexcepaelim.value);"><?php echo $dto->__($lng,"Eliminar");?></button>
                    </form>
                </div>
              </div>
            </div>
                
            </center>
    </div>
    <div class="modal fade" id="modConsole" role="dialog">
            <center>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <label id="msgConsole"></label><br><br>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar");?></button>                    
                </div>
              </div>
            </div>                
            </center>
    </div>
    </body>
    
</html>
