<?php
	session_start();
	include("../conexion.php");
	$unid= $_POST["unid_tem"];
	$unidViejo= $_POST["unid_viejo"];
	$asig= $_POST["asig"];
	
	$sql= "UPDATE unidad_tematica SET nomb_unid='".$unid."', asignatura='".$asig."' WHERE nomb_unid='".$unidViejo."'";
	
	if(mysql_query($sql)){
		$_SESSION['actAviso']=2;
		header('Location: ../inicio.php?view=8');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8');
	}
?>
