<?php 

class Persona{

	public $ci; 
	public $nombre; 
	public $paterno; 
	public $materno;
	public $sexo;
	public $telefono; 
	public $celular; 
	public $fechaNac; 
	public $direccion; 

	public function __construct($ci,$nombre,$paterno,$materno,$sexo,$telefono,$celular,$fechaNac,$direccion)
	{
		$this->ci= $ci ;
		$this->nombre=$nombre; 
		$this->paterno=$paterno; 
		$this->materno=$materno; 
		$this->sexo=$sexo; 
		$this->telefono=$telefono; 
		$this->celular=$celular; 
		$this->fechaNac=$fechaNac; 
		$this->direccion=$direccion; 
	}

	public function mostarPersona(){
		$res = $this->ci;
				$this->nombre; 
				$this->paterno; 
				$this->materno ; 
				$this->sexo; 
				$this->telefono; 
				$this->celular; 
				$this->fechaNac; 
				$this->direccion; 

		return $res;
	}
	public static function getpersonabyci($ci){
		$sql = "SELECT * FROM  persona p WHERE p.ci=:id ;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id",$ci,PDO::PARAM_INT);
		if($stmt->execute()){
			return $stmt->fetch();
		}
		
	}
}