<?php
session_start();
include "../../includes/config.inc-s.php";
include "../../includes/libs/mysql.php";
date_default_timezone_set("America/Monterrey");

if(isset($_POST["ac"])){
	$a=$_POST["ac"];
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/html; charset=ISO-8859-1");	
	switch($a){
		case "login":
			//include("../conf/conexion.php"); //  AND activo=1 
			$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
			//mysql_select_db($db_actual);
			$sql="SELECT id,no_empleado, nombres, a_paterno, a_materno, foto FROM cat_personal WHERE no_empleado='".$_POST["nde"]."' LIMIT 1; ";
            $res=$obj->ejecutarQuery($sql);
			if ($res){ 
				//$ndr=mysql_num_rows($res);
                $ndr=$obj->numeroRegistros($res);
				if($ndr>0){	
					//while($reg=mysql_fetch_array($res)){
                    while($reg=$obj->regresaResulatdos($res)){    
						$id=$reg["id"];
						$nde=$reg["no_empleado"];
						$nombres=strtoupper($reg["nombres"]);
						$ap=strtoupper($reg["a_paterno"]);
						$am=strtoupper($reg["a_materno"]);
						$foto=$reg["no_empleado"];
					}
				}else{ 
					?><script language="javascript"> limpiar_datos(); $('#spa_nombre_completo').text('EMPLEADO DESCONOCIDO'); </script><?php
					exit; 
				}
			} else{ echo "<br>Error "; exit;	}	
			// Registrar acceso ...
			$sql2="SELECT id,ES FROM reg_accesos WHERE id_empleado=$id ORDER BY id DESC LIMIT 1; ";
			$res=$obj->ejecutarQuery($sql2);
            if ($res){ 
				//$ndr=mysql_num_rows($res);
                $ndr=$obj->numeroRegistros($res);
				if($ndr>0){	
					//while($reg=mysql_fetch_array($res)){
                    while($reg=$obj->regresaResulatdos($res)){
						($reg["ES"]==1)?$tipo='SALIDA':$tipo='ENTRADA';
					}
				}else{ $tipo='ENTRADA'; }
			} else{ echo "<br>Error ."; exit;	}	
			$nueva_fecha=date("Y-m-d");
			$nueva_hora=date("H:i:s");
			($tipo=='ENTRADA')?$nuevo_ES=1:$nuevo_ES=0;
			$sql3="INSERT INTO reg_accesos (id,id_empleado,fecha,hora,ES) VALUES (NULL,'$id','$nueva_fecha','$nueva_hora','$nuevo_ES'); ";
            $res=$obj->ejecutarQuery($sql3);
            if (!$res){ echo "<br>Error SQL (".mysql_error($link).")."; exit;  }
				$nombreCompleto=$nombres." ".$ap." ".$am;				                                
				$path="../../fotos/".$foto.".jpg";
				if(file_exists($path)){
                                    $path=$path;
                                }else{
                                    $path="../../fotos/other_profile.png";
                                }
				?><script language="javascript">                                        
					$('#spa_nde').attr('value','<?=$nde?>');
					$('#spa_nombre_completo').text('<?=$nombreCompleto;?>');                                        
					$('#div_foto').css('background-image','url(<?=$path;?>)');
					$('#div_foto').css('background-position','center');
					$('#div_foto').css('background-repeat','no-repeat');
					$('#txt_ES').attr('value','<?=$tipo?>');
					$('#txt_fecha').attr('value','<?=$nueva_fecha?>');
					$('#txt_hora').attr('value','<?=$nueva_hora?>');
					$("#txt_nde").val("");
					$("#txt_nde").focus();
				</script><?php
			break;
		default:
			"Accion no encontrada.";
			break;	
	}
	exit();
}

//reloj digital
/*** Clock -- beginning of server-side support code
by Andrew Shearer, http://www.shearersoftware.com/
v2.1.2-PHP, 2003-08-07. For updates and explanations, see
<http://www.shearersoftware.com/software/web-tools/clock/>. ***/

/* Prevent this page from being cached (though some browsers still
   cache the page anyway, which is why we use cookies). This is
   only important if the cookie is deleted while the page is still
   cached (and for ancient browsers that don't know about Cache-Control).
   If that's not an issue, you may be able to get away with
   "Cache-Control: private" instead. */
