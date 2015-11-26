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
	echo "No hay opciones seleccionadas";
}else{
	//cantidad de subtemas seleccionados
	$subt=explode(",",$micadena);
	$totalSeleccionados = count($subt);
	echo "<h2>Parcial Manual / Ejercicios disponibles</h2>";
	$k=1;
	$conten = "<table width='100%'>";
	//update enunciado set fec_ult_uso='2015-08-25' where id_e='5'SELECT * FROM `enunciado` WHERE nombre_sub='DemostraciÃ³n lÃ³gica de predicados' order by fec_ult_uso ASC
	$i=0;
	$j=0;
	//Para escribir por cada enunciado, si el enunciado es Teórico o Práctico
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
		

		$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC ";
		/*$sql="SELECT * FROM (SELECT * FROM enunciado WHERE nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC) ORDER BY rand(".time()."*".time().") LIMIT 0,".$cant[$i];*/
		$result=mysql_query($sql);
		$n=mysql_num_rows($result);
		if($n>0){
			while($row=mysql_fetch_array($result)){
				$sub= $subt[$i];
				$comp= $subt[$i+2];
				$desc=$row['descripcion'];
				$desc=addslashes($desc);
				$desc=substr($desc, 3, strlen($desc)-7);
				//$desc=preg_quote($desc,'/');
				$conten = $conten."
					<tr onclick=\"apilar(".$row['id_e'].",'$desc','comp');\" onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\" title=\"ver enunciados\">
						<td width='5%;' valign='top'><strong>".($row['id_e']).".</strong></td>
						<td width='95%;'><b>Ejercicio $componente / ".$subt[$i]."</b><br>".$row['descripcion']."</td>		
					</tr>
				";
				$k++;
			}
		}
		$i=$i+3;
		$j++;
		}
	echo "<br><h3>Cantidad de preguntas encontradas:<strong>".($k-1)."</strong></h3><br> ";
	$conten=$conten."</table>";
	echo $conten;
	$_SESSION['contenido']=$conten;
}
?>
