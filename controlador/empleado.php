<?php 
	require_once("../modelo/empleado.php");
	require("../modelo/bitacora.php");
	
	//Distribuidor de funciones
	if(isset($_POST['funcion'])){
		$funcion = addslashes(trim($_POST['funcion']));
		switch($funcion){
			case 'agregar_empleado':
					insertar_empleado();
			break;
			case 'modificar_empleado':
				mod_empleado();
			break;
			case 'eliminar_emp':
				elim_empleado();
			break;
		}
	}
	
	//Funciones
	
	function insertar_empleado(){ //Función para agregar un empleado
			//Variables enviadas para el registro del usuario
				if(isset($_POST['titulo']) && isset($_POST['nombre']) && isset($_POST['paterno']) && isset($_POST['materno']) && isset($_POST['cargo']) && isset($_POST['nocuenta'])){
					//Limpiar variables
					$titulo = (int)($_POST['titulo']);
					$nombre = addslashes($_POST['nombre']);
					$paterno = addslashes($_POST['paterno']);
					$materno = addslashes($_POST['materno']);
					$cargo = addslashes($_POST['cargo']);
					$cuenta = (int)($_POST['nocuenta']);	

			if(!empty($nombre) && !empty($paterno) && !empty($materno) && !empty($titulo) && !empty($cargo) && !empty($cuenta)){
				$empleado = new Empleado();
				if($empleado->validarExistencia($nombre,$paterno,$materno) == true){
					//Se mandan los datos para agregar al empleado
						$idPer = $empleado->agregarDatosPersonales($nombre,$paterno,$materno);
						$idEmp = $empleado->agregarEmpleado($titulo,$cargo,$idPer);
						$empleado->agregarCuentaEmpleado($cuenta,$idEmp); 
				}else{
					echo '<script language="javascript">alert("Datos del empleado ya existentes");</script>';
						?>
							<script type="text/javascript">
								window.location="../vista/formEmpleado.php";
							</script>
						<?php
				}
			}else{
				echo '<script language="javascript">alert("Existen campos vacíos");</script>';
				?>
					<script type="text/javascript">
						window.location="../vista/formEmpleado.php";
					</script>
				<?php
			}
		}
		//Agrega a la bitacora la acción, sección y usuario
		$bitacora = new Bitacora();
        $bitacora->agregarBitacora('Agregar Empleado', 'Empleado');
	}
	
	function mod_empleado(){ //Función para modificar un empleado
		//Variables enviadas para el registro del empleado
		if(isset($_POST['id'])&& isset($_POST['modTitulo']) && isset($_POST['modNombre'])&& isset($_POST['modPaterno'])&& isset($_POST['modMaterno'])&& isset($_POST['modCargo']) && isset($_POST['modCuenta'])){
			
			//Limpiar variables	
			$id_mod = (int)($_POST['id']);
			$titulo = (int)($_POST['modTitulo']);
			$nombre =(addslashes($_POST['modNombre']));
			$paterno = (addslashes($_POST['modPaterno']));
			$materno = (addslashes($_POST['modMaterno']));
			$cargo = (addslashes($_POST['modCargo']));
			$cuenta = (int)($_POST['modCuenta']);
			$empleado = new Empleado();
			$empleado->modificarEmpleado($nombre,$paterno,$materno,$titulo,$cargo,$cuenta,$id_mod);
			
		}
		//Agrega a la bitacora la acción, sección y usuario
		$bitacora = new Bitacora();
        $bitacora->agregarBitacora('Modificar Empleado', 'Empleado');
	}
	
	function elim_empleado(){ //Función para eliminar un empleado
		//Variables enviadas para eliminar un empleado
		if(isset($_POST['elim_emp'])){	
			//Limpiar variable
			$idemp=(int)($_POST['elim_emp']);
			$empleado = new Empleado();
			$empleado->eliminarEmpleado($idemp);
			echo "<script> alert('Empleado eliminado con éxito')</script>";	
		}
		//Agrega a la bitacora la acción, sección y usuario
		$bitacora = new Bitacora();
        $bitacora->agregarBitacora('Eliminar Empleado', 'Empleado');
	}
?>