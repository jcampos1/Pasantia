<?php
$baseDatos="prueba";
$host="localhost";
$usuario = $_SESSION["usuario"];
$clave = $_SESSION["clave"];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$conexion=mysql_connect($host, $usuario, $clave) or die ("No se pudo establecer la conexion al servidor".mysql_error());
//Selecciono la base de datos
mysql_select_db($baseDatos, $conexion) or die ("error al seleccionar la base de datos ".mysql_error());

?>
				






