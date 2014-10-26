<?php
	session_start();
	if(!isset($_SESSION["id"])){
		//header("Location: ../mod_login/index.php");
		//exit();
		echo "<script type='text/javascript'> parent.location.href='../mod_login/index.php'; </script>";
		exit();
	}
	
	include "../../includes/config.inc-s.php";
	// include db config
	include_once("../../includes/libs/phpgridv1.5.2/config.php");

	// set up DB
	mysql_connect($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"]);
	mysql_select_db($configGral["bd"]["base"]);

	$sql="SELECT no_empleado,nombres,a_paterno,a_materno,descripcion,tipo_nomina,fecha_ingreso FROM cat_personal INNER JOIN cat_areas ON cat_personal.id_area=cat_areas.id";

	// include and create object
	include("../../includes/libs/phpgridv1.5.2/lib/inc/jqgrid_dist.php");
	$g = new jqgrid();

	// set few params
	$grid["caption"] = "Cat&aacute;logo de Departamentos / Areas";
	$grid["multiselect"] 	= true;
	$grid["autowidth"] 		= true;

	$g->set_options($grid);
	$g->set_actions(array(  
                        "add"=>false,
                        "edit"=>false,
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
	$g->table = "cat_areas";
	$g->select_command = $sql;
	// render grid
	$out = $g->render("areas");
	include "../../includes/templates/header.inc.php"; 
?>
<link rel="stylesheet" type="text/css" media="screen" href="../../includes/libs/phpgridv1.5.2/lib/js/themes/smoothness/jquery-ui.custom.css"></link>    
<link rel="stylesheet" type="text/css" media="screen" href="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/css/ui.jqgrid.css"></link>    

<script src="../../includes/libs/phpgridv1.5.2/lib/js/jquery.min.js" type="text/javascript"></script>
<script src="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="../../includes/libs/phpgridv1.5.2/lib/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>    
<script src="../../includes/libs/phpgridv1.5.2/lib/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script> 
<div id="barraHerramientasEmpleados">
	<!--<div class="btnHerramientasEmpleados" title="Agregar empleado"><img src="../../img/facturacion.png" width="32" height="32" border="0" />Agregar empleado</div>-->
	<a href="agregarEmpleado.php" class="btnHerramientasEmpleados" title="Agregar empleado"><img src="../../img/facturacion.png" width="32" height="32" border="0" />Agregar empleado</a>
</div>
<div style="margin:10px;font-size:10px;">
    <?php echo $out?>
</div>
<?php
	include "../../includes/templates/footer.inc.php";
?> 