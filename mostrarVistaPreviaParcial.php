<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("conexion.php");
$nivel = $_GET['nivel'];
$string = $_GET['cant'];
$micadena = $_GET['subt'];
$conten='';
if(empty($micadena)){
	echo "<div id='aviso_banco' class='alert alert-warning fade in'>";
	echo "<strong><span class='glyphicon glyphicon-info-sign'></span> Seleccione los parametros de busqueda correctamente.</strong>";
	echo "</div>";
}else{
	//cantidad de subtemas seleccionados
	$subt=explode(",",$micadena);
	$cant=explode(",",$string);
	$totalSeleccionados = count($subt);
	echo "<h2>Parcial Automático</h2>";
	$k=1;
	$conten2 = "<table width='100%'><tbody id='filas'>";
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
		
		if($nivel =='todos'){
			$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and unidad_tematica='".$subt[$i+1]."' and nivel='bajo' or nivel='medio' or nivel='alto' ORDER BY fec_ult_uso ASC LIMIT 0,".$cant[$j];
		}
		else{
			$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and unidad_tematica='".$subt[$i+1]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC LIMIT 0,".$cant[$j];
		}
		/*$sql="SELECT * FROM (SELECT * FROM enunciado WHERE nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC) ORDER BY rand(".time()."*".time().") LIMIT 0,".$cant[$i];*/
		$result=mysql_query($sql);
		$n=mysql_num_rows($result);
		if($n>0){
			while($row=mysql_fetch_array($result)){
				$conten2 = $conten2."
				<tr>
					<td valign='top' width='10%;'><b>".$k.". </b></td><td valign='top' width='90%'>".$row['descripcion']."</td>		
				</tr>";
				$k++;
			}
		}
		$i=$i+3;
		$j++;
		}
	echo "<br><h3>Cantidad de preguntas encontradas:<strong>".($k-1)."</strong></h3><br> ";
	$conten2=$conten2."</tbody></table>";
	echo $conten2;
}
?>
