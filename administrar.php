<div>
	<?php 
	if(isset($_GET['actAviso'])){
		if($_GET['actAviso']=='1'){?>
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="background:; height:50px;">
     	<b>El elemento fue agregado exitosamente</b>
        </div>
  <?php }else{
			if($_GET['actAviso']=='2'){?>
				<!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        		<div id="aviso" style="background:#0CC; height:50px;">
     			<b>El elemento seleccionado ha sido modifificado exitosamente</b>
        		</div>
        <?php }else{?>
				<!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        		<div id="aviso" style="background:#0CC; height:50px;">
     			<b>El elemento seleccionado ha sido eliminado</b>
        		</div>
		<?php }
		}
	}?>
  	<div  id="opciones" style="width:100%;background:#CCC;">
    	<div style="float:left; width:20%; text-align:center; text-align:center; background-color:#999;">
    		<h4>Carpetas</h4>
    	</div>
        <div style="float:left; width:80%; text-align:center; text-align:center; background-color:#999;">
    	<h4>Aqui van los avisos</h4>
        </div>
    </div>
    
  	<div id="carpetas" style="float:left; width:20%; background:#CCC; font-size: 18px; height:400px;">
        <a id="temas" style="display:block; margin-top:20px; margin-left:2%; cursor:pointer;" onclick="verTemas();">Temas</a>
        <a id="subtemas" style="display:block; margin-top:10px; cursor:pointer;" onclick="verSubtemas('0');">Subtemas</a>
        <a id="usuarios" style="display:block; margin-top:10px; cursor:pointer;" onclick="verUsuarios('0');">Usuarios</a>
    </div>
    
    <!--El contenido de este div es creado al seleccionar los mensajes que se desea ver (recibidos o enviados) -->
    <div id="informacion" style="float:left; width:80%; display:block;">
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

