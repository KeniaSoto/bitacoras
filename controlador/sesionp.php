<?php

	require_once("../modelo/sesion.php");
	if(isset($_POST['usuario']) && isset($_POST['password'])){
		$user = addslashes ($_POST['usuario']);
		$pass = addslashes ($_POST['password']);
		
		$sesion = new Sesion();

		if($sesion->validarCampos($user,$pass) == false){
			if($sesion->validaUsuario($user,$pass) == true){
			  $sesion->iniciarSesion("indexA.php", $user);
			}else{
			  echo '<script language="javascript">alert("Usuario y/o Contraseña incorrecto");</script>';  
			}
		}else{
		  echo '<script language="javascript">alert("Existen campos vacíos");</script>';
		}	
	}
	//#581248 color morado
?>