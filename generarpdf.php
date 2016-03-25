<?php
	session_start();
	$tipo_evaluacion=$_POST['tipo_evaluacion'];
	$titulo_evaluacion=$_POST['titulo_evaluacion']; 
	$contenido_evaluacion=$_POST['contenido_evaluacion'];
	$fecha_evaluacion=$_POST['fecha_evaluacion'];
	
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=evaluacion.doc");

	$tipo1 = '<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>

	<style>
	  body { font-family: Helvetica, sans-serif; }
	</style>

	<body >'.
		'<p style="text-align:left">Universidad de Carabobo<br>                             
		Facultad Experimental de Ciencias y Tecnologia<br>        
		Departamento de Computacion<br>
		Unidad Academica de Elementos Discretos</p>
		
		<p style="text-align:right"><br>
		'.$fecha_evaluacion.'</p>
		
		<p style="text-align:center; font-family:Times New Roman;"><strong>'.$tipo_evaluacion.'<br><i>'.$titulo_evaluacion.'</i></p>
		<br>
		<p>Nombre:_________________________________ C.I:_________________ No.:____</p>
		<table>
		'.$contenido_evaluacion.'</table></body></html>';
		
		echo $tipo1;
?>
