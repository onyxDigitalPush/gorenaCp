var loc = window.location.href+'';
if (loc.indexOf('http://')==0){
    window.location.href = loc.replace('http://','https://');
}
var refreshTime = 600000; // every 10 minutes in milliseconds
window.setInterval( function() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "Check.php",
        success: function(data) {
        }
    });
}, refreshTime );
var now = new Date();
var night = new Date(
    now.getFullYear(),
    now.getMonth(),
    now.getDate() + 1, // the next day, ...
    0, 0, 0 // ...at 00:00:00 hours
);
var msTillMidnight = night.getTime() - now.getTime();
setTimeout('document.location.refresh()', msTillMidnight);

function modaldrag(){
    $(".modal-header").on("mousedown", function(mousedownEvt) {
        var $draggable = $(this);
        var x = mousedownEvt.pageX - $draggable.offset().left,
            y = mousedownEvt.pageY - $draggable.offset().top;
        $("body").on("mousemove.draggable", function(mousemoveEvt) {
            $draggable.closest(".modal-dialog").offset({
                "left": mousemoveEvt.pageX - x,
                "top": mousemoveEvt.pageY - y
            });
        });
        $("body").one("mouseup", function() {
            $("body").off("mousemove.draggable");
        });
        $draggable.closest(".modal").one("bs.modal.hide", function() {
            $("body").off("mousemove.draggable");
        });
    });
}
function DoubleScroll(element,emargin) {            
    var scrollbar = document.createElement('div');
    scrollbar.appendChild(document.createElement('div'));
    scrollbar.style.overflow = 'auto';
    scrollbar.style.overflowY = 'hidden';
    
    var ewidth = element.scrollWidth+emargin;
    scrollbar.firstChild.style.width = ewidth+'px';
    scrollbar.firstChild.style.paddingTop = '1px';
    scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
    scrollbar.onscroll = function() {
        element.scrollLeft = scrollbar.scrollLeft;
    };
    element.onscroll = function() {
        scrollbar.scrollLeft = element.scrollLeft;
    };
    element.parentNode.insertBefore(scrollbar, element);
    
}

