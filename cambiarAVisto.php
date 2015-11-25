<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("conexion.php");

$ci_rem = $_GET['ci_rem'];
$ci_dest = $_GET['ci_dest'];
$fec_emision = $_GET['fec_emision'];
$sql="UPDATE envia_msj SET visto='si' WHERE ci_rem='".$ci_rem."' and ci_dest='".$ci_dest."' and fec_emision='".$fec_emision."'";
mysql_query($sql) or die ("Error al indicar que el mensaje ha sido visto por el usuario, error:  ".mysql_error());

/*$sql= "SELECT * FROM envia_msj WHERE ci_dest=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."') ORDER BY visto ASC, fec_emision DESC";
$result = mysql_query($sql,$conexion);

if(mysql_num_rows($result)>0){
//contiene la cantidad de caracteres que se muestran inicialmente del mensaje
$cant=80;
echo "<table width='100%' border='1'>
  <tr>
    <th scope='col'>Asunto</th>
    <th scope='col'>Mensaje</th>
	<th scope='col'>Remitente</th>
  </tr>";
$i=1;
while($row = mysql_fetch_array($result)) {
	$sql= "SELECT nombre, user FROM usuario WHERE ci='".$row['ci_rem']."'";
	$nombre = mysql_fetch_array(mysql_query($sql,$conexion));
	$msjComp= $row['msj'];
	if(strlen($msjComp)>$cant){
		$row['msj']=substr($row['msj'],0,$cant)."...";
	}else{
		$row['msj']=substr($row['msj'],0,$cant);
	}
	if($row['visto']=="no"){
		echo "<tr style='color:blue;' onclick=\"verMensaje('".$nombre['user']."','".$nombre['nombre']."','".$row['asunto']."','".$msjComp."','".$row['ci_rem']."','".$row['ci_dest']."','".$row['fec_emision']."')\" onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td><b>".$row['asunto']."</b></td>
    	<td><b>".$row['msj']."</b></td> <td><b><div id='nomRem".$i."'>".$nombre['nombre']."</div></b></td></tr>";
	}else{
		echo "<tr onclick=\"verMensaje('".$nombre['user']."','".$nombre['nombre']."','".$row['asunto']."','".$msjComp."','".$row['ci_rem']."','".$row['ci_dest']."','".$row['fec_emision']."')\" onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td>".$row['asunto']."</td>
    <td>".$row['msj']."</td> <td>".$nombre['nombre']."</td></tr>";
	}
	$
$i=$i++;  
}
echo "</table>";
}else{
	echo "No hay mensajes recibidos";	
}*/
?>