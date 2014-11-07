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
	$txtIdEmpleado=$_POST["txtIdEmpleado"];
//exit();
	if($txtNoEmpleado=="" || $txtFechaIngreso=="" || $txtNombre=="" || $apellidoPaterno=="" || $apellidoMaterno=="" || $cboDepto=="" || $txtCargo=="" || $estadoCivil=="" || $rdbSexo=="" || $txtFechaNacimiento==""){
		echo "<script type='text/javascript'> alert('Los campos marcados con * son obligatorios'); </script>";
		echo "<script type='text/javascript'> history.back(); </script>";
	}else{
		$update="UPDATE cat_personal SET 
		id_area='".$cboDepto."',
		tipo_nomina='".$cboTipo."',
		no_empleado='".$txtNoEmpleado."',
		nombres='".$txtNombre."',
		a_paterno='".$apellidoPaterno."',
		a_materno='".$apellidoMaterno."',
		email='".$email."',
		telefono='".$telcasa."',
		telefono_cel='".$celular."',
		cargo='".$txtCargo."',
		estado_civil='".$estadoCivil."',
		fecha_ingreso='".$txtFechaIngreso."',
		sexo='".$rdbSexo."',
		fecha_nacimiento='".$txtFechaNacimiento."',
		curp='".$txtcurp."',
		obs='".$obs."',
		contrato_fecha_inicio='".$txtFechaInicioContrato."',
		contrato_fecha_fin='".$txtFechaFinContrato."',
		calle='".$txtcalle."',
		colonia='".$txtColonia."',
		ciudad_estado='".$txtCiudad."',
		municipio_delegacion='".$txtMunicipio."',
		codigo_postal='".$txtcp."',
		rfc='".$txtRfc."',
		imss='".$txtImss."',
		num_cta_bancaria='".$txtcuenta."' WHERE id='".$txtIdEmpleado."'";

		$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
		$res=$obj->ejecutarQuery($update);
		if($res){
			echo "<script type='text/javascript'> alert('Registro Actualizado Exitosamente'); </script>";
			echo "<script type='text/javascript'> window.location.href='index.php'; </script>";
		}else{
			echo "<script type='text/javascript'> alert('No se registraron cambios o ha ocurrido un error al Actualizar el registro'); </script>";
			echo "<script type='text/javascript'> history.back(); </script>";
		}
	}
?>