<?php
/*Borra los mensajes seleccionados por el usuario*/
session_start();
include("conexion.php");
$msjs = $_POST['msjs'];
if(empty($msjs)){
	echo "No se selecciono ningun mensaje";
}else{
	$totalSeleccionados = count($msjs);
	echo "Se seleccionaron $totalSeleccionados opcion(s): ";
	for($i=0; $i < $totalSeleccionados; $i++){
		$sql= "DELETE FROM envia_msj WHERE ".$msjs[$i];
		mysql_query($sql) or die ("ocurrio un problema al eliminar el mensaje, error: ".mysql_error());;
	}
}
header('Location: inicio.php?view=6');
?>