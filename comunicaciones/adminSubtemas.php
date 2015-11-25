<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");

echo "<div id='addSubtema' style='width:40%; margin-left:2%;float:left; margin-top:2%; display:block;'>
	<form name='agregarSubtema' action='comunicaciones/agregarSubtema.php' method='post'>
		<input type='hidden' name='subt_viejo' id='subt_viejo' value=''/>
        <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR SUBTEMA</div></h4></div>
		<div id='subtema' name='subtema' style=' margin-top:10%;'><h5>Nombre del Subtema</h5><textarea name='nomb_subt'  id='nomb_subt' placeholder='escriba aqui el subtema' ></textarea></div>
		<div id='unidades'>
		<h5>Unidad Tematica</h5>
		<select name='unidad_tematica' id='unidad_tematica' >";	
		$resultado = mysql_query("SELECT nomb_unid FROM unidad_tematica");
		while($row = mysql_fetch_array($resultado)){
			
				  echo"<option id='".$row['nomb_unid']."' value='".$row['nomb_unid']."'>".$row['nomb_unid']."</option>";
			}
			echo "</select>
		<div style=' margin-top:-10px;' align='center'>
			<input type='submit' id='boton' value='Agregar'/>
		</div>
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
echo "<div id='lista' style='width:56%; float:left; margin-left:2%; margin-top:2%;'>
<table width='100%' border='1' height='350px'>
    <thead>
        <th style='width:60%'>SUBTEMA</th>
        <th style='width:20%'>UNID. TEMATICA</th>
        <th style='width:10%'>MODIFICAR</th>
        <th style='width:10%'>BORRAR</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td  style='width:10px'>".$row['nombre_subtema']."</td>
			<td  style='width:100px'>".$row['nomb_u']."</td>
			<td  style='width:10px'><input type='image' src='resources/imagenes/icn_edit_article.png' style='margin-left:30px;' title='Editar' class='edit_or_delete' onclick=\"modifSubtema('".$row['nombre_subtema']."','".$row['nomb_u']."');\" /></td>
			
			<td  style='width:100px'>
			<form name='eliminar' method='post' action='comunicaciones/eliminarSubtema.php' onsubmit=\"return confirmTema('".$row['nombre_subtema']."','subtema');\">
			<input type='hidden' name='subt' id='subt' value='".$row['nombre_subtema']."'>
			<input type='image' src='resources/imagenes/icn_trash.png' style='margin-left:30px;' title='Eliminar' class='edit_or_delete'/></form></td>
			
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
	echo "<div style='margin:40px;'><span style='font-size:16px;'>NO HAY UNIDADES TEMATICAS</span>
	<div align='center'>
		<img src='resources/imagenes/buzon_vacio.jpg' width='100px;' height='80px;' alt='No posee mensajes actualmente' >
	</div>
	</div>";
}
?>