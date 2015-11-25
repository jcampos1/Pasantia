<?php
	session_start();
	include("../conexion.php");
	mysql_query("DELETE FROM subtema WHERE nombre_subtema='".$_POST['subt']."'") or die ("Falló la eliminacion".mysql_error());

	header('Location: ../inicio.php?view=8&actAviso=3&fuente=1');
?>
