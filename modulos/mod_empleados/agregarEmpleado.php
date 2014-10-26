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
    <title>Agregar empleado</title>
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
	<form name="" id="" method="post" action="">
		<table border="0" align="center" cellpading="1" cellspacing="0" width="800" style="background:#FFF;margin-top:10px;">
			<tr>
				<td colspan="5" class="tituloAddUsuarios">Alta de Empleados</td>
			</tr>
			<tr>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>No. Empleado:</td>
				<td width="185"><input type="text" name="" id=""></td>
				<td width="50">&nbsp;</td>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>Fecha de Ingreso</td>
				<td width="185"><input type="text" name="txtFechaIngreso" id="txtFechaIngreso" title="De click para seleccionar una fecha"></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Nombre:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Apellido Paterno:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Apellido Materno:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Email:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Telefono casa:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Celular:</td>
				<td><input type="text" name="" id=""></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Departamento:</td>
				<td>
					<select>
						<option value="" selected="selected">Seleccionar...</option>
						<?php echo $deptos; ?>
					</select>
				</td>
				<td>&nbsp;</td>
				<td class="tituloCampo"><span class="obligatorio">*</span>Cargo:</td>
				<td><input type="text" name="" id=""></td>
			</tr>
			<tr>
				<td class="tituloCampo">Estado civil:</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="tituloCampo"><span class="obligatorio">*</span>Estatus laboral:</td>
				<td>
					<select>
						<option value="" selected="selected">Seleccionar...</option>
						<option value="1">Activo</option>
						<option value="0">Inactivo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Sexo:</td>
				<td>
					<input type="radio" name="rdbSexo" id="rdbMasculino" value="M"><label for="rdbMasculino">Masculino</label><br />
					<input type="radio" name="rdbSexo" id="rdbFemenino" value="M"><label for="rdbFemenino">Femenino</label>
				</td>
				<td>&nbsp;</td>
				<td class="tituloCampo"><span class="obligatorio">*</span>Estado civil:</td>
				<td>
					<select>
						<option value="" selected="selected">Seleccionar...</option>
						<option value="Soltero">Soltero</option>
						<option value="Casado">Casado</option>
						<option value="Viudo">Viudo(a)</option>
						<option value="Union Libre">Uni&oacute;n libre</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Fecha de nacimiento:</td>
				<td><input type="text" name="txtFechaNacimiento" id="txtFechaNacimiento" title="De click para seleccionar una fecha"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Curp:</td>
				<td><input type="text" name="" id=""></td>
			</tr>
			<tr>
				<td class="tituloCampo">Fecha de inicio contrato</td>
				<td><input type="text" name="txtFechaInicioContrato" id="txtFechaInicioContrato" title="De click para seleccionar una fecha"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Fecha de fin de contrato</td>
				<td><input type="text" name="txtFechaFinContrato" id="txtFechaFinContrato" title="De click para seleccionar una fecha"></td>
			</tr>
			<tr>
				<td class="tituloCampo">Calle y numero:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Colonia:</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Ciudad</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Municipio / Delegaci&oacute;n</td>
				<td><input type="text" name="" id=""></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">C&oacute;digo postal</td>
				<td><input type="text" name="" id="" maxlength="5" size="5"></td>
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
				<td colspan="5"><textarea name="" id="" cols="50" rows="4"></textarea></td>
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