function changeSessionIdempresa(idempresa)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=changeSessionIdempresa&1="+idempresa, true);
    xmlhttp.send();
}
function actualitzaCampTaula(taula,camp,idreg,valorvell,valornou)
{
    if(valorvell === valornou) return false;    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
       
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=actualitzaCampTaula&taula=" + taula + "&camp=" + camp + "&idreg=" + idreg + "&valor=" + valornou, true);
    xmlhttp.send();
}
function actualitzaCampTaulaNR(taula,camp,idreg,valorvell,valornou)
{
    if(valorvell === valornou) return false;    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
       
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=actualitzaCampTaula&taula=" + taula + "&camp=" + camp + "&idreg=" + idreg + "&valor=" + valornou, true);
    xmlhttp.send();
}
function actualitzaNCampTaulaNR(taula,camp,idreg,valornou)
{    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=actualitzaCampTaula&taula=" + taula + "&camp=" + camp + "&idreg=" + idreg + "&valor=" + valornou, true);
    xmlhttp.send();
}
function actualitzaChkCampTaula(camp,taula,idreg,valor)
{
    var valorint = 0;
    if(valor===true) valorint = 1;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=actualitzaCampTaula&taula=" + taula + "&camp=" + camp + "&idreg=" + idreg + "&valor=" + valorint, true);
    xmlhttp.send();
}
function actualitzaChkExisteixCampTaula(htmlid,camp,taula,idreg,valorvell,valor)
{
    if(valorvell === valor) return false;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById(htmlid).setAttribute("data-old_value",valor);
        
    }
    if (this.readyState === 4 && this.status === 300) {
        popuphtml(this.responseText);
        document.getElementById(htmlid).value = valorvell;
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=actualitzaChkExisteixCampTaula&taula=" + taula + "&camp=" + camp + "&idreg=" + idreg + "&valor=" + valor, true);
    xmlhttp.send();
}
function mostraCarregaExcel()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModalUploadExcel.php", true);
    xmlhttp.send();
}
function mostraLlegeixExcel()
{
    try{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModalLlegeixExcel.php", true);
    xmlhttp.send();
}catch(err){alert(err);}
}
function mostraCarregaQuadrantMes(any,mes,idsubemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModalUploadQuadrant.php?1="+any+"&2="+mes+"&3="+idsubemp, true);
    xmlhttp.send();
}
function mostraNouMarcatgeObs(id,data)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modNouMarcatge").innerHTML = this.responseText;
        $modal = $('#modNouMarcatge');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModNouMarcatgeObs.php?&1="+id+"&2="+data, true);
    xmlhttp.send();
}
function insereixMarcatgeObs(id,entsort,tipus,data,hora,obs)
{
    obs = tipus;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
       
    }
    if (this.readyState === 4 && this.status === 300) {
        popuphtml(this.responseText);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=insereixMarcatgeObs2&id=" +id+ "&entsort=" +entsort+ "&tipus=" +tipus+ "&data=" +data+ "&hora=" +hora+ "&obs=" + obs, true);
    xmlhttp.send();
}
function mostraEditaMarcatgeObs(id)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modNouMarcatge").innerHTML = this.responseText;
        $modal = $('#modNouMarcatge');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModEditaMarcatgeObs.php?&1="+id, true);
    xmlhttp.send();
}
function editaMarcatgeObs(id,entsort,tipus,data,hora,obs)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
       
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=editaMarcatgeObs&id=" +id+ "&entsort=" +entsort+ "&tipus=" +tipus+ "&data=" +data+ "&hora=" +hora+ "&obs=" + obs, true);
    xmlhttp.send();
}
function confElimMarcatge(idmarcatge) 
{
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modEliminaMarcatge").innerHTML = this.responseText;
            $modal = $('#modEliminaMarcatge');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModEliminaMarcatge.php?1="+idmarcatge, true);
        xmlhttp.send();
}    
function eliminaMarcatge(idmarcatge)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        window.location.reload(window.location);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaMarcatge&idmarcatge=" +idmarcatge , true);
    xmlhttp.send();
}
function mostraMultiMarcatges(id,data)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modNouMarcatge").innerHTML = this.responseText;
        $modal = $('#modNouMarcatge');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModMultiMarcatges.php?&1="+id+"&2="+data, true);
    xmlhttp.send();
}
function lockhours()
{
    if(document.getElementById("chkhrqd").checked === true) 
    {
        $("#frmhores").display='none';
        $('#horam1').val('null');
        $('#horam1').attr({'disabled':'disabled'});
        $('#horam2').val('null');
        $('#horam2').attr({'disabled':'disabled'});
    }
    else {
        $("#frmhores").display='block';
        $("#horam1").removeAttr('disabled');
        $("#horam2").removeAttr('disabled');
    }
}


function eliminaMarcajesExistente(id, dataini, datafi) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log("Marcajes eliminados exitosamente");
        }
        if (this.readyState === 4 && this.status === 404) {
            console.log("Error al eliminar marcajes existentes");
        }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaMarcajesExistente&id=" + id + "&dataini=" + dataini + "&datafi=" + datafi, true);
    xmlhttp.send();
}












