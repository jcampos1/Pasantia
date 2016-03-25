<!DOCTYPE html>
<?php include("conexion.php"); ?>
<script type="text/javascript" src="Editor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
window.onload = function()
{
 editor = CKEDITOR.replace('editor',{uiColor : '#0088cc'});
 
 CKFinder.setupCKEditor( editor, '/ckfinder/' );
 
 //agregue otro editor para la solucion
 solucion = CKEDITOR.replace('solucion',{uiColor : '#0088cc'});
 CKFinder.setupCKEditor( solucion, '/ckfinder/' );
}
</script>		

<div>
<?php 
	if(isset($_SESSION["actAviso"])){
		switch ($_SESSION["actAviso"]){
			case 0:
				echo "<div id='aviso_banco' class='alert alert-success fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong><span class='glyphicon glyphicon-ok-sign'></span> Ejercicio agregado exitosamente.</strong>";
				echo "</div>";
			break;
			case 1:
				echo "<div id='aviso_banco' class='alert alert-danger fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> Se ha producido un error,compruebe los datos.</strong>";
				echo "</div>";
			break;
			case 2:
				echo "<div id='aviso_banco' class='alert alert-danger fade in'>";
					echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
					echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> El enunciado no puede estar vacio.</strong>";
					echo "</div>";
				break;
		}
		echo "<script>$('#aviso_banco').fadeOut(8000);</script>";
		$_SESSION["actAviso"]=-1;
    }?>
	<h2>
		Agregar Ejercicio
	</h2>
	<form role="form" action="agregar.php"  method="post" name="banco">
		<p>
			<textarea name="editor" id="desc"></textarea>
		</p>
			<div class="form-group">
				<label for="Nivel">Complejidad:</label>
				<select class="form-control" id="nivel" name="nivel">
					<option value="bajo">Bajo</option>
				  <option value="medio">Medio</option>
				  <option value="alto">Alto</option>
				  <option value="reparacion">Reparación</option>
                  <option value="concurso">Concurso</option>
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
				<option value="" disabled selected>Seleccione</option>
				<?php
				$resultado = mysql_query("SELECT * FROM unidad_tematica");
				while($row = mysql_fetch_array($resultado)){
				?>
					  <option value="<?php echo $row['nomb_unid'];?>"><?php echo $row['nomb_unid'];?></option>
				<?php }?>
				</select>
			</div>
            
			<!-- Lista de los subtemas de la unidad tematica seleccionada -->
			<div id="contenidoSubtemas">
			</div>
			
			
			<?php if($_SESSION['tipo']=="Profesor"){?>
			<div class="form-group">
				<label for="visibilidad">Visibilidad:</label>
				<select class="form-control" name="visibilidad" id="visibilidad"  >
					<option value="privado" >Privado</option>
					<option value="publico" selected>Público</option>
				</select>
			</div>
            <?php }else{?>
				<input type="hidden" name="visibilidad" id="visibilidad" value="privado" />
			<?php }?>
			
			
            
            <div class="checkbox">
				<label><input type="checkbox" name="dar_solucion" onChange="mostrar('solu1');">Añadir solución</label>
			</div>
            
            <div id="solu1" style="display:none">
            <div id="solu">
                <p id='editorSolucion'><textarea name='solucion'></textarea></p>
            </div>
            <div id="solu2" style="display:none">
            <select name='solucionTeo' id='solucionTeo'><option value='verdadero'>verdadero</option><option value='falso'>falso</option></select>
            </div></div>
            <?php/* $resultado = mysql_query("SELECT tipo FROM usuario WHERE user='".$_SESSION['usuario']."'");
			 $row = mysql_fetch_array($resultado);
			 if($row['tipo']=="profesor"){
				 $control=""
			 }*/
			 ?>
            <input type="hidden" name="control">
			<input class="btn btn-primary pull-right" type="submit" value="Agregar">
			<br>
	</form>
	<br>
</div>
