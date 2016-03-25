<?php
	session_start();
	include("../conexion.php");
	$subt= $_POST["nomb_subt"];
	$subtViejo= $_POST["subt_viejo"];
	$unid= $_POST["unidad_tematica"];
	
	
	$sql= "UPDATE subtema SET nombre_subtema='".$subt."', nomb_u='".$unid."' WHERE nombre_subtema='".$subtViejo."'";
	if(mysql_query($sql)){
		$_SESSION['actAviso']=2;
		header('Location: ../inicio.php?view=8&fuente=1');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8&fuente=1');
	}
?>
