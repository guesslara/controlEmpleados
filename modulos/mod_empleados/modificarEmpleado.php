<?php
	/*modificacion de usuarios*/
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";	
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar empleado</title>
    <link rel="stylesheet" type="text/css" href="../../includes/libs/datetimepicker-master/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.js"></script>
	<script type="text/javascript" src="../../includes/libs/datetimepicker-master/jquery.datetimepicker.js"></script>
	
</head>
<style type="text/css">
body{overflow: auto;font-size: 10px;}
</style>
<body>
<div id="barraHerramientasEmpleados">
	<a href="index.php" class="btnHerramientasEmpleados" title="Listado de Empleados"><img src="../../img/Report-32.png" width="32" height="32" border="0" />Listado de empleados</a>
	<a href="agregarEmpleado.php" class="btnHerramientasEmpleados" title="Agregar empleado"><img src="../../img/facturacion.png" width="32" height="32" border="0" />Agregar empleado</a>
</div>
<div style="margin:10px;">
	<form name="frmBuscar" id="frmBuscar" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
		<table border="0" width="600" cellpading="1" cellspacing="1" style="background:#FFF;">
			<tr>
				<td width="100" align="right">Buscar empleado:</td>
				<td width="200"><input type="text" name="txtBuscar" id="txtBuscar" style="width:350px;" /></td>
				<td width="100"><input type="submit" value="Buscar"></td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<input type="radio" name="filtro" id="noEmpleado" value="no_empleado" checked="checked" /><label for="noEmpleado">No Empleado</label>
					<input type="radio" name="filtro" id="nombres" value="nombres" /><label for="nombres">Nombre</label>
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="margin:10px;">
<?php
	if($_POST){
		//proceso para la busqueda
		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		$filtro=$_POST["filtro"];
		$txtBuscar=$_POST["txtBuscar"];
		if($filtro=="nombres"){
			$sqlBuscar="SELECT id,no_empleado,nombres,a_paterno,a_materno FROM cat_personal WHERE nombres LIKE '%".$txtBuscar."%' OR a_paterno LIKE '%".$txtBuscar."%' OR a_materno LIKE '%".$txtBuscar."%'";
		}elseif($filtro=="no_empleado"){
			$sqlBuscar="SELECT id,no_empleado,nombres,a_paterno,a_materno FROM cat_personal WHERE no_empleado LIKE '%".$txtBuscar."%'";
		}
//echo $sqlBuscar;
		$obj= new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
		
		$resBuscar=$obj->ejecutarQuery($sqlBuscar);
		if($obj->numeroRegistros($resBuscar)==0){
			echo "<br />(0) coincidencias en la busqueda.";
			exit();
		}else{
			//se muestran los resultados de la busqueda
?>
			<table border="0" cellpading="1" cellspacing="1" width="600" style="background:#FFF;">
				<tr>
					<td class="tituloCampo">Acci&oacute;n</td>
					<td class="tituloCampo">No. Empleado</td>
					<td class="tituloCampo">Nombre(s)</td>
					<td class="tituloCampo">Apellido Paterno</td>
					<td class="tituloCampo">Apellido Materno</td>
				</tr>
<?php			
			while($rowBuscar=$obj->regresaResulatdos($resBuscar)){
?>
				<tr>
					<td class="tituloCampo2"><a href="modificaInfo.php?emp=<?php echo $rowBuscar["id"];?>" title="Modificar Informaci&oacute;n">Editar</a></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["no_empleado"];?></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["nombres"];?></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["a_paterno"];?></td>
					<td class="tituloCampo2"><?php echo $rowBuscar["a_materno"];?></td>
				</tr>
<?php
			}
?>
			</table>
<?php			
		}
	}
?>
</div>
</body>
</html>