<?php
	session_start();
	include("../conexion.php");
	$subt = $_POST["nomb_subt"];
	$unid=$_POST["unidad_tematica"];
	
	$sql="INSERT INTO subtema VALUES('".$subt."','".$unid."')";
	
	if(mysql_query($sql)){
		$_SESSION['actAviso']=1;
		header('Location: ../inicio.php?view=8&fuente=1');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8&fuente=1');
	}
?>
