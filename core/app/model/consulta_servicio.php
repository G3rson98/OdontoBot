<?php
class consulta_servicio{
    private $id_consulta;
    private $id_historial;
    private $id_serv;
    private $precio;
    public function consulta_servicio ($id_consulta,$id_historial,$id_serv,$precio){
        $this->id_consulta=$id_consulta;
        $this->id_historial=$id_historial;
        $this->id_serv=$id_serv;
        $this->precio=$precio;
    }
    public  static function asignarservicio($id_serv,$id_historial,$id_consulta,$precio){
		$sql = "INSERT INTO serv_cons VALUES(:id_serv,:id_historial,:id_cons,:precio);";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_serv",$id_serv,PDO::PARAM_INT);
        $stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
        $stmt->bindValue(":id_cons",$id_consulta,PDO::PARAM_INT);
        $stmt->bindValue(":precio",$precio,PDO::PARAM_INT);
		if ($stmt->execute()){
			echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;					
		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
	public static function mostrarservicio($id_consulta,$id_historial){
		$sql = "SELECT * FROM serv_cons WHERE id_historial=:historial and id_consulta=:consulta";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
        $stmt->bindValue(":historial",$id_historial,PDO::PARAM_INT);
        $stmt->bindValue(":consulta",$id_consulta,PDO::PARAM_INT);
		$stmt->execute();
		//	echo '<pre>'; print_r("exito"); echo '</pre>';
		return $stmt->fetchAll();

	}
	public static function eliminarservicio($id_consulta,$id_historial,$id){
		$sql = "DELETE FROM serv_cons WHERE id_historial=:historial and id_consulta=:consulta and id_serv=:id_serv;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
        $stmt->bindValue(":historial",$id_historial,PDO::PARAM_INT);
        $stmt->bindValue(":consulta",$id_consulta,PDO::PARAM_INT);
		$stmt->bindValue(":id_serv",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}

	public static function getprecio($id_consulta,$id_historial,$id_servicio){
		$sql = "SELECT * FROM serv_cons WHERE id_historial=:historial and id_consulta=:consulta and id_serv=:serv;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":historial",$id_historial,PDO::PARAM_INT);
        $stmt->bindValue(":consulta",$id_consulta,PDO::PARAM_INT);
		$stmt->bindValue(":serv",$id_servicio,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return $stmt->fetch();

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}

	}
}