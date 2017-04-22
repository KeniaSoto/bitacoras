<?php
	include_once("../modelo/conexion.php");
	$conexion=conectar();
	mysql_query("set names 'utf8'");
	
	if (isset($_POST['clave'])){
		$clave = addslashes($_POST['clave']);
		$texto="SELECT
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
					AND b.estado = 1
					AND b.nombre like '%".$clave."%';		
			";

		$query = mysqli_query($conexion,$texto);
		if(mysqli_num_rows($query)>0){
			echo "<div class='table-responsive table-condensed'>";
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
			while($fila=mysql_fetch_assoc($query)){
				echo "<tr>";
				foreach ($fila as $columna => $valor) {
					echo "<td>".$valor."</td>";
				}
			?>		
				<td>
					<form action="#" method="post">
						<input type="hidden" name="modificar_user" value="<?php echo $fila['id']; ?>" />
						<input type="submit" value="Modificar" class="btn btn-info"/>
					</form>
				</td>
				<td>
					<?php if($fila['Tipo']!='Administrador'){?>
					<form action="#" method="post">
						<input type="hidden"  name="funcion" value="eliminar_usuario"/>
						<input type="hidden" name="eliminar_user" value="<?php echo $fila['id']; ?>" />
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
			echo "<script> alert(No hay datos que mostrar); </script>";
		}
	}
?>