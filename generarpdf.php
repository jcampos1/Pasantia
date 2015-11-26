<?php
	session_start();
	include("dompdf/dompdf_config.inc.php");
	include("conexion.php");
	
	$eval=$_POST['tip'];
	$unid_sel=$_POST['unid_sel'];
	
	$contenido_neto=$_POST['trampa'];
	setlocale(LC_ALL,"es_ES");
	
	//se determina de que asignatura es la unidad tematica
	$sql="SELECT asignatura FROM unidad_tematica WHERE nomb_unid='$unid_sel'";
	$asig=mysql_fetch_array(mysql_query($sql));
	if($asig['asignatura']=="EDI"){
		$asig= "ELEMENTOS DISCRETOS I";
	}else{
		$asig= "ELEMENTOS DISCRETOS II";
	}

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
		
		<p style="text-align:right">'.$asig.'<br>
		'.date("F , Y").'</p>
		
		<p style="text-align:center; font-family:Times New Roman;"><strong>PARCIAL<br><i>'.$unid_sel.'</i></p>
		<br>
		<p>NOMBRE:_________________________________________ C.I:___________________ No.:____</p>
		<table>
		'.$contenido_neto.'</table></body></html>';
	
	//Especificaciones del documento
	$dompdf = new DOMPDF();
	//Esto genera un pdf de hoja tamaño carta y en orientacion horizontal  
	$dompdf->set_base_path('localhost/compartido');
	
	
	$dompdf->load_html($tipo1); 
	
	$dompdf->render();
	set_time_limit(-1); //Tiempo Ilimitado
	
	$dompdf->stream($str, array("Attachment" => 0));
?>
