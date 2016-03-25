<?php
	session_start();
	include("conexion.php");
	

	
// the message
$msg = $_POST["msg"];
$usuario = $_POST["name"]."-".$_POST["email"];

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);



// send email
if(mail("delwinferreira94@gmail.com",$usuario,$msg)){
	$_SESSION["error"]="correo_yes";
	}
	else{
			$_SESSION["error"]="correo_no";
		}

	header('Location: ../index.php');
?>
	
