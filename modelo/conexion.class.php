<?php
	/**
	* Database connect
	*/
	class Conexion{
		protected $conexion;
		protected $db;
		private $nombre_base;
		private $host;
		private $usuario;
		private $contra;
		private $mysqli;
		function __construct()
		{
			$this->nombre_base ="bitacora";
				$this->host        ="localhost";
				$this->usuario     ="root";
				$this->contra      ='';
				$this->mysqli      =null;
		}

		public function connect()
		{
			$this->mysqli = new mysqli($this->host, $this->usuario, $this->contra, $this->nombre_base);
			if ($this->mysqli->connect_errno) {
				$mensaje .= "Errno: " . $this->mysqli->connect_errno . "\n";
				exit(json_encode(array('err' => $mensaje)));
			}
			$this->mysqli->set_charset("utf8");

			return true;

		}
		function __destruct()
		{
			if($this->mysqli)$this->mysqli->close();
		}
		function query($sql){
			$this->connect();
			//$sql = eregi_replace("[\n|\r|\n\r]", ' ', $sql);
			//$sql = $this->mysqli->real_escape_string($sql);
			if (!$query =$this->mysqli->query($sql)) {
			    return false;
			}else {
				if ($query===true) {
					return true;
				}else{
					$rows = array();
					while($row = $query->fetch_assoc())
					{
						$rows[] = $row;
					}
					return $rows;
				}
			}
		}

		public function closeConnection()
		{
			if ($this->conectar->conexion) {
				mysql_close($this->$conexion);
			}

		}

		public function devolverDato($string,$campo){
			$this->connect();
			if ($rows =$this->mysqli->query($string)) {
				foreach ($rows as $row )
					$valor = $row[$campo]; //Se obtiene el id
					return $valor;
			}
		}
}

?>
