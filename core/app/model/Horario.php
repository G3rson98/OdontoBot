<?php 

class Horario{

	private $id;
	private $dia;
	private $horaInicio;
	private $horaFin;
	private $estado;

	public function Horario($idHorario,$dia, $horaInicio,$horaFin,$estado){

		$this->id = $idHorario;
		$this->dia = $dia;
		$this->horaInicio = $horaInicio;
		$this->horaFin = $horaFin;
		$this->estado = $estado;
	}

	public function add(){
		$sql = "INSERT INTO `horario`(`id_hor`, `hra_inicio`, `hra_fin`, `dia`, `estado`) VALUES (null,:horaInicio,:horaFin,:dia,:estado);";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql); 
		$stmt->bindValue(":horaInicio", $this->horaInicio,PDO::PARAM_STR);
		$stmt->bindValue(":horaFin", $this->horaFin,PDO::PARAM_STR);
		$stmt->bindValue(":dia", $this->dia,PDO::PARAM_STR);
		$stmt->bindValue(":estado", $this->estado,PDO::PARAM_STR);

		if ($stmt->execute()) {
			echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;
		}
		return false;

	}

	public function edit(){
		$sql = "UPDATE `horario` SET `hra_inicio`=:horaInicio,`hra_fin`=:horaFin,`dia`=:dia,`estado`=:estado WHERE `id_hor`=:id;";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql); 
		$stmt->bindValue(":horaInicio", $this->horaInicio,PDO::PARAM_STR);
		$stmt->bindValue(":horaFin", $this->horaFin,PDO::PARAM_STR);
		$stmt->bindValue(":dia", $this->dia,PDO::PARAM_STR);
		$stmt->bindValue(":estado", $this->estado,PDO::PARAM_STR);
		$stmt->bindValue(":id", $this->id,PDO::PARAM_STR);

		if ($stmt->execute()) {
			echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;
		}
		return false;


	}

	public static function mostrarHorarios(){

		$sql = "SELECT * FROM horario;";
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql); 
		
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function mostrarHorarioNoAsignado($ci_odont){
		$sql = "select * from horario where horario.id_hor not in(
				select distinct(horario.id_hor) from odontologo,odontologo_horario,horario where odontologo.ci_odont=odontologo_horario.ci_odont and odontologo_horario.id_hor=horario.id_hor and odontologo.ci_odont=:ci_odont);";
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql); 
		$stmt->bindValue(":ci_odont", $ci_odont,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function getHorarioById($id){
		$sql = "SELECT * FROM horario WHERE id_hor = :id;";
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql); 
		$stmt->bindValue(":id", $id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function toString(){
		return  $this->id ."\n".
				$this->dia ."\n".
				$this->horaInicio ."\n".
				$this->horaFin ."\n".
				$this->estado ."\n";
				 
		
	}



}

