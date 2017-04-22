<?php
	require_once("../modelo/sesion.php");
	
	if(isset($_POST['funcion'])){
		$funcion = addslashes(trim($_POST['funcion']));
		switch($funcion){
			case 'inicioSesion':
				iniciar_Sesion();
			break;
		}
	}
	
	function iniciar_Sesion(){
		$sesion = new Sesion();
		if(isset($_POST['usuario']) && isset($_POST['password'])){
			$user = addslashes ($_POST['usuario']);
			$pass = addslashes ($_POST['password']);
			echo "1";
			if($sesion->validarCampos($user,$pass) == false){echo "2";
				if($sesion->validarUsuario($user,$pass) == true){echo "3";
					$sesion->iniciarSesion($user);
					if($_SESSION['tipo'] == 1){
						header("Location: ../vista/indexA.php");
					}
					if($_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 3){
						header("Location: ../vista/index.php");
					}
				}else{
				  echo '<script language="javascript">alert("Usuario y/o Contraseña incorrecto");</script>';  
				}
			}else{
			  echo '<script language="javascript">alert("Existen campos vacíos");</script>';
			}	
		}
	}
?>