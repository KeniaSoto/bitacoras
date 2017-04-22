<?php
	require_once("../modelo/bitacora.php");
	
	if(isset($_POST['funcion'])){
		$funcion = addslashes(trim($_POST['funcion']));
		switch($funcion){
			case 'agregarBitacora':
				dos();
			break;
		}	
	}
	
	function agregar_bitacora(){
		$bita = new Bitacora();
		
		if(isset($_POST['date']) && isset($_POST['pago']) && isset($_POST['km'])){
			$fechaCarga = $_POST['date'];
			$pagoGas = (int)($_POST['pago']);
			$kmCarga = (int)($_POST['km']);
			
			if(!empty($fechaCarga) && !empty($pagoGas) && !empty($kmCarga)){
				
			}else{
				echo '<script language="javascript"> alert("Existen campos vacíos");</script>';
			}
		}
		
		$fecha1 = strtotime('2016-12-01'); 
		$fecha2 = strtotime('2016-12-12');
		for($fecha1;$fecha1<$fecha2;$fecha1=strtotime('+1 day'.date('Y-m-d',$fecha1))){ 
			if((strcmp(date('D',$fecha1),'Sun')==0) || (strcmp(date('D',$fecha1),'Sat')==0)){
				$fecha1++;
			}
			else{
					$fecha= date('Y-m-d',$fecha1);
					echo "<br/>".$fecha;
			}
		}
	}
	function h(){
		$hrIni=strtotime("09:00");
		$hrFin=strtotime("18:00");
		for($i=$hrIni; $i<$hrFin; $i+=2400){
			$aleat = rand($hrIni,$hrFin);
			$hr = date("H:00", $aleat);
			echo "<br/>".$hr;
		}
	}
	function p($date){
		$d =$date;
		//echo '<br/>'.$d;
		return $d;
	}
	function hr($hora){
		$h = $hora;
		//echo '<br/>'.$h;
		return $h;
	}
	
	function x(){
		$fecha = date('2017-01-12');
		$nuevafecha = strtotime ( '+6 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		
		for($fecha; $fecha < $nuevafecha; $fecha1=strtotime('+1 day'.date('Y-m-d',$fecha1))){
			echo "<br/> fecha: ".$nuevafecha;
		}
		
	}
	
	function dos(){
		agregar_bitacora();
		h();
		x();
		
	}
?>