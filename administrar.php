<div>
	<br>
	<?php 
	if(isset($_SESSION["actAviso"])){
		switch ($_SESSION["actAviso"]){
			case 1:
				echo "<div id='aviso' class='alert alert-success fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong>Elemento agregado exitosamente</strong>";
				echo "</div>";
			break;
			case 2:
				echo "<div id='aviso' class='alert alert-success fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong>El elemento seleccionado ha sido modificado exitosamente</strong>";
				echo "</div>";
			break;
			case 3:
				echo "<div id='aviso' class='alert alert-success fade in'>";
					echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
					echo "<strong>El elemento seleccionado ha sido eliminado exitosamente</strong>";
					echo "</div>";
				break;
			case 4:
				echo "<div id='aviso' class='alert alert-danger fade in'>";
					echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
					echo "<strong>Ha ocurrido algún error, verifique los datos.</strong>";
					echo "</div>";
				break;
		}
		echo "<script>$('#aviso').fadeOut(8000);</script>";
		$_SESSION["actAviso"]=-1;
    }?>
  	<div  id="opciones" style="width:100%;background:aliceblue;">
    	<div style="float:left; width:20%; background-color:#0088cc;">
    		<h4>Opciones</h4>
    		<div id="carpetas" style="float:left; width:100%; background:aliceblue; font-size: 18px; height:400px;">
				<a id="temas" style="display:block; margin-top:20px; cursor:pointer;" onclick="verTemas();"><span class="glyphicon glyphicon-asterisk"></span> Unidades Tematicas</a>
				<a id="subtemas" style="display:block; margin-top:10px; cursor:pointer;" onclick="verSubtemas('0');"><span class="glyphicon glyphicon-asterisk"></span> Subtemas</a>
				<a id="usuarios" style="display:block; margin-top:10px; cursor:pointer;" onclick="verUsuarios('0');"><span class="glyphicon glyphicon-asterisk"></span> Usuarios</a>
			</div>
    	</div>
        <div style="float:left; width:80%; background-color:#aliceblue;">
			 <!--El contenido de este div es creado al seleccionar los mensajes que se desea ver (recibidos o enviados) -->
			<div id="informacion" style="float:left; width:100%; display:block;">
			<?php if(isset($_GET['fuente'])){
				if($_GET['fuente']=='1'){
			?>
				<script type="text/javascript">
					setTimeout("verSubtemas('0');", 0);
				</script>
			
			<?php }else{?>
				<script type="text/javascript">
					setTimeout("verUsuarios('0');", 0);
				</script>
			<?php }
			}else{?>
				<script type="text/javascript">
					setTimeout("verTemas();", 0);
				</script>
			<?php }?>
			</div>
        </div>
    </div>
   
    
   
</div>		

