<?php
	session_start();
	include("../conexion.php");
	$ced = $_POST["ced"];
	$nombre=$_POST["nombre"];
	$tipo = $_POST["tipo"];
	$usuario=$_POST["usuario"];
	$pass = $_POST["pass"];
	
	$sql="GRANT ALL ON *.* TO '$usuario'@'$host' IDENTIFIED BY '$pass' WITH GRANT OPTION";
	mysql_query($sql) or die ("ERROR AL CREAR EL USUARIO DE LA BD. ERROR: ".mysql_error());
	if(!empty($_POST["coord"])){
		$coord=$_POST["coord"];
		echo $tipo.", ".$coord;
		$sql="INSERT INTO usuario VALUES('$ced','$nombre', '$tipo', '$usuario', '$pass','$coord')";
	}else{
			$sql="INSERT INTO usuario VALUES('$ced','$nombre', '$tipo', '$usuario', '$pass','no')";
	}
	mysql_query($sql) or die ("ERROR AL INSERTAR USUARIO. ERROR: ".mysql_error());
	header('Location: ../inicio.php?view=8&actAviso=1&fuente=2');
?>
