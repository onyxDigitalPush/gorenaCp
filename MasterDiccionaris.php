<!DOCTYPE html>
<html>
    <head>
        <?php include './Pantalles/HeadGeneric.html'; ?>
        <script>
            function afegeixTraduccio(idenunciat,ididioma,textvell,textnou)
            {
               
                if(textvell === textnou) return false;    
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {                    
                    
                }
                };
                xmlhttp.open("GET", "Serveis.php?action=afegeixTraduccio&idenunciat=" + idenunciat + "&ididioma=" + ididioma + "&traduccio=" + textnou, true);
                xmlhttp.send();
            }
            function nouEnunciat(text)
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {                    
                    window.location.reload(window.location);
                }
                };
                xmlhttp.open("GET", "Serveis.php?action=nouEnunciat&text=" + text, true);
                xmlhttp.send();
            }
            function popuphtml(innerhtml)
            {
                document.getElementById("msgConsole").innerHTML = innerhtml;
                $modal = $('#modConsole');
                $modal.modal('show');
            }
            </script>
    </head> 
    <body>
        <?php
        include 'autoloader.php';
        $dto = new AdminApiImpl();
        session_start();
        $lng = 0;
        if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
        $dto->navResolver();
        ?>
    <center>
        <h3><?php echo $dto->__($lng,"Edició dels Diccionaris"); ?></h3><br>
        <div class="container well">
            <br>
            <form name="nouenunciat"><input type="text" name="enunciat" placeholder="<?php echo $dto->__($lng,"Nou Enunciat"); ?>"><button class="btn btn-success btn-sm" onclick="nouEnunciat(nouenunciat.enunciat.value);"><span class="glyphicon glyphicon-plus"></span> <?php echo $dto->__($lng,"Afegeix Enunciat"); ?></button></form>
            <br><br>
            <table class="table-hover table-bordered table-condensed">
                <thead style="width: 80%"><th><?php echo $dto->__($lng,"Enunciats"); ?> (<?php echo $dto->__($lng,"Català"); ?>)</th><th><?php echo $dto->__($lng,"Castellà"); ?></th><th><?php echo $dto->__($lng,"Anglès"); ?></th><th>(Idioma a definir)</th></thead>
            <tbody>
                <?php
                $enunciats = $dto->mostraEnunciatsWeb();
                foreach ($enunciats as $enunciat) echo '<tr><td><input type="text" data-old_value="'.$enunciat["text"].'" value="'.$enunciat["text"].'" '
                        . 'onblur="actualitzaCampTaula('."'enunciat','text',".$enunciat["idenunciat"].',this.getAttribute('."'data-old_value'".'),this.value);"></td>'
                        . '<td><input type="text" data-old_value="'.$dto->getTraduccioPerIdEnunciat($enunciat["idenunciat"],2).'" value="'.$dto->getTraduccioPerIdEnunciat($enunciat["idenunciat"],2).'" '
                        . 'onblur="afegeixTraduccio('.$enunciat["idenunciat"].',2,this.getAttribute('."'data-old_value'".'),this.value);"></td>'
                        . '<td><input type="text" data-old_value="'.$dto->getTraduccioPerIdEnunciat($enunciat["idenunciat"],3).'" value="'.$dto->getTraduccioPerIdEnunciat($enunciat["idenunciat"],3).'" '
                        . 'onblur="afegeixTraduccio('.$enunciat["idenunciat"].',3,this.getAttribute('."'data-old_value'".'),this.value);"></td>'
                        . '<td><input type="text" value=""></td>'
                        . '</tr>';
                ?>
            </tbody>
            </table><br>
        </div>
    </center>   
    <div class="modal fade" id="modConsole" role="dialog">
        <center>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <label id="msgConsole"></label><br><br>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $dto->__($lng,"Tornar"); ?></button>                    
            </div>
          </div>
        </div>                
        </center>
    </div>    
    </body>
</html>
