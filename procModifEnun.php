<?php
	session_start();
	include("conexion.php");
	$id= $_GET["idModif"];
	$descripcion = $_GET["editor"];
	$nivel = $_GET["nivel"];
	$solucion = $_GET["solucion"];
	$visib= "privado";
	$sql= "UPDATE enunciado SET descripcion='".$descripcion."', nivel='".$nivel."', solucion='".$solucion."' WHERE id_e='".$id."'";
	mysql_query($sql) or die ("NO SE PROCESO CORRECTAMENTE LA MODIFICACION. ".mysql_error());
	header('Location: inicio.php?view=5&actAviso=1');
?>
