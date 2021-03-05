<?php 
class Especialidad { 
	private $id_esp;
	public $nombre_esp;
	public $estado_espe;

	public function Especialidad($id_esp,$nombre_esp,$estado_espe){
		$this->id_esp=$id_esp;
		$this->nombre_esp=$nombre_esp;
		$this->estado_espe=$estado_espe;
	}

	public function mostrarEspecialidad(){
		$sql="select * from especialidad";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function addEspecialidad(){
		$con=Database::getConexion(); 
		$sql="insert into especialidad values(null,:nombre_esp,:estado_espe);";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":nombre_esp", $this->nombre_esp,PDO::PARAM_STR);
		$stmt->bindValue(":estado_espe", $this->estado_espe,PDO::PARAM_STR);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function getEspecialidadByID($id){
		$con=Database::getConexion(); 
		$sql="select * from especialidad where especialidad.id_esp=:id";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":id", $id,PDO::PARAM_INT);
		$stmt->execute(); 
		return $stmt->fetch();
	}


	public function editEspecialidad(){
		$con=Database::getConexion(); 
		$sql="update especialidad set especialidad.nombre_esp=:nombre_esp where especialidad.id_esp=:id_esp";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":id_esp", $this->id_esp,PDO::PARAM_INT);
		$stmt->bindValue(":nombre_esp", $this->nombre_esp,PDO::PARAM_STR);
		if ($stmt->execute()){
			return true;
		}else
		{
			return false;
		}
	}

	public function deleteEspecialidad(){
		$con=Database::getConexion(); 
		$sql="update especialidad set especialidad.estado_espe=:estado_espe where especialidad.id_esp=:id_esp";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":id_esp", $this->id_esp,PDO::PARAM_INT);
		$stmt->bindValue(":estado_espe", "b",PDO::PARAM_STR);
			if ($stmt->execute()){
			return true;
		}else
		{
			return false;
		}
	}

}




 ?>