//DECLARACIÓN DE VARIABLES GLOBALES //
//esta variable es usada por las funciones quitar() y apilar()
var cantHijos=0;
//La pagina que se incluye por defecto es crear_unid_y_temas.php
var pagina="crear_unid_y_temas.php";
$(document).ready(function() {
$('#formElimMsj').on('submit', function(e){
        e.preventDefault();
		if (!$('input[name="msjs[]"]').is(':checked')) {
        alert('Debe seleccionar por lo menos un mensaje para ejecutar esta acción');
    	}else{
			this.submit();
		}
        /*var len = $('#username').val().length;
        if (len < 6 && len > 1) {
            this.submit();
        }*/
    });

$('#Asignatura').on("change",function(){
	document.getElementById('elegirTipo').innerHTML ="<b>Elija tipo de parcial</b><select name='tipoDeParcial' id='tipoParcial' onchange=\"m();\"><option value='' disabled selected>Seleccione</option><option value='teorico'>Teorico</option><option value='practico'>Práctico</option><option value='teopract'>Teórico-Práctico</option></select><b>Elija complejidad</b><select name='nivel' id='nivel'><option value='' disabled selected>Complejidad</option><option value='bajo'>Bajo</option><option value='medio'>Medio</option><option value='alto'>Alto</option><option value='reparacion'>Reparacion</option><option value='reparacion'>Concurso</option></select>";
                
	if(document.getElementById('elegirTipo').style.display=="none"){
		document.getElementById('elegirTipo').style.display="block";
	}
	//En caso de que esten visibles
	document.getElementById('camposTeoria').style.display="none";
	document.getElementById('camposPractica').style.display="none";
});
});

//Marca como seleccionado un elemento referenciado por un ID
//paginas que la usan: cuenta.php
function seleccionar(idElemento,coord){
	document.getElementById(idElemento).selected=true;
	fun();
	if(document.getElementById('coordinador').innerHTML!=""){
		document.getElementById(coord).selected=true;
	}
}

function obtenerXMLHTTP(){
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function desmarcarChecbox(){
	//desmarco todos los checkbox seleccionados
	$('input[name="user[]"]:checked').each(function() {
		$('input[name="user[]"]:checked').prop('checked',false);
	});
}

//Muestra como va quedando el parcial colaborativo (solo se muestran los enunciados aprobados)
//paginas que la usan: colaborativo.php
function verParcialCol(){
	objetoHtml= document.getElementById('cont');
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('cont').innerHTML = xmlhttp.responseText;
			document.getElementById('informacion').style.display="none";
			document.getElementById('practica').style.display="none";
			document.getElementById('tit').style.display="none";
			document.getElementById('cont').style.display="block";
		}
	}
	xmlhttp.open("GET","comunicaciones/verParcialCol.php",true);
	xmlhttp.send();
}

//paginas que la usan: colaborativo.php
function verParticipantes(){
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('cont').innerHTML = xmlhttp.responseText;
			document.getElementById('informacion').style.display="none";
			document.getElementById('practica').style.display="none";
			document.getElementById('tit').style.display="none";
			document.getElementById('cont').style.display="block";
		}
	}
	xmlhttp.open("GET","comunicaciones/verParticipantes.php",true);
	xmlhttp.send();
}

//carga el tipo de parcial a realizar (teorico, practico, teorico-practico)
//paginas que la usan: crearParcialCol.php
function tipoDeParcial(){
	document.getElementById('informacion').style.display='none';
	document.getElementById('contactos').style.display='none';
	document.getElementById('elegirTipo').innerHTML ="<b>Elija tipo de parcial</b><select name='tipoDeParcial' id='tipoParcial' onChange=\"desmarcarChecbox();subtemas();document.getElementById('contactos').style.display='block'\"><option value='' disabled selected>Seleccione</option><option value='teorico'>Teorico</option><option value='practico'>Práctico</option><option value='teopract'>Teórico-Práctico</option></select>";
	desmarcarChecbox();
}

