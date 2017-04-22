<?php
	require("conexion.php");
	$conexion = conectar();
	mysqli_set_charset($conexion, "utf8");
	
	class Sesion{
		
		function validarCampos($user_name,$password){ //Valida que los datos no estén vacíos.
			if(empty($user_name) || empty($password))
				return true;
			else 
				return false;
		}
		//Función para validar el Usuario y Contraseña
		function validarUsuario($user_name,$password){ // Recibe el usuario y contraseña
			$string_query="SELECT
					COUNT(*) as cuenta
				FROM
					login AS a
				WHERE
					a.user = '".$user_name."'
					AND a.password = md5('".$password."')
					AND a.estado = 1;
				";
				
			if(devolverDato($string_query,"cuenta") == "1") //Valida si hay un registro con dichos datos.
				return true;
			else
				return false;
		}
		
		function iniciarSesion($user){
			$query="SELECT
					a.idlogin as 'id'
					,a.user as 'nombre'
					,a.tipo as 'tipo'
				FROM
					login as a
				WHERE
					a.user = '".$user."'
					AND a.estado = 1;
				";
			$id = devolverDato($query,"id");
			$nom = devolverDato($query,"nombre");
			$tipo = devolverDato($query,"tipo");
			
			$_SESSION['id']= $id;
			$_SESSION['nombre']= $nom;
			$_SESSION['tipo'] = $tipo;
			$_SESSION['bandera'] = 1;
		}			
	}
?>