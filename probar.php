
<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> 
<html> 
<head> 
<title>Ejemplo</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        /**
         * Funcion para a�adir una nueva columna en la tabla
         */
        $("#add").click(function(){
            // Obtenemos el numero de filas (td) que tiene la primera columna
            // (tr) del id "tabla"
            var tds=$("#tabla tr:first td").length;
            // Obtenemos el total de columnas (tr) del id "tabla"
            var trs=$("#tabla tr").length;
            var nuevaFila="<tr>";
            for(var i=0;i<tds;i++){
                // a�adimos las columnas
                nuevaFila+="<td>columna "+(i+1)+" A�adida con jquery</td>";
            }
            // A�adimos una columna con el numero total de columnas.
            // A�adimos uno al total, ya que cuando cargamos los valores para la
            // columna, todavia no esta a�adida
            nuevaFila+="<td>"+(trs+1)+" columnas";
            nuevaFila+="</tr>";
            $("#tabla").append(nuevaFila);
        });
 
        /**
         * Funcion para eliminar la ultima columna de la tabla.
         * Si unicamente queda una columna, esta no sera eliminada
         */
        $("#del").click(function(){
            // Obtenemos el total de columnas (tr) del id "tabla"
            var trs=$("#tabla tr").length;
            if(trs>1)
            {
                // Eliminamos la ultima columna
                $("#tabla tr:last").remove();
            }
        });
    });
    </script>
 
    <style>
    #add, #del  {cursor:pointer;text-decoration:underline;color:#00f;}
    </style>
</head>
 
<body>
<div id="add">pulsa aqu� para a�adir una nueva fila desde jquery</div>
<div id="del">pulsa aqu� para eliminar la ultima fila desde jquery</div>
<p>
    <table id="tabla" border=1>
        <tr>
            <td>primera columma</td>
            <td>segundo columna</td>
            <!-- podemos a�adir tantas columnas como deseemos -->
            <!--<td>tercera columna</td>-->
        </tr>
    </table>
</p>
</body>
</html>

</body> 
</html>