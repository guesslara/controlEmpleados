<?php
	/*
	Verificacion del usuario en la base de datos metodos a llamar en GUI
	Fecha de creacion:10 - Junio - 2010
	*/
	include "../../includes/config.inc-s.php";
	include "../../includes/libs/mysql.php";
	
	//se llama al modelo
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	if($_SERVER["HTTP_REFERER"]==""){
		header("Location: index.php?error=1");
		exit;
	}else{
		$usuarioEntrante=mysql_real_escape_string(strip_tags($_POST['txtUsuario']));
		$passEntrante=mysql_real_escape_string(strip_tags($_POST['txtPassword']));
		if($usuarioEntrante=="" || $passEntrante==""){
			header("Location: index.php?error=0");
			exit;
		}else{
			//se instancia el manejador de la base de datos
			$objBd=new mysql($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"],$configGral["bd"]["base"],$configGral["bd"]["puerto"]);
			//se construye el SQL
			$sqlVerifica="SELECT id,contrasena,nivel_acceso,nombre_completo FROM cat_usuarios WHERE usuario='".mysql_real_escape_string(strip_tags($usuarioEntrante))."'";
			$res=$objBd->ejecutarQuery($sqlVerifica);//se ejecuta el query
			if($objBd->numeroRegistros($res)==0){//se redirige en caso de error
				header("Location: index.php?error=1");
				exit;
			}else{//caso contrario se inicia el proceso para la validacion de la contraseña
				$row=$objBd->regresaResulatdos($res);
				$contrasenaBd=$row["contrasena"];
				$passEntrante=md5($passEntrante);
				if($passEntrante != $contrasenaBd){
					header("Location: index.php?error=2");
					exit;
				}else{
					session_start();//se inicia la sesion del usuario
					session_name("controlEmpleados");//se coloca el nombre a la sesion
					session_cache_limiter('nocache,private');//se evita la cache
					//se inicializan las variables para la sesion
					$_SESSION['nombreUsuario']=$usuarioEntrante;
					$_SESSION['pass']=$contrasenaBd;				
					$_SESSION['id']=$row["id"];				
					$_SESSION['nivel']=$row["nivel_acceso"];
					$_SESSION['nombre_completo']=$row["nombre_completo"];
					unset($usuarioEntrante);//se liberan las variables
					unset($passEntrante);//se liberan las variables
					$objBd->liberarResultado($res);//se libera el resultado de la base de datos
					header("Location: ../mod_App/index.php");//se redirige al modulo principal
					exit;
				}
			}
		}
	}	
?>