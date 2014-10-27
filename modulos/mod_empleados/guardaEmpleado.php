<?php
	//procedimiento para guardar al empleado
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";

	//se recuperan los elementos del formulario
	/*echo count($_POST)."<br>";
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

	$txtNoEmpleado=$_POST["txtNoEmpleado"];
	$txtFechaIngreso=$_POST["txtFechaIngreso"];
	$txtNombre=$_POST["txtNombre"];
	$apellidoPaterno=$_POST["apellidoPaterno"];
	$apellidoMaterno=$_POST["apellidoMaterno"];
	$cboTipo=$_POST["cboTipo"];
	$email=$_POST["email"];
	$txtRfc=strtoupper($_POST["txtRfc"]);
	$telcasa=$_POST["telcasa"];
	$celular=$_POST["celular"];
	$cboDepto=$_POST["cboDepto"];
	$txtCargo=$_POST["txtCargo"];
	$estadoCivil=$_POST["estadoCivil"];
	$cboActivo=$_POST["cboActivo"];
	$rdbSexo=$_POST["rdbSexo"];
	$txtImss=$_POST["txtImss"];
	$txtFechaNacimiento=$_POST["txtFechaNacimiento"];
	$txtcurp=strtoupper($_POST["txtcurp"]);
	$txtFechaInicioContrato=$_POST["txtFechaInicioContrato"];
	$txtFechaFinContrato=$_POST["txtFechaFinContrato"];
	$txtcalle=$_POST["txtcalle"];
	$txtColonia=$_POST["txtColonia"];
	$txtCiudad=$_POST["txtCiudad"];
	$txtMunicipio=$_POST["txtMunicipio"];
	$txtcp=$_POST["txtcp"];
	$txtcuenta=$_POST["txtcuenta"];
	$obs=$_POST["obs"];
	
//exit();

	if($txtNoEmpleado=="" || $txtFechaIngreso=="" || $txtNombre=="" || $apellidoPaterno=="" || $apellidoMaterno=="" || $cboDepto=="" || $txtCargo=="" || $estadoCivil=="" || $rdbSexo=="" || $txtFechaNacimiento==""){
		echo "<script type='text/javascript'> alert('Los campos marcados con * son obligatorios'); </script>";
		echo "<script type='text/javascript'> history.back(); </script>";
	}else{
		//proceso de guardado de los datos en la tabla
		
		$sql="INSERT INTO cat_personal(id_area,tipo_nomina,no_empleado,nombres,a_paterno,a_materno,email,telefono,telefono_cel,cargo,estado_civil,fecha_ingreso,sexo,fecha_alta,fecha_nacimiento,curp,obs,contrato_fecha_inicio,contrato_fecha_fin,calle,colonia,ciudad_estado,municipio_delegacion,codigo_postal,rfc,imss,num_cta_bancaria)";
		$values=" VALUES ('".$cboDepto."',
			'".$cboTipo."',
			'".$txtNoEmpleado."',
			'".$txtNombre."',
			'".$apellidoPaterno."',
			'".$apellidoMaterno."',
			'".$email."',
			'".$telcasa."',
			'".$celular."',
			'".$txtCargo."',
			'".$estadoCivil."',
			'".$txtFechaIngreso."',
			'".$rdbSexo."',
			'".date("Y-m-d")."',
			'".$txtFechaNacimiento."',
			'".$txtcurp."',
			'".$obs."',
			'".$txtFechaInicioContrato."',
			'".$txtFechaFinContrato."',
			'".$txtcalle."',
			'".$txtColonia."',
			'".$txtCiudad."',
			'".$txtMunicipio."',
			'".$txtcp."',
			'".$txtRfc."',
			'".$txtImss."',
			'".$txtcuenta."')";
		//echo $sql.$values;
		$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
		$res=$obj->ejecutarQuery($sql.$values);
		if($res){
			echo "<script type='text/javascript'> alert('Registro Guardado Exitosamente'); </script>";
			echo "<script type='text/javascript'> window.location.href='index.php'; </script>";
		}else{
			echo "<script type='text/javascript'> alert('Error al guardar el registro'); </script>";
			echo "<script type='text/javascript'> history.back(); </script>";
		}
	}
?>