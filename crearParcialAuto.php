<?php include("conexion.php"); ?>
<div>
    <div  id="opciones" style="width:100%;background:#CCC ;border-radius:5px 5px 0px 0px ;" align="right">
    <form method="post" action="generarpdf.php" onsubmit="return validarPuntaje()">
        <input id="trampa" name="trampa" type="hidden" value=""> 
        <input id="unid_sel" name="unid_sel" type="hidden" value="">
        <input id="boton"  type="submit"  value="Generar" style="display:none;all:none"/>
    </form>
    </div>
    
    <div id="contenedor" style="width:100%; display:block">
        <div id="practica" style=" width:35%; display:block; float:left; background:#CCC; font-size: 14px; min-height:450px; height:auto; text-align:left;">
            <b>Elija asignatura</b>
            <select name="asig" id="Asignatura">
                 <option value="" disabled selected>Asignatura</option>
                 <option value="EDI">EDI</option>
                 <option value="EDII">EDII</option>
            </select>
            
            <div id="elegirTipo" style="display:none;">
            </div>
            
            <div style="display:none;" id="camposTeoria">
                <div id="unidadesTeoria" >vacio</div>
            </div>
            
            <div id="camposPractica" style="display:none;">
                <div id="unidadesPractica" >vacio</div>
            </div>
            
            <div id="complejidad" style="display:none;">
                <input type="button" value="Buscar Ejercicios" style="margin: 0 auto" onclick="vistaPrevia('mostrarVistaPreviaParcial.php');" />
            </div>
        </div>
    </div>

    <div id="informacion" style="width:65%; float:right; padding:10px 0 0 10px; ">
    </div>
    
</div>      

