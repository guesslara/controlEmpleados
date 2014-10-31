<?php
	session_start();
	if(!isset($_SESSION["id"])){
		//header("Location: ../mod_login/index.php");
		//exit();
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
	// include db config
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";

	$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
	$sqlDeptos="SELECT id,descripcion FROM cat_areas WHERE activo='1'";
	$res=$obj->ejecutarQuery($sqlDeptos);
	if($obj->numeroRegistros($res)==0){
		echo "( 0 ) registros encontrados.";
	}else{
		$deptos="";
		while($row=$obj->regresaResulatdos($res)){
			$deptos.="<option value='".$row["id"]."'>".$row["descripcion"]."</option>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar usuario</title>
    <link rel="stylesheet" type="text/css" href="../../includes/libs/datetimepicker-master/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.js"></script>
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.datetimepicker.js"></script>
	
    <script type="text/javascript">
    	$(document).ready(function(){
			jQuery("#txtFechaIngreso").datetimepicker({
				lang : "es",
				timepicker:false,
 				format:'Y-m-d'
			});
    	});

    	$(document).ready(function(){
			jQuery("#txtFechaNacimiento").datetimepicker({
				lang : "es",
				timepicker:false,
 				format:'Y-m-d'
			});
    	});

    	$(document).ready(function(){
			jQuery("#txtFechaInicioContrato").datetimepicker({
				lang : "es",
				timepicker:false,
 				format:'Y-m-d'
			});
    	});

		$(document).ready(function(){
			jQuery("#txtFechaFinContrato").datetimepicker({
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
	<form name="frmAgrega" id="frmAgrega" method="post" action="guardaEmpleado.php">
		<table border="0" align="center" cellpading="1" cellspacing="0" width="800" style="background:#FFF;margin-top:10px;">
			<tr>
				<td colspan="5" class="tituloAddUsuarios">Agregar Usuarios</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Nombre completo:</td>
				<td><input type="text" name="txtNombre" id="txtNombre"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>Usuario:</td>
				<td width="185"><input type="text" name="txtNoEmpleado" id="txtNoEmpleado"></td>
				<td width="50">&nbsp;</td>
				<td width="190">&nbsp;</td>
				<td width="185">&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Password:</td>
				<td><input type="password" name="txtNombre" id="txtNombre"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Repetir Password:</td>
				<td><input type="password" name="txtNombre" id="txtNombre"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Nivel de acceso</td>
				<td>
					<select name="cboTipo" id="cboTipo">
						<option value="" selected="selected">Seleccionar...</option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Observaciones:</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5"><textarea name="obs" id="obs" cols="50" rows="4"></textarea></td>
			</tr>
			<tr>
				<td colspan="5" class="leyenda">Los campos marcados con (<span class="obligatorio">*</span>) son obligatorios.</td>
			</tr>
			<tr>
				<td colspan="5"><hr style="background:#CCC;"></td>
			</tr>
			<tr>
				<td colspan="5" class="botonesAgregaUsuario"><input type="reset" name="" id="" value="Limpiar" /><input type="submit" name="" id="" value="Guardar" /></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		</table>
</form>
</body>
</html>
