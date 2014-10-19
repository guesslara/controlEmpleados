<?php
	include "../../includes/templates/header.inc.php";
	if($_GET["error"]!=""){
		if($_GET["error"]==0){
			echo "<div class='error'>Error, verifique la informaci&oacute;n</div>";
		}else if($_GET["error"]==1){
			echo "<div class='error'>Error, informaci&oacute;n no valida</div>";
		}else if($_GET["error"]==2){
			echo "<div class='error'>Error, acceso no Valido</div>";
		}
		
	}
?>
<form name="frmLogin" id="frmLogin" method="post" action="controladorLogin.php">
	<div id="contenedorLogin">
		<div class="bienvenido">Bienvenido</div>
		<div class="datosUsuario">
			<div class="usuario">Usuario:</div>
			<div class="cajasLogin"><input type="text" id="txtUsuario" name="txtUsuario" style="font-size:24px;text-align:center;" /></div>
			<div class="password">Password:</div>
			<div class="cajaPassword"><input type="password" id="txtPassword" name="txtPassword" style="font-size:24px;text-align:center;" /></div>
		</div>
		<div class="btnLogin"><input type="submit" id="btnLogin" value="Entrar" style="font-size:20px;" /></div>
	</div>
</form>
<?php
	include "../../includes/templates/footer.inc.php";
?>