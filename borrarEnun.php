<?php
	session_start();
	include("conexion.php");
	mysql_query("DELETE FROM enunciado WHERE id_e='".$_POST['id']."'") or die ("Falló la eliminacion".mysql_error());

	header('Location: inicio.php?view=5.php');
?>
