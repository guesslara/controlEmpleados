<?php
    /**
     *@name Archivo de Configuracion
     *@description Archivo de configuraciones en el sistema
     *@author Gerardo Lara
     *@version 1.0.0
     *@date 15 Marzo 2014
    */
    $pathPrincipal=$_SERVER["DOCUMENT_ROOT"];
    $pathApp=$_SERVER["PHP_SELF"];
    $configGral=array();
    $configGral["nombre"]["sistema"] = "Control de Empleados";
    $configGral["bd"]["host"] = "localhost";
    $configGral["bd"]["usuario"] = "root";
    $configGral["bd"]["password"] = "xampp";
    $configGral["bd"]["base"] = "db_control";
    $configGral["bd"]["puerto"] = "3306";
    //configuraciones y ubicaciones
    $configGral["path"]["includes"]="../../includes/";
    $configGral["path"]["css"]="../../css/";
    //textos interfaces
    $configGral["login"]["title"]="Control de Empleados";
?>