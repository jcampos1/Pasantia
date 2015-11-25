<?php
	session_start();
	include("../conexion.php");

	$ced = $_POST["ced"];
	$tipo = $_POST["tipo"];
	
	if(!empty($_POST["coord"])){
			$coord=$_POST["coord"];
			$con="UPDATE usuario SET tipo='$tipo', coord='$coord' WHERE ci='$ced'";
	}else{
			$con="UPDATE usuario SET tipo='$tipo', coord='no' WHERE ci='$ced'";
	}
	mysql_query($con) or die ("ERROR AL ACTUALIZAR TABLA DE USUARIO. ERROR: ".mysql_error());
	echo $con;
	header('Location: ../inicio.php?view=8&actAviso=2&fuente=2');
?>
