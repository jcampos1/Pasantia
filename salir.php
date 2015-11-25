<?php 
	/******************************************
	* Se liberan la variables de sesion que se
	* usan para controlar las vistas de los
	* usuarios.
	*******************************************/
	session_start();
	unset($_SESSION['usuario']);
	unset($_SESSION['clave']);
	unset($_SESSION['conex_mysql']);
	session_destroy();
	
	/*Cerrar la conexion con la base de datos*/
	
	/*Volver al login*/
	header('Location: index.php');
?>
				






