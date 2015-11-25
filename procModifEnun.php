<?php
	session_start();
	include("conexion.php");
	$id= $_GET["idModif"];
	$descripcion = $_GET["editor"];
	$nivel = $_GET["nivel"];
	$componente = $_GET["componente"];
	$subtema=$_GET["subtema"];
	$solucion = $_GET["solucion"];
	$visib= "privado";
	$sql= "UPDATE enunciado SET descripcion='".$descripcion."', nombre_sub='".$subtema."', nivel='".$nivel."', componente='".$componente."', solucion='".$solucion."' WHERE id_e='".$id."'";
	mysql_query($sql) or die ("NO SE PROCESO CORRECTAMENTE LA MODIFICACION. ".mysql_error());
	header('Location: inicio.php?view=5&actAviso=1');
?>
