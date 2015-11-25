<?php
	session_start();
	include("../conexion.php");
	$subt = $_POST["nomb_subt"];
	$unid=$_POST["unidad_tematica"];
	
	$sql="INSERT INTO subtema VALUES('".$subt."','".$unid."')";
	mysql_query($sql);
	header('Location: ../inicio.php?view=8&actAviso=1&fuente=1');
?>
