<?php 

class Log {

	public function __construct(){

	}

	public function Log(){}

	public static function registrarAccion($idUsu,$nombreUsu,$idRol,$accion, $descripcion){

		$sql="insert into log values(null,:idusu,:nombreusu,:idrol,:accion,:descripcion, default);";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		$stmt->bindValue(":idusu", $idUsu,PDO::PARAM_INT);
		$stmt->bindValue(":nombreusu", $nombreUsu,PDO::PARAM_STR);
		$stmt->bindValue(":idrol", $idRol,PDO::PARAM_INT);
		$stmt->bindValue(":accion", $accion,PDO::PARAM_STR);
		$stmt->bindValue(":descripcion", $descripcion,PDO::PARAM_STR);

		if($stmt->execute()){
			return true;
		}		
		return false;
	}

	public static function mostrarRegistroDeAcciones(){
		$sql = "Select l.idlog,id_usuario,l.nombre_usuario,l.id_rol,r.nombre_rol,l.accion,l.descripcion,l.fecha,p.ci,p.nombre_per,p.paterno
		From log l, usuario u, rol r, persona p
		Where l.id_usuario = u.id_usu and u.id_rol = r.id_rol and u.ci_persona = p.ci
        order by l.idlog";

		$con = Database::getConexion(); 
		$stmt = $con->prepare($sql);

		if($stmt->execute()){
			return $stmt->fetchAll();
		}

		echo '<pre>'; print_r("error en el log"); echo '</pre>';

	}
}