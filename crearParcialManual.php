<?php include("conexion.php"); ?>
<div>
	<br>
    <!-- Funcion Js necesaria para poder mostrar las unidades tematicas y el campo cantidad-->
    <script type="text/javascript">
        setTimeout("actPagina('unidtemas.php')", 0);
    </script>
    
    
	<div id="contenedor" style="width:100%; display:block">
		<div id="practica" class="well" style=" width:35%; display:block; float:left; background:aliceblue; font-size: 14px; min-height:450px; height:auto; text-align:left;">
			
			<div id="busqueda rapida">
				<h4>Búsqueda rápida.</h4>
				<form class="form-inline">	
					<input class="form-control" type="text" id="busqueda" name="busqueda" title="Inserte ID de ejercicios separados por coma(,)" placeholder="Ej: 1,2,3,4,5">
					<button type="button" onclick="BusquedaRapida()" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-search"></span> Busqueda rapida</button>
				</form>
			</div>
			<hr>
			<div class="form-group">
				<h4>Búsqueda específica.</h4>
				<select class="form-control" name="asig" id="Asignatura">
					 <option value="" disabled selected>Asignatura</option>
					 <option value="EDI">EDI</option>
					 <option value="EDII">EDII</option>
				</select>
			</div>

			<div id="elegirTipo" style="display:none;">
			</div>
            
			<div style="display:none;" id="camposTeoria">
				<div id="unidadesTeoria" ></div>
			</div>
            
			<div id="camposPractica" style="display:none;">
				<div id="unidadesPractica" ></div>
			</div>
            
			<div id="complejidad" style="display:none;">
				<button type="button" onclick="mostrarEnunciados()" class="pull-right btn btn-primary" ><span class="glyphicon glyphicon-search"></span> Buscar</button>
			</div>
		
			
		</div>
	</div>
        
	<div id="informacion" style="width:65%; float:right; padding:0 0 0 10px; ">
		<div class="alert alert-info fade in">
			<strong><span class="glyphicon glyphicon-info-sign"></span> Seleccione los parámetros de búsqueda.</strong>
		</div>
	</div>
        
         

        
	<div id="seleccionados" style="float:left; display: block; width:100%;">
		<h3 width="100%" style="display:block" >Seleccionados</h3>
			
		<div class="alert alert-info" id="no_selec">
			<strong>No ha seleccionado ningun ejercicio.</strong>
		</div>
		
		<table  id="tablaselec" style="display:none;">
			<tbody id="filas">
			</tbody>
		</table> 
		<hr>
		<div  id="boton" style="display:none;all:none;">
			<form class="form-inline" role="form" method="post" action="generarpdf.php" onsubmit="return prueba_word();">	
				<input type="hidden" id="contenido_evaluacion" name="contenido_evaluacion" value="aqui">
				<select class="form-control" id="tipo_evaluacion" name="tipo_evaluacion" >
					<option disabled selected>Tipo</option>
					<option>Práctica</option>
					<option>Taller</option>
					<option>Quiz</option>
					<option>Parcial</option>
				</select>
				<input class="form-control" type="text" id="titulo_evaluacion" name="titulo_evaluacion" title="Titulo de la Evaluación" placeholder="Titulo">
				<input class="form-control" type="date" id="fecha_evaluacion" name="fecha_evaluacion" title="Fecha de la Evaluación"  value="<?php echo date("Y-m-d");?>">
				<button type="submit" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-file"></span> WORD</button>
			</form>
		</div>
	</div>
        
      
</div>      

