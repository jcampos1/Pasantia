<?php include("conexion.php"); ?>
<div class="row">
<h2>Mis Enunciados</h2>

<?php 
if(isset($_GET['actAviso']) and $_GET['actAviso']=='1'){?>
	<script type="text/javascript">
		setTimeout("mostrarAviso()", 0);
	</script>
    <?php }?>    
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="height:40px; display:none;">
     	<b><h3 style="color:#00F;">El enunciado fue modificado correctamente</h3></b>
        </div>
<table width="100%" border="1" height="350px">
    <thead>
        <th style="width:10%">ID</th>
        <th style="width:40%">UNIDAD TEMÁTICA</th>
        <th style="width:25%">SUBTEMA</th>
        <th style="width:25%">FECHA DE CREACIÓN</th>
        <th style="width:25%">ÚLTIMO USO</th>
        <th style="width:25%">MODIFICAR</th>
        <th style="width:25%">BORRAR</th>
    <tbody>
    <?php 
	$cant_reg = 3;
	$num_pag=1;
	if (!isset($_GET["pagina"])){
		$comienzo = 0;
	}else{
		$num_pag=intval($_GET["pagina"]);
		$aux=$num_pag-1;
		$comienzo = ($aux)*$cant_reg;
	}
	$sql= "SELECT * FROM enunciado WHERE ci_crea_en=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."')";
	$resultado = mysql_query($sql) or die ("Falló la consulta".mysql_error());
	$total_registros = mysql_num_rows($resultado);
	$resultado = mysql_query( "SELECT * FROM enunciado WHERE ci_crea_en=(SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."') ORDER BY id_e LIMIT $comienzo, $cant_reg");
	$total_paginas = ceil($total_registros / $cant_reg);

	while($row = mysql_fetch_array($resultado)){
		$id=$row['id_e'];
		$nombre_sub=$row['nombre_sub'];
		$fec_creacion=$row['fec_creacion'];
		$fec_ult_uso=$row['fec_ult_uso'];
		$desc=$row['descripcion'];
		$query= "SELECT nomb_u FROM subtema WHERE nombre_subtema='".$nombre_sub."'";
		$result = mysql_query($query);
		$unid_tem = mysql_fetch_array($result);
		?>
		<tr onmouseover="this.className = 'resaltar'" onmouseout="this.className = null">
			<td  style='width:10px'><?php echo $id?></td>
			<td  style='width:100px' title="<?php echo $desc?>"><?php echo $unid_tem['nomb_u']?></td>
			<td  style='width:10px'><?php echo $nombre_sub?></td>
			<td  style='width:100px'><?php echo $fec_creacion?></td>
            <td  style='width:100px'><?php echo $fec_ult_uso?></td>
            <td  style='width:100px'>
            <form name="formEdit" action="inicio.php?view=7" method="post">
                <input type="hidden" id="<?php echo $id?>" name="idModif" value="<?php echo $id?>" />
                <input type="image" src="resources/imagenes/icn_edit_article.png" style="margin-left:30px;" title="Editar" class="edit_or_delete"/>
            </form>
            </td>
            <td  style='width:100px'>
            <form name="formDelete" action="borrarEnun.php" onsubmit="return confirmacion(<?php echo $id?>);" method="post">
                <input type="image" src="resources/imagenes/icn_trash.png" style="margin-left:30px;" title="Eliminar" class="edit_or_delete"/>
                
                <input type="hidden" name="id" id="<?php echo $id?>" value="<?php echo $id?>" />
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
?>	
</div>