<?php
header("Location: index-3.php");
exit;
session_start();
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
				
				
				?><script language="javascript">
					$('#spa_nde').text('<?=$nde?>');
					$('#spa_nombre_completo').text('<?=$nombreCompleto;?>');
					$('#div_foto').css('background-image','url(../fotos/<?=$foto;?>.JPG)');
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Acceso de Personal</title>
<style type="text/css">
body,html,document{ position:absolute; height:100%; width:100%; margin:0px; background-color:#000000; font-family:Arial, Helvetica, sans-serif; }
#a{ position:absolute; height:600px; width:800px; left:50%; top:50%; margin-left:-400px; margin-top:-300px; background-color:#000; }
	#a1{ position:relative; width:100%; height:72px; text-align:center; background-color:#333333; }
		#a11{ position:relative; width:15%; height:100%; text-align:left; float:left; }
		#a12{ position:relative; width:85%; height:100%; text-align:center; float:left; font-size:x-large; color:#FFFFFF; }
	#a2{ position:relative; width:100%; height:28px; background-color:#999999; text-align:center; font-size:large; color:#333; font-weight:bold;  }	
	#a3{ position:relative; width:100%; height:500px; background-color:#fff;   }
		#a31{ text-align:right;}
			#txt_nde{ margin:2px; text-align:center; font-size:large; font-weight:bold; width:145px; background-image:url(../img/no_empleado.png); background-position:center; background-repeat:no-repeat;}
		#a32{ text-align:center; font-weight:bold; font-size:large; }
		#a33{ text-align:center; height:482px; background-color:#FFFFFF; }	
			#div_foto{ position:relative; width:480px; height:417px; left:50%; margin-left:-240px; margin-top:5px; border:#333333 1px dashed; background-position:center; background-repeat:no-repeat; }
			#txt_ES{ border:none; font-size:large; background-color:#ccc; text-align:center; font-weight:bold; }
			.fecha_hora{ width:100px; text-align:center; font-weight:normal; border:none; background-color:#FFFFFF; font-size:14px; }
#b{ /*color:#FFFF66; color:#000000;*/ color:#FFFF66; }			
</style>
<script language="javascript" src="../js/jquery.js"></script>
<script language="javascript">
$("document").ready(function(){  
	limpiar_datos();
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
</script>
</head>
<body>
<div id="a">
	<div id="a1">
		<div id="a11"><img src="../img/iq_128x96.jpg" style="margin:2px;" /></div>
		<div id="a12">
			<div>IQ Electronics International S.A. de C.V.</div>
			<div style="font-size:15px; text-align:center; color:#CCCCCC;">Sistema de Acceso de Personal</div>
			<div style=" font-size:small; color:#FFCC00; text-align:right; margin-top:10px; ">Recursos Humanos&nbsp;</div>
		</div>
	</div>
	<div id="a3">
		<div id="a31"><input type="text" id="txt_nde" maxlength="6" onKeyPress="tecla(0,event)" /></div>
		<div id="a32"><span id="spa_nde">&nbsp;</span>&nbsp;&nbsp;&nbsp;<span id="spa_nombre_completo">&nbsp;</span></div>
		<div id="a33">
			<div id="div_foto">&nbsp;</div>
			<div style="padding-top:5px;">
				<input type="text" id="txt_ES" readonly="1" value="" />
				<br /><input type="text" id="txt_fecha" readonly="1" class="fecha_hora" value="" />
				<input type="text" id="txt_hora" readonly="1" class="fecha_hora" value="" />
			</div>			
		</div>
		<div id="a34"></div>
	</div>
</div>
<div id="b"></div>
</body>
</html>