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

echo "<div id='addTema' style='width:45%; margin-left:2%;float:left; margin-top:2%; display:block;'>
		<form role='form' name='agregarTema' action='comunicaciones/agregarTema.php' method='post'>
			<input type='hidden' name='unid_viejo' id='unid_viejo' value=''/>
            <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR UNIDAD TEMÁTICA</div></h4></div>
				<div class='form-group'>
					<label for='unid_tem'>Unidad temática</label>
					<textarea class='form-control' name='unid_tem'  id='unid_tem' placeholder='Unidad Temática' ></textarea>
				</div>
				<div class='form-group'>
					<label for='asig'>Asignatura</label>
					<select class='form-control' name='asig' id='asig'>
						<option id='EDI' value='EDI'>EDI</option>
						<option id='EDII' value='EDII'>EDII</option>
					</select>
				</div>
				<button id='boton_temas' type='submit' class='btn btn-primary btn-block'>Agregar</button>
	</form></div>"; 
$sql= "SELECT * FROM unidad_tematica";
$result= mysql_query($sql);

$total_registros = mysql_num_rows($result);
if($total_registros>0){
echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
<table class='table-striped table-responsive'>
    <thead>
        <th style='width:60%'>Unidad Temática</th>
        <th style='width:45%'>Asignatura</th>
        <th colspan='2' style='width:50%'>Opciones</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td>".$row['nomb_unid']."</td>
			<td>".$row['asignatura']."</td>
			<td><input type='image' src='resources/imagenes/icn_edit_article.png'  title='Editar' class='edit_or_delete' onclick=\"modifUnidad('".$row['nomb_unid']."','".$row['asignatura']."');\" /></td>
			
			<td>
			<form name='eliminar_".$row['nomb_unid']."' id='eliminar_".$row['nomb_unid']."' method='post' action='comunicaciones/eliminarTema.php'>
			<input type='hidden' name='unid' id='unid' value='".$row['nomb_unid']."'>
			<span class='glyphicon glyphicon-trash' title='Eliminar'  onclick=\"confirmEliminacion('".$row['nomb_unid']."','la unidad tematica','eliminar_".$row['nomb_unid']."');\"></span>
			</form></td>
            </tr>";
}
echo "</table></div>";
}
else{
	echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
	<div class='alert alert-info'>
	<strong>No hay Unidades Tematicas actualmente</strong>
	</div></div>";
	}

?>
