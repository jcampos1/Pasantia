<?php
session_start();
	$file="uploads/horarios/horario_".md5($_SESSION['usuario']).".jpg";
   if(unlink($file))
   {
	   header('Location: inicio.php?view=1');
	}
	else
	{
		echo "Error Borrando";
	};
	
?>