function insereixMultiMarcatges(id,dataini,horaini,datafi,horafi)
{
    var chkhrqd = 0;
    var chkhrrd = 0;
    if(document.getElementById("chkhrqd").checked === true) {chkhrqd = 1;}
    if(document.getElementById("chkhrrd").checked === true) {chkhrrd = 1;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=insereixMultiMarcatges&id=" +id+ "&dataini=" +dataini+ "&horaini=" +horaini+ "&datafi=" +datafi+ "&horafi=" +horafi+ "&chkhrqd=" + chkhrqd+ "&chkhrrd=" + chkhrrd, true);
    xmlhttp.send();
}
function mostraNouHorari(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modAssignaNouHorari").innerHTML = this.responseText;
        $modal = $('#modAssignaNouHorari');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModNouHorari.php?&1="+idemp, true);
    xmlhttp.send();
}
function mostraEditaHorari(idhorari)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modAssignaNouHorari").innerHTML = this.responseText;
        $modal = $('#modAssignaNouHorari');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaHorari.php?&1="+idhorari, true);
    xmlhttp.send();
}
function gestionaRefrescaHoraris(idemp)
{
    try{
    popupload();
    setTimeout(function(){ 
        $modal = $('#modAssignaNouHorari');
        $modal.modal('hide');
        actualitzaHoraris(idemp);
        popoutload();
            },900);
        } catch(err) {popuphtml(err);}
}
function actualitzaHoraris(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("tbodyhoraris").innerHTML = this.responseText;
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=generaTblHoraris&1="+idemp, true);
    xmlhttp.send();
}
function confElimHorari(idhorari,idemp) 
{
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modAssignaNouHorari").innerHTML = this.responseText;
            $modal = $('#modAssignaNouHorari');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModEliminaHorari.php?1="+idhorari+"&2="+idemp, true);
        xmlhttp.send();
}
function eliminaHorari(idhorari,idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      
        actualitzaHoraris(idemp);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaHorari&1="+idhorari, true);
    xmlhttp.send();
}
function mostraNouTipustorn(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modAssignaNouTipustorn").innerHTML = this.responseText;
        $modal = $('#modAssignaNouTipustorn');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModNouTipustorn.php?&1="+idemp, true);
    xmlhttp.send();
}
function creaTipusTorn(idempresa,nom,abr,torn,hora1,hora2,htreb,hnoct,hdesc,colortxt,colorbckg,autsb){
    var autsbint = 0;
    if(autsb===true) autsbint = 1;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        actualitzaTipustorn(idempresa);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=creaTipusTorn&1="+idempresa+"&2="+encodeURIComponent(nom)+"&3="+encodeURIComponent(abr)+"&4="+encodeURIComponent(torn)+"&5="+hora1+"&6="+hora2+"&7="+htreb+"&8="+hnoct+"&9="+hdesc+"&10="+encodeURIComponent(colorbckg)+"&11="+encodeURIComponent(colortxt)+"&12="+autsbint, true);
    xmlhttp.send();
}
function mostraEditaTipustorn(idtipustorn)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modAssignaNouTipustorn").innerHTML = this.responseText;
        $modal = $('#modAssignaNouTipustorn');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaTipustorn.php?&1="+idtipustorn, true);
    xmlhttp.send();
}
function editaTipusTorn(idtipus,nom,abr,torn,hora1,hora2,htreb,hnoct,hdesc,colortxt,colorbckg,autsb){
    var autsbint = 0;
    if(autsb===true) autsbint = 1;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        actualitzaTipustorn(this.responseText);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=editaTipusTorn&1="+idtipus+"&2="+encodeURIComponent(nom)+"&3="+encodeURIComponent(abr)+"&4="+encodeURIComponent(torn)+"&5="+hora1+"&6="+hora2+"&7="+htreb+"&8="+hnoct+"&9="+hdesc+"&10="+encodeURIComponent(colorbckg)+"&11="+encodeURIComponent(colortxt)+"&12="+autsbint, true);
    xmlhttp.send();
}
function gestionaRefrescaTipustorn(idemp)
{
    try{
    popupload();
    setTimeout(function(){ 
        $modal = $('#modAssignaNouTipustorn');
        $modal.modal('hide');
        actualitzaTipustorn(idemp);
        popoutload();
            },900);
        } catch(err) {popuphtml(err);}
}
function actualitzaTipustorn(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("tbodytipustorns").innerHTML = this.responseText;
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=generaTblTipustorn&1="+idemp, true);
    xmlhttp.send();
}
function confElimTipustorn(idtipustorn,idemp) 
{
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modAssignaNouTipustorn").innerHTML = this.responseText;
            $modal = $('#modAssignaNouTipustorn');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModEliminaTipustorn.php?1="+idtipustorn+"&2="+idemp, true);
        xmlhttp.send();
}
function eliminaTipustorn(idtipustorn,idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        
        actualitzaTipustorn(idemp);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaTipustorn&1="+idtipustorn, true);
    xmlhttp.send();
}
function mostraEditaEmp(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaEmpresa.php?&1=" + idemp, true);
    xmlhttp.send();
}
function mostraEditaAdminEmp(idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaAdminEmpresa.php?&1=" + idemp, true);
    xmlhttp.send();
}
function mostraEditaSubemp(idsubemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaSubempresa.php?&1=" + idsubemp, true);
    xmlhttp.send();
}
function mostraFestius(idubicacio)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modFestius").innerHTML = this.responseText;
        $modal = $('#modFestius');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModalFestius.php?&idubicacio=" + idubicacio, true);
    xmlhttp.send();
}
function mostraEditaFestius(idubicacio)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modFestius").innerHTML = this.responseText;
        $modal = $('#modFestius');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaFestius.php?&idubicacio=" + idubicacio, true);
    xmlhttp.send();
}

