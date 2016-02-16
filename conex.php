<?php
session_start();
$host="localhost";
$usuario = $_POST["nombre_usuario"];
$clave = $_POST["clave_usuario"];

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$conexion=mysql_connect($host, $usuario, $clave);
if(!$conexion){
	$_SESSION['error']='invalido';
	header('Location: index.php');
}
else{
	mysql_select_db("prueba", $conexion);
	$sql="SELECT tipo,coord FROM usuario WHERE user='".$usuario."'";
	$ro=mysql_fetch_array(mysql_query($sql));

	if($ro){
		$_SESSION['activa']=1;
		$_SESSION['usuario']=$usuario;
		$_SESSION['clave']=$clave;
		$_SESSION['pdf']="";
		$_SESSION['tipo']=$ro['tipo'];
		$_SESSION['coord']=$ro['coord'];
		header('Location: inicio.php?view=2');
	}
	else{
		$_SESSION['error']='invalido';
		header('Location: index.php');
		}
}
?>






