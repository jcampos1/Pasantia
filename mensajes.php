<div>
	<br>
	<?php 
	if(isset($_GET['actAviso']) and $_GET['actAviso']=='1'){?>
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="background:#0CC; height:50px;">
     	<b>su mensaje fue enviado con exito</b>
        </div>
    <?php }?>
    <input type="hidden" id="usuarioAResponder" value=""/>
  	<div  id="opciones" style="width:100%;background:#0088cc;">
    	<div style="float:left; width:20%; background-color:#0088cc; height:31px;">
    		<h4>Carpetas</h4>
    	</div>
        <div style="float:left; width:80%;">
    		<input type="button" style="width:120px; font-size:18px; display:inline;" name="redactar" id="redactar" value="Redactar" onclick="camposRedaccion();"  />
            <input type="button" style="width:120px; font-size:18px; display:inline;" name="eliminar" id="eliminar" value="Eliminar" onclick="enviar_formulario()"/>
            <input type="button" style="width:120px; font-size:18px; display:none;" name="resp" id="resp" value="Responder" onclick="camposRedaccion(); marcarCheckbox();"/>
            <form method="post" name="formElimMsj" id="formElimMsj" action="borrarMsjs.php">
            </form>
        </div>
    </div>
    
  	<div id="carpetas" style="float:left; width:20%; background:aliceblue; font-size: 18px; height:400px;">
        <a id="rec" style="display:block; margin-top:20px; margin-left:2%; cursor:pointer;" onclick="mostrarMensajesRec('0');"><span class="glyphicon glyphicon-asterisk"></span> Recibidos</a>
        <a id="env" style="display:block; margin-top:10px; margin-left:2%; cursor:pointer;" onclick="mostrarMensajesEnv('0');"><span class="glyphicon glyphicon-asterisk"></span> Enviados</a>
    	<?php 
			//se muestra el campo 'Enviar a'
			echo "<div id='campoPara' style='width:100%; height:280px; margin-top:20%; display:none; overflow:auto;'>
			<h4 style='margin-left:2%;'>Contactos</h4>";
			$evento="";
			include("mostrarUsuarios.php");
			echo "</div>";
		?>
    </div>
    
    <!--El contenido de este div es creado al seleccionar los mensajes que se desea ver (recibidos o enviados) -->
    <div id="mensajes" style="float:left; width:80%; display:block;">
    
	<script type="text/javascript">
		setTimeout("mostrarMensajesRec('0');", 0);
	</script>
  	</div>
  
  	<div id="escribir" style="float:left; width:80%; display:none;">
		<form method="post" name="formMsj" id="formMsj" action="procesarEnvio.php">
    	<div style='width:50%; margin-left:5%; margin-top:2%;'>
            <!--enviar unicamente a todos los profesores -->
            <div id="opcGrupales" style="display:inline;"><h6 style="display:inline;">Profesorado   </h6><input form="formMsj" name="opcion" id="opcion" type="radio" class="margen_izq" value="Profesor" onclick="ocultar('campoPara');" />
            <!--enviar unicamente a todos los preparadores -->
            <h6 style="display:inline;">Preparadores   </h6><input form="formMsj" name="opcion" id="opcion" type="radio" class="margen_izq" value="Preparador" onclick="ocultar('campoPara');"/></div>
            <!--enviar unicamente a un conjunto de usuarios seleccionados -->
            <h6 style="display:inline;">Seleccionados  </h6><input form="formMsj" name="opcion" id="opcion" type="radio" class="margen_izq" value="elegidos" checked="checked" onclick="desplegar('campoPara');" />
        </div>
      
         <!--campo asunto -->
        <div id="asun" class="form-group" style='width:50%; margin-left:5%; margin-top:2%;'>
            <label for="asunto">Asunto:</label>
            <input class="form-control" form="formMsj" type='text' name="asunto" id='asunto' placeholder='Asunto' style="font-size:12px;"/>
        </div>
        
        
        <div class="form-group" style='width:50%; margin-left:5%; margin-top:2%;'>
			<label for="msj">Mensaje:</label>
			<textarea class="form-control"form="formMsj" name="msj" id='msj' placeholder='Mensaje' style="font-size:12px;" ></textarea>
		</div> 
        
        <button style='width:50%; margin-left:5%; margin-top:2%;' type='submit'id='boton' class='btn btn-primary btn-block'>Enviar</button>
         </form>
  </div>
    
</div>		

