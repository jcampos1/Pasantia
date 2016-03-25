<?php
	session_start();
	include("../conexion.php");
	
	if(mysql_query("DELETE FROM usuario WHERE user='".$_POST['user']."'")){
		$_SESSION['actAviso']=3;
		header('Location: ../inicio.php?view=8&fuente=2');
	}
	else{
		$_SESSION['actAviso']=4;
		header('Location: ../inicio.php?view=8&fuente=2');
	}
?>