function showDeleteHoliday(idubicacio)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modFestius").innerHTML = this.responseText;
            $modal = $('#modFestius');
            modaldrag();
            $modal.modal('show');
        } else {
            console.error('error: ' + this.status);
        }
    };
    xmlhttp.open("GET", "ModDeleteHoliday.php?&idubicacio=" + idubicacio, true);
    xmlhttp.send();
}



function showForm(idubicacio)
{
    /*
    let form = document.getElementById('myform_test');
    let idHoliday = form.querySelector('input[name="id"]');
    let nameLabel = form.querySelector('label[for="id"]');
    nameLabel.textContent = name;
    idHoliday.value = id;
    form.style.display = 'block';*/
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modFestius").innerHTML = this.responseText;
            $modal = $('#modFestius');
            modaldrag();
            $modal.modal('show');
        }
    };
    xmlhttp.open("GET", "ModSecureDeleteHoliday.php?&idubicacio=" + idubicacio, true);
    xmlhttp.send();
}

function afegeixUbicacio(nom)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        
        actualitzaUbicacions();
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=afegeixUbicacio&1="+nom, true);
    xmlhttp.send();
}
function afegeixFestiuUbicacio(idubicacio,dia,mes,dataany,nomfestiu)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
       
        actualitzaUbicacions();
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=afegeixFestiuUbicacio&1="+idubicacio+"&2="+dia+"&3="+mes+"&4="+dataany+"&5="+nomfestiu, true);
    xmlhttp.send();
}
function marcaLocAct(idloc)
{
    var i = 0;
    if(document.getElementById("chklocact"+idloc).checked===true) i = 1;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        
        
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=marcaLocAct&1="+idloc+"&2="+i, true);
    xmlhttp.send();
}
function actualitzaUbicacions()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("tbodyubicacions").innerHTML = this.responseText;
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=generaTblUbicacions", true);
    xmlhttp.send();
}
function mostraEditaRol(idrol) 
{
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modContent").innerHTML = this.responseText;
            $modal = $('#modContent');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModEditaRol.php?1="+idrol, true);
        xmlhttp.send();
} 
function creaRol(nom)
{
    var esemp = 0;
    var esadm = 0;
    var esmst = 0;
    if(document.getElementById('chkesemp').checked===true) {esemp = 1;}
    if(document.getElementById('chkesadm').checked===true) {esadm = 1;}
    if(document.getElementById('chkesmst')){if(document.getElementById('chkesmst').checked===true) {esmst = 1;}}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        generaTaulaRols();
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=creaRol&1="+encodeURIComponent(nom)+"&2="+esemp+"&3="+esadm+"&4="+esmst, true);
    xmlhttp.send();
}
function editaRol(idrol,nom)
{
    var esemp = 0;
    var esadm = 0;
    var esmst = 0;
    if(document.getElementById('esemp').checked===true) {esemp = 1;}
    if(document.getElementById('esadm').checked===true) {esadm = 1;}
    if(document.getElementById('chkesmst')){if(document.getElementById('esmst').checked===true) {esmst = 1;}}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        generaTaulaRols();
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=editaRol&1="+idrol+"&2="+encodeURIComponent(nom)+"&3="+esemp+"&4="+esadm+"&5="+esmst, true);
    xmlhttp.send();
}
function generaTaulaRols()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById('bodyrols').innerHTML = this.responseText;
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=generaTaulaRols", true);
    xmlhttp.send();
}
function mostraTorns(idhorari)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modTorns").innerHTML = this.responseText;
        $modal = $('#modTorns');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModalTorns.php?&idhorari=" + idhorari, true);
    xmlhttp.send();
}
function printElem(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    var is_chrome = Boolean(mywindow.chrome);
    var isPrinting = false;
    
    mywindow.document.write('<html><head>');
    
    mywindow.document.write('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); 
    
    if (is_chrome) {
        mywindow.onload = function() { // wait until all resources loaded 
            isPrinting = true;
            mywindow.focus(); // necessary for IE >= 10
            mywindow.print();  // change window to mywindow
            mywindow.close();// change window to mywindow
            isPrinting = false;
        };
        setTimeout(function () { if(!isPrinting){mywindow.print();mywindow.close();} }, 60);
    }
    else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
    }
    return true;
}
function informe2Excel()
{
    $("#tableinforme").table2excel({
    exclude: ".noExl",
    name: "Informe",
    filename: "Informe Baixes"
  });
}
function taulaAExcel(htmlid,nomfull,nomarxiu)
{
   
    $("#"+htmlid).table2excel({
    exclude: ".noExl",
    name: nomfull,
    filename: nomarxiu
  });
}

