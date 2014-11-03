<?php
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	$nombreArchivo="reporteES_".date("Y-m-d");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$nombreArchivo.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$fechaInicial=$_POST["txtFechaInicio"];
	$fechaFinal=$_POST["txtFechaFinal"];
	//procedimiento para guardar al empleado
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";
	$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
	$sql="SELECT nombres,a_paterno,a_materno,fecha,hora,IF(ES=1,'Entrada','Salida') AS ES FROM reg_accesos INNER JOIN cat_personal ON reg_accesos.id_empleado=cat_personal.id WHERE fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'";
	$res=$obj->ejecutarQuery($sql);
	$tabla="<table border='0' cellpading='1' cellspacing='1'>";
	$tabla.="<tr>
				<td>Nombre</td>
				<td>Apellido Paterno</td>
				<td>Apellido Materno</td>
				<td>Fecha</td>
				<td>Hora</td>
				<td>Incidencia</td>
			</tr>";
	while($row=$obj->regresaResulatdos($res)){
		$tabla.="<tr>
				<td>".$row["nombres"]."</td>
				<td>".$row["a_paterno"]."</td>
				<td>".$row["a_materno"]."</td>
				<td>".$row["fecha"]."</td>
				<td>".$row["hora"]."</td>
				<td>".$row["ES"]."</td>
			</tr>";
	}
	$tabla.="</table>";
	echo $tabla;
?>