<?php
require_once("conexion.class.php");



	class Usuario{
								// FUNCIONES PARA VALIDAR LOS DATOS DEL USUARIO Y/O CONDUCTOR

		//Función para validar que los datos personales no existan en la BD
		function validarDatosUser($nombre,$apellidoP){
			//Primero se verifica que el nombre del usuario a registrar no exista
			$texto="SELECT
						COUNT(*) as 'cuenta'
					FROM
						login AS a
						INNER JOIN usuario AS b ON b.idlogin = a.idlogin
					WHERE
						b.nombre = '".$nombre."'
						and b.paterno = '".$apellidoP."'
						and a.tipo = 2
						and a.estado = 1
						and b.estado = 1;
					";
			$conexion = new Conexion();
			if ($conexion->devolverDato($texto,"cuenta") == 0) { //Valida que no haya datos repetidos.
						return true;
			}else{
				return  false;
			}
		}

		//Función para validar que el nombre de usuario exista.
		function validarLoginUser($user,$pass){
			//Primero se verifica que el user no exista en la BD
			$texto="SELECT
						COUNT(*) as 'cuenta'
					FROM
						login AS a
						INNER JOIN usuario AS b ON b.idlogin = a.idlogin
					WHERE
						a.`user` = '".$user."'
						and a.`password` = MD5('".$pass."')
						and a.tipo = 2
						and a.estado = 1
						and b.estado = 1;
					";
					$conexion = new Conexion();
					$valor = 0;
					if ($rows =$conexion->query($texto)) { //Valida que no haya datos repetidos.
						foreach ($rows as $row )
							if($row["cuenta"] == 1)
								return false;
					}
					return  true;
		}

		// Validar datos si se trata de un CONDUCTOR
		function validarDatosCond($nombre,$paterno,$materno){
			// Se verifica que los datos del conductor no esten registrados
			$texto = "SELECT
						  COUNT(*) as 'cuenta'
					  FROM
						  login AS a
						  INNER JOIN conductor AS b ON b.idlogin = a.idlogin
					  WHERE
						  b.nombre = '".$nombre."'
						  and b.paterno = '".$paterno."'
						  and b.materno = '".$materno."'
						  and a.tipo = 3
						  and a.estado = 1
						  and b.estado = 1;
					";
					$conexion = new Conexion();
					$valor = 0;
					if ($rows =$conexion->query($texto)) { //Valida que no haya datos repetidos.
						foreach ($rows as $row )
							if($row["cuenta"] == 1)
								return false;
					}
					return  true;
		}

		// Valida que los datos para inicar sesión no estén registrados ya en la BD
		function validarLoginCond($user,$password){
		// Se verifican los datos enviados
			$texto = "SELECT
						  COUNT(*) as 'cuenta'
					  FROM
						  login AS a
						  INNER JOIN conductor AS b ON b.idlogin = a.idlogin
					  WHERE
						  a.`user` = '".$user."'
						  and a.`password` = MD5('".$password."')
						  and a.tipo = 3
						  and a.estado = 1
						  and b.estado = 1;
					";
					$conexion = new Conexion();
					$valor = 0;
					if ($rows =$conexion->query($texto)) { //Valida que no haya datos repetidos.
						foreach ($rows as $row )
							if($row["cuenta"] == 1)
								return false;
					}
					return  true;
		}

										// FUNCIONES PARA AGREGAR AL USUARIO Y/O CONDUCTOR

		//Función para agregar al USUARIO en la tabla de login
		function agregarLogUser($user_name,$password){
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO login(
								user
								,password
								,tipo
								,estado
							)VALUES(
								'".$user_name."'
								,md5('".$password."')
								,2
								,1);
							";
			$conexion = new Conexion();
			$conexion->query($texto);
			$texto="SELECT MAX(idlogin) AS id FROM login as a WHERE a.estado = 1";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					return $row['id'];
				}
			}
		}

		//Agregar los datos en la tabla de USUARIO
		function agregarUsuario($nombre,$paterno,$idLog){ //Recibe los datos del usuario.
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO usuario(
								nombre
								,paterno
								,estado
								,idlogin
							)VALUES(
								'".$nombre."'
								,'".$paterno."'
								,1
								,$idLog);
							";

				$conexion = new Conexion();
				$conexion->query($texto);
				return true;
		}

		//Función para agregar al CONDUCTOR en la tabla de login
		function agregarLogCond($user,$password){
			//Se realiza la conexión a la BD
			$conexion = new Conexion();

			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO login(
								user
								,password
								,tipo
								,estado
							)VALUES(
								'".$user."'
								,md5('".$password."')
								,3
								,1);
							";
			//Se reliza el registro
			$conexion->query($texto);

			//Obtener el último registro en agregarse
			$texto="SELECT MAX(idlogin) AS id FROM login as a WHERE a.estado = 1;";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					return $row['id'];
				}
			}
		}

		//Función para agregar los datos en la tabla CONDUCTOR
		function agregarConductor($nombre,$paterno,$materno,$tipoC,$idLog){
			//Se realiza la conexión a la BD
			$conexion = new Conexion();

			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO conductor(
								nombre
								,paterno
								,materno
								,tipoconductor
								,estado
								,idlogin
							)VALUES(
								'".$nombre."'
								,'".$paterno."'
								,'".$materno."'
								,'".$tipoC."'
								,1
								,'".$idLog."');
							";
			//Se reliza el registro
			$conexion->query($texto);
		}


									// Funciones para MOSTRAR los USUARIOS y CONDUCORES

		//Función para mostrar los datos del USUARIO
		function MostrarUsuario(){
			//Se realiza la conexión a la BD
			$conexion = new Conexion();

			echo "<section id='busqueda'>";
					$query="SELECT
								a.idlogin 'No.'
								,CONCAT(b.nombre,' ',b.paterno,' ') AS 'Usuario'
								,CASE
									WHEN a.tipo = 1 THEN 'Administrador'
									WHEN a.tipo = 2 THEN 'Empleado'
								END
								AS 'Tipo'
							FROM
								login as a
								INNER JOIN usuario AS b ON b.idlogin = a.idlogin
							WHERE
								a.estado = 1
								AND b.estado = 1;
						";
				$texto = $conexion->query($query);
				if(mysqli_num_rows($texto) > 0){
					echo "<div class='table-responsive table-condensed''>";
					echo "<div style='text-align:center'>";
					echo "<table class='table table-striped table-bordered table-hover'>";

					//Aquí recorremos los campos
					echo "<thead>";
					echo "<tr>";
					while($cabecera=mysqli_fetch_field($texto)){
						foreach($cabecera as $index => $columna){
							if($index=="name"){
								echo "<th style='text-align:center'>".$columna."</th>";
							}
						}
					}

					echo "</tr>";
					echo "</thead>";

					//Aquí recorremos las filas
					echo "<tbody>";
					while($fila=mysqli_fetch_assoc($texto)){
						echo "<tr>";
						foreach ($fila as $columna => $valor) {
							echo "<td>".$valor."</td>";
						}
					?>
						<td>
							<form action="#" method="post">
								<input type="hidden" name="modificar_user" value="<?php echo $fila['No.']; ?>" />
								<input type="submit" value="Modificar" class="btn btn-info"/>
							</form>
						</td>
						<td>
							<?php if($fila['Tipo']!='Administrador'){?>
							<form action="" method="post" onsubmit="return confirm('¿Esta seguro de querer eliminar este usuario? (Se eliminará del sistema)');">
								<input type="hidden" name="funcion" value="eliminar_user"/>
								<input type="hidden" name="eliminar_user" value="<?php echo $fila['No.']; ?>" />
								<input type='submit' value='Eliminar' class="btn btn-danger"/>
							</form>
							<?php }?>
						</td>
					</tr>
					<?php
					}
					echo "</tbody>";

					echo "</table>";
					echo "</div>";
					echo "</div>";
			}else{
				echo "<script>alert(No hay datos que mostrar);</script>";
			}
			echo "</section>";
		}

		// Función para mostrar los datos del Conductor
		function MostrarConductor(){
			//Se realiza la conexión a la BD
			$conexion = conectar();
			mysqli_set_charset($conexion, "utf8");

			echo "<section id='busqueda'>";
					$texto="SELECT
								a.idlogin 'No.'
								,CONCAT(b.nombre,' ',b.paterno,' ',b.materno) AS 'Conductor'
							FROM
								login as a
								INNER JOIN conductor AS b ON b.idlogin = a.idlogin
							WHERE
								AND a.tipo = 3
								AND a.estado = 1
								AND b.estado = 1;
						";

				$query = mysqli_query($conexion,$texto);
				if(mysqli_num_rows($query)>0){
					echo "<div class='table-responsive table-condensed''>";
					echo "<div style='text-align:center'>";
					echo "<table class='table table-striped table-bordered table-hover'>";

					//Aquí recorremos los campos
					echo "<thead>";
					echo "<tr>";
					while($cabecera=mysqli_fetch_field($query)){
						foreach($cabecera as $index => $columna){
							if($index=="name"){
								echo "<th style='text-align:center'>".$columna."</th>";
							}
						}
					}
					echo "</tr>";
					echo "</thead>";

					//Aquí recorremos las filas
					echo "<tbody>";
					while($fila=mysqli_fetch_assoc($query)){
						echo "<tr>";
						foreach ($fila as $columna => $valor) {
							echo "<td>".$valor."</td>";
						}
					?>
						<td>
							<form action="#" method="post">
								<input type="hidden" name="modificarCond" value="<?php echo $fila['No.']; ?>" />
								<input type="submit" value="Modificar" class="btn btn-info"/>
							</form>
						</td>
						<td>
							<form action="" method="post" onsubmit="return confirm('¿Esta seguro de querer eliminar este usuario? (Se eliminará del sistema)');">
								<input type="hidden" name="funcion" value="eliminar_user"/>
								<input type="hidden" name="eliminarCond" value="<?php echo $fila['No.']; ?>" />
								<input type='submit' value='Eliminar' class="btn btn-danger"/>
							</form>
						</td>
					</tr>
					<?php
					}
					echo "</tbody>";

					echo "</table>";
					echo "</div>";
					echo "</div>";
			}else{
				echo "<script> alert(No hay datos que mostrar); </script>";
			}
			echo "</section>";
		}
												// Funciones para ELIMINAR -- Usuarios y Conductores --
												//Nota: NO ESTAN ACTUALIZADOS LOS QUERY'S

		//Función para eliminar un USUARIO
		function EliminarUsuario($user_id){
			//Se realiza la conexión a la BD
			$conexion = conectar();
			mysqli_set_charset($conexion, "utf8");

			//Se realiza el registro en la base de datos.
			mysqli_query($conexion,"start transaction;");
			$texto="UPDATE
							usuario
					SET
							usuario.estado=0
					WHERE
							usuario.idusuario=".$user_id;

			mysqli_query($conexion,$texto) or mysqli_rollback($conexion) and die("ERROR 5030");
			mysqli_commit($conexion);
		}



			//Función para modificar los datos del usuario
			function modificarUsuario($nombre,$paterno,$materno,$usuario,$contrasena,$id_mod){
				mysql_query("start transaction;");//Iniciamos la transacción

				//Actualizamos los datos
				$texto="UPDATE usuario set
							nombre='".$nombre."'
							,paterno='".$paterno."'
							,materno='".$materno."'
							,usuario='".$usuario."'
							,password = md5('".$contrasena."')
						WHERE idusuario='".$id_mod."';";

				mysql_query($texto) or mysql_query("rollback;") and die("ERROR 405");

				echo "<script> alert('Registro modificado exitosamente')</script>";
				echo"<script language='javascript'>window.location='searchuser.php'</script>;";

				mysql_query("commit;");
			}

	}
?>
