<?php
session_start();
$target_path = "uploads/horarios/";
$target_path = $target_path ."horario_".md5($_SESSION['usuario']).".".explode(".",$_FILES['uploadedfile']['name'])[1];
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
{
	header('Location: inicio.php?view=1');
} else{
echo "Ha ocurrido un error, trate de nuevo!";
}
?>
