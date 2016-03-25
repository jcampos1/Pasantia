<?php
	session_start();
	include("../conexion.php");
	if(mysql_query("DELETE FROM subtema WHERE nombre_subtema='".$_POST['subt']."'")){
		$_SESSION['actAviso']=3;
		header('Location: ../inicio.php?view=8&fuente=1');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8&fuente=1');
	}

	
?>
