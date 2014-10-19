<?php
	/*
	Verificacion del usuario en la base de datos metodos a llamar en GUI
	Fecha de creacion:10 - Junio - 2010
	Autor: Gerardo Lara
	*/
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";
	
	//se llama al modelo
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";

	//exit();
	
	$usuarioEntrante=mysql_real_escape_string(strip_tags($_POST['txtUsuario']));
	$passEntrante=mysql_real_escape_string(strip_tags($_POST['txtPassword']));
	if($usuarioEntrante=="" || $passEntrante==""){
		header("Location: index.php?error=0");
		exit;
	}else{
		//se instancia el manejador de la base de datos
		$objBd=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
		$sqlVerifica="SELECT id,contrasena,nivel_acceso FROM cat_usuarios WHERE usuario='".mysql_real_escape_string(strip_tags($usuarioEntrante))."'";
		$res=$objBd->ejecutarQuery($sqlVerifica);
		if($objBd->numeroRegistros($res)==0){
			header("Location: index.php?error=1");
			exit;
		}else{
			$row=$objBd->regresaResulatdos($res);
			echo "<br>".$contrasenaBd=$row["contrasena"];
			echo "<br>".$passEntrante=md5($passEntrante);
			if($passEntrante != $contrasenaBd){
				header("Location: index.php?error=2");
				exit;
			}else{
				session_start();//se inicia la sesion del usuario
				session_name("controlEmpleados");
				session_cache_limiter('nocache,private');
				$_SESSION['nombreUsuario']=$usuarioEntrante;				
				$_SESSION['pass']=$contrasenaBd;				
				$_SESSION['id']=$row["id"];				
				$_SESSION['nivel']=$row["nivel"];
				unset($usuarioEntrante);
				unset($passEntrante);
				$objBd->liberarResultado($res);
				$objBd->cerrarConexion();
				header("Location: ../mod_App/index.php");
				exit;
			}
		}
	}	
?>