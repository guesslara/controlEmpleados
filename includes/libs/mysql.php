<?php
/*
*Clase para el manejo de las operaciones con la base de datos
*/
class mysql{

	private $hostBd="";
	private $usuarioBd="";
	private $passBd="";
	private $bd="";
	private $puerto="";
	private $link="";
	private $query="";
	private $result="";

	function __construct($host,$usuarioBd,$passBd,$bd,$puerto){
		$this->hostBd=$host;
		$this->usuarioBd=$usuarioBd;
		$this->passBd=$passBd;
		$this->bd=$bd;
		$this->puerto=$puerto;
		$this->conexionBd();
	}

	private function conexionBd(){
		$this->link = mysqli_connect($this->hostBd,$this->usuarioBd,$this->passBd,$this->bd);
		if(!$this->link)
			echo "Error al realizar la conexion con la base de datos";
	}
	//consulta que ejecuta las consultas a la base de datos
	public function ejecutarQuery($sql){
		$sql=@mysqli_query($this->link,$sql);
		
		if(!$sql){
			echo "Error no.".mysqli_errno($this->dbconn);
		}else{
			return $sql;
		}
	}

	public function regresaResulatdos($result){
		return @mysqli_fetch_array($result);
	}

	public function numeroRegistros($result){
		return @mysqli_num_rows($result);
	}

	public function liberarResultado($result){
		return @mysqli_free_result($result);
	}	
}
?>