<?php
	session_start();
	include("../conexion.php");
	mysql_query("DELETE FROM unidad_tematica WHERE nomb_unid='".$_POST['unid']."'") or die ("Falló la eliminacion".mysql_error());

	header('Location: ../inicio.php?view=8&actAviso=3');
?>
