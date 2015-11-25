<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");

//cantidad de subtemas seleccionados
$subt=explode(",",$micadena);
$cant=explode(",",$string);
$totalSeleccionados = count($subt);

//obtengo la cedula de identidad del usuario coordinador
$sql= "SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'";
$ci_rem = mysql_fetch_array(mysql_query($sql));

echo "<h2 align=\"center\">Parcial Colaborativo</h2>";
$conten = "<table width='100%'>";
//Para escribir por cada enunciado, si el enunciado es Teórico o Práctico
$sql="SELECT msj FROM envia_msj WHERE ci_dest='".$ci_rem['ci']."' and visto='aprobado'";
$result=mysql_query($sql) or die ("Error al consultar el mensaje aprobado. Error: . ".mysql_error());
	
	
	$n=mysql_num_rows($result);
	if($n>0){
		$k=1;
		while($row=mysql_fetch_array($result)){
			$arreglo=explode(",",$row['msj']);
				$totalSeleccionados = count($arreglo);
				$i=0;
				while($i < $totalSeleccionados){		
					$sql="SELECT * FROM enunciado WHERE id_e='".$arreglo[$i]."'";
					$r=mysql_query($sql) or die ("Error al consultar el mensaje aprobado. Error: . ".mysql_error());
					$enun = mysql_fetch_array($r);
					
					$conten = $conten."
					<tr>
						<tr>
							<td width='5%;' valign='top'><strong>".($k).".</strong></td>
							<td width='95%;'><b>Ejercicio $componente / ".$enun['nombre_sub']."</b><br>".$enun['descripcion']."</td>		
						</tr>
					</tr>
					<tr style='background:white'>
						<td width='30%;' align='center'><strong style='font-size:10px;'>pts ejerc. ".$k."<br></strong><input name='pts[]' style='height:20px;pading:0;width:60px;' type='number' min='0' max='20'></td>
						<td width='70%;' align='center'><strong style='font-size:10px;'>pts por Items ejercicio ".$k."</strong><input type='text' name='items[]' placeholder='pts por items' style='font-size:12px; height:20px;' width='70%'/></td>
					</tr>";
					$i++;
					$k++;
				}
		}
	}else{
		echo "NO SE HA APROBADO NINGUN ENUNCIADO. ASEGURESE DE HABER ASIGNADO TAREAS A LOS USUARIOS PARTICIPANTES";
	}
	$i=$i+3;
	$j++;
echo "<br><h3 align=\"center\">Ejercicios Aprobados</h3><br> ";
$conten=$conten."</table>";
echo $conten;
$_SESSION['contenido']=$conten;

?>
