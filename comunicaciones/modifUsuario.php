<?php
	session_start();
	include("../conexion.php");

	$ci_vieja= $_POST["ci_vieja"];
	$ced = $_POST["ced"];
	$nombre=$_POST["nombre"];
	$tipo = $_POST["tipo"];
	$usuario=$_POST["usuario"];
	$pass = $_POST["pass"];
	
	//elimino el usuario
	mysql_query("DROP USER '$usuario'@'$host'") or die ("ERROR AL ELIMINAR CON DROP USER. ERROR: ".mysql_error());
	
	$sql="GRANT ALL ON *.* TO '$usuario'@'$host' IDENTIFIED BY '$pass' WITH GRANT OPTION";
	mysql_query($sql) or die ("ERROR AL CREAR EL USUARIO DE LA BD. ERROR: ".mysql_error());
	if(!empty($_POST["coord"])){
			$coord=$_POST["coord"];
			$con="UPDATE usuario SET ci='$ced', nombre= '$nombre', tipo='$tipo', user='$usuario', pass='$pass', coord='$coord' WHERE ci='$ci_vieja'";
			$_SESSION['coord']=$coord;
	}else{
		$_SESSION['coord']="no";
			$con="UPDATE usuario SET ci='$ced', nombre= '$nombre', tipo='$tipo', user='$usuario', pass='$pass', coord='no' WHERE ci='$ci_vieja'";
	}
	mysql_query($con) or die ("ERROR AL ACTUALIZAR TABLA DE USUARIO. ERROR: ".mysql_error());
	header('Location: ../inicio.php?view=1&actAviso=1');
?>
