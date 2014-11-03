<?php
	session_start();
	if(!isset($_SESSION["id"])){
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Opciones Reporte</title>
    <link rel="stylesheet" type="text/css" href="../../includes/libs/datetimepicker-master/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.js"></script>
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.datetimepicker.js"></script>
	
    <script type="text/javascript">
    	$(document).ready(function(){
			jQuery("#txtFechaInicio").datetimepicker({
				lang : "es",
				timepicker:false,
 				format:'Y-m-d'
			});

			jQuery("#txtFechaFinal").datetimepicker({
				lang : "es",
				timepicker:false,
 				format:'Y-m-d'
			});
    	});
    </script>
</head>
<style type="text/css">
body{overflow: auto;font-size: 10px;}
</style>
<body>
	<form name="frmAgrega" id="frmAgrega" method="post" action="exportarReporte.php">
		<table border="0" align="center" cellpading="1" cellspacing="0" width="800" style="background:#FFF;margin-top:10px;">
			<tr>
				<td colspan="5" class="tituloAddUsuarios">Selecci&oacute;n de Fechas del Reporte</td>
			</tr>
			<tr>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>Fecha de Inicio</td>
				<td width="185"><input type="text" name="txtFechaInicio" id="txtFechaInicio" title="De click para seleccionar una fecha"></td>
				<td width="50">&nbsp;</td>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>Fecha de Termino:</td>
				<td width="185"><input type="text" name="txtFechaFinal" id="txtFechaFinal" title="De click para seleccionar una fecha"></td>
			</tr>
			<tr>
				<td colspan="5" class="leyenda">Los campos marcados con (<span class="obligatorio">*</span>) son obligatorios.</td>
			</tr>
			<tr>
				<td colspan="5"><hr style="background:#CCC;"></td>
			</tr>
			<tr>
				<td colspan="5" class="botonesAgregaUsuario"><input type="reset" name="" id="" value="Limpiar" /><input type="submit" name="" id="" value="Exportar reporte" /></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		</table>
</form>
</body>
</html>
