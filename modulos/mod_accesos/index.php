<?php
	session_start();
	if(!isset($_SESSION["id"])){
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
	
	include "../../includes/config.inc-s.php";
	// include db config
	include_once("../../includes/libs/phpgridv1.5.2/config.php");

	// set up DB
	mysql_connect($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"]);
	mysql_select_db($configGral["bd"]["base"]);

	$sql="SELECT reg_accesos.id AS id,nombres,a_paterno,a_materno,fecha,hora,IF(ES=1,'Entrada','Salida') AS ES FROM reg_accesos INNER JOIN cat_personal ON reg_accesos.id_empleado=cat_personal.id";

	// include and create object
	include("../../includes/libs/phpgridv1.5.2/lib/inc/jqgrid_dist.php");
	$g = new jqgrid();

	// set few params
	$grid["caption"] = "Usuarios del Sistema";
	$grid["multiselect"] 	= true;
	$grid["autowidth"] 		= true;

	$g->set_options($grid);
	$g->set_actions(array(  
                        "add"=>false,
                        "edit"=>true,
                        "delete"=>true,
                        "view"=>true,
                        "rowactions"=>false,
                        "export"=>false,
                        "autofilter" => true,
                        "search" => "advance",
                        "inlineadd" => false,
                        "showhidecolumns" => false
                    )
                );

	// set database table for CRUD operations
	$g->table = "cat_usuarios";
	$g->select_command = $sql;
	// render grid
	$out = $g->render("usuarios");
	include "../../includes/templates/header.inc.php"; 
?>
<link rel="stylesheet" type="text/css" media="screen" href="../../includes/libs/phpgridv1.5.2/lib/js/themes/smoothness/jquery-ui.custom.css"></link>    
<link rel="stylesheet" type="text/css" media="screen" href="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/css/ui.jqgrid.css"></link>    

<script src="../../includes/libs/phpgridv1.5.2/lib/js/jquery.min.js" type="text/javascript"></script>
<script src="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>    
<script src="../../includes/libs/phpgridv1.5.2/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
<div id="barraHerramientasEmpleados">
	<a href="agregarUsuario.php" class="btnHerramientasEmpleados" title="Agregar usuario"><img src="../../img/facturacion.png" width="32" height="32" border="0" />Agregar usuario</a>
	<a href="formContrasenia.php" class="btnHerramientasEmpleados" title="Modificar Contrase&ntilde;as"><img src="../../img/Edit_icon.png" width="32" height="32" border="0" />Modificar Contrase&ntilde;as</a>
</div> 
<div style="margin:10px;font-size:10px;">
    <?php echo $out?>
</div>
<?php
	include "../../includes/templates/footer.inc.php";
?> 