<?php 
class Recepcionista extends Persona {
	
	public $estado ; 

	public function Recepcionista($ci , $nombre ,$paterno , $materno , $sexo , $telefono , $celular, $fechaNac , $direccion, $estado){
		parent::__construct($ci , $nombre , $paterno , $materno , $sexo, $telefono, $celular , $fechaNac , $direccion);
		$this->estado= $estado;
	}

	public static function mostrarRecepcionista(){
		// $sql="select * from persona";
		$sql="select persona.ci, persona.nombre_per, persona.paterno , persona.materno, persona.sexo, persona.telefono, persona.direccion, persona.celular, persona.fecha_nac, recepcionista.estado_rec from persona , recepcionista where recepcionista.ci_rec=persona.ci";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		if ($stmt->execute()) {
			echo '<pre>'; print_r("exito"); echo '</pre>';

			return $stmt->fetchAll();
		}else{ 
			echo '<pre>'; print_r("MAL"); echo '</pre>';
		}


	}

	public  function addRecepcionista(){
		$con=Database::getConexion(); 
		$stmt=$con->prepare(" CALL insertarRecepcionista(:ci,:nombre,:paterno,:materno,:sexo,:telefono,:celular,:direccion,:fechaNac,:estado);"); 
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
		}

	}

	public function deleteRecepcionista(){
		$sql="update recepcionista set recepcionista.estado_rec='b' where recepcionista.ci_rec=$this->ci";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		if ($stmt->execute()) {
			return "true";
		}else{
			return "false";
		}
	}

	public static function getRecepcionistaByCI($ci){

		$sql = "Select * from recepcionista,persona where persona.ci = recepcionista.ci_rec and persona.ci= :ci;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();

	}

	public function edit(){
		return $this->addRecepcionista();
	}

}