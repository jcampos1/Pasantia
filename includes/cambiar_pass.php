<?php
	session_start();
	include("../conexion.php");

	$usuario=$_SESSION["usuario"];
	$nuevo_pass = $_POST["nuevo_pass"];
	
	
	$con="UPDATE usuario SET pass='".md5($nuevo_pass)."' WHERE user='$usuario'";
	
	if(mysql_query($con)) $_SESSION['error']=1;
	else $_SESSION['error']=2;
	
	header('Location: ../inicio.php?view=2');
	
	
?>
