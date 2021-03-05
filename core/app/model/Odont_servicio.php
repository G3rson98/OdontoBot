<?php
class Odont_servicio {
    private $ci_odont;
    private $id_serv;
    public function Odont_servicio ($ci_odont,$id_serv){
        $this->ci_odont=$ci_odont;
        $this->id_serv=$id_serv;
    }
    public  static function asignarservicio($ci,$id){
		$sql = "INSERT INTO odont_servicio VALUES(:ci_odont,:id_serv);";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_odont",$ci,PDO::PARAM_INT);
		$stmt->bindValue(":id_serv",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
		//	echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
	public static function mostrarservicio($id){
		$sql = "SELECT id_serv FROM odont_servicio WHERE ci_odont=:ci_odont;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_odont",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
		//	echo '<pre>'; print_r("exito"); echo '</pre>';
			return $stmt->fetchall();

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
	public static function eliminarservicio($ci,$id){
		$sql = "DELETE FROM odont_servicio WHERE ci_odont=:ci_odont and id_serv=:id_serv;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_odont",$ci,PDO::PARAM_INT);
		$stmt->bindValue(":id_serv",$id,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
		//	echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
	}
}