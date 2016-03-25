<?php
	session_start();
	include("../conexion.php");

	$ci_vieja= $_POST["ci_vieja"];
	$ced = $_POST["ced"];
	$nombre=$_POST["nombre"];
	$tipo = $_POST["tipo"];
	$usuario=$_POST["usuario"];
	$pass = $_POST["pass"];
	
	
	$con="UPDATE usuario SET ci='$ced', nombre= '$nombre', tipo='$tipo', user='$usuario', pass='$pass', coord='no' WHERE ci='$ci_vieja'";
	if(mysql_query($con)){
		$_SESSION['actAviso']=2;
		header('Location: ../inicio.php?view=1&fuente=2');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=1&fuente=2');
	}
	
?>
