<?php 

class Paciente extends Persona{
	
	public $estado;
	public $lugarNacimiento;

	public function Paciente($ci, $nombre, $paterno, $materno, $sexo, $telefono, $celular, $fechaNac, $direccion,$estado,$lugarNacimiento) {
		parent::__construct($ci, $nombre, $paterno, $materno, $sexo, $telefono, $celular, $fechaNac, $direccion);
		$this->estado = $estado;
		$this->lugarNacimiento = $lugarNacimiento;

	}
	
	public function add(){

		$sql = "CALL insert_Paciente(:ci,:nombre,:paterno,:materno,:sexo,:telefono,:celular,:direccion,:fecha_nac,:lugar_nac,:estado);";
		// mostrarPacientes();
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":ci", $this->ci,PDO::PARAM_INT);
		$stmt->bindValue(":nombre",$this->nombre,PDO::PARAM_STR);
		$stmt->bindValue(":paterno", $this->paterno,PDO::PARAM_STR);
		$stmt->bindValue(":materno",$this->materno,PDO::PARAM_STR);
		$stmt->bindValue(":sexo", $this->sexo,PDO::PARAM_STR);
		$stmt->bindValue(":telefono",$this->telefono,PDO::PARAM_INT);
		$stmt->bindValue(":celular", $this->celular,PDO::PARAM_INT);
		$stmt->bindValue(":direccion",$this->direccion,PDO::PARAM_STR);
		$stmt->bindValue(":fecha_nac", $this->fechaNac,PDO::PARAM_STR);
		$stmt->bindValue(":lugar_nac",$this->lugarNacimiento,PDO::PARAM_STR);
		$stmt->bindValue(":estado", $this->estado,PDO::PARAM_STR);

		if($stmt->execute()){
			return "true";
		}else {

		return "false";
		}
	}

	public function edit(){ return $this->add(); }


	public function deletePaciente(){
		$sql="update paciente set paciente.estado_pac='b' where paciente.ci_pac=$this->ci";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		if ($stmt->execute()) {
			return "true";
		}else{
			return "false";
		}
	}
	public function cambiarEstado(){

	}



	public static function mostrarPacientes(){

		$sql = "Select per.ci,per.nombre_per,per.paterno,per.sexo,per.telefono,per.celular,per.fecha_nac,per.direccion,p.lugar_nac,p.estado_pac from paciente p, persona per where p.ci_pac = per.ci;";

		$con = Database::getConexion();
		$stmt = $con->prepare($sql);

		$stmt->execute();

		return $stmt->fetchAll();
	}

	public static function getPacienteByCI($ci){
		$sql = "Select * from paciente p ,persona per where per.ci = p.ci_pac and per.ci = :ci;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function existePaciente($ci){
		$sql = "Select count(*) from paciente p ,persona per where per.ci = p.ci_pac and per.ci = :ci;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci,PDO::PARAM_INT);
	    $stmt->execute();
		return $stmt->fetch();

	}

	public function actualizarUnaColumna($nombreColm, $value){

	}

	public function mostrarPaciente(){

		$res=   $this->ci ."\n".
				 $this->nombre ."\n".
				 $this->paterno ."\n".
				 $this->materno ."\n".
				 $this->sexo ."\n".
				 $this->telefono ."\n".
				 $this->celular ."\n".
				 $this->fechaNac ."\n".
				 $this->direccion ."\n".
				 $this->estado ."\n".
				 $this->lugarNacimiento; 
		return " ".$res;	
	}


}