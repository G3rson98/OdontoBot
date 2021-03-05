<?php
class pas_pat{
    
    public  static function asignarpatologia($id,$ci,$descripcion){
		$sql = "INSERT INTO pac_pat VALUES(:id_pat,:ci_pac,:descripcion);";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_pat",$id,PDO::PARAM_INT);
        $stmt->bindValue(":ci_pac",$ci,PDO::PARAM_INT);
        $stmt->bindValue(":descripcion",$descripcion,PDO::PARAM_STR);
		if ($stmt->execute()){
		//	echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
	public static function mostrarpatologia($id){
		$sql = "SELECT * FROM pac_pat WHERE ci_pac=:ci_pa;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_pa",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return $stmt->fetchall();

		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
	public static function eliminarpatologia($id,$ci){
		$sql = "DELETE FROM pac_pat WHERE ci_pac=:ci_pac and id_pat=:id_pat;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_pac",$ci,PDO::PARAM_INT);
		$stmt->bindValue(":id_pat",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
}