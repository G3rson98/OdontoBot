<?php 
	class OdontologoEspecialidad{
		private $id_esp;
		private $ci_odont;

		public function OdontologoEspecialidad($id_esp,$ci_odont){
			$this->id_esp=$id_esp; 
			$this->ci_odont=$ci_odont; 
		}

		public function mostrarOdontologoEspecialidad($ci_odont){
			$sql="select * from odont_espe,especialidad,odontologo where odont_espe.id_espe=especialidad.id_esp and odontologo.ci_odont=odont_espe.ci_odont and odontologo.ci_odont=:ci_odont";
			$con=Database::getConexion();
			$stmt=$con->prepare($sql);
			$stmt->bindValue(":ci_odont", $ci_odont,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		public function mostrarEspecialidadesNoAsignadas($ci_odont){
			$con=Database::getConexion();
			$sql="select * from especialidad where especialidad.id_esp not in(select odont_espe.id_espe from odont_espe,odontologo where odont_espe.ci_odont=odontologo.ci_odont and odontologo.ci_odont=:ci_odont)";
			$stmt=$con->prepare($sql);
			$stmt->bindValue(":ci_odont", $ci_odont,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		public function addOdontologoEspecialidad(){
			$con=Database::getConexion();
			$sql="insert into odont_espe(odont_espe.ci_odont,odont_espe.id_espe) values(:ci_odont,:id_esp)";
			$stmt=$con->prepare($sql);
			$stmt->bindValue(":ci_odont", $this->ci_odont,PDO::PARAM_STR);
			$stmt->bindValue(":id_esp", $this->id_esp,PDO::PARAM_INT);
			if ($stmt->execute()){
				return true;

			}else{
				return false;
			}
		
		}
	}






 ?>