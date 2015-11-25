<?php session_start();
include("../conexion.php");
$micadena=$_GET['parametro'];
//lo convierto en un array que solo tiene tres posiciones (subtema, unidad tematica y componente)
$par=explode(",",$micadena);
$subt= 	$par[0];
$unid= 	$par[1];
$comp= 	$par[2];
echo "
<div>
	<div align=\"center\"><b>
		subtema $subt<br/> Unidad Temática $unid<br/> Componente $comp<br/>
	</b>
	</div>
	<div style=\"overflow:auto; height:500px;\">
	<table width=\"100%\" border=\"1\" height=\"480px\">
        <thead>
			<th style=\"width:15%\">ID</th>
            <th style=\"width:65%\">DESCRIPCION</th>
			<th style=\"width:20%\">ULTIMO USO</th>
         </thead>
         <tbody>";
    
	$resultado = mysql_query("SELECT * FROM enunciado WHERE nombre_sub='$subt' and componente='$comp' ORDER BY fec_ult_uso ASC");
	while($row = mysql_fetch_array($resultado)){
	echo	"<tr onclick=\"apilar(".$row['id_e'].",'$subt','$comp');\" onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\" title=\"ver enunciados\">";
    echo   	"<td  style='width:15%'>".$row['id_e']."</td>";
    echo    "<td  style='width:65%'>".$row['descripcion']."</td>";
	if($row['fec_ult_uso']==""){
		echo    "<td  style='width:20%'>Sin Usar</td>";
	}else{
		echo    "<td  style='width:20%'>".$row['fec_ult_uso']."</td>";
	}
    echo    "</tr>";
   
	}
     echo "</tbody>
     </table></div>";
?>
</div>