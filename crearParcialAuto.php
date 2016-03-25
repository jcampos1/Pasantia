<?php include("conexion.php"); ?>
<div>
	<br>
    
    <div id="contenedor" style="width:100%; display:block">
        <div id="practica" class="well" style=" width:35%; display:block; float:left; background:aliceblue; font-size: 14px; min-height:600px; height:100%; text-align:left;">
            <h4>Parámetros de búsqueda.</h4>
            <div class="form-group">
				<select class="form-control" name="asig" id="Asignatura">
					 <option value="" disabled selected>Asignatura</option>
					 <option value="EDI">EDI</option>
					 <option value="EDII">EDII</option>
				</select>
            </div> 
            
            <div id="elegirTipo" style="display:none;">
            </div>
            
            <div style="display:none;" id="camposTeoria">
                <div id="unidadesTeoria" >vacio</div>
            </div>
            
            <div id="camposPractica" style="display:none;">
                <div id="unidadesPractica" >vacio</div>
            </div>
            
            <div id="complejidad"  style="display:none;">
				<br>
				<button type="submit" class="btn btn-primary btn-block" onclick="vistaPrevia('mostrarVistaPreviaParcial.php');">Buscar Ejercicios</button>
            </div>
        </div>
    </div>

    <div id="informacion" style="width:65%; float:right; padding:0 0 0 10px; ">
		<div class="alert alert-info fade in">
		<strong><span class="glyphicon glyphicon-info-sign"></span> Seleccione los parametros de busqueda.</strong>
		</div>
    </div>
    
    
    <div  id="boton" style="float:left;width:100%;display:none;all:none;">
			<hr>
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

