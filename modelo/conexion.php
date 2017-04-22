<?php

	function conectar(){
		$server = "localhost";
		$user = "root";
		$password = "";
		$bd = "bitacora";

		$conexion = mysqli_connect($server,$user,$password,$bd);
		mysqli_set_charset($conexion, "utf8");

		if (mysqli_connect_errno()) {
			echo "Error 404";
		}
		return $conexion;
		mysqli_close($conexion);
	}

	function devolverFila($string,$campo){
		$con = conectar();
		$query = mysqli_query($con,$string);
		$fila = mysqli_fetch_assoc($query);
		return $fila;
	}

	function devolverDato($string,$campo){
		$con = conectar();
		$query = mysqli_query($con,$string);

		if(mysqli_num_rows($query) > 0){
			$fila = mysqli_fetch_assoc($query);
			return $fila[$campo];
		}
		return 0;
	}
?>
