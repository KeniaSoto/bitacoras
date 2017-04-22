<?php
	require_once("conexion.class.php");

	class Bitacora{
																							// CRUD para la bitácora //
		// Obtener id del conductor
		function idConductor($idLog){
			$texto = "SELECT
						  a.idconductor AS 'id'
					  FROM
						  conductor AS a
						  INNER JOIN login AS b ON b.idlogin = a.idlogin
					  WHERE
						  b.idlogin = ".$idLog."
						  AND a.estado = 1
						  AND b.estado = 1;
					  ";
			$conexion = new Conexion();
			$idC = $conexion->devolverDato($texto,"id");

			return $idC;
		}

		//función para Obtener el tipo de conductor
		function obtenerTipoCond($idC){
			$texto = "SELECT
											a.tipoconductor AS 'tipo'
								FROM
								conductor as a
								WHERE
								a.idconductor = ".$idC."
								AND a.estado = 1;
							";
			$conexion = new Conexion();
			$tipoC = $conexion->devolverDato($texto,"tipo");
		 	echo "TipoC ".$tipoC."<br />";
			return $tipoC;
		}

		//Función para obtener el id del automovil del conductor
		function automovilConductor($idConductor){
			$texto = "SELECT
									b.idautomovil as 'id'
								FROM
									conductor as a
									INNER JOIN automovil as b on b.idconductor = a.idconductor
								WHERE
									a.idconductor = ".$idConductor."
									AND a.estado = 1
									AND b.estado = 1;
							";
			$conexion = new Conexion();
			$idA = $conexion->devolverDato($texto,"id");
			echo "id ".$idA."<br />";
			return $idA;
		}
		//Función para insertar en la tabla Bitácora de COMBUSTIBLE
		function agregarBitacoraCombustible(){
			$conexion = new Conexion();
			setlocale(LC_TIME, "spanish");
			$mes = date("m");// Mes actual en texto
			$mesActual = strftime("%B",mktime($mes));
			echo "MES: ".$mesActual."<br />";

			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO bitacora(
								mesregistro
								,tipobitacora
								,estado
							)VALUES(
								'".$mesActual."'
								,1
								,1);
							";
			//Se reliza el registro o se envía error
			print_r($texto);
			echo "<br />";
			$conexion->query($texto);
			//Obtener el último registro en agregarse
			$texto="SELECT MAX(idbitacora) AS id FROM bitacora as a WHERE a.estado = 1 AND a.tipobitacora=1;";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					echo "idCOM: ".$row['id']."<br />";
					return $row['id'];
				}
			}
			return true;
		}

		//Función para insertar en la tabla Bitácora de RECORRIDO/VIAJE
		function agregarBitacoraRecorrido(){

			setlocale(LC_TIME, "spanish");
			$mes = date("m");// Mes actual en texto
			$mesActual = strftime("%B",mktime($mes));

			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO bitacora(
								mesregistro
								,tipobitacora
								,estado
							)VALUES(
								'".$mesActual."'
								,2
								,1);
							";
			$conexion = new Conexion();
			//Se reliza el registro o se envía error
			print_r($texto);
			$conexion->query($texto);
			//Obtener el último registro en agregarse
			$texto="SELECT MAX(idbitacora) AS id FROM bitacora as a WHERE a.estado = 1 AND a.tipobitacora=2;";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					echo "idRV: ".$row['id']."<br />";
					return $row['id'];
				}
			}
		return true;
		}

		//Función que agrega las cargas que se realizan
		function agregarKmCarga($fecha,$carga){
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO kmcarga(
								fechacarga
								,kmcarga
								,estado
							)VALUES(
								'".$fecha."'
								,'".$carga."'
								,1);
							";
			$conexion = new Conexion();
			//Se reliza el registro o se envía error
			print_r($texto);
			echo "<br />";
			$conexion->query($texto);
			//Obtener el último registro en agregarse
			$texto="SELECT MAX(idkmcarga) AS id FROM kmcarga as a WHERE a.estado = 1;";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					return $row['id'];
				}
			}
			return true;
		}

		//Función para agregar en la tabla del registro de las Bitacoras
		function registroBitacora($idBitacora,$idkmCarga){
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO regbitacora(
								idbitacora
								,idkmcarga
							)VALUES(
								".$idBitacora."
								,".$idkmCarga.");
							";
			$conexion = new Conexion();
			//Se reliza el registro o se envía error
			print_r($texto);
			echo "<br />";
			$conexion->query($texto);
			return true;
		}
		//Función para calcular los litros de la gasolina MAGNA
		function calcularLtGasMagna($pago){
			setlocale(LC_TIME, "spanish");
			$mes = date("m");// Mes actual en texto
			$mesActual = strftime("%B",mktime($mes));

			$texto = "SELECT
						  a.precio AS 'precio'
					  FROM
						  gasolina AS a
						  INNER JOIN mes AS b ON b.idmes = a.idmes
					  WHERE
						  a.tipogasolina = 1
						  AND b.nombre = '".$mesActual."'
						  AND a.estado = 1
						  AND b.estado = 1;
					";
			$conexion = new Conexion();
			$precio = $conexion->devolverDato($texto,"precio"); //Se obtiene el precio de la gas de la BD
			echo "PRECIO: ".$precio."<br>";
			//$fecha=devolverDato($texto,"fecha");

			//Se calculan los Lt de gasolina
			$litros = $pago/$precio;
			$lt = round($litros,2); // Se redondea el resultado que arroje

			return $lt;
		}
		//Función para calcular los litros de la gasolina PREMIUM
		function calcularLtGasPremium($pago){
			setlocale(LC_TIME, "spanish");
			$mes = date("m");// Mes actual en texto
			$mesActual = strftime("%B",mktime($mes));

			$texto = "SELECT
						  a.precio AS 'precio'
					  FROM
						  gasolina AS a
						  INNER JOIN mes AS b ON b.idmes = a.idmes
					  WHERE
						  a.tipogasolina = 2
						  AND b.nombre = '".$mesActual."'
						  AND a.estado = 1
						  AND b.estado = 1;
					 ";
			$conexion = new Conexion();
		 	$precio = $conexion->devolverDato($texto,"precio"); //Se obtiene el precio de la gas de la BD
			echo "PRECIO: ".$precio."<br>";

			//Se calculan los Lt de gasolina
			$litros = $pago/$precio;
			$lt = round($litros,2); // Se redondea el resultado que arroje

			return $lt;
		}

		// Función para saber el tipo de gasolina que usa el automovil de acuerdo al conductor
		function tipogasolinaCondu($idC){
			$texto = "SELECT
									d.tipogasolina AS 'tipo'
								FROM
									conductor AS a
									INNER JOIN automovil AS b ON a.idconductor = b.idconductor
									INNER JOIN consumible AS c ON b.idautomovil = c.idautomovil
									INNER JOIN gasolina AS d ON d.idgasolina = c.idgasolina
								WHERE
									a.idconductor = ".$idC."
									AND a.estado = 1
									AND b.estado = 1;
							";
			$conexion = new Conexion();
			$tipoGas = $conexion->devolverDato($texto,'tipo');
				return $tipoGas;
		}
		// Función para devolver el id del consumible de acuerdo al id del conductor
		function idconsumibleConductor($idC){
			$texto = "SELECT
									c.idconsumible AS 'id'
								FROM
									conductor AS a
									INNER JOIN automovil AS b ON a.idconductor = b.idconductor
									INNER JOIN consumible AS c ON b.idautomovil = c.idautomovil
								WHERE
									a.idconductor = 1
									AND a.estado = 1
									AND b.estado = 1;
								";
			$conexion = new Conexion();
			$idCons = $conexion->devolverDato($texto,'id');
			return $idCons;
		}
		//Función agregar la carga del consumible de la Bita./Consumible, tabla cargaconsumible
		function agregarCargaConsumible($lt,$pago,$idconsumible){
			$conexion = new Conexion();
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO cargaconsumible(
								litros
								,pesos
								,estado
								,idconsumible
							)VALUES(
								".$lt."
								,".$pago."
								,1
								,".$idconsumible.");
							";
			print_r($texto);
			echo "<br />";
			//Se reliza el registro o se envía error
			$conexion->query($texto);
			return true;
		}

		//Función para calcular los KM-Recorridos (lts en km)
		function calcularKmRecorridos($lt,$idC){
			$texto = "SELECT
									b.rendimiento as 'rendimiento'
								FROM
									conductor AS a
									INNER JOIN automovil AS b ON b.idconductor = a.idconductor
								WHERE
									a.idconductor = ".$idC."
									AND a.estado = 1
									AND b.estado = 1;
							";
			$conexion = new Conexion();
			$rendimiento = $conexion->devolverDato($texto,"rendimiento"); //Se obtiene el rendimiento del auto de la BD
			echo "Rendimiento: ".$rendimiento."<br />";

			//Se calculan los KM a recorrer
			$kmRecorrido = $lt * $rendimiento;
			$kmR = round($kmRecorrido,0); // Se redondea el resultado que arroje
			return $kmR;
		}

		//Función para calcular los km que rinde con esa gasolina (TOPE)
		function calcularKMRendidos($kmCarga,$kmRecorrido){
			$kmR = $kmCarga + $kmRecorrido;
			$kmRendimiento = round($kmR,0);
			echo "KMR: ".$kmRendimiento."<br>";
			return $kmRendimiento;
		}

		//Función para saber si hay registros en la tabla de kilometraje de acuerdo
		//con una carga determinada, esto con el fin de saber si será el primer reg.
		//de esa carga para que pase a KM inicial
		function existenciaRegCarga($idkmCarga){
			$texto = "SELECT
						  COUNT(*) as 'cuenta'
					  FROM
						  kilometraje AS a
						  INNER JOIN kmcarga AS b ON b.idkmcarga = a.idkmcarga
					  WHERE
						  a.idkmcarga = ".$idkmCarga."
						  AND a.estado = 1
						  AND b.estado = 1;
						  ";
			$conexion = new Conexion();
			if($conexion->devolverDato($texto,"cuenta") == "0") //Valida si hay un registro con dichos datos.
				return true;
			else
				return false;
		}

		//En caso que sea el primer registro de esa carga, la carga pasará a inicial en el kilometraje
		function cargaInicial($idB){
			$texto = "SELECT
							a.idkmcarga AS 'carga'
						FROM
							kmcarga AS a
							INNER JOIN regbitacora AS b ON b.idkmcarga = a.idkmcarga
							INNER JOIN bitacora AS c ON c.idbitacora = b.idbitacora
						WHERE
							c.idbitacora = ".$idB."
							AND a.estado = 1
							AND c.estado = 1;
					";
			$conexion = new Conexion();
			$carga = $conexion->devolverDato($texto,"carga"); //Se obtiene la fecha de la BD
			echo "carga: ".$carga."<br>";
			return $carga;
		}

		/// ------>   Cambios <-----

		//Función para calcular los km x día, es decir los km que recorrerá cada día, para calcular
		//el kmfinal posteriormente
		//NOTA: Éste funciona para ambos, el oficial y si el de apoyo sólo tiene una fecha registrada en el mes
		function calcularKmxDia($ltkm){
			$kmdia = $ltkm/5;
			$kmxdia = round($kmdia,1, PHP_ROUND_HALF_DOWN);
			return $kmxdia;
		}

		// SI ES DE APOYO Y SE ENCUENTRAN DOS FECHAS, calcular los días entre ambas para dividir
		function calcularDias($fecha_inicial,$fecha_final){
			$newArray = array();
			list($year,$mes,$dia) = explode("-",$fecha_inicial);
			$ini = mktime(0, 0, 0, $mes , $dia, $year);
			list($yearf,$mesf,$diaf) = explode("-",$fecha_final);
			$fin = mktime(0, 0, 0, $mesf , $diaf, $yearf);

			$r = 1;
			while($ini != $fin){
				$ini = mktime(0, 0, 0, $mes , $dia+$r, $year);
				$newArray[] .=$ini;
				$r++;
			}
			return $newArray;
		}

		// Una función que evalué el arreglo de fechas obtenido, que contenga los feriados nacionales que correspondan (restando) y que reste los sábados y domingos.

		static function EvaluarDias($arreglo){
			$newArray = array();

			$feriados = array(
					'1-1', // Año Nuevo
					'21-3', // Natalicio de Benito Juaréz
					'13-4', // Jueves Santo
					'14-4', // Viernes Santo
					'16-4', // Domingo de Resurrección
					'1-5', // Día del trbajo
					'16-9', // Día de la Independencia
					'2-11', //	Día de los Muertos
					'20-11', // Revolución Mexicana
					'24-12', // Noche buena
					'25-12', //	Día de Navidad
					);

			$j= count($arreglo);
			$dia_NoLab = 0;
			$dia = 0;

			for($i=0;$i<$j;$i++){
				$dia = $arreglo[$i];
				$fechaActual = date('Y-m-j',$dia);

				$fechadia = strtotime ('-1 day', strtotime($fechaActual));
				$fecha = getdate($fechadia);

				$feriado = $fecha['mday']."-".$fecha['mon'];

				$fechadia = date('Y-m-j',$fechadia);

				if($fecha["wday"]==0 or $fecha["wday"]==6){
					$dia_NoLab++;
				}
				elseif(in_array($feriado,$feriados)){
					$dia_NoLab++;
				}else {
					$newArray[$i]=$fechadia;
				}
			}
			$rlt = $j - $dia_NoLab;
			return $newArray;
		}

		//Esta función es para verificar que la fecha no este dentro del última semana
		// del mes
		function validarFecha($fecha){

		}
		//Se calcula el kmxdía si es el de apoyo, contando que tiene una fecha inicio y final
		// y calculados con las funciones anteriores
		function calcularDiasFechas($días,$ltkm){
			$kmdia = $ltkm/$días;
			$kmxdia = round($kmdia,1, PHP_ROUND_HALF_DOWN);
			return $kmxdia;
		}

		//Función para calcular el KmFINAL
		function calcularKmFinal($kminicial,$kmxdia){
			$final = $kminicial + $kmxdia;
			$kmFinal = round($final,1, PHP_ROUND_HALF_DOWN); // Se redondea el resultado que arroje
			echo "kmFINAL_MODELO: ".$kmFinal."<br />";
			return $kmFinal;

		}

		// Función para validar que los kmfinales sean menores que los km del rendimiento (TOPE);
		// o sea que no se pase del tope
		function validarRecorridos($kmFinal,$kmRecorrido){
			if($kmFinal <= $kmRecorrido)
				return true;
			else
				return false;
		}

		//Función para obtener el kminicial (ya con registros) mediante el kmfinal
		function obtenerKmInicial($idKM){
			$texto = "SELECT
						  a.kmfinal AS 'inicio'
					  FROM
						  kilometraje as a
						  INNER JOIN kmcarga AS b ON b.idkmcarga = a.idkmcarga
					  WHERE
						  a.idkilometraje = ".$idKM."
						  AND a.estado = 1
						  AND b.estado = 1;
				    ";
			$conexion = new Conexion();
			$inicio = $conexion->devolverDato($texto,"inicio"); //Se obtiene el km inicial de la BD
			echo "inicio: ".$inicio."<br>";
			return $inicio;
		}

		// Función para generar aleaoriamente las act. y des.
		function aleatorioActividad($idC){
			$texto = "SELECT
									b.idautorizacion_actividad AS 'id'
								FROM
									actividad as a
									INNER JOIN autorizacion_actividad AS b ON b.idactividad = a.idactividad
									INNER JOIN conductor AS c ON c.idconductor = b.idconductor
								WHERE
									c.idconductor = ".$idC."
								ORDER BY RAND() LIMIT 1;
					";
			$conexion = new Conexion();
			$idAct = $conexion->devolverDato($texto,"id"); //Se obtiene el id de la Act de la BD

			return $idAct;

		}

		// Función para generar aleaoriamente las act. y des.
		function aleatorioDestino($idC){
			$texto = "SELECT
									b.idautorizacion_destino AS 'id'
								FROM
									destino as a
									INNER JOIN autorizacion_destino AS b ON b.iddestino = a.iddestino
									INNER JOIN conductor AS c ON c.idconductor = b.idconductor
								WHERE
									c.idconductor = ".$idC."
								ORDER BY RAND() LIMIT 1;
					";
			$conexion = new Conexion();
			$idDes = $conexion->devolverDato($texto,"id"); //Se obtiene el id de la Des de la BD
			return $idDes;
		}

		//Función para registrar id las act y dest. y agregarlos en el registro
		function registroActDes($idC,$idDes,$idA,$idBita){
			//Se realiza el registro en la base de datos.
			$texto="INSERT INTO registro_conductor(
								idconductor
								,idautorizacion_destino
								,idautorizacion_actividad
								,idbitacora
							)VALUES(
								".$idC."
								,".$idDes."
								,".$idA."
								,".$idBita.");
							";
			//Se reliza el registro o se envía error
			$conexion = new Conexion();
			print_r($texto);
			echo "<br />";
			$conexion->query($texto);
		}

		//Función para recorrer las fechas, con 5 días posteriores a está
		//es decir, cuando se cuenta con UNA fecha
		function fechasCincoDias($fecha){
			$ArrayFechas = array();
			$cont = 0;

		  $fecha1 = strtotime($fecha);
		  $mod_date = strtotime($fecha."+5 days");

		  for($fecha1; $fecha1<$mod_date; $fecha1=strtotime('+1 day'.date('Y/m/d',$fecha1))){
		    if((strcmp(date('D',$fecha1),'Sun')==0) || (strcmp(date('D',$fecha1),'Sat')==0)){
		      $fecha1++;
		    }
				else{
		        $ArrayFechas[$cont] = date('Y/m/d',$fecha1);
		        $cont++;
		    }
		  }
		    return $ArrayFechas;
		}

		//Función para evaluar los días de 5 fechas
		static function EvaluarCincoDias($dia){
			$newArray = array();

			$feriados = array(
					'1-1', // Año Nuevo
					'21-3', // Natalicio de Benito Juaréz
					'13-4', // Jueves Santo
					'14-4', // Viernes Santo
					'16-4', // Domingo de Resurrección
					'1-5', // Día del trbajo
					'16-9', // Día de la Independencia
					'2-11', //	Día de los Muertos
					'20-11', // Revolución Mexicana
					'24-12', // Noche buena
					'25-12', //	Día de Navidad
					);
			$dia_NoLab = 0;
			$i = 0;
			$nuevafecha = null;

			while($i<5){
				$dia = strtotime($dia);
				$fechaActual = date('Y-m-j',$dia);
				/*
				$dia = $arreglo[$i];
				$fechaActual = date('Y-m-j',$dia);

				$fechadia = strtotime ('-1 day', strtotime($fechaActual));
				$fecha = getdate($fechadia);

				$feriado = $fecha['mday']."-".$fecha['mon'];

				$fechadia = date('Y-m-j',$fechadia); */
				$fechadia = strtotime ('-1 day', strtotime($fechaActual));
				$fecha = getdate($fechadia);

				$feriado = $fecha['mday']."-".$fecha['mon'];
				$fechadia = date('Y-m-j',$fechadia);
				$nuevafecha = strtotime ( '+1 day' , $dia ) ;
				$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

				if($fecha["wday"]==0 or $fecha["wday"]==6){ //Si es fin de semana
					$dia_NoLab++;
				}
				elseif(in_array($feriado,$feriados)){ // Si es feriado
					$dia_NoLab++;
				}else {
					$i++;
					$newArray[$i]=$fechadia;
				}
				$dia = $nuevafecha;
			}
			return $newArray;
		}

		//Funciòn para contar los elementos de un array
		static function contarArreglo($request){
			return count($request);
		}

		//Función para obtener una hora aleatoria entre el horario laboral, es decir de 9:00 a 17:00 hrs
		function horaAleat(){
			$ArrayHoras = array();
		  $cont = 0;
		    $hrIni=strtotime("09:00");
		    $hrFin=strtotime("17:00");
		    for($i=$hrIni; $i<=$hrFin; $i+=2400){
		      $aleat = rand($hrIni,$hrFin); //rand(mínimo,máximo);
		      $ArrayHoras[$cont] = date("H:00", $aleat);
		      $cont++;
		    }
		  return $ArrayHoras;
		}

		//Función para agregar el Kilometraje
		function agregarKilometraje($fecha,$hora,$kminicio,$kmfinal,$idKmCarga){ //PENDIENTE //
			$conexion = new Conexion();
			//Se realiza el registro en la base de datos
			$texto="INSERT INTO kilometraje(
								fecha
								,hora
								,kminicial
								,kmfinal
								,estado
								,idkmcarga
							)VALUES(
								'".$fecha."'
								,'".$hora."'
								,".$kminicio."
								,".$kmfinal."
								,1
								,'".$idKmCarga."');
							";
			//Se reliza el registro o se envía error
			print_r($texto);
			echo "<br />";
			$conexion->query($texto);
			//Obtener el último registro en agregarse
			$texto="SELECT MAX(idkilometraje) AS id FROM kilometraje as a WHERE a.estado = 1;";
			if ($rows =$conexion->query($texto)) {
				foreach ($rows as $row ) {
					echo "idkm: ".$row['id']."<br />";
						return $row['id'];
				}
			}
		return true;
		}

		//Función para verificar si hay registros de cargas del mismo mes
		function valExistenciaCargas(){ // NOOOOOOOOOOOO
			setlocale(LC_TIME, "spanish");
			$mes = date("m");// Mes actual en texto
			$mesActual = strftime("%B",mktime($mesActual));

			$texto = "SELECT
						  COUNT(*) as 'cuenta'
					  FROM
						  bitacora AS a
						  INNER JOIN regbitacora AS b ON b.idbitacora = a.idbitacora
						  INNER JOIN kmcarga AS c ON c.idkmcarga = b.idkmcarga
					  WHERE
						  a.mesresgistro = '".$mesActual."'
						  AND a.estado = 1
						  AND c.estado = 1;
				     ";
			$conexion = new Conexion();
			if($conexion->devolverDato($texto,"cuenta") == "0") //Valida si hay registros de ese mes, si es 0 no hay ninguno
				return true;
			else
				return false;
		}
	}
?>
