<?php
	session_start();
	$_SESSION['bandera_inicio']=1;
	unset($_SESSION['bandera_inicio']);
	session_destroy();
	
	header("Location: login.php");
?>