<?php 
class Odontologo extends Persona {
	
	public $estado ; 

	public function Odontologo($ci , $nombre ,$paterno , $materno , $sexo , $telefono , $celular, $fechaNac , $direccion, $estado){
		parent::__construct($ci , $nombre , $paterno , $materno , $sexo, $telefono, $celular , $fechaNac , $direccion);
		$this->estado= $estado;
	}

	public static function mostrarOdontologo(){
		// $sql="select * from persona";
		$sql="select persona.ci, persona.nombre_per, persona.paterno , persona.materno, persona.sexo, persona.telefono, persona.direccion, persona.celular, persona.fecha_nac, odontologo.estado_odon from persona , odontologo where odontologo.ci_odont=persona.ci";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		if ($stmt->execute()) {
			// echo '<pre>'; print_r("exito"); echo '</pre>';

			return $stmt->fetchAll();
		}else{ 
			echo '<pre>'; print_r("MAL"); echo '</pre>';
		}


	}

	public  function addOdontologo(){
		
		$con=Database::getConexion(); 
		$stmt=$con->prepare(" CALL insertarOdontologo(:ci,:nombre,:paterno,:materno,:sexo,:telefono,:celular,:direccion,:fechaNac,:estado);"); 
		$stmt->bindValue(":ci", $this->ci,PDO::PARAM_INT);
		$stmt->bindValue(":nombre", $this->nombre,PDO::PARAM_STR);
		$stmt->bindValue(":paterno", $this->paterno,PDO::PARAM_STR);
		$stmt->bindValue(":materno", $this->materno,PDO::PARAM_STR);
		$stmt->bindValue(":sexo", $this->sexo,PDO::PARAM_STR);
		$stmt->bindValue(":telefono", $this->telefono,PDO::PARAM_INT);
		$stmt->bindValue(":celular", $this->celular,PDO::PARAM_INT);
		$stmt->bindValue(":direccion", $this->direccion,PDO::PARAM_STR);
		$stmt->bindValue(":fechaNac", $this->fechaNac,PDO::PARAM_STR);
		$stmt->bindValue(":estado", $this->estado,PDO::PARAM_STR);

		if ($stmt->execute()){
			echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}

	}

	public function deleteOdontologo(){
		$sql="update odontologo set odontologo.estado_odon='b' where odontologo.ci_odont=$this->ci";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->execute();
		return true;
		
	}
	

	public static function getOdontologoByCI($ci){

		$sql = "Select * from odontologo,persona where persona.ci = odontologo.ci_odont and persona.ci= :ci;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();

	}

	public function edit(){
		return $this->addOdontologo();
	}
	public static function getOdontobyAgenda($id_agenda){
		$sql = "Select * from odontologo,persona,agenda where persona.ci = odontologo.ci_odont and agenda.ci_odont=odontologo.ci_odont and agenda.id_age=:id_agenda;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_agenda",$id_agenda,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();

	}




}

 ?>