function novaPersona(idempresa,cognom1,cognom2,nom,dni,datanaix,numafil,dpt,rol,subemp,respasg)
{   
   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=novaPersona&idempresa="+idempresa+"&cognom1="+cognom1+"&cognom2="+cognom2+"&nom="+nom+"&dni="+dni+"&datanaix="+datanaix+"&numafil="+numafil+"&dpt="+dpt+"&rol="+rol+"&subemp="+subemp+"&respasg="+respasg, true);
    xmlhttp.send();
}
function confCessaPersona(idpers,nompers) 
{
   
document.getElementById("nompersonaacessar").innerHTML = nompers;
$('#idpersonaacessar').val(idpers);
$modal = $('#modConfCessaPersona');
            modaldrag();
$modal.modal('show');
}
function changeEncargVal(checkObj,idempleat) 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "Serveis.php?action=changeEncargVal&idempleat="+idempleat+"&newVal="+checkObj.checked);
    xmlhttp.send();

}





function updateAutomarcaje(checkbox) {
    var valor = checkbox.checked ? 1 : 0; // Obtener el valor 1 si está marcado, de lo contrario, obtener 0
    
    var idempresa = $_SESSION["idempresa"]; // Reemplaza con el valor correcto de idempresa
    
    // Crear una solicitud AJAX para enviar el valor al servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "automarcaje.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
      }
    };
    xhr.send("idempresa=" + idempresa + "&valor=" + valor);
  }



function cessaPersona(idpers)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=cessaPersona&idpers=" + idpers, true);
    xmlhttp.send();
}
function confReactivaPersona(idpers,nompers) 
{
   
document.getElementById("nompersonaareactivar").innerHTML = nompers;
$('#idpersonaareactivar').val(idpers);
$modal = $('#modConfReactivaPersona');
            modaldrag();
$modal.modal('show');
}

