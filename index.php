<?php 
session_start();
if(isset($_SESSION['activa'])) 
header('Location: inicio.php?view=2');;
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="title" content="Inicio">
<link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
<link rel="icon" href="resources/favicon.ico" type="image/x-icon">
<link href='https://fonts.googleapis.com/css?family=Crimson+Text:400,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="./resources/css/styles.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<title>Login</title>
</head>

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

.jumbotron{
	background-image: url('resources/imagenes/inteligencia.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    font-family: 'Crimson Text', serif;
	}

</style>
<body>

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
      <ul class="nav navbar-nav navbar-right">
        <li><a href="salir.php"><span class="glyphicon glyphicon-envelope"></span> Solicitar Registro</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>GIE</h1> 
  <p>Elementos Discretos <strong>I</strong> &amp; <strong>II</strong></p> 
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-3"><br></div>
		<div class="col-sm-6">
			<?php 
			if(isset($_SESSION['error'])){
				if($_SESSION['error']=="invalido"){
					echo "<div class='alert alert-danger'>";
					echo "<strong>Por favor verifique su Usuario y/o Contraseña.</strong>.";
					echo "</div>";
				}
			}
			?>
			<div class="contentbox createquiz">
				<h2>Ingresa al Sistema</h2>
				<form id="newquizformmodel" action="conex.php" method="post">
					<div class="required">
						<input placeholder="Usuario" id="nombre_usuario" name="nombre_usuario" type="text" required>
						<input placeholder="Contraseña" id="clave_usuario" name="clave_usuario" type="password" required>
					</div>
					<input class="liftoff" type="submit" name="yt0" value="Acceder">
				</form>
			</div>
		</div>
		<div class="col-sm-3"><br></div>
	</div>
</div>

						
					

<!-- Container (Services Section) -->
<div class="container-fluid text-center">
  <h2>Enlaces de Interes</h2>
  <br>
  <div class="row">
    <div class="col-sm-4">
      <a href="http://entornovirtual.facyt.uc.edu.ve/" ><img src="./resources/imagenes/entornovirtual.png" alt="Entorno Virtual" width="200px"></a>
    </div>
    <div class="col-sm-4">
		 <a href="http://www.facyt.uc.edu.ve/"><img src="./resources/imagenes/cajas_estudiar.png" alt="FACYT" width="200px"></a>
    </div>
    <div class="col-sm-4">
		 <a href="http://sice.facyt.uc.edu.ve/"><img src="./resources/imagenes/sice.png" alt="SICE" width="200px"></a>
    </div>
  </div>
  <br><br>
</div>


<footer class="container-fluid text-center">
  <hr>
  <p>Powered By: <a href="http://www.fabricomidinero.xyz" title="Fabricomidinero" target="blank"><img src="http://fabricomidinero.xyz/images/logo_fabricomidinero.png"  width="100px"></a><strong> & </strong><a href="http://www.tecnosolvision.com.ve/" title="TecnoSolVisión" target="blank" rel="home" style="color:black;"><strong>TecnoSolVisión</strong></a><p>
</footer>
</body>
</html>
						
