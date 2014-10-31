<?php
	session_start();
	if(!isset($_SESSION["id"])){
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
	include "../../includes/templates/header.inc.php";
?>
<script type="text/javascript" src="js/funcionesApp.js"></script>
<div id="contenedorApp">
	<div id="barraHerramientas">
		<div class="btnHerramientas" title="Departamentos / &Aacute;reas" onclick="modulos('deptos')">
			<div class="imgHerramientas"><img src="../../img/directorio.png" width="32" height="32" border="0" /></div>
			Deptos
		</div>
		<div class="btnHerramientas" title="Empleados" onclick="modulos('empleados')">
			<div class="imgHerramientas"><img src="../../img/recurso1.png" width="32" height="32" border="0" /></div>
			Empleados
		</div>
		<div class="btnHerramientas" title="Reporte de Entradas / Salidas">
			<div class="imgHerramientas"><img src="../../img/ince.png" width="32" height="32" border="0" /></div>
			Ent/Sal
		</div>
<?php
	if($_SESSION["nivel"]==0){
?>
		<div class="btnHerramientas" title="Alta de Usuarios" onclick="modulos('usuarios')">
			<div class="imgHerramientas"><img src="../../img/warning4.png" width="32" height="32" border="0" /></div>
			Usuarios
		</div>
<?php
	}
?>		
		<div onclick="cerrarSesion()" class="btnHerramientasCerrar" title="Cerrar sesi&oacute;n">
			<div class="imgHerramientas"><img src="../../img/shutdown1.png" width="40" height="40" border="0" /></div>
			Cerrar
		</div>
		<div id="datosUsuario">
			<div style="margin:3px;">
<?php 
			echo $_SESSION["nombre_completo"];
?>			
			</div>
			<div style="margin:3px;"><?php echo $configGral["nombre"]["sistema"];?></div>
		</div>
	</div>
	<!--contenedor para las aplicaciones-->
	<iframe id="contenedorModulos" name="contenedorVentana" scrolling="yes"></iframe>
</div><!--Fin div contenedor-->
<?php
	include "../../includes/templates/footer.inc.php";
?>