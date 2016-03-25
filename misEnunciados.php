
	<?php include("conexion.php"); ?>	
<div>
	<h2>
		Mis Ejercicios
	</h2>
    <?php
	$cant_reg = 10;
	$num_pag=1;
	if (!isset($_GET["pagina"])){
		$comienzo = 0;
	}else{
		$num_pag=intval($_GET["pagina"]);
		$aux=$num_pag-1;
		$comienzo = ($aux)*$cant_reg;
	}
	$resultado = mysql_query("SELECT * FROM enunciado WHERE ci_crea_en=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."')");
	$total_registros = mysql_num_rows($resultado);
	
	if($total_registros > 0){
	echo "<table class='table-striped table-responsive'>";
	echo "<thead>";
	echo "<th style='width:5%'>ID</th>";
	echo "<th style='width:80%'>CONTENIDO</th>";
	echo "<th style='width:15%'>UNIDAD TEMATICA</th>";
	echo "<th style='width:15%'>SUBTEMA</th>";
	echo "</thead>";
	echo "<tbody>";
	
	$total_paginas = ceil($total_registros / $cant_reg);
	$resultado = mysql_query("SELECT * FROM enunciado WHERE ci_crea_en=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."')");
	while($row = mysql_fetch_array($resultado)){
	
	echo	"<tr>";
    echo   	"<td  style='width:5%'>".$row['id_e']."</td>";
    echo    "<td  style='width:80%'>".$row['descripcion']."</td>";
    echo   	"<td  style='width:15%'>".$row['unidad_tematica']."</td>";
    echo    "<td  style='width:15%'>".$row['nombre_sub']."</td>";
    echo    "</tr>";
	}
	?>
	</tbody>
    </table>
     <?php
	$aux=$num_pag-1;
	if(($aux)>0){
	echo "<a href='inicio.php?view=11&pagina=".$aux."' style='color:blue; font-size:12px'><b>< Anterior</b></a> ";
}
/* Luego, mediante un ciclo de tipo for que dura mientras la variable i sea menor al número total de páginas, se van listando, con números, todas las páginas disponibles con sus respectivos vínculos. También se desplega la página actual, sin vincular. */
for ($i=1; $i<=$total_paginas; $i++){
	if ($num_pag == $i){
		echo "<b style='font-size:12px'>Página ".$num_pag."</b> ";
	}else{
		echo "<a href='inicio.php?view=3&pagina=$i' style='background:blue; font-size:12px'>$i</a> ";
	}
}
/* Y finalmente, se pregunta mediante un if si el número de la página actual  más 1 es menor o igual al total de páginas. Si es así se presenta un vínculo para la página siguiente, enviando el parámetro correspondiente que se recoje mediante GET */
if(($num_pag+1)<=$total_paginas){
	?><a href='inicio.php?view=11&pagina=<?php echo ($num_pag+1)?>' style='color:blue; font-size:12px'><b>Siguiente ></b></a><?php
}
}
else{
	echo "<div class='alert alert-info'>
	<strong>Usted no ha agregado ejercicios.</strong>
	</div></div>";
}
?>
</div>


