<div>
	<h2>¿Que tipo de evaluacion desea Generar?</h2>
	<p>Puede elegir entre, Practicas, Quices, Parciales.</p>
	<div class="row" style="text-align:center; width:100%;">
        <?php if($_SESSION['tipo']=="Profesor"){
			$col="col6";
		}else{
			$col="col12";
		}?>
        
		<a id="quiz" onclick="activarCB('1')" class="<?php echo $col?> qtype equal1 type_assessment" style="height: 200px;cursor:pointer;">
			<h3>Practicas,Talleres y Quices</h3>
			<p>Preparacion previa al parcial.</p>
			<img src="resources/imagenes/quiz.jpg" alt="En Construccion">
		</a>
        <?php if($_SESSION['tipo']=="Profesor"){
		?>
		<a id="parcial" onclick="activarCB('2')" class="<?php echo $col?> last qtype equal1 type_exam" style="height: 200px;cursor:pointer;">
			<h3>Parcial</h3>
			<p>Evaluacion con gran ponderacion. </p>
			<img src="resources/imagenes/parcial.jpg" alt="En Construccion">
		</a>
         <?php }?>
         
	</div>
	<div>
		<select name="generar_tipo" id="generar_tipo">
					  <option value="automatico">Automatico</option>
					  <option value="manual">Manual</option>
		</select>
		<input id="oculto" type="hidden" value="">
		<a id="generar" onclick="genera()" href=""><input type="button" style="float:right" value="Generar"></a>
	</div>
</div>				

<script type="text/javascript">
	function activarCB(x)
	{	
		if(x==1){
		document.getElementById("quiz").style.backgroundColor="#cccccc";
		document.getElementById("parcial").style.backgroundColor="#f5f9f8";
		document.getElementById("oculto").value="quiz";
		}
		else
		{
			document.getElementById("quiz").style.backgroundColor="#f5f9f8";
			document.getElementById("parcial").style.backgroundColor="#cccccc";	
			document.getElementById("oculto").value="parcial";
		}
		
	}
	
	function genera()
	{
		if(document.getElementById("oculto").value=="quiz")
		{
			if(document.getElementById("generar_tipo").value=="automatico")
				document.getElementById("generar").href="inicio.php?view=9";
			else
				document.getElementById("generar").href="inicio.php?view=12";
			
		}
		else
		{
			if(document.getElementById("oculto").value=="parcial")
			{
			
				if(document.getElementById("generar_tipo").value=="automatico"){
					document.getElementById("generar").href="inicio.php?view=10";}
				else{
					document.getElementById("generar").href="inicio.php?view=13";}
			}
		}	
	} 
</script>