//funcion utilizada por el elemento con id elegirTipo'
function m(){
	if(document.getElementById('tipoParcial').value=='teorico'){
		document.getElementById('camposPractica').style.display="none";
		mostrarUnidSubt('unidadesTeoria','teorico',document.getElementById('Asignatura').value);
		document.getElementById('camposTeoria').style.display="block";
	}else{
		if(document.getElementById('tipoParcial').value=='practico'){
			document.getElementById('camposTeoria').style.display="none";
			mostrarUnidSubt('unidadesPractica','practico',document.getElementById('Asignatura').value);
			document.getElementById('camposPractica').style.display="block";
		}else{
			mostrarUnidSubt('unidadesTeoria', 'teorico', document.getElementById('Asignatura').value);
			document.getElementById('camposTeoria').style.display="block";
			mostrarUnidSubt2('unidadesPractica','practico',document.getElementById('Asignatura').value);
			document.getElementById('camposPractica').style.display="block";
		}
	}
	if(document.getElementById('complejidad').style.display=="none"){
		document.getElementById('complejidad').style.display="block";
	}
}

//Realiza la asignación de que tema le corresponde desarrollar a cada profesor para el parcial colaborativo por parte del profesor coordinador//
//paginas que la usan: procAsignacion.php
function procAsignacion(){
	xmlhttp= obtenerXMLHTTP();
	var arraySubt = new Array();
	var cant = new Array();
	var user= new Array();
	$('input[name="subt[]"]:checked').each(function() {
		arraySubt.push($(this).val());
	});
	$('input[name="cant[]"]:enabled').each(function() {
		cant.push($(this).val());
	});
	$('input[name="user[]"]:checked').each(function() {
		user.push($(this).val());
	});
	parametros="subt="+arraySubt+"&cant="+cant+"&user="+user;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('aviso').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/procAsignacion.php?"+parametros,true);
	xmlhttp.send();

}

//muestra unidades y subtemas, tanto de la parte practica como la teorica, y coloca los usuarios seleccionados en un campo con id campoPara//
//paginas que la usan: crearParcial.php
function subtemas(){
	if(document.getElementById('tipoParcial').value=='teorico'){
		document.getElementById('unidadesPractica').innerHTML="";
		mostrarUnidSubt('unidadesTeoria','teorico',document.getElementById('asig').value);
	}else{
		if(document.getElementById('tipoParcial').value=='practico'){
			document.getElementById('unidadesTeoria').innerHTML="";
			mostrarUnidSubt('unidadesPractica','practico',document.getElementById('asig').value);
		}else{
			mostrarUnidSubt('unidadesTeoria', 'teorico', document.getElementById('asig').value);
			mostrarUnidSubt2('unidadesPractica','practico',document.getElementById('asig').value);
		}
	}
	document.getElementById('informacion').style.display="block";
	var str= "";
	$('input[name="user[]"]:checked').each(function() {
		str+=$(this).val()+", ";
	});
	str = str.substring(0, str.length-1);
	document.getElementById('campoPara').value = str.substring(0, str.length-1);
}

//muestras el conjunto de unidades tematicas junto con el grupo de subtemas asociado a cada unidad temática
//paginas que la usan: crearParcial.php
function mostrarUnidSubt(idElemento, tipoParcial,asig) {
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(idElemento).innerHTML = "<b style='text-align:center; display:block'>Ejercicios parte "+tipoParcial+"</b><br />"+xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/"+pagina+"?comp="+tipoParcial+"&asig="+asig,true);
	xmlhttp.send();
}

function mostrarUnidSubt2(idElemento, tipoParcial,asig) {
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2 = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange = function() {
		if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
			document.getElementById(idElemento).innerHTML = "<b style='text-align:center; display:block'>Ejercicios parte "+tipoParcial+"</b><br />"+xmlhttp2.responseText;
			
		}
	}
	xmlhttp2.open("GET","comunicaciones/"+pagina+"?comp="+tipoParcial+"&asig="+asig,true);
	xmlhttp2.send();
}

