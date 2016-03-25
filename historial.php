<?php include("conexion.php"); ?>
<div class="row">
<h2>Repositorio</h2>

<?php 
	if(isset($_SESSION["actAviso"])){
		switch ($_SESSION["actAviso"]){
			case 0:
				echo "<div id='aviso_banco' class='alert alert-success fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong><span class='glyphicon glyphicon-ok-sign'></span> Ejercicio modificado exitosamente.</strong>";
				echo "</div>";
			break;
			case 1:
				echo "<div id='aviso_banco' class='alert alert-danger fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> No se ha podido modificar el enunciado, verifique los datos.</strong>";
				echo "</div>";
			break;
		}
		echo "<script>$('#aviso_banco').fadeOut(8000);</script>";
		$_SESSION["actAviso"]=-1;
    }?>
	
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
	$sql= "SELECT * FROM enunciado WHERE visibilidad='publico'";
	$resultado = mysql_query($sql) or die ("Falló la consulta".mysql_error());
	$total_registros = mysql_num_rows($resultado);
	
	if($total_registros > 0){
		
		echo "<table class='table-striped table-responsive'>";
		echo "<thead>";
        echo "<th style='width:5%'>ID</th>";
        echo "<th style='width:20%'>UNIDAD TEMÁTICA</th>";
        echo "<th style='width:20%'>SUBTEMA</th>";
        echo "<th style='width:10%'>SOLUCIÓN</th>";
        echo "<th style='width:15%'>CREADO POR</th>";
        echo "<th style='width:15%'>FECHA DE CREACIÓN</th>";
        echo "<th style='width:15%'>ÚLTIMO USO</th>";
        echo "<th colspan='2' style='width:20%'>OPCIONES</th>";
		echo "<tbody>";
		
		
		$resultado = mysql_query( "SELECT * FROM enunciado INNER JOIN usuario ON ci_crea_en=ci WHERE visibilidad='publico' ORDER BY id_e LIMIT $comienzo, $cant_reg");
		$total_paginas = ceil($total_registros / $cant_reg);

		while($row = mysql_fetch_array($resultado)){
			$id=$row['id_e'];
			$nombre_sub=$row['nombre_sub'];
			$fec_creacion=$row['fec_creacion'];
			$fec_ult_uso=$row['fec_ult_uso'];
			$desc=$row['descripcion'];
			$unid_tem=$row['unidad_tematica'];
			$creado=$row['user'];
			if($row['solucion']) $solucion="Si";
			else $solucion="No";
			?>
			<tr onmouseover="this.className = 'resaltar'" onmouseout="this.className = null">
				<td  style='width:10px' ><?php echo $id?></td>
				<td  style='width:10px' ><?php echo $unid_tem?></td>
				<td  style='width:10px'><?php echo $nombre_sub?></td>
				<td  style='width:10px'><?php echo $solucion?></td>
				<td  style='width:10px'><?php echo $creado?></td>
				<td  style='width:10px'><?php echo $fec_creacion?></td>
				<td  style='width:100px'><?php echo $fec_ult_uso?></td>
				<td  style='width:10px'>
				<form name="formEdit" action="inicio.php?view=7" method="post">
					<input type="hidden" id="<?php echo $id?>" name="idModif" value="<?php echo $id?>" />
					<input type="image" src="resources/imagenes/icn_view.png"  title="Visualizar/Editar" class="edit_or_delete"/>
				</form>
				</td>
				<td  style='width:10px'>
				<form name="eliminar_enun_<?php echo $id?>" id="eliminar_enun_<?php echo $id?>" action="borrarEnun.php"  method="post">
					<input type="hidden" name="id" id="<?php echo $id?>" value="<?php echo $id?>" />
					<span class="glyphicon glyphicon-trash" title="Eliminar"  onclick="confirmEliminacion('<?php echo $id?>','el enunciado','eliminar_enun_<?php echo $id?>');"></span>
					
				</form>
				</td>
			</tr>
		<?php }
		?>  
		</tbody>
	</table>
	<?php
	$aux=$num_pag-1;
	if(($aux)>0){
		echo "<a href='inicio.php?view=5&pagina=".$aux."' style='color:blue; font-size:12px'><b>< Anterior</b></a> ";
	}
	/* Luego, mediante un ciclo de tipo for que dura mientras la variable i sea menor al número total de páginas, se van listando, con números, todas las páginas disponibles con sus respectivos vínculos. También se desplega la página actual, sin vincular. */
	for ($i=1; $i<=$total_paginas; $i++){
		if ($num_pag == $i){
			echo "<b style='font-size:12px'>Página ".$num_pag."</b> ";
		}else{
			echo "<a href='inicio.php?view=5&pagina=$i' style='background:blue; font-size:12px'>$i</a> ";
		}
	}
	/* Y finalmente, se pregunta mediante un if si el número de la página actual  más 1 es menor o igual al total de páginas. Si es así se presenta un vínculo para la página siguiente, enviando el parámetro correspondiente que se recoje mediante GET */
	if(($num_pag+1)<=$total_paginas){
		?><a href='inicio.php?view=5&pagina=<?php echo ($num_pag+1)?>' style='color:blue; font-size:12px'><b>Siguiente ></b></a><?php
	}
}
else{
	echo "<div class='alert alert-info'>
	<strong>No hay ejercicios en el repositorio público.</strong>
	</div></div>";
}
	?>	
</div>
