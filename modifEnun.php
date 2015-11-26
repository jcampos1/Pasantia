<!DOCTYPE html>
<?php include("conexion.php"); ?>
<html>
<head>
		<meta charset="utf-8">
		<title>Editar Ejercicios</title>
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
</head>

<div>
	<h1 class="samples">
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
        	<h4>Nivel</h4>
			<select name="nivel" id="nivel"  onChange="verEnun()">
            	  <option value="<?php echo $row['nivel']?>"><?php echo $row['nivel']?></option>
				  <option value="bajo">bajo</option>
				  <option value="medio">medio</option>
				  <option value="alto">alto</option>
				  <option value="reparacion">reparacion</option>
                  <option value="concurso">concurso</option>
			</select>
            <h4>Componente</h4>
            <select name="componente" id="componente">
				  <option value="<?php echo $row['componente']?>"><?php echo $row['componente']?></option>
                  <?php if($row['componente']=="teorico"){?>
				  <option value="practico">practico</option>
                  <?php }else{?>
                  <option value="teorico">teorico</option>
				  <?php }?>
            </select>
            
            <h4>Unidad Temática</h4>
            <select name="unidad_tematica" id="unidad_tematica"  onChange="mostrarSubtemas(this.value);" >
            
			<?php
			$unidad = mysql_fetch_array(mysql_query("SELECT nomb_u FROM  subtema WHERE nombre_subtema='".$row['nombre_sub']."'"));
			?>
            <option value="<?php echo $unidad['nomb_u'];?>"><?php echo $unidad['nomb_u'];?></option>
            <?php
			$resultado=mysql_query("SELECT nomb_unid FROM  unidad_tematica WHERE nomb_unid!='".$fila['nomb_u']."'");
			while($fila = mysql_fetch_array($resultado)){
			?>
				  <option value="<?php echo $fila['nomb_unid'];?>"><?php echo $fila['nomb_unid'];?></option>
			<?php }?>
			</select>
            
            <!-- Lista de los subtemas de la unidad tematica seleccionada -->
            
            <div id="contenidoSubtemas">
            <?php
			$sql="SELECT nombre_subtema FROM subtema WHERE nomb_u = '".$unidad['nomb_u']."' and nombre_subtema!='".$row['nombre_sub']."'";
			$result = mysql_query($sql,$conexion);
			?>
			<h4>Tema</h4>
			<select name='subtema' id="subtema">
			<option value="<?php echo $row['nombre_sub'] ?>"><?php echo $row['nombre_sub'] ?></option>
			<?php while($fila = mysql_fetch_array($result)) {
				?>
                <option value="<?php echo $fila['nombre_subtema'] ?>"><?php echo $fila['nombre_subtema'] ?></option>
			<?php } ?>
			</select>
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
			<input type="submit" value="Modificar Enunciado" id="btn" onclick="modificarEnunciado()">
	</form>
	<hr></hr>
</div>
</html>