<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("conexion.php");
$cant_reg = 9;
$num_pag=1;
if ($_GET["pagina"]==0){
	$comienzo = 0;
}else{
	$num_pag=intval($_GET["pagina"]);
	$aux=$num_pag-1;
	$comienzo = ($aux)*$cant_reg;
}
$sql= "SELECT * FROM envia_msj WHERE ci_dest=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."')";
$resultado = mysql_query($sql);
$total_registros = mysql_num_rows($resultado);
$sql= "SELECT * FROM envia_msj WHERE ci_dest=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."') and (visto='si' or visto='no') ORDER BY visto ASC, fec_emision DESC LIMIT $comienzo, $cant_reg";
$result = mysql_query($sql);
$total_paginas = ceil($total_registros / $cant_reg);

if($total_registros>0){
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
	
	/*Nota: en el atributo de cada checkbox que va a tener cada mensaje, construyo la condicion de la transaccion a ejecutar en borrarMsjs.php, el atributo value de cada checkbox tendra ci_rem, ci_dest, fec_emision*/ 
	if($row['visto']=="no"){
		echo "<tr style='color:blue;' onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td><input type='checkbox' form='formElimMsj' name='msjs[]' id='msjs[]' value=\"ci_rem='".$row['ci_rem']."' and ci_dest='".$row['ci_dest']."' and fec_emision='".$row['fec_emision']."'\"><b>".$row['asunto']."</b></td>
    	<td title='Ver Mensaje' onclick=\"verMensaje('".$nombre['user']."','".$nombre['nombre']."','".$row['asunto']."','".$msjComp."','".$row['ci_rem']."','".$row['ci_dest']."','".$row['fec_emision']."','".$row['visto']."','rec')\"><b>".$row['msj']."</b></td> <td><b><div id='nomRem".$i."'>".$nombre['nombre']."</div></b></td></tr>";
	}else{
		echo "<tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">";
		echo "<td><input type='checkbox' form='formElimMsj'  name='msjs[]' id='msjs[]' value=\"ci_rem='".$row['ci_rem']."' and ci_dest='".$row['ci_dest']."' and fec_emision='".$row['fec_emision']."'\">".$row['asunto']."</td>
    <td title='Ver Mensaje' onclick=\"verMensaje('".$nombre['user']."','".$nombre['nombre']."','".$row['asunto']."','".$msjComp."','".$row['ci_rem']."','".$row['ci_dest']."','".$row['fec_emision']."','".$row['visto']."','rec')\">".$row['msj']."</td> <td>".$nombre['nombre']."</td></tr>";
	}
	$
$i=$i++;  
}
echo "</table>";
$aux=$num_pag-1;
if(($aux)>0){
	echo "<a style='color:blue; font-size:12px; cursor:pointer;' onclick='mostrarMensajesRec($aux)'><b>< Anterior</b></a> ";
}
/* Luego, mediante un ciclo de tipo for que dura mientras la variable i sea menor al número total de páginas, se van listando, con números, todas las páginas disponibles con sus respectivos vínculos. También se desplega la página actual, sin vincular. */
for ($i=1; $i<=$total_paginas; $i++){
	if ($num_pag == $i){
		echo "<b style='font-size:12px'>Página ".$num_pag."</b> ";
	}else{
		echo "<a style='background:blue;font-size:12px;cursor:pointer;' onclick='mostrarMensajesRec($i)'>$i</a> ";
	}
}
/* Y finalmente, se pregunta mediante un if si el número de la página actual  más 1 es menor o igual al total de páginas. Si es así se presenta un vínculo para la página siguiente, enviando el parámetro correspondiente que se recoje mediante GET */
if(($num_pag+1)<=$total_paginas){
	?><a style='color:blue; font-size:12px;cursor:pointer;' onclick="mostrarMensajesRec(<?php echo ($num_pag+1)?>)"><b>Siguiente ></b></a><?php
}
}else{
	echo "<div style='margin:40px;'><span style='font-size:16px;'>No Posee Mensajes Actualmente</span>
	<div align='center'>
		<img src='resources/imagenes/buzon_vacio.jpg' width='100px;' height='80px;' alt='No posee mensajes actualmente' >
	</div>
	</div>";
}
?>