function reactivaPersona(idpers)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=reactivaPersona&idpers=" + idpers, true);
    xmlhttp.send();
}
function chkAllPers(numpers)
{
    if(numpers>0) {
        if(document.getElementById('chkallpers').checked === true) {
            for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = true;
        }
        else for(var i=1;i<=numpers;i++) document.getElementById('pers'+i).checked = false;
    }
}
function asgMultHorari(numpers)
{
    
    var anychk = 0;
    var stridpers = [];
    for(var i=1;i<=numpers;i++) {
        if(document.getElementById('pers'+i).checked === true) {
            anychk=1;
            try{
            stridpers.push(document.getElementById('idempleat'+i).value);
            }catch(err){alert(err);}
        }
    }
   
    if(anychk===0) {popuphtml('No hi ha ningú seleccionat!'); }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modContent").innerHTML = this.responseText;
            $modal = $('#modContent');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModAsgMultHorari.php?&1="+JSON.stringify(stridpers), true);
        xmlhttp.send();
      
    }
}
function assignaHorariMultipers(numpers)
{
    var idhorari = document.getElementById('idhorarih').value;
    var dataini = document.getElementById('datainih').value;
    var datafi = document.getElementById('datafih').value;
   
    var stridpers = [];
    var id=0;
    for(var i=1;i<=numpers;i++){
        if(document.getElementById('chkemp'+i).checked===true){id=document.getElementById('idemp'+i).value;stridpers.push(id);}
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);        
        popupflash('Horaris Assignats!');
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=assignaHorariMultipers&stridpers=" + JSON.stringify(stridpers) + "&2=" + idhorari + "&3=" + dataini + "&4=" + datafi, true);
    xmlhttp.send();
}
function asgMultUbic(numpers)
{
    
    var anychk = 0;
    var stridpers = [];
    for(var i=1;i<=numpers;i++) {
        if(document.getElementById('pers'+i).checked === true) {
            anychk=1;
            try{
            stridpers.push(document.getElementById('idempleat'+i).value);
            }catch(err){alert(err);}
        }
    }
    
    if(anychk===0) {popuphtml('No hi ha ningú seleccionat!'); }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modContent").innerHTML = this.responseText;
            $modal = $('#modContent');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModAsgMultUbic.php?&1="+JSON.stringify(stridpers), true);
        xmlhttp.send();
       
    }
}
function assignaUbicacioMultipers(numpers)
{
    var idubicacio = document.getElementById('idlocalitzacio').value;
    var dataini = document.getElementById('dataini').value;
   
    var stridpers = [];
    var id=0;
    for(var i=1;i<=numpers;i++){
        if(document.getElementById('chkemp'+i).checked===true){id=document.getElementById('idemp'+i).value;stridpers.push(id);}
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);        
        popupflash('Ubicacions Assignades!');
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=assignaUbicacioMultipers&stridpers=" + JSON.stringify(stridpers) + "&2=" + idubicacio + "&3=" + dataini, true);
    xmlhttp.send();
}
function asgMultMarcatData(numpers)
{
   
    var anychk = 0;
    var stridpers = [];
    for(var i=1;i<=numpers;i++) {
        if(document.getElementById('pers'+i).checked === true) {
            anychk=1;
            try{
            stridpers.push(document.getElementById('idempleat'+i).value);
            }catch(err){alert(err);}
        }
    }
   
    if(anychk===0) {popuphtml('No hi ha ningú seleccionat!'); }
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modContent").innerHTML = this.responseText;
            $modal = $('#modContent');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModAsgMultMarcatData.php?&1="+JSON.stringify(stridpers), true);
        xmlhttp.send();
    }
}
function assignaMarcatgeMultipers(numpers,data)
{
    try{
    var stridpers = [];
    var id=0;
    for(var i=1;i<=numpers;i++){
        if(document.getElementById('chkemp'+i).checked===true){id=document.getElementById('idemp'+i).value;stridpers.push(id);}
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
       
        popupflash('Marcatges Reassignats!');
       
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=assignaMarcatgeMultipers&stridpers="+JSON.stringify(stridpers)+"&2="+data, true);
    xmlhttp.send();
    }catch(err){alert(err);}
}
function mostraNouPeriodeQuadrant(any,mes,dpt,rol,idsubemp,idemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    
    };
    xmlhttp.open("GET", "ModNouPeriodeQuadrant.php?&1="+any+"&2="+mes+"&3="+dpt+"&4="+rol+"&5="+idsubemp+"&0="+idemp, true);
    xmlhttp.send();
}
function mostraIntercanviTorns(any,mes,dpt,rol,idsubemp,idemp,dia)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    
    };
    xmlhttp.open("GET", "ModIntercanviTorns.php?&1="+any+"&2="+mes+"&3="+dpt+"&4="+rol+"&5="+idsubemp+"&0="+idemp+"&6="+dia, true);
    xmlhttp.send();
}
function intercanviTorns(data,idemp1,idemp2,tipus)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=intercanviTorns&1="+data+"&2="+idemp1+"&3="+idemp2+"&4="+tipus, true);
    xmlhttp.send();
}
function marcaInformeDisp(idemp,idinforme)
{
    var chk = 0;
    if(document.getElementById("chkinf"+idinforme).checked === true){chk = 1;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=marcaInformeDisp&1="+idemp+"&2="+idinforme+"&3="+chk, true);
    xmlhttp.send();    
}
function mostraEnganxaNecessitat(any,mes,dpt,rol,idsubemp)
{
    try{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModEnganxaNecessitat.php?&1="+any+"&2="+mes+"&3="+dpt+"&4="+rol+"&5="+idsubemp, true);
    xmlhttp.send();
    }catch(err){alert(err);}
}
function enganxaNecessitat(idnec,any,mes,dpt,rol,idsubemp)
{

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=enganxaNecessitat&1="+any+"&2="+mes+"&3="+dpt+"&4="+rol+"&5="+idsubemp+"&0="+idnec, true);
    xmlhttp.send();
}
function CahngeStateSolicExep(idexcep,tipus) 
{        

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModChangeStateSolicExepc.php?&1="+idexcep+"&2="+tipus, true);
    xmlhttp.send();
}



function VerSolicExcep(idexcep,tipus,dataini,datafi,idempleEncg,idempleaSession) 
{        

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModVisuaSolictExcep.php?&1="+idexcep+"&2="+tipus+"&3="+dataini+"&4="+datafi+"&5="+idempleEncg+"&6="+idempleaSession+"&7=0", true);
    xmlhttp.send();
}




function EditSolicExcep(idexcep,tipus,dataini,datafi,idempleEncg, comentario) 
{        

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModEditaSolicExcepcio.php?&1="+idexcep+"&2="+tipus+"&3="+dataini+"&4="+datafi+"&5="+idempleEncg +"&6="+comentario, true);
    xmlhttp.send();
}

function mostraExcep(idexcep,tipus,dataini,datafi) 
{        

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    };
    xmlhttp.open("GET", "ModalEditException.php?&1="+idexcep+"&2="+tipus+"&3="+dataini+"&4="+datafi, true);
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
            modaldrag();
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
function mostraEditaLogo(idimage,taula,idtaula,camp)
{
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("modLogo").innerHTML = this.responseText;
            $modal = $('#modLogo');
            modaldrag();
            $modal.modal('show'); 
        }
        };
        xmlhttp.open("GET", "ModalUpload1.php?idimage="+idimage+"&taula="+taula+"&idtaula="+idtaula+"&camp="+camp, true);
        xmlhttp.send();
}
function gestionaCarregaLogo(idimage,taula,idtaula,camp)
{
    popupload();
    setTimeout(function(){ 
        $modal = $('#modLogo');
        $modal.modal('hide');
        actualitzaLogoCarregat(idtaula,taula,camp,idimage);
        popoutload();
            },900);
}
function actualitzaLogoCarregat(idtaula,taula,camp,idimage)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById(idimage).src = this.responseText;
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=obteCampTaulaPerId&idtaula="+idtaula+"&taula="+taula+"&camp="+camp,true);
    xmlhttp.send();
}
function gestionaCarregaExcel(data)
{
    popupload();
    setTimeout(function(){ 
        $modal = $('#modContent');
        $modal.modal('hide');
        processaExcelPujat(data);        
        popoutload();
            },1800);
}
function processaExcelPujat(data)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        popuphtml(this.responseText);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=processaExcelPujat&1="+data,true);
    xmlhttp.send();
}
function gestionaCarregaQuadrant(any,mes,idsubemp)
{
    popupload();
    setTimeout(function(){ 
        $modal = $('#modContent');
        $modal.modal('hide');
        processaQuadrantPujat(any,mes,idsubemp);        
        popoutload();
            },1800);
}
function processaQuadrantPujat(any,mes,idsubemp)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
        popuphtml("Actualizando...");
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=processaQuadrantPujat&1="+any+"&2="+mes+"&3="+idsubemp,true);
    xmlhttp.send();
}
function marcaTotsDiesSetm()
{
    if(document.getElementById('chkalldays').checked === true) {
        for(var i=1;i<=7;i++) document.getElementById(i+'f0').checked = true;
    }
    else { 
        for(var i=1;i<=7;i++) document.getElementById(i+'f0').checked = false;
    }
}
function popuphtml(innerhtml)
{
    document.getElementById("msgConsole").innerHTML = innerhtml;
    $modal = $('#modConsole');
            modaldrag();
    $modal.modal('show');
}
function dataString(strtotime) 
{        
    var data = new Date(strtotime*1000);
    var mm = data.getMonth()+1;
    var dd = data.getDate();
    return data.getFullYear()+"-"+(mm<10 ? '0' : '')+mm+"-"+(dd<10 ? '0' : '')+dd;
}
function popupload()
{
   
    $modal = $('#modLoad');
            //modaldrag();
    $modal.modal('show');
}
function popoutload()
{
    $modal = $('#modLoad');
            //modaldrag();
    $modal.modal('hide');
}
function popupwait()
{
    
    $modal = $('#modWait');
            //modaldrag();
    $modal.modal('show');
}
function popdownwait()
{
    $modal = $('#modWait');
            //modaldrag();
    $modal.modal('hide');
}
function afegeixFestiu(idubicacio,nomubicacio) 
{        
$('#idubicacio').val(idubicacio);
document.getElementById("calendari").innerHTML = nomubicacio;
$modal = $('#modAfegeixFestiu');
            modaldrag();
$modal.modal('show');
}

