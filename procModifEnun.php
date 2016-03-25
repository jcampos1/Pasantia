<?php
	session_start();
	include("conexion.php");
	$id= $_GET["idModif"];
	$descripcion = $_GET["editor"];
	$nivel = $_GET["nivel"];
	$componente = $_GET["componente"];
	$unidad_tematica= $_GET["unidad_tematica"];
	$subtema=$_GET["subtema"];
	$solucion = $_GET["solucion"];
	$visib= "privado";
	$sql= "UPDATE enunciado SET descripcion='".$descripcion."', nombre_sub='".$subtema."', nivel='".$nivel."', componente='".$componente."', solucion='".$solucion."',unidad_tematica='".$unidad_tematica."' WHERE id_e='".$id."'";
	
	if(mysql_query($sql)){
			$_SESSION['actAviso']=0;
			header('Location: inicio.php?view=5');
		}
		else{
			$_SESSION['actAviso']=1;
			header('Location: inicio.php?view=5');
	}
?>
