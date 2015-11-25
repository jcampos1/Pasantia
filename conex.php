<?php
session_start();
$host="localhost";
$usuario = $_POST["nombre_usuario"];
$clave = $_POST["clave_usuario"];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$conexion=mysql_connect($host, $usuario, $clave) or die ("No se pudo establecer la conexion al servidor".mysql_error());
$_SESSION['activa']=1;
$_SESSION['usuario']=$usuario;
$_SESSION['clave']=$clave;
$_SESSION['pdf']="";

//Selecciono la base de datos
mysql_select_db("prueba", $conexion) or die ("error al seleccionar la base de datos ".mysql_error());
$sql="SELECT tipo,coord FROM usuario WHERE user='".$usuario."'";
$ro=mysql_fetch_array(mysql_query($sql));
$_SESSION['tipo']=$ro['tipo'];
$_SESSION['coord']=$ro['coord'];
header('Location: inicio.php?view=2');
?>
				






