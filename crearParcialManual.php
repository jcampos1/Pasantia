<?php include("conexion.php"); ?>
<div>
    <?php 
    if(isset($_GET['actAviso']) and $_GET['actAviso']=='1'){?>
        <!--Aqui se indica que el mensaje ha sido enviado o que hubo problemas al enviarlo -->
        <div id="aviso" style="background:#0CC; height:50px;">
        <b>su mensaje fue enviado con exito</b>
        </div>
    <?php }?>
    <!-- Funcion Js necesaria para poder mostrar las unidades tematicas y el campo cantidad-->
    <script type="text/javascript">
        setTimeout("actPagina('unidtemas.php')", 0);
    </script>
    
    <div  id="opciones" style="width:100%;background:#CCC ;border-radius:5px 5px 0px 0px ;" align="right">
    <a onclick='validarPuntaje();' target="_blank"><input type="button"  value="Generar"/></a>
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
                <input type="button" value="Buscar Ejercicios" style="margin: 0 auto" onclick="vistaPrevia('mostrarVistaPreviaParcial.php','')" />
            </div>
        </div>
        
    
        <!--El contenido de este div es creado al seleccionar los mensajes que se desea ver (recibidos o enviados) -->
        
        <div id="informacion" style="width:65%; float:right; padding:10px 10px;" align="left">
            <div id="disponibles"  style="overflow-x:hidden; overflow-y:scroll;height:300px;">
                <h3>Disponibles</h3>
                <?php include("conexion.php"); ?>   
                <table width="100%" border="1" height="300px">
                    <thead>
                        <th style="width:5%">ID</th>
                        <th style="width:95%">CONTENIDO</th>
                     </thead>
                     <tbody>
                    <?php
                    $resultado = mysql_query("SELECT * FROM enunciado");
                    while($row = mysql_fetch_array($resultado)){
                    
                    echo    "<tr onclick='copiar(this)'>";
                    echo    "<td  >".$row['id_e']."</td>";
                    echo    "<td  >".$row['descripcion']."</td>";
                    echo    "</tr>";
                   
                    }
                    ?>

                    </tbody>
             </table>
           </div>
            <hr>
            <div id="seleccionados">
                <h3>Seleccionados</h3>
                <table  width="100%"   >
                    <thead>
                        <th style="width:5%">ID</th>
                        <th style="width:95%">CONTENIDO</th>
                     </thead>
                     <tbody id="tablaselec">
                     </tbody>
                </table>         
            </div>
        </div>
     
    </div>
    
</div>      

<script>
function copiar(x) 
{
    x.onclick="";
    var node = document.createElement("tr");
    seleccionado=x.innerHTML;
    node.innerHTML=seleccionado;
    document.getElementById("tablaselec").appendChild(node);
    var node2 = document.createElement("tr");
    node2.innerHTML="<td colspan='2'><strong style='font-size:10px;'>Pts ejerc. 1</strong><input name='pts[]' style='height:20px;pading:4px;width:10%;' type='number' min='0' max='20'><strong style='font-size:10px;'>Pts por Items ejercicio 1</strong><input type='text' name='items[]' placeholder='Pts por item' style='font-size:12px; height:20px;width:40%;' ></td>";
    document.getElementById("tablaselec").appendChild(node2);
}
</script>