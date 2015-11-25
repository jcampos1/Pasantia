<?php include("conexion.php"); ?>
<div>
    <div id="aviso" style="height:auto;" align="left">
    </div>
    
  	<div id="contenedor" style="width:100%; display:block">
        <div id="practica" style="width:35%;display:block;float:left;background:white;font-size: 14px;min-height:450px;height:auto;padding-top:10px;">
        
            <div id="elegidos" style="display:none">
                <b>Ejercicios selecionados para el parcial:</b><br /><br />
            </div>
            <div id="boton" style="display:none"><input type="button" value="Enviar" onclick="if(confirm('¿Seguro de enviar el/los enunciado(s) al coordinador?')){envACoord();limpiar();}" /></div>
            <hr /><br /><b>Asignaciones</b><hr />
            <div style="overflow:auto; height:450px;">
            <table width='100%' border='1'  height='440px' style="margin-top:10px;">
            <tr>
                <th scope='col'>SUBTEMA</th>
                <th scope='col'>COMPONENTE</th>
                <th scope='col'>CANT</th>
                
              </tr>
            <?php $sql="SELECT * FROM envia_msj WHERE visto='pendiente' and ci_dest=(SELECT ci FROM usuario WHERE tipo='Profesor' and user='$user')";
            $resultado=mysql_query($sql); 
            while($row=mysql_fetch_array($resultado)){
                $i=0;
                $micadena=$row['msj'];
                $cont=explode(",",$micadena);
                $totalSeleccionados = count($cont);
                while($i < $totalSeleccionados){
                    $parametro= $cont[$i].",".$cont[$i+1].",".$cont[$i+2];
                    echo "
                    <tr onclick=\"verEnunciados('$parametro');\" onmouseover=\"this.className = 'resaltar'\" onmouseout=\"this.className = null\" title=\"ver enunciados\">
                        <td scope='col'>".$cont[$i]."</td>
                        <td scope='col'>".$cont[$i+2]."</td>
                        <td scope='col'>".$cont[$i+3]."</td>
                    </tr> ";
                    $i=$i+4;
                }
            }
            ?>
            </table>
            </div>    
        </div>
        
        <div id="informacion" align="left" style="width:65%;float:right;padding:10px 10px; ">
     
        </div>
  	</div>
</div>				
		

