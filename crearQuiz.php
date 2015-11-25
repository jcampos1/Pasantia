<?php include("conexion.php"); ?>
<div>
	<?php 
	if(isset($_GET['actAviso']) and $_GET['actAviso']=='1'){?>
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="background:#0CC; height:50px;">
     	<b>su mensaje fue enviado con exito</b>
        </div>
    <?php }?>
    <input type="hidden" id="usuarioAResponder" value=""/>
  	<div  id="opciones" style="width:100%;background:#CCC ;border-radius:5px 5px 0px 0px ;" align="right">
    <form action="generarpdf.php" id="formPdf" name="formPdf" onsubmit="" method="post">
    <input type="hidden" name="tip" value="PRÁCTICA" id="tip"  />
    <input type="hidden" name="unid_sel" value="" id="unid_sel"  />
    	<a onclick='enviar_formulario2();' target="_blank"><input type="button"  value="Generar"/></a>
    </form>
    </div>
    
  	<div id="contenedor">
        <div id="carpetas" style="float:left; width:35%; background:#CCC; font-size: 18px; height:600px; text-align:center;">
            <div align="left">
                <input name="opcion" id="opcion1" type="radio" class="margen_izq" value="Práctica" onclick="escTipo('PRÁCTICA');" checked="checked"/>Práctica<br /><br />
                <input name="opcion" id="opcion2" type="radio" class="margen_izq" value="Taller" onclick="escTipo('TALLER');" />Taller<br/><br />
                <input name="opcion" id="opcion3" type="radio"  class="margen_izq" value="Quiz" onclick="escTipo('QUIZ');"/>Quiz<br/><br />
            </div>
            <div id="SeleccionTema">
            <b>Seleccione un Tema</b>
            <select name="unidad_tematica" id="unidad_tematica" onChange="mostrarSubtemasChecbox(this.value);">
            <option value="" disabled selected>Unidad Tematica</option>
			<?php

			
			$resultado = mysql_query("SELECT * FROM unidad_tematica");
			while($row = mysql_fetch_array($resultado)){
			?>
				  <option value="<?php echo $row['nomb_unid'];?>"><?php echo $row['nomb_unid'];?></option>
			<?php }?>
			</select>
            </div>
            <!-- Lista de los subtemas de la unidad tematica seleccionada -->
            <div id="contenidoSubtemas" style="font-size:12px">
			</div>
            <div>
            <select name="nivel" id="nivel">
            	  <option value="" disabled selected>Complejidad</option>
				  <option value="bajo">Bajo</option>
				  <option value="medio">Medio</option>
				  <option value="alto">Alto</option>
				  <option value="reparacion">Reparacion</option>
                  <option value="reparacion">Concurso</option>
			</select>
            </div>
            <input type="button" value="Vista Previa" style="margin: 0 auto" onclick="vistaPrevia('mostrarVistaPrevia.php');" />
        </div>
        
    
        <!--El contenido de este div es creado al seleccionar los mensajes que se desea ver (recibidos o enviados) -->
        
        <div id="informacion" style="float:left; width:65%; padding:10px 10px; display:block;" align="left">
        </div>
     
  	</div>
    
</div>		

