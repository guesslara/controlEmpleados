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
    <title>Agregar usuario</title>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
</head>
<style type="text/css">
body{overflow: auto;font-size: 10px;}
</style>
<body>
	<form name="frmAgrega" id="frmAgrega" method="post" action="guardaUsuario.php">
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
				<td width="185"><input type="text" name="txtUsuario" id="txtUsuario"></td>
				<td width="50">&nbsp;</td>
				<td width="190">&nbsp;</td>
				<td width="185">&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Password:</td>
				<td><input type="password" name="txtPass1" id="txtPass1"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Repetir Password:</td>
				<td><input type="password" name="txtPass2" id="txtPass2"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Nivel de acceso</td>
				<td>
					<select name="cboNivel" id="cboNivel">
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