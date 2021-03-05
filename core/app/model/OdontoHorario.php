<?php 


Class OdontoHorario {

	private $ciOdont;
	private $horarios;
	private $nroConsul;

	public function OdontoHorario($ciOdo,$horarios,$nroConsul){
		$this->ciOdont = $ciOdo;
		$this->horarios = $horarios;
		$this->nroConsul = $nroConsul;

	}

	public static function getHorioDeOdontologo($ciOdont){

		$sql = "SELECT * FROM horario h, odontologo_horario oh where oh.ci_odont = :ci and h.id_hor = oh.id_hor;";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql); 
		$stmt->bindValue(":ci", $ciOdont,PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();

	}

	// public function insertarHorarioOdontologo(){

	// 	if( $this->deleteHorarioOdontologo() ){

	// 		$arrayHorarios = $this->horarios;
	// 		$length = count($arrayHorarios);
	// 		for ($i=0; $i < $length; $i++) {

	// 			$this->insertHorarioOdontologo($this->ciOdont,$arrayHorarios[$i]);	
	// 		}

	// 	}else{

	// 		echo '<pre>'; print_r("error delete"); echo '</pre>';
	// 	}




	// }

		public function insertarHorarioOdontologo(){

			$arrayHorarios = $this->horarios;
			$length = count($arrayHorarios);
			for ($i=0; $i < $length; $i++) {

				$this->insertHorarioOdontologo($this->ciOdont,$arrayHorarios[$i]);

			}

		}


	private  function deleteHorarioOdontologo(){
		$sql="DELETE FROM `odontologo_horario` WHERE `odontologo_horario`.`ci_odont` = :ciOdo";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql); 
		$stmt->bindValue(":ciOdo", $this->ciOdont,PDO::PARAM_STR);
		return $stmt->execute();
	}

	private function insertHorarioOdontologo($ciOdontologo,$idHorario){
		$sql="INSERT INTO `odontologo_horario`(`ci_odont`, `id_hor`, `nro_consultorio`) VALUES (:ciOdo,:idHor,NULL)";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql); 
		$stmt->bindValue(":ciOdo", $ciOdontologo,PDO::PARAM_STR);
		$stmt->bindValue(":idHor", $idHorario,PDO::PARAM_INT);
		return $stmt->execute();

	}





	
}