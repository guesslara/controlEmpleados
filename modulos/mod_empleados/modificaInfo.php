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
	$idEmpleado=trim($_GET["emp"]);
	//se extrae la info del empleado
	$sqlEmp="SELECT * FROM cat_personal WHERE id='".$idEmpleado."'";
	$resEmp=$obj->ejecutarQuery($sqlEmp);
	if($obj->numeroRegistros($resEmp)==0){
		echo "Error, empleado desconocido.";
		exit();
	}else{
		$rowEmp=$obj->regresaResulatdos($resEmp);
		//se obtiene el area seleccionada
		$sqlA="SELECT id,descripcion FROM cat_areas WHERE id='".$rowEmp["id_area"]."'";
		$resA=$obj->ejecutarQuery($sqlA);
		$rowA=$obj->regresaResulatdos($resA);
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar Informaci&oacute;n</title>
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
	<form name="frmModifica" id="frmModifica" method="post" action="guardaEmpleadoModifica.php">
		<input type="hidden" name="txtIdEmpleado" id="txtIdEmpleado" value="<?=$rowEmp["id"];?>">
		<table border="0" align="center" cellpading="1" cellspacing="0" width="800" style="background:#FFF;margin-top:10px;">
			<tr>
				<td colspan="5" class="tituloAddUsuarios">Modificar Informaci&oacute;n</td>
			</tr>
			<tr>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>No. Empleado:</td>
				<td width="185"><input type="text" name="txtNoEmpleado" id="txtNoEmpleado" value="<?=$rowEmp["no_empleado"];?>"></td>
				<td width="50">&nbsp;</td>
				<td width="190" class="tituloCampo"><span class="obligatorio">*</span>Fecha de Ingreso</td>
				<td width="185"><input type="text" name="txtFechaIngreso" id="txtFechaIngreso" title="De click para seleccionar una fecha" value="<?=$rowEmp["fecha_ingreso"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Nombre:</td>
				<td><input type="text" name="txtNombre" id="txtNombre" value="<?=$rowEmp["nombres"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Apellido Paterno:</td>
				<td><input type="text" name="apellidoPaterno" id="apellidoPaterno" value="<?=$rowEmp["a_paterno"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Apellido Materno:</td>
				<td><input type="text" name="apellidoMaterno" id="apellidoMaterno" value="<?=$rowEmp["a_materno"];?>"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Tipo de Nomina</td>
				<td>
					<select name="cboTipo" id="cboTipo">
						<option value="<?=$rowEmp["tipo_nomina"];?>" selected="selected"><?=$rowEmp["tipo_nomina"];?></option>
						<option value="Quincenal">Qunicenal</option>
						<option value="Semanal">Semanal</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="tituloCampo">Email:</td>
				<td><input type="text" name="email" id="email" value="<?=$rowEmp["email"];?>"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">RFC</td>
				<td><input type="text" name="txtRfc" id="txtRfc" value="<?=$rowEmp["rfc"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo">Telefono casa:</td>
				<td><input type="text" name="telcasa" id="telcasa" value="<?=$rowEmp["telefono"];?>"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Celular:</td>
				<td><input type="text" name="celular" id="celular" value="<?=$rowEmp["telefono_cel"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Departamento:</td>
				<td>
					<select name="cboDepto" id="cboDepto">
						<option value="<?=$rowA["id"];?>" selected="selected"><?=$rowA["descripcion"];?></option>
						<?php echo $deptos; ?>
					</select>
				</td>
				<td>&nbsp;</td>
				<td class="tituloCampo"><span class="obligatorio">*</span>Cargo:</td>
				<td><input type="text" name="txtCargo" id="txtCargo" value="<?=$rowEmp["cargo"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Estado civil:</td>
				<td>
					<select name="estadoCivil" id="estadoCivil">
						<option selected="selected" value="<?=$rowEmp["estado_civil"];?>"><?=$rowEmp["estado_civil"];?>(a)</option>
						<option value="Soltero">Soltero(a)</option>
						<option value="Casado">Casado(a)</option>
						<option value="Viudo">Viudo(a)</option>
						<option value="Union Libre">Uni&oacute;n libre</option>
					</select>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Sexo:</td>
				<td>
<?php
					if($rowEmp["sexo"]=="Masculino"){
?>
						<input type="radio" name="rdbSexo" id="rdbMasculino" value="Masculino" checked="checked"><label for="rdbMasculino">Masculino</label><br />
						<input type="radio" name="rdbSexo" id="rdbFemenino" value="Femenino"><label for="rdbFemenino">Femenino</label>
<?php
					}else{
?>
						<input type="radio" name="rdbSexo" id="rdbMasculino" value="Masculino"><label for="rdbMasculino">Masculino</label><br />
						<input type="radio" name="rdbSexo" id="rdbFemenino" value="Femenino" checked="checked"><label for="rdbFemenino">Femenino</label>
<?php
					}
?>					
				</td>
				<td>&nbsp;</td>
				<td class="tituloCampo">IMSS</td>
				<td><input type="text" name="txtImss" id="txtImss" value="<?=$rowEmp["imss"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Fecha de nacimiento:</td>
				<td><input type="text" name="txtFechaNacimiento" id="txtFechaNacimiento" title="De click para seleccionar una fecha" value="<?=$rowEmp["fecha_nacimiento"];?>"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Curp:</td>
				<td><input type="text" name="txtcurp" id="txtcurp" value="<?=$rowEmp["curp"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo">Fecha de inicio contrato</td>
				<td><input type="text" name="txtFechaInicioContrato" id="txtFechaInicioContrato" title="De click para seleccionar una fecha" value="<?=$rowEmp["contrato_fecha_inicio"];?>"></td>
				<td>&nbsp;</td>
				<td class="tituloCampo">Fecha de fin de contrato</td>
				<td><input type="text" name="txtFechaFinContrato" id="txtFechaFinContrato" title="De click para seleccionar una fecha" value="<?=$rowEmp["contrato_fecha_fin"];?>"></td>
			</tr>
			<tr>
				<td class="tituloCampo">Calle y numero:</td>
				<td><input type="text" name="txtcalle" id="txtcalle" value="<?=$rowEmp["calle"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Colonia:</td>
				<td><input type="text" name="txtColonia" id="txtColonia" value="<?=$rowEmp["colonia"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Ciudad</td>
				<td><input type="text" name="txtCiudad" id="txtCiudad" value="<?=$rowEmp["ciudad_estado"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Municipio / Delegaci&oacute;n</td>
				<td><input type="text" name="txtMunicipio" id="txtMunicipio" value="<?=$rowEmp["municipio_delegacion"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">C&oacute;digo postal</td>
				<td><input type="text" name="txtcp" id="txtcp" maxlength="5" size="5" value="<?=$rowEmp["codigo_postal"];?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo">Cuenta Bancaria</td>
				<td><input type="text" name="txtcuenta" id="txtcuenta" value="<?=$rowEmp["num_cta_bancaria"];?>"></td>
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
				<td colspan="5"><textarea name="obs" id="obs" cols="50" rows="4"><?=$rowEmp["obs"];?></textarea></td>
			</tr>
			<tr>
				<td colspan="5" class="leyenda">Los campos marcados con (<span class="obligatorio">*</span>) son obligatorios.</td>
			</tr>
			<tr>
				<td colspan="5"><hr style="background:#CCC;"></td>
			</tr>
			<tr>
				<td colspan="5" class="botonesAgregaUsuario"><input type="reset" name="" id="" value="Limpiar" /><input type="submit" name="" id="" value="Guardar cambios" /></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		</table>
</form>
</body>
</html>