function ocultar(idElemento){
	if(document.getElementById(idElemento).style.display=='block'){
		document.getElementById(idElemento).style.display='none';
	}
	
}

function desplegar(idElemento){
	if(document.getElementById(idElemento).style.display=='none'){
		document.getElementById(idElemento).style.display='block';
	}
}

//Muestra un elemento referenciado por un id
function mostrar(idElemento){
	if(document.getElementById(idElemento).style.display=='none'){
		document.getElementById(idElemento).style.display='block';
	}else{
		document.getElementById(idElemento).style.display='none';
	} 
}

//muestra un elemento oculto
//paginas que la usan: banco.php
function mostrarElemento(idElemento){
	if(document.getElementById(idElemento).style.display=='none'){
		document.getElementById(idElemento).style.display='block';
	}
}

//escribe en el campo oculto id, el id del enunciado seleccionado
//paginas que la usan: historial.php
function writeID(idCampo, valor){
	document.getElementById(idCampo).value=valor;
}

//muestra la ventana de confirmación de borrado
//paginas que la usan: historial.php
function confirmacion(ident){
	var reply=confirm("¿Seguro que desea eliminar el enunciado de ID: "+document.getElementById(idElemento).value+"?")
	return reply;
}

//muestra la ventana de confirmación de borrado
//paginas que la usan: adminTemas.php
function confirmTema(ident,str){
	var reply=confirm("¿Seguro que desea eliminar el "+str+": "+ident+"?")
	return reply;
}

function mostrarAviso(){
	$('#aviso').slideDown(500);
	$('#aviso').hide(15000);
}
function cambiarSolucion(){
	if(document.getElementById('componente').value=="practico"){
		document.getElementById('solu').style.display="block";
		document.getElementById('solu2').style.display="none";
	}else{
		document.getElementById('solu').style.display="none";
		document.getElementById('solu2').style.display="block";
	}
}

//AJAX, muestra los subtemas de la unidad tematica referenciada por str
function mostrarSubtemas(str) {
    if (str == "") {
        document.getElementById("contenidoSubtemas").innerHTML = "";
        return;
    } else { 
        xmlhttp= obtenerXMLHTTP();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("contenidoSubtemas").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getSubtemas.php?q="+str,true);
        xmlhttp.send();
    }
}

//AJAX, muestra los subtemas de la unidad tematica referenciada por str
function mostrarSubtemasChecbox(str) {
    if (str == "") {
        document.getElementById("contenidoSubtemas").innerHTML = "";
        return;
    } else { 
        xmlhttp= obtenerXMLHTTP();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("contenidoSubtemas").innerHTML = xmlhttp.responseText;
				document.getElementById('unid_sel').value=str;
            }
        }
        xmlhttp.open("GET","getSubtemasCheckbox.php?q="+str,true);
        xmlhttp.send();
    }
}

/*Busqueda de los mensajes Enviados 
//paginas que la usan: mensajes.php*/
function mostrarMensajesEnv(pag) {
	if (document.getElementById('usuarioAResponder').value!=''){
    	document.getElementById(document.getElementById('usuarioAResponder').value).checked=false;
		document.getElementById('usuarioAResponder').value="";
  	}
	if(document.getElementById('escribir').style.display=='block'){
		document.getElementById('escribir').style.display='none';
		document.getElementById('campoPara').style.display='none';
		document.getElementById('mensajes').style.display='block';
	}
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('mensajes').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","buscarMsjEnv.php?pagina="+pag,true);
	xmlhttp.send();
	if(document.getElementById('eliminar').style.display=='none'){
		document.getElementById('eliminar').style.display='inline';
	}
	if(document.getElementById('resp').style.display=='inline'){
		document.getElementById('resp').style.display='none';
	}
	if(document.getElementById('redactar').style.display=='none'){
		document.getElementById('redactar').style.display='inline';
	}
}

