<?php
header("Location: index-3.php");
exit;
session_start();
date_default_timezone_set("America/Monterrey");
//echo "La hora en Mexico es: " . date ("H:i",time()) . "<br />";
if(isset($_POST["ac"])){
	$a=$_POST["ac"];
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/html; charset=ISO-8859-1");	
	switch($a){
		case "login":
			include("../conf/conexion.php"); //  AND activo=1 
			
			mysql_select_db($db_actual);
			$sql="SELECT id,no_empleado, nombres, a_paterno, a_materno, foto FROM cat_personal WHERE no_empleado='".$_POST["nde"]."' LIMIT 1; ";
			if ($res=mysql_query($sql,$link)){ 
				$ndr=mysql_num_rows($res);
				if($ndr>0){	
					while($reg=mysql_fetch_array($res)){
						$id=$reg["id"];
						$nde=$reg["no_empleado"];
						$nombres=$reg["nombres"];
						$ap=$reg["a_paterno"];
						$am=$reg["a_materno"];
						$foto=$reg["foto"];
					}
				}else{ 
					?><script language="javascript"> limpiar_datos(); $('#spa_nombre_completo').text('EMPLEADO DESCONOCIDO'); </script><?php
					exit; 
				}
			} else{ echo "<br>Error SQL (".mysql_error($link).")."; exit;	}	
			// Registrar acceso ...
			$sql2="SELECT id,ES FROM reg_accesos WHERE id_empleado=$id ORDER BY id DESC LIMIT 1; ";
			if ($res=mysql_query($sql2,$link)){ 
				$ndr=mysql_num_rows($res);
				if($ndr>0){	
					while($reg=mysql_fetch_array($res)){
						($reg["ES"]==1)?$tipo='SALIDA':$tipo='ENTRADA';
					}
				}else{ $tipo='ENTRADA'; }
			} else{ echo "<br>Error SQL (".mysql_error($link).")."; exit;	}	
			$nueva_fecha=date("Y-m-d");
			$nueva_hora=date("H:i:s");
			($tipo=='ENTRADA')?$nuevo_ES=1:$nuevo_ES=0;
			$sql3="INSERT INTO reg_accesos (id,id_empleado,fecha,hora,ES) VALUES (NULL,'$id','$nueva_fecha','$nueva_hora','$nuevo_ES'); ";
			if (!$res=mysql_query($sql3,$link)){ echo "<br>Error SQL (".mysql_error($link).")."; exit;	}
				$nombreCompleto=$nombres." ".$ap." ".$am;
				//echo "<br>".strlen($nde)."<br>";
				switch(strlen($nde)){
					case 1:
						$foto="000".$nde;
					break;
					case 2:
						$foto="00".$nde;
					break;
					case 3:
						$foto="0".$nde;
					break;
					default:
						$foto=$nde;
					break;
				}
				//echo "<br>".$foto."<br>";
				$path="../fotos/".$foto.".JPG";
				//$foto="000000";
				if(file_exists($path)){
					$path=$path;
				}else{
					$path="../fotos/other_profile.png";
				}
				//echo $path;
				?><script language="javascript">
					$('#spa_nde').text('<?=$nde?>');
					$('#spa_nombre_completo').text('<?=$nombreCompleto;?>');
					$('#div_foto').css('background-image','url(<?=$path;?>)');
					$('#div_foto').css('background-position','center');
					$('#div_foto').css('background-repeat','no-repeat');
					$('#txt_ES').attr('value','<?=$tipo?>');
					$('#txt_fecha').attr('value','<?=$nueva_fecha?>');
					$('#txt_hora').attr('value','<?=$nueva_hora?>');
					$("#txt_nde").attr('value','');
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
<title>Sistema de Acceso de Personal</title>
<style type="text/css">
body,html,document{ position:absolute; height:100%; width:100%; margin:0px; background-color:#666; font-family:Verdana, Arial, Helvetica, sans-serif; overflow:hidden;}
#a{ position:absolute; height:600px; width:800px; left:50%; top:50%; margin-left:-400px; margin-top:-300px; background-color:#666666; }
	#a1{ position:relative; width:100%; height:72px; text-align:center; background-color:#333333; }
		#a11{ position:relative; width:15%; height:100%; text-align:left; float:left; }
		#a12{ position:relative; width:85%; height:100%; text-align:center; float:left; font-size:x-large; color:#FFFFFF; }
	#a2{ position:relative; width:100%; height:28px; background-color:#999999; text-align:center; font-size:large; color:#333; font-weight:bold;  }	
	#a3{ position:relative; width:100%; height:500px; background-color:#fff;   }
		#a31{ text-align:right;}
			#txt_nde{ margin:2px; text-align:center; font-size:large; font-weight:bold; background-image:url(../img/no_empleado.png); background-position:center; background-repeat:no-repeat;}
		#a32{ text-align:center; font-weight:bold; font-size:large; }
		#a33{ text-align:center; height:482px; background-color:#FFFFFF; }	
			/*#div_foto{ position:relative; width:480px; height:417px; left:50%; margin-left:-240px; margin-top:5px; border:#333333 1px dashed; background-position:center; background-repeat:no-repeat; }*/
			#txt_ES{ border:none; font-size:large; background-color:#ccc; text-align:center; font-weight:bold; width:96%; font-size:36px; margin:5px; }
			.fecha_hora{ width:100px; text-align:center; font-weight:normal; border:none; background-color:#FFFFFF; font-size:18px; }
#b{ /*color:#FFFF66; color:#000000;*/ color:#FFFF66; }			
</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="javascript">
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
	var evento = elEvento || window.event;
	var codigo = evento.charCode || evento.keyCode;
	if (n==0&&codigo==13){ // Enter o Tabulacion...
		var nde=$("#txt_nde").attr("value");		
		
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
	$('#spa_nde').text('');
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
//-->
</script>
</head>
<body>
<div style="z-index:20;font-size:12px; font-weight:bold;position:absolute; background:#F0F0F0; background:url(../img/desv.png); border:1px solid #CCC; height:40px; width:100%;">
	<div style="float:left; margin-top:13px; margin-left:10px;">IQ Electronics International S.A. de C.V.</div>
	<div style="float:right;font-size:small; color:#FFCC00; text-align:right; margin-top:13px; margin-right:10px;">Recursos Humanos&nbsp;</div>
</div>
<div id="a">
	<div style="width:100%; text-align:right; height:42px;">
		<div id="ClockBkgnd" style="position: absolute; left: 0px; top: -30px;width:350px; z-index: 10;color:#FFF; font-weight:bold;border: 0px solid #ff0000;">
			<p><br><?php echo(clockDateString($gDate));?></p>
		</div>
		<div style="float:left; text-align:center; height:20px; width:75%; padding:10px; font-weight:bold;"></div>
		<div style="float:right;width:20%;border:1px solid #CCC; background:#f0f0f0;"><input type="text" id="txt_nde" maxlength="6" onKeyPress="tecla(0,event)" style="width:150px; height:30px;" /></div>
	</div>
	<div id="a3" style="border:1px solid #000;">
		<div id="nombreCompleto" style="position: absolute; left: 10px; top: 420px;width: 479px; height: 30px; padding:10px; font-weight:bold; z-index: 11; text-align:center; color:#000;background:url(../img/desv.png);">
			<span id="spa_nde" style="padding:5px;">&nbsp;</span>&nbsp;&nbsp;&nbsp;<span id="spa_nombre_completo">&nbsp;</span>
		</div>
		<div style="border:1px solid #CCC; float:left; margin:10px; width:500px; height:95%; z-index:20;">
			<div style="z-index:10; float:left;"><img src="../img/iq_128x96.jpg" style="margin:2px;" /></div>
			<div id="div_foto" style="z-index:5;width:480px; height:417px; border:1px solid #FFF; margin:30px 10px 10px 10px;"></div>			
		</div>
		<div style="float:right;border:1px solid #CCC; background:#f0f0f0; width:256px; height:95%; margin:10px; text-align:center;">
			<div style="margin:190px 5px 5px 5px; border:1px solid #999999; height:55px;"><input type="text" id="txt_ES" readonly="1" value="" /></div>
			<br /><input type="text" id="txt_fecha" readonly="1" class="fecha_hora" value="" /><input type="text" id="txt_hora" readonly="1" class="fecha_hora" value="" />
			<div id="ClockTime" style="position: absolute; left: 540px; top: 370px;width: 250px; height: 20px; z-index: 11; cursor: pointer;font-size:34px;"  onclick="clockToggleSeconds()">
				<p><?php echo(clockTimeString($gDate,$gClockShowsSeconds));?></p>
			</div>			
		</div>		
	</div>
	<div id="b"></div>	
</div>
</body>
</html>