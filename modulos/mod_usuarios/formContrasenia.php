<?php
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";	
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar empleado</title>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
</head>
<style type="text/css">
body{overflow: auto;font-size: 10px;}
</style>
<body>
<div style="margin:10px;">
<?php
		$txtBuscar=$_POST["txtBuscar"];
		$sqlBuscar="SELECT id,nombre_completo,usuario,nivel_acceso FROM cat_usuarios WHERE usuario NOT IN ('Admin')";
		$obj= new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
		$resBuscar=$obj->ejecutarQuery($sqlBuscar);
		if($obj->numeroRegistros($resBuscar)==0){
			echo "<br />(0) registros encontrados.";
			exit();
		}else{//se muestran los resultados de la busqueda
?>
			<table align="center" border="0" cellpading="1" cellspacing="1" width="600" style="background:#FFF;">
				<tr>
					<td colspan="4" class="tituloAddUsuarios">Modificar contrase&ntilde;a</td>
				</tr>
				<tr>
					<td class="tituloCampo">Acci&oacute;n</td>
					<td class="tituloCampo">Nombre</td>
					<td class="tituloCampo">Usuario</td>
					<td class="tituloCampo">Nivel de Acceso</td>
				</tr>
<?php			
			while($rowBuscar=$obj->regresaResulatdos($resBuscar)){
?>
				<tr>
					<td class="tituloCampo2"><a href="modificaInfo.php?emp=<?php echo $rowBuscar["id"];?>" title="Modificar Informaci&oacute;n">Editar</a></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["nombre_completo"];?></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["usuario"];?></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["nivel_acceso"];?></td>
				</tr>
<?php
			}
?>
			</table>
<?php			
		}
?>
</div>
</body>
</html>