/*Busqueda de los mensajes recibidos 
//paginas que la usan: mensajes.php*/
function mostrarMensajesRec(pag) {
	if (document.getElementById('usuarioAResponder').value!=''){
    	document.getElementById(document.getElementById('usuarioAResponder').value).checked=false;
		document.getElementById('usuarioAResponder').value="";
  	}
	if(document.getElementById('escribir').style.display=='block'){
		document.getElementById('escribir').style.display='none';
		document.getElementById('campoPara').style.display='none';
		document.getElementById('mensajes').style.display='block';
	}
	//var pag= captPagina();
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('mensajes').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","buscarMsjRec.php?pagina="+pag,true);
	xmlhttp.send();
	
	if(document.getElementById('eliminar').style.display=='none'){
		document.getElementById('eliminar').style.display='inline';
	}
	if(document.getElementById('resp').style.display=='inline'){
		document.getElementById('resp').style.display='none';
	}
	if(document.getElementById('redactar').style.display=='none'){
		document.getElementById('redactar').style.display='inline';
	}
}

//CAPTURA LA PAGINA POR GET QUE SE DESEA MOSTRAR
//paginas que la usan: mensajes.php
function captPagina(){
	//SIMULACION DEL $_GET EN JAVASCRIPT
	var loc = document.location.href;
	// cogemos la parte de la url que hay despues del interrogante ?
	var getString = loc.split('?')[1];
	// obtenemos un array con cada clave=valor
	var GET = getString.split('&');
	var get = {};

	// recorremos todo el array de valores
	for(var i = 0, l = GET.length; i < l; i++){
		var tmp = GET[i].split('=');
		get[tmp[0]] = unescape(decodeURI(tmp[1]));
	}
	var pag=0;
	var i=1;
	for(var index in get){
		if(i==2){
			pag=get[index];
		}
		i++;
	}	
	return(pag);
}
//Muestra los campos para necesarios para la redaccion del mensaje a enviar
//paginas que lo utilizan: mensajes.php
function camposRedaccion() {
	if(document.getElementById('mensajes').style.display=='block'){
		document.getElementById('mensajes').style.display='none';
		document.getElementById('escribir').style.display='block';
		document.getElementById('campoPara').style.display='block';
	}
	if(document.getElementById('eliminar').style.display=='inline'){
		document.getElementById('eliminar').style.display='none';
	}
	if(document.getElementById('opcGrupales').style.display=='none'){
		document.getElementById('opcGrupales').style.display='inline';
	}
}

function marcarCheckbox(){
	if (!document.getElementById(document.getElementById('usuarioAResponder').value).checked){
    	document.getElementById(document.getElementById('usuarioAResponder').value).checked=true;
  	}
	if(document.getElementById('eliminar').style.display=='inline'){
		document.getElementById('eliminar').style.display='none';
	}
	if(document.getElementById('redactar').style.display=='inline'){
		document.getElementById('redactar').style.display='none';
	}
	if(document.getElementById('opcGrupales').style.display=='inline'){
		document.getElementById('opcGrupales').style.display='none';
	}
}
//despliega la descripcion del mensaje que selecciono el usuario
//paginas que lo utilizan: mensajes.php
function verMensaje(user,nombre,asunto,mensaje,ci_rem,ci_dest,fec_emision,visto,envORec){	
	if(envORec=='rec'){
	document.getElementById('mensajes').innerHTML="<div style='height:60px; margin:10px 10px 0px 10px; border-style: outset; border-width: 2px; padding:5px;'><span style='font-size:18px;'>"+asunto+"</span><br>De: "+nombre+" ("+user+")</div><div style='height:150px; font-size:12px; margin:10px; border-style: outset; border-width: 2px; padding:5px;'>"+mensaje+"</div>";
			document.getElementById('usuarioAResponder').value=user;
		if(document.getElementById('resp').style.display=='none'){
			document.getElementById('resp').style.display='inline';
		}
	}else{
		document.getElementById('mensajes').innerHTML="<div style='height:60px; margin:10px 10px 0px 10px; border-style: outset; border-width: 2px; padding:5px;'><span style='font-size:18px;'>"+asunto+"</span><br>Para: "+nombre+" ("+user+")</div><div style='height:150px; font-size:12px; margin:10px; border-style: outset; border-width: 2px; padding:5px;'>"+mensaje+"</div>";
	}
	if(visto=="no"){
		xmlhttp= obtenerXMLHTTP();
		parametros= "ci_rem="+ci_rem+"&ci_dest="+ci_dest+"&fec_emision="+fec_emision;
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById('aviso').innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","cambiarAVisto.php?"+parametros,true);
		xmlhttp.send();
	}
	if(document.getElementById('eliminar').style.display=='inline'){
		document.getElementById('eliminar').style.display='none';
	}
}

