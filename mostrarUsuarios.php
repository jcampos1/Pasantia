<?php
	include("conexion.php");
	$sql= "SELECT user,nombre FROM usuario WHERE user!='".$_SESSION['usuario']."' ORDER BY tipo DESC";
	$result=mysql_query($sql) or die ("Error al ejecutar consulta para mostrar usuarios. ".mysql_error());
	echo "<table width='100%' height='280px'>
  <tr>
    <th scope='col'>usuario</th>
    <th scope='col'>Nombre</th>
  </tr>";

	while($row = mysql_fetch_array($result)) {
		echo "<tr><td><input form='formMsj' id='".$row['user']."' type='checkbox' name='user[]' value='".$row['user']."' $evento>".$row['user']."</td>
			<td>".$row['nombre']."</td>
  		</tr>";
	}
	echo "</table>";
?>
