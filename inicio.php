<?php 
session_start();
if($_SESSION['activa']!=1) 
header('Location: index.php');
$user=$_SESSION['usuario'];
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
<link rel="icon" href="resources/favicon.ico" type="image/x-icon">
<!--
<link rel="stylesheet" type="text/css" href="./resources/css/styles.css">
-->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="resources/javascript/funciones.js"></script>

<title>INICIO</title>

<script type="text/javascript">

function enviar_formulario(){
	if (!$('input[name="msjs[]"]').is(':checked')) {
        alert('Debe seleccionar por lo menos un mensaje para ejecutar esta acción');
    	}else{
			document.formElimMsj.submit()
		}
   //document.formElimMsj.submit() 
}
</script>

<style>
.edit_or_delete img:hover {
	width:20px; 
}

.navbar-inverse .navbar-nav>li>a {
    color:white;
}

.navbar-inverse .navbar-nav>.active>a{
	background-color: #121214;
	}
 
/* cambiar el color de fondo a la barra */
nav.navbar {
    background-color: #0088cc;
    border-color: #0088cc;
}

</style>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#"><img src="resources/imagenes/logo.png" width="50px"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li <?php if($_GET['view']==2) echo "class='active'"?>><a href="inicio.php?view=2">Instrumentos</a></li>
		<li <?php if($_GET['view']==3) echo "class='active'"?>><a href="inicio.php?view=3">Ejercicios</a></li>
		<li <?php if($_GET['view']==15) echo "class='active'"?>><a href="inicio.php?view=15">Mis Enunciados</a></li>
		<li <?php if($_GET['view']==5) echo "class='active'"?>><a href="inicio.php?view=5">Historial</a></li>
		<li <?php if($_GET['view']==6) echo "class='active'"?>><a href="inicio.php?view=6">Mensajes</a></li>
		<?php if($_SESSION['coord']=="si"){?><li <?php if($_GET['view']==8) echo "class='active'"?>><a href="inicio.php?view=8">Administrar</a></li><?php }?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="salir.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
<?php include("conexion.php");
$sql="SELECT * FROM envia_msj WHERE visto='pendiente' and ci_dest=(SELECT ci FROM usuario WHERE tipo='Profesor' and user='$user')"; 
$cant=mysql_num_rows(mysql_query($sql));

?>
	<?php 
	switch ($_GET['view']) {
		case 2:
			include("seleccion.php");
			break;
		case 3:
			include("banco.php");
			break;
		case 5:
			include("historial.php");
			break;
		case 6:
			include("mensajes.php");
			break;
		case 7:
			include("modifEnun.php");
			break;
		case 8:
			include("administrar.php");
			break;
		case 9:
			include("crearQuiz.php");
			break;
		case 10:
			include("crearParcialAuto.php");
			break;
		case 11:
		include("crearParcialCol.php");
		break;
		case 12:
		include("crearQuizManual.php");
		break;
		case 13:
		include("crearParcialManual.php");
		break;
		case 15:
		include("misEnunciados.php");
		break;
	}
	?>

</div>



</body>
</html>

