<?php

/*Pagina para mostrar los enunciados de forma asincrona, basandose en la asignatura, tipo de parcial, complejidad*/
session_start();
include("conexion.php");
$nivel = $_GET['nivel'];
$string = $_GET['cant'];
$micadena = $_GET['subt'];
$conten='';
if(empty($micadena)){
	echo "No hay opciones seleccionadas";
}else{
	//cantidad de subtemas seleccionados
	$subt=explode(",",$micadena);
	$cant=explode(",",$string);
	$totalSeleccionados = count($subt);
	echo "<h2>Parcial Automatico</h2>";
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
		
		//and un_tema='".$subt[$i+1]."' hay que agregarselo a la consulta
		$sql="SELECT * FROM enunciado WHERE componente='".$subt[$i+2]."' and nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC LIMIT 0,".$cant[$j];
		/*$sql="SELECT * FROM (SELECT * FROM enunciado WHERE nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC) ORDER BY rand(".time()."*".time().") LIMIT 0,".$cant[$i];*/
		$result=mysql_query($sql);
		$n=mysql_num_rows($result);
		if($n>0){
			while($row=mysql_fetch_array($result)){
				$conten = $conten."
				<tr>
					<tr>
						<td width='5%;' valign='top'><strong>".($k).".</strong></td>
						<td width='95%;'><b>Ejercicio $componente / ".$subt[$i]."</b><br>".$row['descripcion']."</td>		
					</tr>
				</tr>
				<tr style='background:white'>
					<td width='30%;' align='center'><strong style='font-size:10px;'>pts ejerc. ".$k."<br></strong><input name='pts[]' style='height:20px;pading:0;width:60px;' type='number' min='0' max='20'></td>
					<td width='70%;' align='center'><strong style='font-size:10px;'>pts por Items ejercicio ".$k."</strong><input type='text' name='items[]' placeholder='pts por items' style='font-size:12px; height:20px;' width='70%'/></td>
				</tr>
				<!--<tr style='width:100%'>
					<tr style='background:yellow;'>
						<td width='5%;' valign='top'><strong>".($k).".</strong></td>
						<td width='95%;'>".$row['descripcion']."</td>
					</tr>		
					<tr style='background:blue;'>
						<td width='5%;' valign='top'>fgfg</td>
						<td width='95%;'>
						<tr>
							<td width='30%' style='background:green;' ></td>
							<td width='70%' width='180px;' style='background:grey;' ></td>
						</tr>
						</td>
					</tr>
				</tr>-->";
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
