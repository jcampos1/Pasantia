<?php 
session_start();
if($_SESSION['activa']!=1) header('Location: index.php');
if(!isset($_GET['view'])) header('Location: index.php?view=2');
$user=$_SESSION['usuario'];
?>
<!DOCTYPE html>
<head>
<?php include("mod/header.php") ?>
<title>Sigie - Inicio</title>

<script type="text/javascript">

function enviar_formulario(){
	if (!$('input[name="msjs[]"]').is(':checked')) {
        alert('Debe seleccionar por lo menos un mensaje para ejecutar esta acción');
    	}else{
			document.formElimMsj.submit()
		} 
}
</script>
</head>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#"><img src="resources/imagenes/logo.png" width="70px"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li <?php if($_GET['view']==2 or $_GET['view']==10 or $_GET['view']==13) echo "class='active'"?>><a href="inicio.php?view=2">Instrumentos</a></li>
		<li <?php if($_GET['view']==3) echo "class='active'"?>><a href="inicio.php?view=3">Ejercicios</a></li>
		<li <?php if($_GET['view']==15) echo "class='active'"?>><a href="inicio.php?view=15">Mis Ejercicios</a></li>
		<li <?php if($_GET['view']==5) echo "class='active'"?>><a href="inicio.php?view=5">Repositorio</a></li>
		<li <?php if($_GET['view']==6) echo "class='active'"?>><a href="inicio.php?view=6">Mensajes</a></li>
		<?php if($_SESSION['coord']=="si"){?><li <?php if($_GET['view']==8) echo "class='active'"?>><a href="inicio.php?view=8">Administrar</a></li><?php }?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="#" data-toggle="modal" data-target="#myModal2"><span class="glyphicon glyphicon-user"></span> <strong><?php echo $user;?></strong></a></li>
		<li><a href="">|</a></li>
        <li><a href="salir.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php 
	if(isset($_SESSION['error'])){
		if($_SESSION['error']==1){
			echo "<div id='aviso_pass' class='alert alert-success fade in'>";
			echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
			echo "<strong><span class='glyphicon glyphicon-ok-sign'></span> Cambio de contraseña realizado.</strong>.";
			echo "</div>";
		}
		else{
			if($_SESSION['error']==2){
				echo "<div id='aviso_pass' class='alert alert-danger fade in'>";
				echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
				echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> No se pudo cambiar su contraseña,verifique los datos.</strong>.";
				echo "</div>";
			}
		}
		echo "<script>$('#aviso_pass').fadeOut(8000);</script>";
		$_SESSION["error"]=-1;
	}
?>

<div class="container" id="contenedor">
	
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog"></div>

<div id="myModal2" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-user"></span> Opciones de usuario</h4>
			</div>
			<div class="modal-body">
					<form role="form" method="post" action="includes/cambiar_pass.php">
						<div class="row">
							<div class="col-sm-8 form-group">
								<label for="nuevo_pass">Nueva contraseña</label>
								<input class="form-control" id="nuevo_pass" name="nuevo_pass" placeholder="Nueva contraseña" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una mayúscula, y al menos 8 o más caracteres." type="password" required>
							</div>
							<div class="col-sm-4 form-group">
								<br>
								<button class="btn btn-primary pull-right" type="submit">Cambiar Contraseña</button>
							</div>
						</div>
					</form>	
			</div>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<br>
	<p><i>Powered By: </i><a href="http://www.fabricomidinero.xyz" title="Fabricomidinero" target="blank"><img src="http://fabricomidinero.xyz/images/logo_fabricomidinero.png"  width="100px"></a><strong> & </strong><a href="http://www.tecnosolvision.com.ve/" title="TecnoSolVisión" target="blank" rel="home"><strong>TecnoSolVisión</strong></a><p>
</footer>

<script>
var tam = screen.availHeight-242;
tam = tam+'px';
document.getElementById('contenedor').style.minHeight = tam;
</script>



</body>
</html>

