<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");
$sql= "SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'";
$ci_rem = mysql_fetch_array(mysql_query($sql));

$sql= "SELECT DISTINCT ci_dest FROM envia_msj WHERE ci_rem='".$ci_rem['ci']."' and visto='pendiente'";
$resultado= mysql_query($sql) or die ("Error en la búsqueda de los participantes. Error: . ".mysql_error());

echo "
	<div style=\"overflow:auto; height:500px;\">
	<table style=\"font-size: 9px;\" width=\"100%\" border=\"1\" height=\"480px\">
        <thead>
			<th style=\"width:20%\">NOMBRE</th>
            <th style=\"width:40%; font-size:10px;\">ASIGNADO</th>
			<th style=\"width:40%\">APROBADO</th>
         </thead>
         <tbody>";
		 
	while($row = mysql_fetch_array($resultado)){
		
		//EN ESTA SECCIÓN SE BUSCA LOS ENUNCIADOS QUE FUERON ASIGNADOS AL USUARIO
		$sql="SELECT msj FROM envia_msj WHERE ci_dest='".$row['ci_dest']."' and visto='pendiente'";
		$res=mysql_query($sql) or die ("Error al consultar el nombre y el usuario. Error: . ".mysql_error());
		$asig="";
		while($fila = mysql_fetch_array($res)){
			$arreglo=explode(",",$fila['msj']);
			$totalSeleccionados = count($arreglo);
			$i=0;
			while($i < $totalSeleccionados){
				$asig=$asig."<li style=\"font-size:10px;\">".$arreglo[$i+3]." ejercicio(s) ".$arreglo[$i+2]." de ".$arreglo[$i]."</li>"."<br>";
				$i=$i+4;
			}
		}
		$sql="SELECT nombre,user FROM usuario WHERE ci='".$row['ci_dest']."'";
		$res=mysql_query($sql) or die ("Error al consultar el nombre y el usuario. Error: . ".mysql_error());
		$fila=mysql_fetch_array($res);
		
		
		//EN ESTA SECCIÓN SE BUSCA LOS EJERCICIOS QUE EL USUARIO TIENE APROBADO //

			$sql="SELECT msj FROM envia_msj WHERE ci_rem='".$row['ci_dest']."' and ci_dest='".$ci_rem['ci']."' and visto='aprobado'";
			$res=mysql_query($sql) or die ("Error al consultar el mensaje aprobado. Error: . ".mysql_error());
			$aprob="";
			while($fila2 = mysql_fetch_array($res)){
				$arreglo=explode(",",$fila2['msj']);
				$totalSeleccionados = count($arreglo);
				$i=0;
				while($i < $totalSeleccionados){
								
					$sql="SELECT nombre_sub FROM enunciado WHERE id_e='".$arreglo[$i]."'";
					$result=mysql_query($sql) or die ("Error al consultar el mensaje aprobado. Error: . ".mysql_error());
					$subt = mysql_fetch_array($result);
			
					$aprob=$aprob."<li style=\"font-size:10px;\">1 ejercicio de ".$subt['nombre_sub']."</li><br>";
					$i++;
				}
			}

		echo	"<tr>";
		echo   	"<td  style='width:20%'>Prof. ".$fila['nombre']."</td>";
		echo    "<td  style=\"width:40%;\" align=\"justify\">$asig</td>";
		echo    "<td  style='width:40%;'>$aprob</td>";
		echo    "</tr>";
	}
     echo "</tbody>
     </table></div>";
?>