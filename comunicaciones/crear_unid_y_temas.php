<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");
$comp=$_GET['comp'];
$asig=$_GET['asig'];
            			
$resultado = mysql_query("SELECT * FROM unidad_tematica WHERE asignatura='".$asig."'");
$i=0;
$k=0;
while($row = mysql_fetch_array($resultado)){
	$sql="SELECT nombre_subtema FROM subtema WHERE nomb_u = '".$row['nomb_unid']."'";
	$result = mysql_query($sql);
		
    echo "<input style='margin-bottom:6px;' type='checkbox' name='unid[]' value=\"".$row['nomb_unid']."\" onclick=\"mostrar('subtema$i$comp')\">".$row['nomb_unid']."<br/>
	<div class='row' id=\"subtema$i$comp\" style=\"font-size:12px;margin-left:1px; display:none; width:100%;\">";
	while($subtema = mysql_fetch_array($result)){			
		echo "<div class='col-sm-9'>
		<input id='".$subtema['nombre_subtema']."$k' type='checkbox' width='100%' name='subt[]' value='".$subtema['nombre_subtema'].",".$row['nomb_unid'].",$comp' onclick=\"habCantidad('$k$comp')\">".$subtema['nombre_subtema']."</div>
		<div class='col-sm-3'>
		<input name='cant[]' id='$k$comp' style='height:20px; width:100%' type='number' min='1' max='3' disabled='disabled'>
		</div><br>";
		$k++;
	}
	echo "</div>";
	$i++;
}
?>
