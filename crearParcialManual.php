<?php include("conexion.php"); ?>
<div>

    <!-- Funcion Js necesaria para poder mostrar las unidades tematicas y el campo cantidad-->
    <script type="text/javascript">
        setTimeout("actPagina('unidtemas.php')", 0);
    </script>
    
    <div  id="opciones" style="width:100%;background:#CCC ;border-radius:5px 5px 0px 0px ;" align="right">
    <form method="post" action="generarpdf.php" onsubmit="return validarPuntaje()">
        <input id="contenido" name="contenido" type="hidden" value="<table style='width:100%'><tr><td>Jill</td><td>Smith</td><td>50</td></tr><tr><td>Eve</td><td>Jackson</td><td>94</td></tr></table>"> 
        <input id="unid_sel" name="unid_sel" type="hidden" value="">
        <input id="boton"  type="submit"  value="Generar" style="display:none;all:none"/></a>
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
                <input type="button" value="Buscar Ejercicios" style="margin: 0 auto" onclick="mostrarEnunciados()" />
            </div>
        </div>
    </div>
        <div id="informacion" style="width:65%; float:right; padding:10px 0 0 10px; ">
        </div>

        
        <div id="seleccionados" style="float:left; display: block; width:100%;">
            <table  id="tablaselec">
                <thead style="width:100%;"><h3 width="100%" style="display:block" >Seleccionados</h3></thead>
                <thead>
                    <th style="width:5%">ID</th>
                    <th style="width:90%">CONTENIDO</th>
                     <th style="width:5%">QUITAR</th>
                 </thead>
                 <tbody id="filas">
                 </tbody>
            </table>         
        </div>
    
</div>      

