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
<?php 
	if(isset($_GET['actAviso']) and $_GET['actAviso']=='1'){?>
	<script type="text/javascript">
		setTimeout("mostrarAviso()", 0);
	</script>
    <?php }?>    
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="height:40px; display:none;">
     	<b><h3 style="color:#00F;">El enunciado fue agregado con éxito</h3></b>
        </div>

	<h2>
		Agregar Enunciado
	</h2>
	<form action="agregar.php"  method="post" name="banco">
		<p>
			<textarea name="editor" id="desc"></textarea>
		</p>
        	<h4>Nivel</h4>
			<select name="nivel" id="nivel" onChange="verEnun()">
				  <option value="bajo">Bajo</option>
				  <option value="medio">Medio</option>
				  <option value="alto">Alto</option>
				  <option value="reparacion">Reparacion</option>
                  <option value="reparacion">Concurso</option>
			</select>
            <h4>Componente</h4>
            <select name="componente" id="componente" onChange="cambiarSolucion()">
				  <option value="teorico" >Teorico</option>
				  <option value="practico" selected>Practico</option>
			</select>
            
            <h4>Unidad Temática</h4>
            <select name="unidad_tematica" id="unidad_tematica"  onChange="mostrarSubtemas(this.value);" >
            <option value=""></option>
			<?php
			$resultado = mysql_query("SELECT * FROM unidad_tematica");
			while($row = mysql_fetch_array($resultado)){
			?>
				  <option value="<?php echo $row['nomb_unid'];?>"><?php echo $row['nomb_unid'];?></option>
			<?php }?>
			</select>
            
            <!-- Lista de los subtemas de la unidad tematica seleccionada -->
            <div id="contenidoSubtemas">
			</div>
            <?php if($_SESSION['usuario']=="Profesor"){?>
            <h4>Privacidad</h4>
            <!-- control de acceso al enunciado -->
            <select name="visibilidad" id="visibilidad"  >
                <option value="privado" selected>privado</option>
                <option value="publico">público</option>
			</select>
            <?php }else{?>
				<input type="hidden" name="visibilidad" id="visibilidad" value="privado" />
			<?php }?>
            <h4 style="display:inline; margin-right:10px;">¿Solución?</h4>
            <input type="checkbox" name="dar_solucion" onChange="mostrar('solu1');"><br>
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
			<input type="submit" value="Agregar Enunciado">
	</form>
</div>
</html>
