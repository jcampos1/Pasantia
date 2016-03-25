<!DOCTYPE html>
<?php include("conexion.php"); ?>
<script type="text/javascript" src="Editor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
window.onload = function()
{
 editor = CKEDITOR.replace('editor',{uiColor : '#0088cc'});
 
 CKFinder.setupCKEditor( editor, 'ckfinder/' );
 
 //agregue otro editor para la solucion
 solucion = CKEDITOR.replace('solucion',{uiColor : '#0088cc'});
 CKFinder.setupCKEditor( solucion, 'ckfinder/' );
}
</script>	

<div>
	<h1>
    	Modificar Enunciado
	</h1>

    <?php 
		$resultado = mysql_query("SELECT * FROM enunciado WHERE id_e='".$_POST['idModif']."'");
		$row = mysql_fetch_array($resultado);
     ?>
    <form name="form" method="get" action="procModifEnun.php">
     <input type="hidden" name="idModif" id="idModif" value="<?php echo $_POST['idModif']?>">
		<p>
			<textarea name="editor" id="desc"><?php echo $row['descripcion']?></textarea>
		</p>
        	<div class="form-group">
				<label for="Nivel">Complejidad:</label>
				<select class="form-control" id="nivel" name="nivel">
					<option value="bajo">Bajo</option>
				  <option value="medio">Medio</option>
				  <option value="alto">Alto</option>
				  <option value="reparacion">Reparación</option>
                  <option value="reparacion">Concurso</option>
			  </select>
			</div>
            <div class="form-group">
				<label for="componente">Componente:</label>
				<select class="form-control" id="componente" name="componente" onChange="cambiarSolucion()">
					<option value="teorico" >Teórico</option>
					<option value="practico" selected>Práctico</option>
			  </select>
			</div>
            
            <div class="form-group">
			<label for="unidad_tematica">Unidad Temática:</label>
			<select class="form-control" name="unidad_tematica" id="unidad_tematica"  onChange="mostrarSubtemas(this.value);" >
			<?php
			$unidad = mysql_fetch_array(mysql_query("SELECT nomb_u FROM  subtema WHERE nombre_subtema='".$row['nombre_sub']."'"));
			?>
            <option value="<?php echo $unidad['nomb_u'];?>"><?php echo $unidad['nomb_u'];?></option>
            <?php
			$resultado=mysql_query("SELECT nomb_unid FROM  unidad_tematica WHERE nomb_unid!='".$unidad['nomb_u']."'");
			while($fila = mysql_fetch_array($resultado)){
			?>
				  <option value="<?php echo $fila['nomb_unid'];?>"><?php echo $fila['nomb_unid'];?></option>
			<?php }?>
				</select>
			</div>
            
            <!-- Lista de los subtemas de la unidad tematica seleccionada -->
            
            <div id="contenidoSubtemas">
            <?php
			$sql="SELECT nombre_subtema FROM subtema WHERE nomb_u = '".$unidad['nomb_u']."' and nombre_subtema!='".$row['nombre_sub']."'";
			$result = mysql_query($sql,$conexion);
			?>
			<div class="form-group">
				<label for="subtema">Subtema:</label>
			<select class="form-control" name="subtema" id="subtema">
			<option value="<?php echo $row['nombre_sub'] ?>"><?php echo $row['nombre_sub'] ?></option>
			<?php while($fila = mysql_fetch_array($result)) {
				?>
                <option value="<?php echo $fila['nombre_subtema'] ?>"><?php echo $fila['nombre_subtema'] ?></option>
			<?php } ?>
			</select>
			</div>
			</div>
           
            <h4 style="display:inline; margin-right:10px;">¿Solución?</h4>
            <?php 
			$seMuestra="none"; //para saber si mostrar o no la solucion del enunciado
			if($row['solucion']!==""){
				$seMuestra="block";
			?>
            
                <input type="checkbox" name="dar_solucion" onChange="mostrar('editorSolucion');" checked>
			<?php }else{?>
				<input type="checkbox" name="dar_solucion" onChange="mostrar('editorSolucion');">
			<?php }
			?>
            <br>
            <p id="editorSolucion" style="display:<?php echo $seMuestra;?>">
				<textarea name="solucion" id="solucion"><?php echo $row['solucion'];?></textarea>
			</p>
            
            <input type="hidden" name="control">
			<input class="btn btn-primary pull-right" type="submit" value="Modificar Enunciado" id="btn" onclick="modificarEnunciado()">
	</form>
	<br>
</div>
</html>
