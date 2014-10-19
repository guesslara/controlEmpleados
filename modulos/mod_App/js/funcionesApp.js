//funciones javascript
$(document).ready(function(){
	redimensionarApp();
});

window.onresize=redimensionarApp;

function redimensionarApp(){
	var altoDiv=$("#contenedorApp").height();
	$("#contenedorModulos").css("height",(altoDiv-66)+"px");
}
function cerrarSesion(){
	window.location.href="../cerrarsesion.php";
}
function modulos(modulo){
	switch(modulo){
		case "deptos":
			contenedorVentana.location.href="../mod_deptos/index.php"
		break;
		case "usuarios":
			contenedorVentana.location.href="../mod_usuarios/index.php"
		break;
		case "empleados":
			contenedorVentana.location.href="../mod_empleados/index.php"
		break;
	}
}