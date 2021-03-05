<?php 

class Rol {

	public function Rol(){

	}

	public static function mostrarRoles(){

		$sql = "SELECT * FROM rol";

		$con = Database::getConexion();
		$stmt = $con->prepare($sql);

		$stmt->execute();
		return $stmt->fetchAll();
	}

}