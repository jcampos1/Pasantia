<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");
$micadena = $_GET['subt'];
$string = $_GET['cant'];
$string2 = $_GET['user'];

$subt=explode(",",$micadena);
$cant=explode(",",$string);
$usuarios=explode(",",$string2);

$totalSeleccionados = count($subt);
$msj="";
$i=0;
$j=0;
while($i < $totalSeleccionados){
	$msj=$msj."".$subt[$i].",".$subt[$i+1].",".$subt[$i+2].",".$cant[$j].",";
	$j++;
	$i=$i+3;
}
//elimino la ultima coma
$msj = substr($msj, 0, -1);

$sql= "SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'";
$ci_rem = mysql_fetch_array(mysql_query($sql));

$totalSeleccionados = count($usuarios);
$string="";
for($i=0; $i < $totalSeleccionados; $i++){
	$string=$string.$usuarios[$i].", ";
	$sql= "SELECT ci FROM usuario WHERE user='".$usuarios[$i]."'";
	$row = mysql_fetch_array(mysql_query($sql));
	
	$sql="INSERT INTO envia_msj VALUES('".$ci_rem['ci']."','".$row['ci']."','".date('Y-m-d H:i:s')."','Parcial Colaborativo','".$msj."','pendiente')";
		mysql_query($sql) or die ("Error al insertar el mensaje. ".mysql_error());
}

//Se muestra el mensaje de que se les asignó a los usuarios los temas seleccionados
echo "<b>La asignación se realizó correctamente</b><br>";
echo "A los usuarios: $string le(s) fue asignado el/los tema(s):<br>";
$totalSeleccionados = count($subt);
$i=0;
while($i < $totalSeleccionados){
	echo $subt[$i]."<br>";
	$i=$i+3;
}