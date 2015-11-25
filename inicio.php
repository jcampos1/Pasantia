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
<link rel="stylesheet" type="text/css" href="./resources/css/styles.css">
<link rel="stylesheet" type="text/css" href="./resources/css/responsivemobilemenu.css">

<title>INICIO</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="resources/javascript/funciones.js"></script>
<script type="text/javascript" src="resources/javascript/responsivemobilemenu.js"></script>
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

</style>
</head>

<div class="navbar menubar" style="position: relative; top: 0px; left: 0px; background-color:#0088cc">
	<div class="wrapper clearfix">
		<div class="row">
			<div class="col8">
			</div>
			<div class="col4 last">
				<div class="accountbar loginregister alignright">
						<p>Bienvenido/a <?php echo $_SESSION['usuario'] ?> <span class="separator">|</span> 
						<a href="salir.php">Salir</a>
						</p>
				</div>			
			</div>
		</div>
	</div>
</div>

<div class="pageheader">
	<div class="bgwrap">
		<div class="wrapper clearfix">
			 <div class="container">
					<div class="row">
                    <?php include("conexion.php");
					$sql="SELECT * FROM envia_msj WHERE visto='pendiente' and ci_dest=(SELECT ci FROM usuario WHERE tipo='Profesor' and user='$user')"; 
					$cant=mysql_num_rows(mysql_query($sql));
					
					?>
						<div class="rmm">
							<ul>
								<li><a href="inicio.php?view=1" <?php if($_GET['view']==1) echo "class='actual'"?>>Información</a></li>
								<li><a href="inicio.php?view=2" <?php if($_GET['view']==2) echo "class='actual'"?>>Instrumentos</a></li>
								<li><a href="inicio.php?view=3" <?php if($_GET['view']==3 || $_GET['view']==11) echo "class='actual'"?>>Ejercicios</a></li>
                                <!-- si se han realizado asignaciones por parte del coord o si el usuario es coordinador-->
								<?php if($cant>0 || $_SESSION['coord']=="si"){?><li><a href="inicio.php?view=4" <?php if($_GET['view']==4) echo "class='actual'"?>>Colaboración</a></li><?php }?>
								<li><a href="inicio.php?view=5" <?php if($_GET['view']==5) echo "class='actual'"?>>Historial</a></li>
								<li><a href="inicio.php?view=6" <?php if($_GET['view']==6) echo "class='actual'"?>>Mensajes</a></li>
                                <?php if($_SESSION['coord']=="si"){?><li><a href="inicio.php?view=8" <?php if($_GET['view']==8) echo "class='actual'"?>>Administrar</a></li><?php }?>
							</ul>
						</div>
				<div class="row clearfix introbar" id="startedit">
					<div class="col12">
						
						<div class="contentbox createquiz">
							<div class="row">
								<?php 
								switch ($_GET['view']) {
									case 1:
										include("cuenta.php");
										break;
									case 2:
										include("seleccion.php");
										break;
									case 3:
										include("banco.php");
										break;
									case 4:
										if($_SESSION['coord']=="si"){
											include("colaborativo.php");
										}else{
											
											include("colaborativoProf.php");
										}
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
								}
								?>
							</div>				
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


		


</body>
</html>

