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
	<div id=\"subtema$i$comp\" style=\"font-size:12px; margin-left:5%; display:none; width:100%;\">";
	while($subtema = mysql_fetch_array($result)){			
		echo "<div class='A' style='width:80%; display:inline-block;' align='left' ><input id='".$subtema['nombre_subtema']."$k' type='checkbox' width='100%' name='subt[]' value='".$subtema['nombre_subtema'].",".$row['nomb_unid'].",$comp' onclick=\"habCantidad('$k$comp')\">".$subtema['nombre_subtema']."</div><br>";
		$k++;
	}
	echo "</div>";
	$i++;
}
?>
