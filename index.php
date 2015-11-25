<?php 
session_start();
if(isset($_SESSION['activa'])) 
header('Location: inicio.php?view=1');;
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="title" content="Inicio">
<link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
<link rel="icon" href="resources/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="./resources/css/styles.css">
<title>Login</title>
</head>
<body class="page_home user_notloggedin" style="background-color:#FFFFFF;">
<div class="navbar menubar" style="position: relative; top: 0px; left: 0px; background-color:#0088cc">
	<div class="wrapper clearfix">
		<div class="row">
			<div class="col8">
			</div>
			<div class="col4 last">
				<div class="accountbar loginregister alignright">
					<p>
						Solicita tu Registro <span class="separator">|</span>
						<a href="">Solicitar</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="pageheader">
	<div class="bgwrap">
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col12">
						<div class="intro">
							<p>
								<span></span>Elementos Discretos <strong>I</strong> &amp; <strong>II</strong>
							</p>
						</div>
					</div>
				</div>
				<div class="row clearfix introbar">
					<div class="col7">
						<h1>Crea tu Evaluacion ahora</h1>
						<div class="pageintro">
							<p>
								 El sistema permitira crear tu evaluacion para Elementos Discretos de manera rapida y sencilla. En de Nuestro Banco de Ejecicios existen mas de 1.000.000 de estos.¡Comienza Ya!
							</p>
						</div>
						<p class="createyourown handwritten">
							¡Tu evaluacion lista en 10 Minutos!
						</p>
					</div>
					<div class="col5">
						<div class="contentbox createquiz">
							<h2>Ingresa al Sistema</h2>
							<form id="newquizformmodel" action="conex.php" method="post">
									<div class="required">
										<input placeholder="Usuario" id="nombre_usuario" name="nombre_usuario" type="text">
										<p>
										</p>
										<input placeholder="Contraseña" id="clave_usuario" name="clave_usuario" type="password">
									</div>
									<input class="liftoff" type="submit" name="yt0" value="Acceder">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="breakout customers">
	<div class="wrapper">
		<div class="row">
			<div class="col12">
				<p>
					<strong>Enlaces</strong> de interés:
				</p>
				<ul class="customerlist">
					<li><img src="./resources/imagenes/entornovirtual.png" alt="Unilever" width="200px"></li>
					<li><img src="./resources/imagenes/sice.png" alt="Heineken" width="200px"></li>
					<li><img src="./resources/imagenes/cajas_estudiar.png" alt="Heineken" width="200px"></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="breakout benefits">
</div>
<div class="breakout examples row0">
	<div class="wrapper">
		<div class="row">
			<div class="col12">
				<h2>Desarrollado Por Delwin y Junior</h2>
			</div>
		</div>
	</div>
</div>
</body>
</html>
