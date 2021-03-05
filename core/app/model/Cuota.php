<?php 

Class Cuota {

	//logica de pagos
	public static function mostrarCuotas($idNota){

		$sql="Select* 
			from cuota
			where id_nota =:idNota;";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":idNota", $idNota, PDO::PARAM_STR);
		 if($stmt->execute()){
		 	
		 	return $stmt->fetchAll();
		}
		echo '<pre>'; print_r("fallo"); echo '</pre>';
		return false;

	}

	public static function insertaCuota($idNota,$monto,$ciPaciente){
		
		$idCuota = Cuota::getNumeroCuotas($idNota);
	
		$sql="INSERT INTO `cuota`(`id_nota`, `id_cuo`, `fecha`, `monto`, `ci_paciente`) VALUES (:idNota,:idCuota,CURDATE(),:monto,:ciPaciente);";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":idNota", $idNota, PDO::PARAM_STR);
		$stmt->bindValue(":idCuota", $idCuota, PDO::PARAM_STR);
		$stmt->bindValue(":monto", $monto, PDO::PARAM_STR);
		$stmt->bindValue(":ciPaciente", $ciPaciente, PDO::PARAM_STR);
		 if($stmt->execute()){
		 	return true;
		}
		echo '<pre>'; print_r("fallo"); echo '</pre>';
		return false;
	}

	public static function getNumeroCuotas($idNota){
		$sql = "Select IFNULL(MAX(cuo.id_cuo)+1,1)from nota_venta nv, cuota cuo where nv.id_vnot = cuo.id_nota and id_nota=:idNota";
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":idNota", $idNota, PDO::PARAM_STR);
		$stmt->execute();
		$rep = $stmt->fetch();
		return $rep[0];
	}


}