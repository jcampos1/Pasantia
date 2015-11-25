<?php
	session_start();
	include("../conexion.php");
	
	mysql_query("DROP USER '".$_POST['user']."'@'$host'") or die ("ERROR AL ELIMINAR CON DROP USER. ERROR: ".mysql_error());
	mysql_query("DELETE FROM usuario WHERE user='".$_POST['user']."'") or die ("ERROR AL ELIMINAR CON DELETE FROM. ERROR: ".mysql_error());
	header('Location: ../inicio.php?view=8&actAviso=3&fuente=2');
?>
