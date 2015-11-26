<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("conexion.php");
$nivel = $_GET['nivel'];
$string = $_GET['cant'];
$micadena = $_GET['subt'];
$conten='';
$contenido='';
$opc=$_GET['opcion'];
if(empty($micadena)){
	echo "No hay opciones seleccionadas";
}else{
	//cantidad de subtemas seleccionados
	$subt=explode(",",$micadena);
	$cant=explode(",",$string);
	$totalSeleccionados = count($subt);
	if($opc=="Quiz"){
		echo "<h2>Quiz Automatico</h2>";
	}else{
		if($opc=="Práctica"){
			echo "<h2>Práctica Automatica</h2>";
		}else{
			echo "<h2>Taller Automatica</h2>";
		}
	}
	$k=1;
	$conten = "<table width='100%'>";
	//update enunciado set fec_ult_uso='2015-08-25' where id_e='5'SELECT * FROM `enunciado` WHERE nombre_sub='DemostraciÃ³n lÃ³gica de predicados' order by fec_ult_uso ASC
	for($i=0; $i < $totalSeleccionados; $i++){
		$sql="SELECT * FROM enunciado WHERE componente='practico' and nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC LIMIT 0,".$cant[$i];
		/*$sql="SELECT * FROM (SELECT * FROM enunciado WHERE nombre_sub='".$subt[$i]."' and nivel='".$nivel."' ORDER BY fec_ult_uso ASC) ORDER BY rand(".time()."*".time().") LIMIT 0,".$cant[$i];*/
		$result=mysql_query($sql);
		$n=mysql_num_rows($result);
		if($n>0){
			while($row=mysql_fetch_array($result)){
				$conten = $conten."
				<tr>
					<tr>
						<td><strong>".($k).".</strong></td>
						<td id='p".($k)."' align='justify'>".$row['descripcion']."</td>		
					</tr>
				</tr>";
				
				
					$contenido=$contenido."<tr>
						<td ><strong>".($k).".</strong></td>
						<td id='p".($k)."' align=\"justify\">".$row['descripcion']."</td>		
					</tr>";
				
				if($opc!="Práctica"){
				$conten = $conten."<tr style='background:white'>
					<td width='30%;' align='center'><strong style='font-size:10px;'>pts ejerc. ".$k."<br></strong><input id='punt".($k)."' name='pts[]' style='height:20px;pading:0;width:60px;' type='number' min='0' max='20'></td>
					<td width='70%;' align='center'><strong style='font-size:10px;'>pts por Items ejercicio ".$k."</strong><input type='text' name='items[]' placeholder='pts por items' style='font-size:12px; height:20px;' width='70%'/></td>
				</tr>";
				}
				$k++;
			}
		}
	}
	echo "<br><h3>Cantidad de preguntas encontradas:<strong><span id='num_res'>".($k-1)."</span></strong></h3><br> ";
	$conten=$conten."</table>";
	echo $conten;
	$_SESSION['contenido']=$contenido;
}
?>
