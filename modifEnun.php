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