//paginas que la usan: colaborativoProf.php
//muestra los enunciados clasificados por unidad tematica, subtema y componente
function verEnunciados(parametro){
	xmlhttp= obtenerXMLHTTP();
	
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/verEnunciados.php?parametro="+parametro,true);
	xmlhttp.send();
}

//Elimina un enunciado junto a su puntaje, ambos referenciados por x e y, respectivamente
function quitarEnunciado(x,y){	
	if (!x){
		alert("El elemento selecionado no existe");
	} else {
		padre = x.parentNode;
		padre.removeChild(x);
		padre2= y.parentNode;
		padre2.removeChild(y);
		cantHijos--;
		if(cantHijos==0){
			document.getElementById("boton").style.display='none';
		}
	}
}

//Elimina un elemento html referenciado por un ID
function quitar(id){
	var dato= document.getElementById(id);	
	if (!dato){
		alert("El elemento selecionado no existe");
	} else {
		padre = dato.parentNode;
		padre.removeChild(dato);
		cantHijos--;
		if(cantHijos==0){
			document.getElementById("boton").style.display='none';
			document.getElementById('elegidos').style.display='none';
		}
	}
}

//paginas que la usan: verEnunciados.php
function apilar(id_e,subt,comp){
	dato = document.getElementById(id_e);	
	if (!dato){
		if(document.getElementById('elegidos').style.display=='none'){
			document.getElementById('elegidos').style.display='block';
			document.getElementById('boton').style.display='block';
		}
		cadena="<div id='"+id_e+"'><div style='display:inline-block; width:95%; text-align:justify;'><span style='font-size:10px;'>ID:"+id_e+", "+subt+"</span></div><div style='display:inline-block; width:5%;'><input type='image' src='resources/imagenes/quitar.jpg' style='width:15px; height:15px;' title='Quitar' class='edit_or_delete' onclick=\"quitar('"+id_e+"');\" /></div><input type='checkbox' value='"+id_e+"' name='eleg[]' style='display:none' checked/><br/></div>";
		document.getElementById('elegidos').innerHTML+=cadena;
		cantHijos++;
	}else{
		alert("Ya ha seleccionado el enunciado de ID: "+id_e);
	}
}

//paginas que la usan: enunParcial.php
function copiar(x,id_e){
	dato = document.getElementById("copia"+id_e);
	if (!dato){
		tbody= document.getElementById("filas");
		var idEnun= document.getElementById("copia"+id_e);
		var idPts= document.getElementById("copia"+id_e);
		newRow= "<tr id='copia"+id_e+"'>"+x.innerHTML+"<td><div style='display:inline-block; width:5%;'><input type='image' src='resources/imagenes/quitar.jpg' style='width:15px; height:15px;' title='Quitar' class='edit_or_delete' onclick=\"quitarEnunciado(document.getElementById('copia"+id_e+"'),document.getElementById('pts"+id_e+"'));\" /></div></td></tr><tr id='pts"+id_e+"' style='background:white'><td width='30%;' align='center'><strong style='font-size:10px;'>pts ejerc. "+id_e+"<br></strong><input id='punt"+id_e+"' name='pts[]' style='height:20px;pading:0;width:60px;' type='number' min='0' max='20'></td><td width='70%;' align='center'><strong style='font-size:10px;'>pts por Items ejercicio "+id_e+"</strong><input type='text' name='items[]' placeholder='pts por items' style='font-size:12px; height:20px;' width='70%'/></td></tr>";
		tbody.innerHTML+=newRow;
		document.getElementById('boton').style.display='block';
		cantHijos++;
	}
}

