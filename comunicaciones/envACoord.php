<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");
$ids = $_GET['enunEleg'];
$sql= "SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'";
$ci_rem = mysql_fetch_array(mysql_query($sql));

$sql= "SELECT ci FROM usuario WHERE coord='si'";
$ci_dest = mysql_fetch_array(mysql_query($sql));

$sql= "INSERT INTO envia_msj VALUES('".$ci_rem['ci']."','".$ci_dest['ci']."','".date('Y-m-d H:i:s')."','Parcial Colaborativo','$ids','pendiente')";
mysql_query($sql) or die ("Error al enviar el enunciado. Error: . ".mysql_error());
echo "<h5><span style=\"color:blue;\">Enunciados Enviados</span></h5>";
?>