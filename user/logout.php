<?php 
session_start();
if(isset($_SESSION['rol'])){	
    session_regenerate_id(); // Generar nuevo ID de sesión
	session_destroy();
	header("Location: ../index.php");
	exit();
}
else{
	header("Location: ../index.php");
	exit();
}
?>
