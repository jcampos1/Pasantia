<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
$unid = $_GET['q'];
include("conexion.php");
$sql="SELECT nombre_subtema FROM subtema WHERE nomb_u = '".$unid."'";
$result = mysql_query($sql,$conexion);

if(mysql_num_rows($result)>0) echo "<b>Subtemas</b><br>";
$i=0;
while($row = mysql_fetch_array($result)){
			echo "<div class='A'><input id='".$row['nombre_subtema']."' type='checkbox' name='subt[]' value='".$row['nombre_subtema']."' onclick=\"habCantidad('$i')\">".$row['nombre_subtema']."</div><div class='B'><input name='cant[]' id='".$i."' style='height:20px;pading:0' type='number' min='1' max='3' disabled='disabled'></div>";
	$i++;
}

/*echo "<input class='col3' style='height:20px' id='".$row['nombre_subtema']."' type='checkbox' name='subt[]' value='".$row['nombre_subtema']."'>".$row['nombre_subtema']."<input type='number'  name='quantity' min='1' max='2'>";*/
?>