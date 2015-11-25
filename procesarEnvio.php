<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("conexion.php");
$asunto = $_POST['asunto'];
$msj = $_POST['msj'];
$opc = $_POST['opcion'];

$sql= "SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'";
$ci_rem = mysql_fetch_array(mysql_query($sql));

if($opc=="Profesor" or $opc=="Preparador"){
	$sql= "SELECT ci FROM usuario WHERE tipo='".$opc."' and user!='".$_SESSION['usuario']."'";
	$result = mysql_query($sql) or die ("Error al seleccionar la cedula del usuario logueado. ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$sql="INSERT INTO envia_msj VALUES('".$ci_rem['ci']."','".$row['ci']."','".date('Y-m-d H:i:s')."','".$asunto."','".$msj."','no')";
		mysql_query($sql) or die ("Error al insertar el mensaje. ".mysql_error());
	}
}else{
	$usuarios = $_POST['user'];
 
// Con esto te imprime cuales opciones se seleccionaron 
	if(empty($usuarios)){
		echo "No hay opciones seleccionadas";
	}else{
		$totalSeleccionados = count($usuarios);
		for($i=0; $i < $totalSeleccionados; $i++){
			$sql= "SELECT ci FROM usuario WHERE user='".$usuarios[$i]."'";
			$row = mysql_fetch_array(mysql_query($sql));
			$sql="INSERT INTO envia_msj VALUES('".$ci_rem['ci']."','".$row['ci']."','".date('Y-m-d H:i:s')."','".$asunto."','".$msj."','no')";
		mysql_query($sql) or die ("Error al insertar el mensaje. ".mysql_error());
		}
	}
}
header('Location: inicio.php?view=6&actAviso=1');
/*$sql= "SELECT * FROM envia_msj WHERE ci_dest=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."') ORDER BY visto ASC, fec_emision DESC";
$result = mysql_query($sql,$conexion);

echo "<table width='100%' border='1'>
  <tr>
    <th scope='col'>Asunto</th>
    <th scope='col'>Mensaje</th>
  </tr>";

while($row = mysql_fetch_array($result)) {
		if($row['visto']=="no"){
		echo "<tr style='color:blue;' onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td><b>".$row['asunto']."</b></td>
    <td><b>".$row['msj']."</b></td></tr>";
	}else{
		echo "<tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td>".$row['asunto']."</td>
    <td>".$row['msj']."</td></tr>";
	}
  
}
echo "</table>";
?>*/