<?php

session_start();
include("../conexion.php");

echo "<div id='addUsuario' style='width:45%; margin-left:2%;float:left; margin-top:2%; display:block;'>
	<form name='agregarUsuario' action='comunicaciones/agregarUsuario.php' method='post'>
		<input type='hidden' name='ci_vieja' id='ci_vieja' value=''/>
        <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR USUARIO</div></h4></div>
		
		<div class='form-group'>
			<label for='nombre'>Nombre y apellido</label>
			<input class='form-control' type='text' name='nombre'  id='nombre' placeholder='Nombre y apellido' />
		</div>
		
		<div class='form-group'>
			<label for='ced'>Cédula</label>
			<input class='form-control' type='text' name='ced'  id='ced' placeholder='Cédula' />
		</div>
		
		<div class='form-group'>
			<label for='correo'>Correo Electrónico</label>
			<input class='form-control' type='email' name='correo'  id='corro' placeholder='Correo electrónico' />
		</div>
		
		<div class='form-group'>
			<label for='usuario'>Usuario</label>
			<input class='form-control' type='text' name='usuario'  id='usuario' placeholder='Usuario' />
		</div>
		
		<div class='form-group'>
			<label for='pass'>Contraseña</label>
			<input class='form-control' type='password' name='pass'  id='pass' placeholder='Contraseña'  />
		</div>
		
		<div class='form-group'>
			<label for='tipo'>Tipo de usuario</label>
			<select class='form-control' name='tipo' id='tipo'>
				<option id='preparador' value='Preparador'>Preparador</option>
				<option id='profesor' value='Profesor' selected>Profesor</option>
			</select>
		</div>
		<button type='submit' class='btn btn-primary btn-block'>Agregar</button>

	</form>
</div>"; 
$cant_reg = 8;
$num_pag=1;
if ($_GET["pagina"]==0){
	$comienzo = 0;
}else{
	$num_pag=intval($_GET["pagina"]);
	$aux=$num_pag-1;
	$comienzo = ($aux)*$cant_reg;
}
$resultado = mysql_query("SELECT * FROM usuario where coord<>'si' ");
$total_registros = mysql_num_rows($resultado);
$total_paginas = ceil($total_registros / $cant_reg);

if($total_registros>0){
$sql= "SELECT * FROM usuario where coord<>'si' LIMIT $comienzo, $cant_reg";
$result= mysql_query($sql);
$total_paginas = ceil($total_registros / $cant_reg);
echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
<table class='table-striped table-responsive'>
    <thead>
        <th style='width:60%'>NOMBRE</th>
        <th style='width:30%'>USUARIO</th>
        <th style='width:10%'>BORRAR</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td  style='width:10px'>".$row['nombre']."</td>
			<td  style='width:100px'>".$row['user']."</td>
			
			<td  style='width:100px'>
			<form name='eliminar_usu_".$row['user']."' id='eliminar_usu_".$row['user']."' method='post' action='comunicaciones/eliminarUsuario.php'>
			<input type='hidden' name='user' id='user' value='".$row['user']."'>
			<span class='glyphicon glyphicon-trash' title='Eliminar'  onclick=\"confirmEliminacion('".$row['user']."','el usuario','eliminar_usu_".$row['user']."');\"></span>
			</form></td>
            </tr>";
}
echo "</table>";
$aux=$num_pag-1;
if(($aux)>0){
	echo "<a style='color:blue; font-size:12px; cursor:pointer;' onclick='verUsuarios($aux)'><b>< Anterior</b></a> ";
}
/* Luego, mediante un ciclo de tipo for que dura mientras la variable i sea menor al número total de páginas, se van listando, con números, todas las páginas disponibles con sus respectivos vínculos. También se desplega la página actual, sin vincular. */
for ($i=1; $i<=$total_paginas; $i++){
	if ($num_pag == $i){
		echo "<b style='font-size:12px'>Página ".$num_pag."</b> ";
	}else{
		echo "<a style='background:blue;font-size:12px;cursor:pointer;' onclick='verUsuarios($i)'>$i</a> ";
	}
}
/* Y finalmente, se pregunta mediante un if si el número de la página actual  más 1 es menor o igual al total de páginas. Si es así se presenta un vínculo para la página siguiente, enviando el parámetro correspondiente que se recoje mediante GET */
if(($num_pag+1)<=$total_paginas){
	?><a style='color:blue; font-size:12px;cursor:pointer;' onclick="verUsuarios(<?php echo ($num_pag+1)?>)"><b>Siguiente ></b></a><?php
}
echo "</div>";
}else{
	echo "<div id='lista' style='width:51%; float:left; margin-left:2%; margin-top:2%;'>
	<div class='alert alert-info'>
	<strong>No hay usuarios actualmente</strong>
	</div></div>";
}
?>
