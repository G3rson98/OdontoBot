<?php 

Class NotaCompra {

	public static function mostrarNotaCompas(){
		$sql = "SELECT * FROM `nota_compra`";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public static function registar($idNotaCompra,$nit,$fecha,$montoTotal,$nombreEmp,$idUsu){
		$sql="INSERT INTO `nota_compra`(`id_cnot`, `nit`, `fecha_cnot`, `monto_cnot`, `nombre_emp`, `id_usuario`) VALUES (:idNota,:nit,:fecha,:monto,:nombre,:idUsu)";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idNota", $idNotaCompra,PDO::PARAM_INT);
		$stmt->bindValue(":nit", $nit,PDO::PARAM_INT);
		$stmt->bindValue(":fecha", $fecha,PDO::PARAM_STR);
		$stmt->bindValue(":monto", $montoTotal,PDO::PARAM_STR);
		$stmt->bindValue(":nombre", $nombreEmp,PDO::PARAM_STR);
		$stmt->bindValue(":idUsu", $idUsu,PDO::PARAM_INT);

        if($stmt->execute())
        	return true;
        return false;
	}
	public static function insertarDetalleNotaCompra($idNotaCompra,$idMateriaPrima,$cantidad,$precio,$fechaVen){
		$sql="INSERT INTO `nota_mat_prima`(`id_nota_c`, `id_mat`, `cantidad`, `precio`, `fecha_venc`) VALUES (:idNota,:idMat,:cant,:prec,:fechaven)";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idNota", $idNotaCompra,PDO::PARAM_INT);
		$stmt->bindValue(":idMat", $idMateriaPrima,PDO::PARAM_INT);
		$stmt->bindValue(":cant", $cantidad,PDO::PARAM_INT);
		$stmt->bindValue(":prec", $precio,PDO::PARAM_STR);
		$stmt->bindValue(":fechaven", $fechaVen,PDO::PARAM_STR);

		if($stmt->execute())
        	return true;

        return false;
	}

	public static function getNotaCompra($idNota){
		$sql="SELECT * FROM nota_compra WHERE nota_compra.id_cnot =:idNota";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
		$stmt->bindValue(":idNota", $idNota,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
	}

	public static function getDetalleNotaCompra($idNota){
		$sql="SELECT * FROM nota_mat_prima np, mat_prima m WHERE m.id_mat = np.id_mat and id_nota_c =:idNota";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
		$stmt->bindValue(":idNota", $idNota,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public static function getNewID(){
		$sql="SELECT IFNULL(MAX(id_cnot)+1,1) FROM `nota_compra`";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resp= $stmt->fetch();
        return $resp[0];
	}
}