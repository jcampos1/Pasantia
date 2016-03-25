<?php
	session_start();
	include("../conexion.php");
	$ced = $_POST["ced"];
	$nombre=$_POST["nombre"];
	$tipo = $_POST["tipo"];
	$usuario=$_POST["usuario"];
	$pass = $_POST["pass"];
	$email= $_POST["correo"];
	

	$sql="INSERT INTO usuario VALUES('$ced','$nombre','$email','$tipo','$usuario','".md5($pass)."','$coord')";
	if(mysql_query($sql)){
		$_SESSION['actAviso']=1;
		header('Location: ../inicio.php?view=8&fuente=2');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8&fuente=2');
		}
?>
