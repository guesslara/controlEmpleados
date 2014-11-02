<?php
	//procedimiento para guardar al empleado
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	//se recuperan los elementos del formulario
    $txtPass1=$_POST["txtPass1M"];
    $txtPass2=$_POST["txtPass2M"];
    $hdnIdUsuario=$_POST["hdnIdUsuario"];
    echo "<br>".$txtPass1;
    echo "<br>".$txtPass2;
    //exit();
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
	    $obj=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
	    //se arma la consulta de la actualizacion
	    $sqlUsuario="UPDATE cat_usuarios SET contrasena='".$txtPass1."' WHERE id='".$hdnIdUsuario."'";
	    $res=$obj->ejecutarQuery($sqlUsuario);
	    if($res){
	    	echo "<script type='text/javascript'> alert('Registro Guardado Exitosamente'); </script>";
			echo "<script type='text/javascript'> window.location.href='index.php'; </script>";
		}else{
			echo "<script type='text/javascript'> alert('Error al actualizar o no se realizaron cambios el registro'); </script>";
			echo "<script type='text/javascript'> history.back(); </script>";
		}
    }
?>