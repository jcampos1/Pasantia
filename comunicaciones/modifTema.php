<?php
	session_start();
	include("../conexion.php");
	$unid= $_POST["unid_tem"];
	$unidViejo= $_POST["unid_viejo"];
	$asig= $_POST["asig"];
	$sql= "UPDATE unidad_tematica SET nomb_unid='".$unid."', asignatura='".$asig."' WHERE nomb_unid='".$unidViejo."'";
	mysql_query($sql) or die ("NO SE PROCESO CORRECTAMENTE LA MODIFICACION. ".mysql_error());
	//echo "EL ENUNCIADO FUE ACTUALIZADO CORRECTAMENTE ".$unidViejo.", ".$unid.",  ".$asig;
	header('Location: ../inicio.php?view=8&actAviso=2');
?>