header("Pragma: no-cache");

/* Grab the current server time. */
$gDate = time();
/* Are the seconds shown by default? When changing this, also change the
   JavaScript client code's definition of clockShowsSeconds below to match. */
$gClockShowsSeconds = false;

function getServerDateItems($inDate) {
	return date('Y,n,j,G,',$inDate).intval(date('i',$inDate)).','.intval(date('s',$inDate));
	// year (4-digit),month,day,hours (0-23),minutes,seconds
	// use intval to strip leading zero from minutes and seconds
	//   so JavaScript won't try to interpret them in octal
	//   (use intval instead of ltrim, which translates '00' to '')
}

function clockDateString($inDate) {
    $dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses=array("0","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    //$dia=date("W");
    return $dias[date("N")]." , ".date("j")." de ".$meses[date("n")]." de ".date("Y");    
    //echo date('l, F j, Y',$inDate);    // eg "Monday, January 1, 2002"
    //return date('l, F j, Y',$inDate);    // eg "Monday, January 1, 2002"
}

function clockTimeString($inDate, $showSeconds) {
    return date($showSeconds ? 'g:i:s' : 'g:i',$inDate).' ';
}
/*** Clock -- end of server-side support code ***/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="../../includes/libs/jquery.js"></script>
<title>Acceso de Personal</title>
<script type="text/javascript">
    $("document").ready(function(){ 
	limpiar_datos();	
	clockInit(clockLocalStartTime, clockServerStartTime);
	clockOnLoad();
	clockToggleSeconds();
    });
function ajax(capa,datos,ocultar_capa){
	if (!(ocultar_capa==""||ocultar_capa==undefined||ocultar_capa==null)) { $("#"+ocultar_capa).hide(); }
	var url="<?=$_SERVER['PHP_SELF']?>";
	$.ajax({
		async:true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url:url,
		data:datos,
		beforeSend:function(){ /*$("#"+capa).html('Procesando, espere un momento');*/  },
		success:function(datos){ $("#"+capa).show().html(datos); },
		timeout:90000000,
		error:function() { $("#"+capa).show().html('<center>Error: El servidor no responde. <br>Por favor intente mas tarde. </center>'); }
	});
}
function tecla(n,elEvento){
	var evento = elEvento || window.event
	var codigo = evento.charCode || evento.keyCode;
	if (n==0&&codigo==13){ // Enter o Tabulacion...
		var nde=$("#txt_nde").val();		
		if(nde==''||nde==undefined||nde==null){			
			return;
		}else if(nde==0){
			limpiar_datos();
		}else{
			ajax('b','ac=login&nde='+nde);
		}
	}
}
function limpiar_datos(){
	$('#spa_nde').attr('value','');
	$('#spa_nombre_completo').text('');
	$('#div_foto').css('background-image','url()');
	$('#txt_ES').attr('value','');
	$('#txt_fecha').attr('value','');
	$('#txt_hora').attr('value','');
	$("#txt_nde").attr('value','');
	$("#txt_nde").focus();
}    
<!--/*RELOJ*/
/* set up variables used to init clock in BODY's onLoad handler;
   should be done as early as possible */
var clockLocalStartTime = new Date();
var clockServerStartTime = new Date(<?php echo(getServerDateItems($gDate))?>);

/* stub functions for older browsers;
   will be overridden by next JavaScript1.2 block */
function clockInit() {
}
//-->
<!--
/*** simpleFindObj, by Andrew Shearer

Efficiently finds an object by name/id, using whichever of the IE,
classic Netscape, or Netscape 6/W3C DOM methods is available.
The optional inLayer argument helps Netscape 4 find objects in
the named layer or floating DIV. */
function simpleFindObj(name, inLayer) {
	return document[name] || (document.all && document.all[name])
		|| (document.getElementById && document.getElementById(name))
		|| (document.layers && inLayer && document.layers[inLayer].document[name]);
}

/*** Beginning of Clock 2.1.2, by Andrew Shearer
See: http://www.shearersoftware.com/software/web-tools/clock/
Redistribution is permitted with the above notice intact.

Client-side clock, based on computed time differential between browser &
server. The server time is inserted by server-side JavaScript, and local
time is subtracted from it by client-side JavaScript while the page is
loading.

Cookies: The local and remote times are saved in cookies named
localClock and remoteClock, so that when the page is loaded from local
cache (e.g. by the Back button) the clock will know that the embedded
server time is stale compared to the local time, since it already
matches its cookie. It can then base the calculations on both cookies,
without reloading the page from the server. (IE 4 & 5 for Windows didn't
respect Response.Expires = 0, so if cookies weren't used, the clock
would be wrong after going to another page then clicking Back. Netscape
& Mac IE were OK.)

Every so often (by default, one hour) the clock will reload the page, to
make sure the clock is in sync (as well as to update the rest of the
page content).

Compatibility: IE 4.x and 5.0, Netscape 4.x and 6.0, Mozilla 1.0. Mac & Windows.

History:  1.0   2000-05-09 GIF-image digits
          2.0   2000-06-29 Uses text DIV layers (so 4.0 browsers req'd), &
                         cookies to work around Win IE stale-time bug
		  2.1   2002-10-12 Noted Mozilla 1.0 compatibility; released PHP version.
		  2.1.1 2002-10-20 Fixed octal bug in the PHP translation; the number of
		  				minutes & seconds were misinterpretes when less than 10
		  2.1.2 2003-08-07 The previous fix had introduced a bug when the
		                minutes or seconds were exactly 0. Thanks to Man Bui
		                for reporting the bug.
*/
var clockIncrementMillis = 60000;
var localTime;
var clockOffset;
var clockExpirationLocal;
var clockShowsSeconds = false;
var clockTimerID = null;

function clockInit(localDateObject, serverDateObject)
{
    var origRemoteClock = parseInt(clockGetCookieData("remoteClock"));
    var origLocalClock = parseInt(clockGetCookieData("localClock"));
    var newRemoteClock = serverDateObject.getTime();
    // May be stale (WinIE); will check against cookie later
    // Can't use the millisec. ctor here because of client inconsistencies.
    var newLocalClock = localDateObject.getTime();
    var maxClockAge = 60 * 60 * 1000;   // get new time from server every 1hr

    if (newRemoteClock != origRemoteClock) {
        // new clocks are up-to-date (newer than any cookies)
        document.cookie = "remoteClock=" + newRemoteClock;
        document.cookie = "localClock=" + newLocalClock;
        clockOffset = newRemoteClock - newLocalClock;
        clockExpirationLocal = newLocalClock + maxClockAge;
        localTime = newLocalClock;  // to keep clockUpdate() happy
    }
    else if (origLocalClock != origLocalClock) {
        // error; localClock cookie is invalid (parsed as NaN)
        clockOffset = null;
        clockExpirationLocal = null;
    }
    else {
        // fall back to clocks in cookies
        clockOffset = origRemoteClock - origLocalClock;
        clockExpirationLocal = origLocalClock + maxClockAge;
        localTime = origLocalClock;
        // so clockUpdate() will reload if newLocalClock
        // is earlier (clock was reset)
    }
    /* Reload page at server midnight to display the new date,
       by expiring the clock then */
    var nextDayLocal = (new Date(serverDateObject.getFullYear(),
            serverDateObject.getMonth(),
            serverDateObject.getDate() + 1)).getTime() - clockOffset;
    if (nextDayLocal < clockExpirationLocal) {
        clockExpirationLocal = nextDayLocal;
    }
}

function clockOnLoad()
{
    clockUpdate();
}

function clockOnUnload() {
    clockClearTimeout();
}

function clockClearTimeout() {
    if (clockTimerID) {
        clearTimeout(clockTimerID);
        clockTimerID = null;
    }
}

function clockToggleSeconds()
{
    clockClearTimeout();
    if (clockShowsSeconds) {
        clockShowsSeconds = false;
        clockIncrementMillis = 60000;
    }
    else {
        clockShowsSeconds = true;
        clockIncrementMillis = 1000;
    }
    clockUpdate();
}

function clockTimeString(inHours, inMinutes, inSeconds) {
    return inHours == null ? "-:--" : ((inHours == 0
                   ? "12" : (inHours <= 12 ? inHours : inHours - 12))
                + (inMinutes < 10 ? ":0" : ":") + inMinutes
                + (clockShowsSeconds
                   ? ((inSeconds < 10 ? ":0" : ":") + inSeconds) : "")
                + (inHours < 12 ? " AM" : " PM"));
}

function clockDisplayTime(inHours, inMinutes, inSeconds) {
    
    clockWriteToDiv("ClockTime", clockTimeString(inHours, inMinutes, inSeconds));
}

function clockWriteToDiv(divName, newValue) // APS 6/29/00
{
    var divObject = simpleFindObj(divName);
    newValue = '<p>' + newValue + '<' + '/p>';
    if (divObject && divObject.innerHTML) {
        divObject.innerHTML = newValue;
    }
    else if (divObject && divObject.document) {
        divObject.document.writeln(newValue);
        divObject.document.close();
    }
    // else divObject wasn't found; it's only a clock, so don't bother complaining
}

function clockGetCookieData(label) {
    /* find the value of the specified cookie in the document's
    semicolon-delimited collection. For IE Win98 compatibility, search
    from the end of the string (to find most specific host/path) and
    don't require "=" between cookie name & empty cookie values. Returns
    null if cookie not found. One remaining problem: Under IE 5 [Win98],
    setting a cookie with no equals sign creates a cookie with no name,
    just data, which is indistinguishable from a cookie with that name
    but no data but can't be overwritten by any cookie with an equals
    sign. */
    var c = document.cookie;
    if (c) {
        var labelLen = label.length, cEnd = c.length;
        while (cEnd > 0) {
            var cStart = c.lastIndexOf(';',cEnd-1) + 1;
            /* bug fix to Danny Goodman's code: calculate cEnd, to
            prevent walking the string char-by-char & finding cookie
            labels that contained the desired label as suffixes */
            // skip leading spaces
            while (cStart < cEnd && c.charAt(cStart)==" ") cStart++;
            if (cStart + labelLen <= cEnd && c.substr(cStart,labelLen) == label) {
                if (cStart + labelLen == cEnd) {                
                    return ""; // empty cookie value, no "="
                }
                else if (c.charAt(cStart+labelLen) == "=") {
                    // has "=" after label
                    return unescape(c.substring(cStart + labelLen + 1,cEnd));
                }
            }
            cEnd = cStart - 1;  // skip semicolon
        }
    }
    return null;
}

/* Called regularly to update the clock display as well as onLoad (user
   may have clicked the Back button to arrive here, so the clock would need
   an immediate update) */
function clockUpdate()
{
    var lastLocalTime = localTime;
    localTime = (new Date()).getTime();
    
    /* Sanity-check the diff. in local time between successive calls;
       reload if user has reset system clock */
    if (clockOffset == null) {
        clockDisplayTime(null, null, null);
    }
    else if (localTime < lastLocalTime || clockExpirationLocal < localTime) {
        /* Clock expired, or time appeared to go backward (user reset
           the clock). Reset cookies to prevent infinite reload loop if
           server doesn't give a new time. */
        document.cookie = 'remoteClock=-';
        document.cookie = 'localClock=-';
        location.reload();      // will refresh time values in cookies
    }
    else {
        // Compute what time would be on server 
        var serverTime = new Date(localTime + clockOffset);
        clockDisplayTime(serverTime.getHours(), serverTime.getMinutes(),
            serverTime.getSeconds());
        
        // Reschedule this func to run on next even clockIncrementMillis boundary
        clockTimerID = setTimeout("clockUpdate()",
            clockIncrementMillis - (serverTime.getTime() % clockIncrementMillis));
    }
}

/*** End of Clock ***/    
</script>
<style type="text/css">
body{height: 100%;position: absolute;width: 100%;margin: 0;font-family: Verdana, monospace,sans-serif;}
.divContenedorChecado{border:1px solid #000;background-color:#FFF;height:650px;width:900px;position:absolute;left:50%;top:50%;margin-left:-450px;margin-top:-325px;z-index:21;}
.fecha_hora{ width:130px; text-align:center; font-weight:normal; border:none; background-color:#FFFFFF; font-size:20px;font-weight: bold;}
.fecha_hora1{ width:210px; text-align:center; font-weight:normal; border:none; background-color:#FFFFFF; font-size:14px;}
#txt_ES{ border:none; font-size:large; background-color:#FFF; text-align:center; font-weight:bold; width:96%; font-size:50px; margin:5px; }
#contenedorChecadorPrincipal{position:absolute;height: 99%;width: 99.5%;background: #666;border: 1px solid #000;margin: 2px;}
#contenedorTituloChecador{font-size: 12px;font-weight: bold;border: 1px solid #CCC;background: #f0f0f0;height: 20px;padding: 8px;width: 97.8%;}
#contenedorLogoImagen{float: left;border: 1px solid #333;width: 425px;height: 565px;margin: 3px;}
#estiloDivContenedorImagen{z-index:10; float:left;position: absolute;}
#div_foto{border: 1px solid #CCC;width: 420px;height: 560px;margin: 1px;}
#divDatosPersonal{float: left;border: 1px solid #CCC;background: #e1e1e1;width: 457px;height: 565px;margin: 3px;}
#contenedorCajaTextoNNomina{margin:10px 5px 5px 5px; border:1px solid #999999; height:57px;text-align: right;}
#txt_nde{margin-top: 10px;margin-right: 15px;width:150px; height:30px;background: #FFF;text-align: center;font-weight: bold;}
</style>
</head>
<body>
<div id="contenedorChecadorPrincipal">
    <div class="divContenedorChecado">
        <div id="contenedorTituloChecador">
            <div style="float: left;"><?php echo $configGral["login"]["title"];?></div>
            <div style="float: right;"><?php echo(clockDateString($gDate));?></div>
        </div>
        <div style="clear: both;"></div>        
        <div id="contenedorLogoImagen">
            <!--<div id="estiloDivContenedorImagen"><img src="../img/iq_128x96.jpg" style="margin:2px;" /></div>-->
            <div id="div_foto"></div>            
        </div>
        <div id="divDatosPersonal">
            <div id="contenedorCajaTextoNNomina">
                <input type="text" id="txt_nde" maxlength="7" onKeyPress="tecla(0,event)" />
            </div>
            <fieldset style="border: 1px solid #999;margin: 5px;"><legend>Incidencia:</legend>
                <div style="border: 1px solid #999;font-size: 16px;height: auto;overflow: hidden;padding: 5px;margin: 5px;">                    
                    <table border="0" cellpadding="1" cellspacing="1" width="340">
                        <tr>
                            <td width="130" style="height: 20px;padding: 5px;">No. Empleado:</td>
                            <td width="210"><input type="text" id="spa_nde" class="fecha_hora"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="nombreCompleto" style="border: 0px solid #000;width: 375px; height: 35px; padding:10px; font-weight:bold; text-align:center; color:#000;background:#FFF;">    
                                <span id="spa_nombre_completo" style="height: 25px;">&nbsp;</span>
                                </div>
                            </td>                            
                        </tr>                        
                        <tr>
                            <td style="height: 20px;padding: 5px;">Fecha:</td>
                            <td><input type="text" id="txt_fecha" readonly="1" class="fecha_hora" value="" /></td>
                        </tr>
                        <tr>
                            <td style="height: 20px;padding: 5px;">Hora:</td>
                            <td><input type="text" id="txt_hora" readonly="1" class="fecha_hora" value="" /></td>
                        </tr>
                    </table>
                </div>                
                <div style="margin:30px 5px 5px 5px; border:1px solid #999999; height:69px;"><input type="text" id="txt_ES" readonly="1" value="" /></div>
                <div style="margin:30px 5px 5px 5px; border:1px solid #999999; height:69px;background: #FFF;">&nbsp;</div>
            </fieldset>
        </div>
        <div style="clear: both;"></div>
        <!--<div style="border-top: 1px solid #ff0000;border-bottom: 1px solid #ff0000;background: #F3F781;height: 25px;padding: 5px;color: #ff0000;"></div>-->
        <div id="ClockTime" style="border: 0px solid #000;position: absolute; left: 560px; top: 425px;width: 250px; height: 20px; z-index: 11; cursor: pointer;font-size:34px;"  onclick="clockToggleSeconds()">
            <p style="font-size: 20px;font-weight: bold;"><?php echo(clockTimeString($gDate,$gClockShowsSeconds));?></p>
	</div>
    </div>
    <div id="b"></div>
</div>
</body>
</html>
