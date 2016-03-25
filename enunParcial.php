<?php

/*Pagina para mostrar los enunciados de forma asincrona, basandose en la asignatura, tipo de parcial, complejidad*/
session_start();
include("conexion.php");
$nivel = $_GET['nivel'];
$micadena = $_GET['subt'];
$tipo = $_GET['tipo'];
$asig = $_GET['asig'];
$conten='';
if(empty($micadena)){
	echo "<div id='aviso_banco' class='alert alert-warning fade in'>";
	echo "<strong><span class='glyphicon glyphicon-info-sign'></span> Seleccione los parámetros de búsqueda correctamente.</strong>";
	echo "</div>";
}else{
	//cantidad de subtemas seleccionados
	$subt=explode(",",$micadena);
	$totalSeleccionados = count($subt);
	$k=1;
	$conten = "<table width='100%'>";

	$i=0;
	$j=0;

	if($subt[2]=="teorico"){
			$componente="Teórico";
		}else{
			$componente="Práctico";
	}
	while($i < $totalSeleccionados){
		if($subt[$i+2]=="teorico" and $componente=="Práctico"){
			$componente="Teórico";
		}else{
			if($subt[$i+2]=="practico" and $componente=="Teórico"){
				$componente="Práctico";
			}	
		}
		
		if($nivel =='todos'){
			$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and unidad_tematica='".$subt[$i+1]."' and nivel='bajo' or nivel='medio' or nivel='alto' ORDER BY fec_ult_uso ASC";
		}
		else{
			$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and unidad_tematica='".$subt[$i+1]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC";
		}
		
		$result=mysql_query($sql);
		$n=mysql_num_rows($result);
		if($n>0){
			$cont=1;
			while($row=mysql_fetch_array($result)){
				$sub= $subt[$i];
				$comp= $subt[$i+2];
				$desc=$row['descripcion'];
				$desc=substr($desc, 3, strlen($desc)-6);
				
				//$desc=preg_quote($desc,'/');
				$conten = $conten."
					<tr id='enun".$row['id_e']."' onclick=\"copiar(this, 'enun".$row['id_e']."');\" style='cursor:pointer' title=\"Click para seleccionar ejercicio\">
						<td width='10%;' valign='top'><strong>".($row['id_e']).".&nbsp;</strong></td>
						<td width='90%;'>".$row['descripcion']."</td>
					</tr>
				";
				$k++;
				$cont++;
			}
		}
		$i=$i+3;
		$j++;
		}
	echo "<h3>Cantidad de preguntas encontradas:<strong>".($k-1)."</strong></h3><br> ";
	$conten=$conten."</table>";
	echo $conten;
}
?>
