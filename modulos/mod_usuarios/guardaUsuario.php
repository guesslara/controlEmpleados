<?php
	//procedimiento para guardar al empleado
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";

	//se recuperan los elementos del formulario
	/*echo count($_POST)."<br>";
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

	$txtNombre=$_POST["txtNombre"];
    $txtUsuario=$_POST["txtUsuario"];
    $txtPass1=$_POST["txtPass1"];
    $txtPass2=$_POST["txtPass2"];
    $cboNivel=$_POST["cboNivel"];
    $obs=$_POST["obs"];
    //verificacion de la contraseña del usuario
    if($txtPass1=="" || $txtPass2==""){
    	echo "<script type='text/javascript'> alert('El campo de la contraseña no debe de ir vacio.'); </script>";
		echo "<script type='text/javascript'> history.back(); </script>";
    }elseif($txtPass1 != $txtPass2){
		echo "<script type='text/javascript'> alert('Los passwords no coinciden'); </script>";
		echo "<script type='text/javascript'> history.back(); </script>";
    }elseif(strlen($txtPass1) < 6){
    	echo "<script type='text/javascript'> alert('La contraseña debe tener minimo 6 caracteres'); </script>";
		echo "<script type='text/javascript'> history.back(); </script>";
    }else{
    	$txtPass1=md5($txtPass1);
    	 //verificaciones
	    if($txtNombre=="" || $txtUsuario=="" || $cboNivel==""){
			echo "<script type='text/javascript'> alert('Llene los campos marcados con un (*)'); </script>";
			echo "<script type='text/javascript'> history.back(); </script>";
	    }else{
	    	$obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
	    	//se arma la consulta de la insercion
	    	$sqlUsuario="INSERT INTO cat_usuarios(usuario,contrasena,nombre_completo,nivel_acceso,obs) VALUES ('".$txtUsuario."','".$txtPass1."','".$txtNombre."','".$cboNivel."','".$obs."')";
	    	$res=$obj->ejecutarQuery($sqlUsuario);
	    	if($res){
	    		echo "<script type='text/javascript'> alert('Registro Guardado Exitosamente'); </script>";
				echo "<script type='text/javascript'> window.location.href='index.php'; </script>";
			}else{
				echo "<script type='text/javascript'> alert('Error al guardar el registro'); </script>";
				echo "<script type='text/javascript'> history.back(); </script>";
			}
	    }
    }
?>