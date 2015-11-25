<?php
	session_start();
	include("../conexion.php");
	$subt= $_POST["nomb_subt"];
	$subtViejo= $_POST["subt_viejo"];
	$unid= $_POST["unidad_tematica"];
	$sql= "UPDATE subtema SET nombre_subtema='".$subt."', nomb_u='".$unid."' WHERE nombre_subtema='".$subtViejo."'";
	mysql_query($sql) or die ("NO SE PROCESO CORRECTAMENTE LA MODIFICACION. ".mysql_error());
	header('Location: ../inicio.php?view=8&actAviso=2');
?>