function afegeixFestiu2(idubicacio,nomubicacio) 
{        
$('#idubicacio').val(idubicacio);
document.getElementById("calendari2").innerHTML = nomubicacio;
$modal = $('#modAfegeixFestiu2');
            modaldrag();
$modal.modal('show');
}


function mostraNovaEmpresa() 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 400) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModNovaEmpresa.php", true);
    xmlhttp.send();
}
function novaEmpresa(nom,nif,ctreb,ccc,poblacio)
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 400) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=novaEmpresa&2="+nom+"&3="+nif+"&4="+ctreb+"&5="+ccc+"&6="+poblacio, true);
    xmlhttp.send();
}
function mostraNovaSubemp(idemp) 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 400) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModNovaSubempresa.php?1="+idemp, true);
    xmlhttp.send();
}
function novaSubempresa(idempresa,nom,nif,ctreb,ccc,poblacio)
{ 
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 400) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=novaSubempresa&1="+idempresa+"&2="+nom+"&3="+nif+"&4="+ctreb+"&5="+ccc+"&6="+poblacio, true);
    xmlhttp.send();
}
function confElimSubemp(idsubemp,nomsubemp)
{
    try {
   
document.getElementById("nomsubempacessar").innerHTML = nomsubemp;
$('#idsubempacessar').val(idsubemp);
$modal = $('#modAdminConfElimSubEmp');
            modaldrag();
$modal.modal('show');
} catch(err) {alert(err);}
}
function mostraNovaNecess(idsubempresa,idtipusnec,idtornfrac) 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
   
    };
    xmlhttp.open("GET", "ModCreaNecessitat.php?1="+idsubempresa+"&2="+idtipusnec+"&3="+idtornfrac, true);
    xmlhttp.send();
}
function creaNecessitat(idsubempresa,idtipusnec,idtipustorn,quantitat)
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=creaNecessitat&1="+idsubempresa+"&2="+idtipusnec+"&3="+idtipustorn+"&4="+quantitat, true);
    xmlhttp.send();
}
function eliminaTornnec(idtornnec)
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaTornnec&1="+idtornnec, true);
    xmlhttp.send();
}
function mostraCreaRotacioDia(idempleat,data) 
{
   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModCreaRotacioDia.php?1="+idempleat+"&2="+data, true);
    xmlhttp.send();
}
function creaRotacioDia(idempleat,idtipustorn,data,datafi)
{  
    var repetir = 0;
    if(document.getElementById('repetirfins').checked === true) {repetir = 1;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=creaRotacioPersonaDia&1="+idempleat+"&2="+idtipustorn+"&3="+data+"&4="+datafi+"&5="+repetir, true);
    xmlhttp.send();
}
function mostraEditaRotacioDia(idrotacio) 
{
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        document.getElementById("modContent").innerHTML = this.responseText;
        $modal = $('#modContent');
            modaldrag();
        $modal.modal('show'); 
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "ModEditaRotacioDia.php?1="+idrotacio, true);
    xmlhttp.send();
}
function editaRotacioDia(idrotacio,idtipustorn,datafi)
{
    var repetir = 0;
    if(document.getElementById('editarepetirfins').checked === true) {repetir = 1;}
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=editaRotacioDia&1="+idrotacio+"&2="+idtipustorn+"&3="+datafi+"&4="+repetir, true);
    xmlhttp.send();
}
function eliminaRotacioDia(idrotacio)
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 404) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=eliminaRotacioDia&1="+idrotacio, true);
    xmlhttp.send();
}
function desaHoresAny(idempleat,any,hores)
{   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        window.location.reload(window.location);
    }
    if (this.readyState === 4 && this.status === 400) {
        popuphtml(this.responseText);
    }
    };
    xmlhttp.open("GET", "Serveis.php?action=desaHoresAny&1="+idempleat+"&2="+any+"&3="+encodeURIComponent(hores), true);
    xmlhttp.send();
}
function popupflash(msg)
{
    var content = '<center><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-body"><h1>'+msg+'</h1></div></div></div></center>';
    document.getElementById("modFlash").innerHTML = content;
    $modal = $('#modFlash');
            modaldrag();
    $modal.modal('show');
    setTimeout(function(){
        $modal.modal('hide');
    },1000);    
}