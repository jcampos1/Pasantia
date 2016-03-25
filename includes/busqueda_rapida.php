<?php
session_start();
include("../conexion.php");

$micadena = $_POST['ids'];
if(empty($micadena)){
	echo "<div id='aviso_banco' class='alert alert-warning fade in'>";
	echo "<strong><span class='glyphicon glyphicon-info-sign'></span> Debe ingresar por lo menos un ID.</strong>";
	echo "</div>";
}else{
	//cantidad de ids
	$subt=explode(",",$micadena);
	$totalSeleccionados = count($subt);
	$k=1;
	$conten = "<table width='100%'>";

	$i=0;
	while($i < $totalSeleccionados){
		$sql="SELECT * FROM enunciado WHERE id_e='".$subt[$i]."'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)){
			$conten = $conten."
				<tr id='enun".$row['id_e']."' onclick=\"copiar(this, 'enun".$row['id_e']."');\" style='cursor:pointer' title=\"Click para seleccionar ejercicio\">
					<td width='10%;' valign='top'><strong>".($row['id_e']).".&nbsp;</strong></td>
					<td width='90%;'>".$row['descripcion']."</td>
				</tr>";
			$k++;
		}
		$i=$i+1;
	}
		
	}
	echo "<h3>Cantidad de preguntas encontradas:<strong>".($k-1)."</strong></h3><br> ";
	$conten=$conten."</table>";
	echo $conten;
?>

