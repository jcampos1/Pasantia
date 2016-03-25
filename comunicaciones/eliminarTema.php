<?php
	session_start();
	include("../conexion.php");
	if(mysql_query("DELETE FROM unidad_tematica WHERE nomb_unid='".$_POST['unid']."'")){
		$_SESSION['actAviso']=3;
		header('Location: ../inicio.php?view=8');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8');
		}

	
?>
