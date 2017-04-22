<?php
	require_once("../modelo/bitacora.php");
	if(!isset($_SESSION)){
			 session_start();
	 }else{
			 session_destroy();
	 }

	if(isset($_POST['funcion'])){
		$funcion = addslashes(trim($_POST['funcion']));
		switch($funcion){
			case 'agregarBitacora':
				agregar_bitacora();
			break;
		}
	}

	function agregar_bitacora(){
		$bita = new Bitacora();
		$valArray = json_decode($_POST['valArray']);

		$idL = $_SESSION['id'];
		$idC = $bita->idConductor($idL);

		foreach($valArray  as $campos){
			//var_dump($campos); // me ayuda para saber qué tipo de dato recibo
			$date = $campos->date;
			$kmCarga = $campos->km;
			$pagoGas = $campos->pago;
		}
			//Se verifica qué tipo de conductor es 1. Oficial y 2. De apoyo
			if($bita->obtenerTipoCond($idC) == 1){
				echo "Entrooo";

			}else{
				echo "es tipo 2";
				//$idBitaCom = $bita->agregarBitacoraCombustible($idC); // Recuperar el id de la bitacora de combustible
				//$idKMCarga = $bita->agregarKmCarga($date,$kmCarga);
				//$idConsm = $bita->idconsumibleConductor($idC);

				//Registro de la Bitácora de Combustible
				//$bita->registroBitacora($idBitaCom,$idKMCarga);

				//Se verifica el tipo de Gasolita del automovil del conductor
				if($bita->tipogasolinaCondu($idC) == 1){
					echo "ES MAGNA <br />";
					/*$ltMagna = $bita->calcularLtGasMagna($pagoGas);
					$bita->agregarCargaConsumible($ltMagna,$pagoGas,$idConsm);

					//Registro de la bitácora Recorrido/Viaje
					$idBitaRV = $bita->agregarBitacoraRecorrido($idC);
					//Registro de la Bitácora de Combustible
					$bita->registroBitacora($idBitaRV,$idKMCarga); */

				}else{
					$valores = 0;
					echo "ES PREMIUM <br />";
					$valores = Bitacora::contarArreglo($valArray);
					echo "Cuenta: ".$valores."<br />";
					if($valores == 1){

					}
					// Evalua si son dos fechas
					if($valores == 2){
						echo "si funcó... al parecer <br />";
						$inicio = $valArray[0]->date;
						$fin = $valArray[1]->date;
						echo "F_INICIO: ".$inicio."<br />";
						echo "F_FIN: ".$fin."<br />";
						$evalua = $bita->calcularDias($inicio,$fin);
						$diasF = Bitacora::EvaluarDias($evalua);
						$totalDias = Bitacora::contarArreglo($diasF);
						echo "total: ".$totalDias;
						print_r($diasF);
					}

					echo "LTP: ".$ltPremium."</br>";
					$bita->agregarCargaConsumible($ltPremium,$pagoGas,$idConsm);

					//Registro de la bitácora Recorrido/Viaje
					$idBitaRV = $bita->agregarBitacoraRecorrido($idC);
					//Registro de la Bitácora de Combustible
					$bita->registroBitacora($idBitaRV,$idKMCarga);

					// Se comienzan a realizar las operaciones
					$ltkm = $bita->calcularKmRecorridos($ltPremium,$idC); // Litros en kilometros
					echo "ltKM: ".$ltkm."</br>";
					$kmTope = $bita->calcularKMRendidos($kmCarga,$ltkm); // Cuál es el tope, o sea cuántos km rinde con esa gasolina
					echo "kmTOPE: ".$kmTope."</br>";
					$kmxdia = $bita->calcularKmxDia($ltkm); // Cuántos km x día recorrerá
					echo "KMdía: ".$kmxdia."</br>";

					//Aquí estaba el IF :v
						//Calcular el kmfinal
						$kmfinal = $bita->calcularKmFinal($kmCarga,$kmxdia);
						echo "kmFinal1: ".$kmfinal."</br>";
						$kminicial = $kmCarga;

						$arrayFechas = $bita->fechasCincoDias($date);
						$arrayHoras = $bita->horaAleat();

						if($bita->validarRecorridos($kmfinal,$kmTope) == true){
							echo "ENTRO IFTOPE <br/>";
							for ($i=0; $i<sizeof($arrayFechas); $i++) {
							   $fecha = $arrayFechas[$i];
							   $hora = $arrayHoras[$i];

								 // Generar los destinos y actividades aleatoriamente
								 $idDes = $bita->aleatorioDestino($idC);
		 						 $idAct = $bita->aleatorioActividad($idC);
								 $bita->registroActDes($idC,$idDes,$idAct);

								 $idkm = $bita->agregarKilometraje($fecha,$hora,$kminicial,$kmfinal,$idKMCarga);
								 $kminicial = $bita->obtenerKmInicial($idkm);

								 echo "KMINI2: ".$kminicial."</br>";
								 $kmfinal = $bita->calcularKmFinal($kminicial,$kmxdia);
								 echo "KMfinal2: ".$kmfinal."</br>";
							}
							return $kmfinal;
					}else{
						echo "BYE";
					}
				}

			}
	}
?>