//paginas que la usan: colaborativoProf.php
//envia los enunciados al usuario coordinador
function envACoord(){
	xmlhttp= obtenerXMLHTTP();
	
	var enunEleg= "";
	$('input[name="eleg[]"]:checked').each(function() {
		enunEleg+=$(this).val()+",";
	});
	enunEleg = enunEleg.substring(0, enunEleg.length-1);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('aviso').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/envACoord.php?enunEleg="+enunEleg,true);
	xmlhttp.send();
}



//paginas que la usan: colaborativoProf.php
function limpiar(){
	document.getElementById('elegidos').style.display="none";
	document.getElementById('boton').style.display="none";
	document.getElementById('elegidos').innerHTML="<b>Ejercicios selecionados para el parcial:</b><br /><br />";
	cantHijos=0;
}

//paginas que la usan: administrar.php
function verTemas(){
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/adminTemas.php",true);
	xmlhttp.send();
}

//paginas que la usan: administrar.php
function verSubtemas(pag){
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/adminSubtemas.php?pagina="+pag,true);
	xmlhttp.send();
}

//paginas que la usan: administrar.php
function verUsuarios(pag){
	xmlhttp= obtenerXMLHTTP();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","comunicaciones/adminUsuarios.php?pagina="+pag,true);
	xmlhttp.send();
}
//paginas que la usan: adminUsuarios.php
function fun(){
	if(document.getElementById('tipo').value=="Profesor"){
		
		document.getElementById('coordinador').innerHTML="<h5>¿Coordinador?</h5><select name='coord' id='coord' ><option id='no' value='no' selected>No</option><option id='si' value='si'>Si</option></select>";
	}else{
		document.getElementById('coordinador').innerHTML="";
	}
}

/*Se ejecuta cuando se selecciona un usuario que se desea modificar.
paginas que la usan: adminUsuarios.php*/
function modifUsuario(ced, tipo, coord){
	document.getElementById('addUsuario').innerHTML="<form name='modUsuario' action='comunicaciones/modifTipoUsuario.php' method='post'><input type='hidden' name='ced' id='ced' value='"+ced+"'/><div style='margin-top:1%;' align='center'><h4><div id='titulo'>MODIFICAR TIPO DE USUARIO</div></h4></div><h5>Tipo de Usuario</h5><select name='tipo' id='tipo' onchange=\"fun();\"></option><option id='Preparador' value='Preparador'>Preparador</option><option id='Profesor' value='Profesor'>Profesor</option></select><div id='coordinador' ></div><div style='margin-top:-10px;' align='center'><input type='submit' id='boton' value='Agregar'/></div></form>";
	
	seleccionar(tipo,coord);
	document.getElementById('boton').value="Actualizar";
}

/*Se ejecuta cuando se selecciona un tema que se desea modificar.
paginas que la usan: adminTemas.php*/
function modifUnidad(unid,asig){
	document.getElementById('unid_tem').value=unid;
	document.getElementById('titulo').innerHTML="MODIFICAR TEMA";
	document.forms.agregarTema.action="comunicaciones/modifTema.php";
	document.getElementById('unid_viejo').value=unid;
	document.getElementById('boton').value="Modificar";
	document.getElementById(asig).selected=true;
}

/*Se ejecuta cuando se selecciona un subtema que se desea modificar.
paginas que la usan: adminTemas.php*/
function modifSubtema(subt,unid){
	document.getElementById('nomb_subt').value=subt;
	document.getElementById('titulo').innerHTML="MODIFICAR SUBTEMA";
	document.forms.agregarSubtema.action="comunicaciones/modifSubtema.php";
	document.getElementById('subt_viejo').value=subt;
	document.getElementById('boton').value="Modificar";
	document.getElementById(unid).selected=true;
}

