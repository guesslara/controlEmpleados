<?php
	session_start();
	unset($_SESSION['nombreUsuario']);
	unset($_SESSION['pass']);				
	unset($_SESSION['id']);				
	unset($_SESSION['nivel']);
	unset($_SESSION['nombre_completo']);
	header("Location: mod_login/index.php");
	exit();
?>