<?php
	session_start();
	if(!isset($_SESSION["id"])){
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
	// include db config
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";
	$emp=$_GET["emp"];
	$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
	$sqlUsuarios="SELECT * FROM cat_usuarios WHERE id='".$emp."'";
	$res=$obj->ejecutarQuery($sqlUsuarios);
	if($obj->numeroRegistros($res)==0){
		echo "( 0 ) registros encontrados.";
	}else{
		$row=$obj->regresaResulatdos($res);
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar ...</title>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
</head>
<style type="text/css">
body{overflow: auto;font-size: 10px;}
</style>
<body>
	<form name="frmAgrega" id="frmAgrega" method="post" action="modificaContrasena.php">
		<input type="hidden" name="hdnIdUsuario" id="hdnIdUsuario" value="<?=$emp;?>" />
		<table border="0" align="center" cellpading="1" cellspacing="0" width="800" style="background:#FFF;margin-top:10px;">
			<tr>
				<td colspan="5" class="tituloAddUsuarios">Modificar Contrase&ntilde;a</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Password:</td>
				<td><input type="password" name="txtPass1M" id="txtPass1M" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tituloCampo"><span class="obligatorio">*</span>Repetir Password:</td>
				<td><input type="password" name="txtPass2M" id="txtPass2M" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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
