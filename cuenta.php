<?php include("conexion.php"); ?>
<div>
	<div style='width:48%; float:left;'>
        <h3>Usuario: <span><?php echo $_SESSION['usuario'] ?></span></h3>
        <div class="row">
            <img  class="col5 imagen" src="resources/imagenes/admin.jpg" alt="En Construccion" >
        </div>
    </div>
    <?php 
	if(isset($_GET['actAviso'])){
		if($_GET['actAviso']=='1'){?>
        <div id="aviso" style="background:; height:50px;">
     	<b>El proceso de actualización se realizo correctamente</b>
        </div>
   <?php }
   } ?>
    <?php $sql= "SELECT * FROM usuario WHERE user='".$_SESSION['usuario']."'";
	$result= mysql_query($sql);
	$row= mysql_fetch_array($result); ?>
    <div id='addUsuario' style='width:50%; margin-left:2%;float:left; margin-top:2%; display:inline-block;'>
        <form name='modifUsuario' action='comunicaciones/modifUsuario.php' method='post'>
            <input type='hidden' name='ci_vieja' id='ci_vieja' value="<?php echo $row['ci']?>"/>
            <div style='margin-top:1%;' align='center'><h4><div id='titulo'>MIS DATOS</div></h4></div>
            <div style=' margin-top:5%;'><h5>Nombre y Apellido</h5><input type='text' name='nombre'  id='nombre' placeholder='escriba el nombre aqui' value="<?php echo $row['nombre']?>" /></div>
            <h5>Cédula</h5><input type='text' name='ced'  id='ced' placeholder='ingrese su número de cédula' value="<?php echo $row['ci']?>" />
            <h5>Usuario</h5><input type='text' name='usuario'  id='usuario' placeholder='escriba el usuario aqui' value="<?php echo $row['user']?>"/>
            <h5>Contraseña</h5><input type='password' name='pass'  id='pass' placeholder='escriba la contraseña aqui' value="<?php echo $row['pass']?>"  />
            <?php if($_SESSION['coord']=="si"){?>
            <h5>Tipo de Usuario</h5>
            <select name='tipo' id='tipo' onchange='fun();'>
            <option id='Preparador' value='Preparador'>Preparador</option>
            <option id='Profesor' value='Profesor'>Profesor</option>
            </select>
            <script type="text/javascript">
            	setTimeout("seleccionar('<?php echo $row['tipo']?>','<?php echo $row['coord']?>');", 0);
        	</script>
            <div id='coordinador' >
            </div>
            <?php }else{?>
            <input type='hidden' name='tipo' id='tipo' value="<?php echo $row['tipo']?>"/>
			<?php }?>
            <div style=' margin-top:-10px;' align='center'>
                <input type='submit' id='boton' value='Actualizar'/>
            </div>
        </form>
	</div>
</div>

<div>
	
	<div class="row">
		
		<div class="col12">
			<hr>
			<h3>Mi Horario</h3>
			<?php
			$ruta_fichero ="uploads/horarios/horario_".md5($_SESSION['usuario']).".jpg";
			if (file_exists($ruta_fichero)) 
			{
				echo "<a href='#openModal'><img onclick='zoom(this)' class='horario' src='".$ruta_fichero."' width='100%' title='Mi Horario'></a>";
				echo "<a onclick='seguridad()'><img class='horario' src='resources/imagenes/eliminar.png' width='20px' height='20px' title='Eliminar Horario'></a>";
			} else 
			{
				echo "<form enctype='multipart/form-data' action='uploader.php' method='POST'>";
				echo "<input name='uploadedfile' type='file' accept='.jpg' title='Solo podra subir archivos .jpg' required />";
				echo "<input type='submit' value='Subir archivo' />";
				echo "</form>";
			}
			?>	
			<hr>
			<h3>Horario Preparadores</h3>
			<table class="hPrepa">
                <tr>
					<td><a href="#openModal"><img onclick="zoom(this)" style="top: -35px; left: -37px;" src="uploads/horarios/horario_preparador.png" width="74" height="70" title="Horario Preparador V"></a></td>
					<td><a href="#openModal"><img onclick="zoom(this)" style="top: -35px; left: -37px;" src="uploads/horarios/horario_preparador1.png" width="74" height="70" title="Horario Preparador W"></a></td>
					<td><a href="#openModal"><img onclick="zoom(this)" style="top: -35px; left: -37px;" src="uploads/horarios/horario_preparador2.png" width="74" height="70" title="Horario Preparador X"></a></td>
					<td><a href="#openModal"><img onclick="zoom(this)" style="top: -35px; left: -37px;" src="uploads/horarios/horario_preparador3.png" width="74" height="70" title="Horario Preparador Y"></a></td>
					<td><a href="#openModal"><img onclick="zoom(this)" style="top: -35px; left: -37px;" src="uploads/horarios/horario_preparador4.png" width="74" height="70" title="Horario Preparador Z"></a></td>
				</tr>
			</table>
					
		</div>
	</div>
</div>		

<div id="openModal" class="modalDialogo">
	<div>
	<a href="#close" onclick="cerrarZoom()" title="Cerrar" class="cerrar">X</a>
	<img id="zoom_horario" style="top: -35px; left: -37px;" src="" width="100%"  title="Horario Preparador Z">
	</div>
</div>


<script>
	function seguridad()
	{
		confirmar=confirm("¿Desea eliminar su Horario actual?");
		if (confirmar) 
		// si pulsamos en aceptar
			window.location="borrarHorario.php"

} 

function zoom(x){
	document.getElementById("zoom_horario").src=x.src;
}	
</script>					
		

