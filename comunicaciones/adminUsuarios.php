<?php

session_start();
include("../conexion.php");

echo "<div id='addUsuario' style='width:40%; margin-left:2%;float:left; margin-top:2%; display:block;'>
	<form name='agregarUsuario' action='comunicaciones/agregarUsuario.php' method='post'>
		<input type='hidden' name='ci_vieja' id='ci_vieja' value=''/>
        <div style='margin-top:1%;' align='center'><h4><div id='titulo'>AGREGAR USUARIO</div></h4></div>
		<div style=' margin-top:5%;'><h5>Nombre y Apellido</h5><input type='text' name='nombre'  id='nombre' placeholder='escriba el nombre aqui' /></div>
		<h5>Cédula</h5><input type='text' name='ced'  id='ced' placeholder='ingrese su número de cédula' />
		<h5>Usuario</h5><input type='text' name='usuario'  id='usuario' placeholder='escriba el usuario aqui' />
		<h5>Contraseña</h5><input type='password' name='pass'  id='pass' placeholder='escriba la contraseña aqui'  />
		<h5>Tipo de Usuario</h5>
		<select name='tipo' id='tipo' onchange='fun();'>
		<option id='seleccione' value='seleccione' disabled selected>Seleccione</option>
		<option id='preparador' value='Preparador'>Preparador</option>
		<option id='profesor' value='Profesor'>Profesor</option>
		</select>
		
		<div id='coordinador' >
		</div>
		<div style=' margin-top:-10px;' align='center'>
			<input type='submit' id='boton' value='Agregar'/>
		</div>
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
$resultado = mysql_query("SELECT * FROM usuario");
$total_registros = mysql_num_rows($resultado);
$total_paginas = ceil($total_registros / $cant_reg);

if($total_registros>0){
$sql= "SELECT * FROM usuario LIMIT $comienzo, $cant_reg";
$result= mysql_query($sql);
$total_paginas = ceil($total_registros / $cant_reg);
echo "<div id='lista' style='width:56%; float:left; margin-left:2%; margin-top:2%;'>
<table width='100%' border='1' height='350px'>
    <thead>
        <th style='width:60%'>NOMBRE</th>
        <th style='width:20%'>USUARIO</th>
        <th style='width:10%'>EDITAR</th>
        <th style='width:10%'>BORRAR</th>
    <tbody>";
while($row=mysql_fetch_array($result)){
	echo " <tr onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\">
			<td  style='width:10px'>".$row['nombre']."</td>
			<td  style='width:100px'>".$row['user']."</td>
			<td  style='width:10px'><input type='image' src='resources/imagenes/icn_edit_article.png' style='margin-left:30px;' title='Editar' class='edit_or_delete' onclick=\"modifUsuario('".$row['ci']."','".$row['tipo']."','".$row['coord']."');\" /></td>
			
			<td  style='width:100px'>
			<form name='eliminar' method='post' action='comunicaciones/eliminarUsuario.php' onsubmit=\"return confirmTema('".$row['user']."','usuario');\">
			<input type='hidden' name='user' id='user' value='".$row['user']."'>
			<input type='image' src='resources/imagenes/icn_trash.png' style='margin-left:30px;' title='Eliminar' class='edit_or_delete'/></form></td>
			
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
	echo "<div style='margin:40px;'><span style='font-size:16px;'>NO SE ENCONTRÓ NINGUN USUARIO</span>
	<div align='center'>
		<img src='resources/imagenes/buzon_vacio.jpg' width='100px;' height='80px;' alt='No posee mensajes actualmente' >
	</div>
	</div>";
}
?>
