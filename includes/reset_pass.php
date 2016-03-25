<?php

session_start();
$usuario=$_POST["name_reset"];
$email = $_POST["email_reset"];

$conexion=mysql_connect("mysql.hostinger.es","u477358893_sigie","sigie.custodes");
if(!$conexion){
	$_SESSION['error']='reset_no';
	header('Location: ../index.php');
}
else{
	mysql_select_db("u477358893_sigie", $conexion);
	$sql="SELECT * FROM usuario WHERE user='$usuario' and email='$email'";
	$ro=mysql_fetch_array(mysql_query($sql));
	
	if($ro){
		$new_pass = getRandomCode();
		$sql="UPDATE usuario SET pass='".md5($new_pass)."' WHERE user='$usuario'";
		if(mysql_query($sql)){
			$subjet="Sigie - Restablecer contraseña";
			$mensaje="Su contraseña provicional es: ".$new_pass." , por su seguridad modifiquela al ingresar.";
			if(mail($email,$subjet,$mensaje)){
				$_SESSION['error']="reset_yes";
				header('Location: ../index.php');
			}
			else{	
				$_SESSION['error']="reset_no";
				header('Location: ../index.php');
			}
		}
		else{

			$_SESSION['error']="reset_no";
			header('Location: ../index.php');
		}
	}
	else{
		$_SESSION['error']="reset_no";
		header('Location: ../index.php');
	}
}

		
function getRandomCode(){
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $su = strlen($an) - 1;
    return 	substr($an, rand(0, $su), 1)  .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1) .
            substr($an, rand(0, $su), 1);
}
?>
