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
	@mysql_connect($configGral["bd"]["host"],$configGral["bd"]["usuario"],$configGral["bd"]["password"]);
	@mysql_select_db($configGral["bd"]["base"]);

	$sql="SELECT descripcion,responsable,obs FROM cat_areas";

	// include and create object
	include("../../includes/libs/phpgridv1.5.2/lib/inc/jqgrid_dist.php");
	$g = new jqgrid();

	// set few params
	$grid["caption"] = "Cat&aacute;logo de Departamentos / Areas";
	$grid["multiselect"] 	= false;
	$grid["autowidth"] 		= true;

	$g->set_options($grid);
	$g->set_actions(array(  
                        "add"=>true,
                        "edit"=>true,
                        "delete"=>true,
                        "view"=>true,
                        "rowactions"=>true,
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
<div style="margin:10px;font-size:10px;">
    <?php echo $out?>
</div>
<?php
	include "../../includes/templates/footer.inc.php";
?> 
