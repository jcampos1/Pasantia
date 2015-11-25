<?php include("conexion.php"); ?>
<div>
    <div id="aviso" style="height:auto;" align="right">
    </div>
    
  	<div id="contenedor" style="width:100%; display:block">
        <div id="practica" style=" width:35%; display:block; float:left; background:#CCC; font-size: 14px; min-height:450px; height:auto; text-align:left; padding-top:10px;">
            <b>Elija asignatura</b>
            <select name="asig" id="asig" onchange="tipoDeParcial();">
                 <option value="" disabled selected>Asignatura</option>
                 <option value="EDI">EDI</option>
                 <option value="EDII">EDII</option>
            </select>
        
            <div id="elegirTipo">
            </div>
            <div id="contactos" style="display:none;">
                <b>Contactos</b>
                <div style="height:280px; margin-top:10%; overflow:auto;">
                <?php
                $evento="onclick='subtemas();'";
                include("mostrarUsuarios.php");?>
                </div>
            </div>
        </div>
        
        <div id="informacion" style="width:65%; float:right; padding:10px 10px; display:none;" align="left">
        	<b>Asignar a:</b><div style="width:60%;"><input type="text" readonly="readonly" id="campoPara"/></div>
            <div id="camposTeoria">
            	<div id="unidadesTeoria" ></div>
            </div>
             
            <div id="camposPractica">
            	<div id="unidadesPractica" ></div>
            </div>
            <input style="margin-top:10px;" type="button" value="Realizar Asignación" onclick="procAsignacion();"/>
        </div>
  	</div>
</div>		

