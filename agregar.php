<?php
	session_start();
	include("conexion.php");
	$descripcion = $_POST["editor"];
	$unid=$_POST["unidad_tematica"];
	$nivel = $_POST["nivel"];
	$componente = $_POST["componente"];
	if($componente=="teoria"){
		$solucion = $_POST["solucionTeo"];
	}else{
		$solucion = $_POST["solucion"];
	}
	$subtema=$_POST["subtema"];
	$visib= $_POST["visibilidad"];
	$row = mysql_fetch_array(mysql_query("SELECT ci FROM usuario WHERE user='".$_SESSION['usuario']."'"));
	if (strcmp ($descripcion , $vacio ) != 0) 
	{
		$query="INSERT INTO enunciado( `ci_crea_en` , `descripcion` , `nivel` , `componente` , `nombre_sub` , `unidad_tematica` , `fec_creacion` , `solucion` , `visibilidad` ) VALUES ('".$row['ci']."','".$descripcion."','".$nivel."','".$componente."','".$subtema."','".$unid."','".date('Y-m-d')."', '".$solucion."', '".$visib."')";
		if(mysql_query($query)){
			$_SESSION['actAviso']=0;
			header('Location: inicio.php?view=3');
		}
		else{
			$_SESSION['actAviso']=1;
			header('Location: inicio.php?view=3');
		}
	}
	else{
		$_SESSION['actAviso']=2;
		header('Location: inicio.php?view=3');
	};
?>
