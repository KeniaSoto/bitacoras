<?php
	require_once("../modelo/usuario.php");

	//Distribuidor de funciones
	if(isset($_POST['funcion'])){
		$funcion = addslashes(trim($_POST['funcion']));
		switch($funcion){
			case 'agregar_user':
				insertar_user();
			break;
			case 'modificar_user':
				modificar_user();
			break;
			case 'eliminar_user':
				eliminar_user();
			break;
		}
	}

	//Funciones

	function insertar_user(){ //Función para agregar un usuario
		echo "holi";
		$user = new Usuario();
		//Variables enviadas para el registro del usuario
		if(isset($_POST['nombre']) && isset($_POST['paterno']) && isset($_POST['user']) && isset($_POST['pass'])){

			//Limpiar variables
			$nombre = addslashes($_POST['nombre']);
			$paterno = addslashes($_POST['paterno']);
			$materno = addslashes($_POST['materno']);
			$user_name = addslashes($_POST['user']);
			$password = addslashes($_POST['pass']);
			$tipo = (int)($_POST['tipo']);

			if(!empty($nombre) && !empty($paterno) && !empty($user_name) && !empty($password)){
				if(isset($_POST['usuario']) == 1 && empty($materno)){ // Si se va registrar un EMPLEADO
					//Validar que exista el Usuario
					if($user->validarDatosUser($nombre,$paterno) == true){
						if($user->validarLoginUser($user_name,$password) == true){
							$idLogin = $user->agregarLogUser($user_name,$password);
							$user->agregarUsuario($nombre,$paterno,$idLogin);
						}else{
							echo '<script language="javascript">alert("El usuario y/o contraseña ya existen");</script>';
							?>
								<script type="text/javascript">
									window.location="../vista/AgregarUsuario.php";
								</script>
							<?php
						}
					}else{
						echo '<script language="javascript">alert("Datos de usuario ya existentes");</script>';
							?>
								<script type="text/javascript">
									window.location="../vista/AgregarUsuario.php";
								</script>
							<?php
					}
				}
				if(isset($_POST['usuario']) == 2  && !empty($materno) && isset($_POST['tipo'])){ // Para registrar un CONDUCTOR
					//Validar Existencia Conductor
					if($user->validarDatosCond($nombre,$paterno,$materno) == true){
						if($user->validarLoginCond($user_name,$password) == true){
							$idLogC = $user->agregarLogCond($user_name,$password);
							$user->agregarConductor($nombre,$paterno,$materno,$tipo,$idLogC);
						}else{
							echo '<script language="javascript">alert("El usuario y/o contraseña ya existen");</script>';
							?>
								<script type="text/javascript">
									window.location="../vista/AgregarUsuario.php";
								</script>
							<?php
						}
					}else{
						echo '<script language="javascript">alert("Datos del conductor ya existentes");</script>';
							?>
								<script type="text/javascript">
									window.location="../vista/AgregarUsuario.php";
								</script>
							<?php
					}
				}
			}else{
				echo '<script language="javascript">alert("Existen campos vacios");</script>';
				?>
					<script type="text/javascript">
						window.location="../vista/formuser.php";
					</script>
				<?php
			}
		}
	}

	function modificar_user(){ //Función para modificar un usuario
		//Variables enviadas para el registro del usuario
		if(isset($_POST['id'])&& isset($_POST['nom'])&& isset($_POST['pat'])&& isset($_POST['mat'])&& isset($_POST['user_name']) && isset($_POST['pass'])){
			//Limpiar variables
			$id_mod = (int)($_POST['id']);
			$nombre =(addslashes($_POST['nom']));
			$paterno = (addslashes($_POST['pat']));
			$materno = (addslashes($_POST['mat']));
			$usuario = (addslashes($_POST['user_name']));
			$contrasena = (addslashes($_POST['pass']));
			$user = new Usuario();
			if(!empty($nombre) && !empty($paterno) && !empty($materno) && !empty($usuario) && !empty($contrasena)){
				$user->modificarUsuario($nombre,$paterno,$materno,$usuario,$contrasena,$id_mod);
			}else{
				echo '<script language="javascript">alert("Existen campos vacios");</script>';
				?>
				  <script type="text/javascript">
                      window.location="../vista/modificaruser.php";
                  </script>
				<?php
			}

		}
		//Agrega a la bitacora la acción, sección y usuario
		$bitacora = new Bitacora();
        $bitacora->agregarBitacora('Modificar Usuario', 'Usuario');
	}

	function eliminar_user(){ //Función para eliminar un usuario
		//Variables enviadas para eliminar un usuario
		if(isset($_POST['eliminar_user'])){
			//Limpiar variable
			$user_id=(int)($_POST['eliminar_user']);
			$user = new Usuario();
			$user->EliminarUsuario($user_id);
			echo "<script> alert('Usuario eliminado con éxito')</script>";
		}
		//Agrega a la bitacora la acción, sección y usuario
		$bitacora = new Bitacora();
        $bitacora->agregarBitacora('Eliminar Usuario', 'Usuario');
	}
?>
