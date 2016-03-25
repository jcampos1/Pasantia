<?php 
session_start();
if(isset($_SESSION['activa'])) 
header('Location: inicio.php?view=2');;
?>
<!DOCTYPE html>
<head>
<?php include("mod/header.php") ?>
<title>Sigie - Ingresar</title>
</head>

<body>

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
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-envelope"></span> Contacto</a></li>
			</ul>
		</div>
	</div>
</nav>


<!-- Modal Contacto -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-envelope"></span> Contacto</h4>
			</div>
			<div class="modal-body">
					<form role="form" method="post" action="includes/correo_contacto.php">
						<div class="row">
							<div class="col-sm-6 form-group">
								<input class="form-control" id="name" name="name" placeholder="Nombre" type="text" required>
							</div>
							<div class="col-sm-6 form-group">
								<input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
							</div>
						</div>
						<textarea class="form-control" id="msg" name="msg" placeholder="Comentario" rows="5"></textarea><br>
						<div class="row">
							<div class="col-sm-12 form-group">
								<button class="btn btn-primary pull-right" type="submit">Enviar</button>
							</div>
						</div>
					</form>	
			</div>
		</div>
	</div>
</div>

<!-- Modal Restablecer contreseña -->
<div id="reset_pass" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-envelope"></span> Reestablecer contraseña</h4>
			</div>
			<div class="modal-body">
					<form role="form" method="post" action="includes/reset_pass.php">
						<div class="row">
							<div class="col-sm-6 form-group">
								<input class="form-control" id="name_reset" name="name_reset" placeholder="Usuario" type="text" required>
							</div>
							<div class="col-sm-6 form-group">
								<input class="form-control" id="email_reset" name="email_reset" placeholder="Email" type="email" required>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 form-group">
								<button class="btn btn-warning pull-right" type="submit">Reestablecer contraseña</button>
							</div>
						</div>
					</form>	
			</div>
		</div>
	</div>
</div>

<div class="jumbotron text-center">
  <h1>SIGIE</h1> 
  <h2>Elementos Discretos <strong>I</strong> &amp; <strong>II</strong></h2> 
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-3"><br></div>
		<div class="col-sm-6">
			<?php 
			if(isset($_SESSION['error'])){
				if($_SESSION['error']=="invalido"){
					echo "<div class='alert alert-danger'>";
					echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> Por favor verifique su Usuario y/o Contraseña.</strong>";
					echo "</div>";
				}
				if($_SESSION['error']=="correo_yes"){
					echo "<div class='alert alert-success'>";
					echo "<strong><span class='glyphicon glyphicon-ok-sign'></span> Su correo fue enviado exitosamente.</strong>";
					echo "</div>";
				}
				if($_SESSION['error']=="correo_no"){
					echo "<div class='alert alert-danger'>";
					echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> Ocurrio un error al enviar el correo.</strong>";
					echo "</div>";
				}
				if($_SESSION['error']=="reset_no"){
					echo "<div class='alert alert-danger'>";
					echo "<strong><span class='glyphicon glyphicon-remove-sign'></span> Datos incorrectos, verifique nuevamente.</strong>";
					echo "</div>";
				}
				if($_SESSION['error']=="reset_yes"){
					echo "<div class='alert alert-success'>";
					echo "<strong><span class='glyphicon glyphicon-ok-sign'></span> La información de cambio de contraseña fue enviada a su correo.</strong>";
					echo "</div>";
				}
				unset($_SESSION['error']);
			}
			?>
			<div class="contentbox createquiz">
				<form role="form" action="conex.php" method="post">
					<div class="form-group">
						<label for="nombre_usuario"><span class="glyphicon glyphicon-user"></span> Usuario</label>
						<input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Usuario" required>
					</div>
					<div class="form-group">
						<label for="clave_usuario"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
						<input type="password" class="form-control" id="clave_usuario" name="clave_usuario" placeholder="Contraseña" required>
					</div>
					<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-off"></span> Ingresar</button>
				</form>
				<hr>
				<a href="#" data-toggle="modal" data-target="#reset_pass">¿Olvidaste tu  contraseña?</a>
			</div>
		</div>
		<div class="col-sm-3"><br></div>
	</div>
	
	<div class="container-fluid text-center">
  <h2><i>Enlaces de Interes</i></h2>
  <br>
  <div class="row">
    <div class="col-sm-4">
      <a href="http://entornovirtual.facyt.uc.edu.ve/" target="_blank" ><img src="./resources/imagenes/entornovirtual.png" alt="Entorno Virtual" width="200px"></a>
    </div>
    <div class="col-sm-4">
		 <a href="http://www.facyt.uc.edu.ve/" target="_blank" ><img src="./resources/imagenes/cajas_estudiar.png" alt="FACYT" width="200px"></a>
    </div>
    <div class="col-sm-4">
		 <a href="http://sice.facyt.uc.edu.ve/" target="_blank" ><img src="./resources/imagenes/sice.png" alt="SICE" width="200px"></a>
    </div>
  </div>
  <br><br>
</div>
</div>


<footer class="container-fluid text-center">
  <br>
  <p><i>Powered By: </i><a href="http://www.fabricomidinero.xyz" title="Fabricomidinero" target="blank"><img src="http://fabricomidinero.xyz/images/logo_fabricomidinero.png"  width="100px"></a><strong> & </strong><a href="http://www.tecnosolvision.com.ve/" title="TecnoSolVisión" target="blank" rel="home" style="color:black;"><strong>TecnoSolVisión</strong></a><p>
</footer>
</body>
</html>
						
