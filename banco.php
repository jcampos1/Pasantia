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
				  <option value="bajo">bajo</option>
				  <option value="medio">medio</option>
				  <option value="alto">alto</option>
				  <option value="reparacion">reparacion</option>
                  <option value="reparacion">concurso</option>
			</select>
            <h4>Componente</h4>
            <select name="componente" id="componente" onChange="cambiarSolucion()">
				  <option value="teorico" >teorico</option>
				  <option value="practico" selected>practico</option>
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
	
	<hr></hr>

	<table width="100%" border="1" height="200px">
        <thead>
            <th style="width:10%">ID</th>
            <th style="width:70%">CONTENIDO</th>
            <th style="width:15%">TEMA</th>
            <th style="width:15%">SUBTEMA</th>
         </thead>
         <tbody>
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
	$resultado = mysql_query("SELECT * FROM enunciado");
	$total_registros = mysql_num_rows($resultado);
	$total_paginas = ceil($total_registros / $cant_reg);
	$resultado = mysql_query("SELECT * FROM enunciado ORDER BY fec_creacion DESC LIMIT $comienzo,$cant_reg");
	while($row = mysql_fetch_array($resultado)){
	
	echo	"<tr>";
    echo   	"<td  style='width:10px'>".$row['id_e']."</td>";
    echo    "<td  style='width:100px'>".$row['descripcion']."</td>";
	$unid_tem= mysql_fetch_array(mysql_query("SELECT nomb_u FROM subtema WHERE nombre_subtema='".$row['nombre_sub']."'"));
    echo   	"<td  style='width:10px'>".$unid_tem['nomb_u']."</td>";
    echo    "<td  style='width:100px'>".$row['nombre_sub']."</td>";
    echo    "</tr>";
   
	}
	?>

        </tbody>
     </table>
     <?php
$aux=$num_pag-1;
if(($aux)>0){
	echo "<a href='inicio.php?view=3&pagina=".$aux."' style='color:blue; font-size:12px'><b>< Anterior</b></a> ";
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
	?><a href='inicio.php?view=3&pagina=<?php echo ($num_pag+1)?>' style='color:blue; font-size:12px'><b>Siguiente ></b></a><?php
}
?>
</div>
</html>
