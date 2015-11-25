<?php
	session_start();
	include("../conexion.php");
	$unid = $_POST["unid_tem"];
	$asig=$_POST["asig"];
	$row=mysql_fetch_array(mysql_query("SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'"));
	
	$sql="INSERT INTO unidad_tematica VALUES('".$unid."','".$row['ci']."','".$asig."')";
	mysql_query($sql);
	header('Location: ../inicio.php?view=8&actAviso=1');
?>
