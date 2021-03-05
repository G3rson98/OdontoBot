<?php 
class Agenda{
	public $id_agenda; 
	public $id_odontologo; 

	public static function mostrarFichasDia($id_odontologo){
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$fechaco = $fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"];
		$sql="select * from ficha,agenda where ficha.id_agen=agenda.id_age and agenda.ci_odont=:ci_odont and ficha.fecha_fic=:fecha;";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":ci_odont", $id_odontologo, PDO::PARAM_STR);
		$stmt->bindValue(":fecha", $fechaco, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();	
	}

		public static function mostrarFichasMes($id_odontologo){
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$fechaini = $fecha["year"] . "-" . $fecha["mon"] . "-" . "01";
		$fechafin = $fecha["year"] . "-" . $fecha["mon"] . "-" . "31";
		$sql="select * from ficha,agenda where ficha.id_agen=agenda.id_age and agenda.ci_odont=:ci_odont and ficha.fecha_fic>=:fi and ficha.fecha_fic<=:ff";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":ci_odont", $id_odontologo, PDO::PARAM_STR);
		$stmt->bindValue(":fi", $fechaini, PDO::PARAM_STR);
		$stmt->bindValue(":ff", $fechafin, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();	
		}

		public static function mostrarFichasAño($id_odontologo){
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$fechaini = $fecha["year"] . "-" . "01" . "-" . "01";
		$fechafin = $fecha["year"] . "-" . "12" . "-" . "31";
		$sql="select * from ficha,agenda where ficha.id_agen=agenda.id_age and agenda.ci_odont=:ci_odont and ficha.fecha_fic>=:fi and ficha.fecha_fic<=:ff";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":ci_odont", $id_odontologo, PDO::PARAM_STR);
		$stmt->bindValue(":fi", $fechaini, PDO::PARAM_STR);
		$stmt->bindValue(":ff", $fechafin, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();	
		}

		public static function getServicioDeFicha($id_ficha){
		$sql="select ficha_serv.id_serv from ficha_serv where ficha_serv.id_ficha=:ficha";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":ficha", $id_ficha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		}


}



 ?>