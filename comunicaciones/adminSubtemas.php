<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");

echo "<div id='addSubtema' style='width:45%; margin-left:2%;float:left; margin-top:2%; display:block;'>
	<form name='agregarSubtema' action='comunicaciones/agregarSubtema.php' method='post'>
		<input type='hidden' name='subt_viejo' id='subt_viejo' value=''/>
        <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR SUBTEMA</div></h4></div>
		
		<div id='subtema' class='form-group'>
			<label for='nomb_subt'>Subtema</label>
		<textarea class='form-control' name='nomb_subt'  id='nomb_subt' placeholder='Subtema' ></textarea>
		</div>
		
		<div id='unidades' class='form-group'>
			<label for='unidad_tematica'>Unidad Tematica</label>
			<select class='form-control' name='unidad_tematica' id='unidad_tematica' >";	
		$resultado = mysql_query("SELECT nomb_unid FROM unidad_tematica");
		while($row = mysql_fetch_array($resultado)){
			
				  echo"<option id='".$row['nomb_unid']."' value='".$row['nomb_unid']."'>".$row['nomb_unid']."</option>";
			}
			echo "</select></div>
		<button id='boton_subtemas' type='submit' class='btn btn-primary btn-block'>Agregar</button>
		</div>
	</form>
</div>"; 
$cant_reg = 7;
$num_pag=1;
if ($_GET["pagina"]==0){
	$comienzo = 0;
}else{
	$num_pag=intval($_GET["pagina"]);
	$aux=$num_pag-1;
	$comienzo = ($aux)*$cant_reg;
}
$resultado = mysql_query("SELECT * FROM subtema");
$total_registros = mysql_num_rows($resultado);
$total_paginas = ceil($total_registros / $cant_reg);

if($total_registros>0){
$sql= "SELECT * FROM subtema LIMIT $comienzo, $cant_reg";
$result= mysql_query($sql);
$total_paginas = ceil($total_registros / $cant_reg);
echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
<table class='table-striped table-responsive'>
    <thead>
        <th style='width:60%'>Subtema</th>
        <th style='width:45%'>Unidad Tematica</th>
        <th colspan='2' style='width:50%'>Opciones</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td>".$row['nombre_subtema']."</td>
			<td>".$row['nomb_u']."</td>
			<td><input type='image' src='resources/imagenes/icn_edit_article.png'  title='Editar' class='edit_or_delete' onclick=\"modifSubtema('".$row['nombre_subtema']."','".$row['nomb_u']."');\" /></td>
			
			<td>
			<form name='eliminar_sub_".$row['nombre_subtema']."' id='eliminar_sub_".$row['nombre_subtema']."' method='post' action='comunicaciones/eliminarSubtema.php'>
			<input type='hidden' name='subt' id='subt' value='".$row['nombre_subtema']."'>
			<span class='glyphicon glyphicon-trash' title='Eliminar'  onclick=\"confirmEliminacion('".$row['nombre_subtema']."','el subtema','eliminar_sub_".$row['nombre_subtema']."');\"></span>
			</form></td>
            </tr>";
}
echo "</table>";
$aux=$num_pag-1;
if(($aux)>0){
	echo "<a style='color:blue; font-size:12px; cursor:pointer;' onclick='verSubtemas($aux)'><b>< Anterior</b></a> ";
}
/* Luego, mediante un ciclo de tipo for que dura mientras la variable i sea menor al número total de páginas, se van listando, con números, todas las páginas disponibles con sus respectivos vínculos. También se desplega la página actual, sin vincular. */
for ($i=1; $i<=$total_paginas; $i++){
	if ($num_pag == $i){
		echo "<b style='font-size:12px'>Página ".$num_pag."</b> ";
	}else{
		echo "<a style='background:blue;font-size:12px;cursor:pointer;' onclick='verSubtemas($i)'>$i</a> ";
	}
}
/* Y finalmente, se pregunta mediante un if si el número de la página actual  más 1 es menor o igual al total de páginas. Si es así se presenta un vínculo para la página siguiente, enviando el parámetro correspondiente que se recoje mediante GET */
if(($num_pag+1)<=$total_paginas){
	?><a style='color:blue; font-size:12px;cursor:pointer;' onclick="verSubtemas(<?php echo ($num_pag+1)?>)"><b>Siguiente ></b></a><?php
}
echo "</div>";
}else{
	echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
	<div class='alert alert-info'>
	<strong>No hay subtemas actualmente</strong>
	</div></div>";
}
?>
