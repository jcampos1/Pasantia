<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
$unid = $_GET['q'];
include("conexion.php");
$sql="SELECT nombre_subtema FROM subtema WHERE nomb_u = '".$unid."'";
$result = mysql_query($sql,$conexion);



echo "<div class='form-group'>
		<label for='subtema'>Subtema:</label>
		<select class='form-control' id='subtema' name='subtema'>";
		while($row = mysql_fetch_array($result)) {
			echo "<option value='".$row['nombre_subtema']."'>".$row['nombre_subtema']."</option>";
		}
echo "</select></div>";
?>
