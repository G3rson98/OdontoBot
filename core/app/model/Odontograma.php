<?php 

class Odontograma {


	public static function crearOdontograma($idHist, $idCons){

		$id =Odontograma::getUltimoID()+1;

		$sql="INSERT INTO `odontograma`(`id_historial`, `id_consulta`, `id_odo`) VALUES (:idHis,:idCons,:id_odo)";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idHis", $idHist,PDO::PARAM_INT);
		$stmt->bindValue(":idCons", $idCons,PDO::PARAM_STR);
		$stmt->bindValue(":id_odo", $id,PDO::PARAM_INT);

		if($stmt->execute()){
			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return $id;
		}
	}

	public static function getUltimoID(){

		$sql="SELECT IFNULL(MAX(id_odo),0) from odontograma";
		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$rep=$stmt->fetch();
		return $rep[0];
	}

	public static function insertarPiezaDental($idOdot,$idD,$nombreDiente,$estadoPieza){

		if(!Odontograma::yaSeInsertoEstaPiezaDental($idOdot,$idD)){

		$sql="INSERT INTO `pieza_dental`(`id_odont`, `nro`, `nombre_pie`, `estado_actual`) VALUES (:idOdot,:idD,:nombrePieza,:estadoPieza)";
		}else{
			$sql = "UPDATE `pieza_dental` SET `nombre_pie`=:nombrePieza,`estado_actual`=:estadoPieza WHERE id_odont = :idOdot and nro=:idD;";
		}


		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idOdot", $idOdot,PDO::PARAM_INT);
		$stmt->bindValue(":idD", $idD,PDO::PARAM_INT);
		$stmt->bindValue(":nombrePieza", $nombreDiente,PDO::PARAM_STR);
		$stmt->bindValue(":estadoPieza", $estadoPieza,PDO::PARAM_STR);

		if($stmt->execute()){

			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return true;
		}
		echo '<pre>'; print_r('fallo'); echo '</pre>';	

	}

	public static function insertarCara_Dental($idOdot,$idD,$idCaraDental,$diagnostico,$estadoCaraDental){

		if(!Odontograma::yaSeInsertoEstaCaraDental($idOdot,$idD,$idCaraDental)){

			$sql="INSERT INTO `c_p_dental`(`id_odont`, `id_pieza`, `id_cara`, `estado_diag`, `estado_trat`) VALUES (:idOdot,:idD,:idCD,:diag,:estadoC)";
		}else{
			$sql="UPDATE `c_p_dental` SET `estado_diag`=:diag,`estado_trat`=:estadoC WHERE id_odont=:idOdot and id_pieza=:idD and id_cara=:idCD;";
		}


		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idOdot", $idOdot,PDO::PARAM_INT);
		$stmt->bindValue(":idD", $idD,PDO::PARAM_INT);
		$stmt->bindValue(":idCD", $idCaraDental,PDO::PARAM_INT);
		$stmt->bindValue(":diag", $diagnostico,PDO::PARAM_STR);
		$stmt->bindValue(":estadoC", $estadoCaraDental,PDO::PARAM_STR);

		if($stmt->execute()){
			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return true;
		}
		echo '<pre>'; print_r('fallo'); echo '</pre>';
	}

	public static function existeOdontograma($idCons){
		$sql="SELECT * FROM `odontograma` WHERE id_consulta = :idCons;";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);

		if($stmt->execute()){
			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return $stmt->fetch();
		}
		echo '<pre>'; print_r('fallo'); echo '</pre>';

	}

	private static function yaSeInsertoEstaPiezaDental($idOdon,$idPieza){
		$sql="SELECT * FROM `pieza_dental` WHERE id_odont = :idOdon and nro= :nro;";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idOdon", $idOdon,PDO::PARAM_INT);
		$stmt->bindValue(":nro", $idPieza,PDO::PARAM_INT);

		if($stmt->execute()){
			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return $stmt->fetch();
		}
		echo '<pre>'; print_r('fallo'); echo '</pre>';
	}
	private static function yaSeInsertoEstaCaraDental($idOdon,$idPieza,$idCara){
		$sql="SELECT * FROM `c_p_dental` WHERE id_odont = :idOdon and id_pieza=:idPieza and id_cara=:idcara";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idOdon", $idOdon,PDO::PARAM_INT);
		$stmt->bindValue(":idPieza", $idPieza,PDO::PARAM_INT);
		$stmt->bindValue(":idcara", $idCara,PDO::PARAM_INT);

		if($stmt->execute()){
			// echo '<pre>'; print_r('exito'); echo '</pre>';
			return $stmt->fetch();
		}
		echo '<pre>'; print_r('fallo'); echo '</pre>';
	}

}