//paginas que la utilizan: getSubtemasCheckbox.php
function habCantidad(idCant){
	if(document.getElementById(idCant).disabled){
		document.getElementById(idCant).value=1;
		document.getElementById(idCant).disabled=false;
	}else{
		document.getElementById(idCant).value=null;
		document.getElementById(idCant).disabled=true;
	}
}

//Utilizada por crearQuiz.php, crearParcialAuto.php	
function vistaPrevia(pagina){
	xmlhttp= obtenerXMLHTTP();
	var arraySubt = new Array();
	var cant = new Array();
	$('input[name="subt[]"]:checked').each(function() {
		arraySubt.push($(this).val());
	});
	$('input[name="cant[]"]:enabled').each(function() {
		cant.push($(this).val());
	});
	nivel=document.getElementById('nivel').value;
	if(pagina=="mostrarVistaPreviaParcial.php"){
		parametros="subt="+arraySubt+"&cant="+cant+"&nivel="+nivel;
	}else{
		opcion=$('input:radio[name=opcion]:checked').val();
		parametros="subt="+arraySubt+"&cant="+cant+"&nivel="+nivel+"&opcion="+opcion;
	}
	
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",pagina+"?"+parametros,true);
	xmlhttp.send();
}

//Funcion utilizada por crearParcialManual.php
//muestra los enunciados filtrados por el usuario
function mostrarEnunciados(){
	xmlhttp= obtenerXMLHTTP();
	var arraySubt = new Array();
	$('input[name="subt[]"]:checked').each(function() {
		arraySubt.push($(this).val());
	});
	nivel=document.getElementById('nivel').value;
	asig=document.getElementById('Asignatura').value;
	tp=document.getElementById('tipoParcial').value;
	
	parametros="subt="+arraySubt+"&asig="+asig+"&nivel="+nivel+"&tipo="+tp;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('informacion').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","enunParcial.php?"+parametros,true);
	xmlhttp.send();
}


//paginas que la usan: crearQuiz.php
//busca que boton de radio esta seleccionado
function verSeleccionado(){
	var porNombre= document.getElementsByName('opcion'), resultado;
	for(var i=0;i<porNombre.length;i++)
    {
	 	if(porNombre[i].checked)
			resultado=porNombre[i].value;
	}
	return resultado; 
}


//Verifica que el puntaje no exceda los 20 pts
function validarPuntaje(){

	var puntaje=0, menor=true;
	$('input[name="pts[]"]').each(function() {
	puntaje=puntaje+ parseFloat($(this).val());
	});
	if(puntaje!=20){
		alert("Verifique el puntaje nuevamente");
		return false;
	}else{
		var i;
		var aux,aux2;
		document.getElementById('trampa').value="<table>"
		for(i=1;i<=parseInt(document.getElementById("num_res").innerHTML);i++){
			aux="p" + i.toString();
			aux2="punt" + i.toString();
			document.getElementById('trampa').value= document.getElementById('trampa').value +"<tr><td valign='top'><p><strong>"+i.toString()+".- </strong></p></td><td valign='top' align='justify'>"+document.getElementById(aux).innerHTML +"</td><td valign='bottom' style='font-size:11px;'><strong>("+document.getElementById(aux2).value+" puntos)</strong></td></tr>";
		}
		document.getElementById('trampa').value = document.getElementById('trampa').value + "</table>";
		document.getElementById('unid_sel').value= document.getElementById('unidad_tematica').value;
		return true;
	}
}



function escTipo(valor){
	document.getElementById('tip').value=valor;
}

//paginas que lo usan: crearQuiz.php
function enviar_formulario2(){ 
	//la comente momentaneamente para hacer las pruebas mas rapido
	//if(validarPuntaje()){
   		document.formPdf.submit();
	//}
}

function actPagina(page){
	pagina=page;
}