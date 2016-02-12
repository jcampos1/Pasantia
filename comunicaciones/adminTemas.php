<?php
/*Este archivo es utilizado por la funcion de JavaScript mostrarSubtemas para la peticion sin recargar*/
session_start();
include("../conexion.php");
$cant_reg = 9;
$num_pag=1;
/*if ($_GET["pagina"]==0){
	$comienzo = 0;
}else{
	$num_pag=intval($_GET["pagina"]);
	$aux=$num_pag-1;
	$comienzo = ($aux)*$cant_reg;
}*/

echo "<div id='addTema' style='width:40%; margin-left:2%;float:left; margin-top:2%; display:block;'>
<form name='agregarTema' action='comunicaciones/agregarTema.php' method='post'>
		<input type='hidden' name='unid_viejo' id='unid_viejo' value=''/>
            <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR TEMA</div></h4></div>
			<div id='unid_t' name='unid_t' style=' margin-top:10%;'><h5>Unidad Temática</h5><textarea name='unid_tem'  id='unid_tem' placeholder='Tema' ></textarea>
        </div>
		<div id='asignatura'>
		<h5>Asignatura</h5>
<select name='asig' id='asig'>
            <option id='EDI' value='EDI'>EDI</option>
			<option id='EDII' value='EDII'>EDII</option>
			</select>
        </div>
		<div style=' margin-top:-10px;' align='center'>
			<input type='submit' id='boton' value='Agregar'/>
		</div>
	 
	</form></div>"; 
$sql= "SELECT * FROM unidad_tematica";
$result= mysql_query($sql);
echo "<div id='lista' style='width:56%; float:left; margin-left:2%; margin-top:2%;'>
<table width='100%' border='1' height='350px'>
    <thead>
        <th style='width:60%'>Tema</th>
        <th style='width:20%'>Asignatura</th>
        <th style='width:10%'>MODIFICAR</th>
        <th style='width:10%'>BORRAR</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td  style='width:10px'>".$row['nomb_unid']."</td>
			<td  style='width:100px'>".$row['asignatura']."</td>
			<td  style='width:10px'><input type='image' src='resources/imagenes/icn_edit_article.png' style='margin-left:30px;' title='Editar' class='edit_or_delete' onclick=\"modifUnidad('".$row['nomb_unid']."','".$row['asignatura']."');\" /></td>
			
			<td  style='width:100px'>
			<form name='eliminar' method='post' action='comunicaciones/eliminarTema.php' onsubmit=\"return confirmTema('".$row['nomb_unid']."','tema');\">
			<input type='hidden' name='unid' id='unid' value='".$row['nomb_unid']."'>
			<input type='image' src='resources/imagenes/icn_trash.png' style='margin-left:30px;' title='Eliminar' class='edit_or_delete'/></form></td>
			
            </tr>";
}
echo "</table>
</div>";

?>
