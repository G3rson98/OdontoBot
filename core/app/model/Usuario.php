<?php
class Usuario {

	public $nombre_usuario;
	public $contrasena;
	public $estado_usu;
	public $ci_persona;
	public $id_rol;
	public $permisos;

	public function Usuario($nombre_usuario,$contrasena, $estado_usu,$ci_persona,$id_rol){
		$this->nombre_usuario=$nombre_usuario; 
		$this->contrasena=$contrasena; 
		$this->estado_usu=$estado_usu;
		$this->ci_persona=$ci_persona;
		$this->id_rol=$id_rol;
		$this->permisos =  array();
	}

	public static function mostrarUsuario(){

		$sql = "SELECT p.nombre_per,p.paterno,p.materno,u.id_usu,u.nombre_usuario,u.contrasena,u.estado_usu,u.ci_persona,r.nombre_rol   FROM persona p, usuario u, rol r WHERE p.ci = u.ci_persona and r.id_rol = u.id_rol";

		$con = Database::getConexion();
		$stmt = $con->prepare($sql);

		if($stmt->execute()){

			// echo '<pre>'; print_r("correcto"); echo '</pre>';
			return $stmt->fetchAll();
		}else{
			echo '<pre>'; print_r("error"); echo '</pre>';
		}

	}

	 public function addUsuario(){
	 	
	 	$con = Database::getConexion();

	 	$stmt = $con->prepare("insert into usuario values (null ,:nombre_usuario ,:contrasena ,:estado_usu ,:ci_persona ,:id_rol);"); 
		$stmt->bindValue(":nombre_usuario", $this->nombre_usuario,PDO::PARAM_STR);
	 	$stmt->bindValue(":contrasena", $this->contrasena,PDO::PARAM_STR);
	 	$stmt->bindValue(":estado_usu", $this->estado_usu,PDO::PARAM_STR);
	 	$stmt->bindValue(":ci_persona", $this->ci_persona,PDO::PARAM_STR);
	 	$stmt->bindValue(":id_rol", $this->id_rol,PDO::PARAM_INT);
	 	// echo '<pre>'; print_r($stmt); echo '</pre>';

	 	if ($stmt->execute()){
	 		echo '<pre>'; print_r("exito add"); echo '</pre>';
			return true;
	 	}		
		return false;
	}

	public function editUsuario(){
		
		//UPDATE usuario u SET u.nombre_usuario = "username", u.contrasena = "1234" , u.estado_usu="a" where u.id_usu = 7;
		$sql = "UPDATE usuario u SET u.nombre_usuario = :nombreUser, u.contrasena = :password , u.estado_usu= :estado where u.ci_persona = :ci_per;";
		$con = Database::getConexion();

	 	$stmt = $con->prepare($sql); 
		$stmt->bindValue(":nombreUser", $this->nombre_usuario,PDO::PARAM_STR);
	 	$stmt->bindValue(":password", $this->contrasena,PDO::PARAM_STR);
	 	$stmt->bindValue(":estado", $this->estado_usu,PDO::PARAM_STR);
	 	$stmt->bindValue(":ci_per", $this->ci_persona,PDO::PARAM_STR);

	 	if ($stmt->execute()){
	 		echo '<pre>'; print_r("exito edit"); echo '</pre>';
			return true;
	 	}		
		return false;

	}

	public function addPermisos(){

		$this->deletePermisos();
		$arrayPermiso = $this->permisos;
		$length = count($arrayPermiso);
		for ($i=0; $i < $length; $i++) {
			$this->insertarPermiso($arrayPermiso[$i]);	
		}
	}

	private function deletePermisos(){
		$con = Database::getConexion();
		// Delete from usu_perm where id_usu = (Select id_usu from usuario where ci_persona = '5401932');
    	// $records = $con->prepare("delete from permiso where id_rol =:idRol;");
    	$records = $con->prepare("delete from usu_perm where id_usu = (Select id_usu from usuario where ci_persona = :ci);");
    	// $records->bindValue(":idRol",$this->id_rol,PDO::PARAM_INT);
    	$records->bindValue(":ci",$this->ci_persona,PDO::PARAM_STR);
		$records->execute();
	}

	private function insertarPermiso($idPermiso){
		$con = Database::getConexion();
    	// $records = $con->prepare("insert into permiso values(:idRol,:idPermiso,:nombrePermiso);");
    	$records = $con->prepare("insert into usu_perm value(null,(Select id_usu from usuario where ci_persona = :ci),:id_perm);");
    	// $records->bindValue(":idRol",$this->id_rol,PDO::PARAM_INT);
    	// $records->bindValue(":idPermiso",$idPermiso,PDO::PARAM_INT);
    	// $records->bindValue(":nombrePermiso",$nombrePermiso,PDO::PARAM_STR);
    	$records->bindValue(":ci",$this->ci_persona,PDO::PARAM_STR);
    	$records->bindValue(":id_perm",$idPermiso,PDO::PARAM_INT);


		$records->execute();
	}
	public static function getUsuarioByID($id){
		$sql = "SELECT * FROM usuario u, persona p, rol r WHERE u.id_usu = :id and u.ci_persona = p.ci and r.id_rol = u.id_rol;";
		$con = Database::getConexion();
    	$stmt = $con->prepare($sql);

    	$stmt->bindValue(":id",$id,PDO::PARAM_INT);
    	$stmt->execute();
    	return $stmt->fetch();
	}

	public static function  getPermisos($idUsuario){
		// $sql = "SELECT * FROM permiso p WHERE p.id_rol = :idUsuario;";
		$sql = "Select* from usu_perm up, permiso p Where id_usu = :idUsuario and p.id_per=up.id_permiso;";
		$con = Database::getConexion();
    	$stmt = $con->prepare($sql);

    	$stmt->bindValue(":idUsuario",$idUsuario,PDO::PARAM_INT);
    	$stmt->execute();
    	return $stmt->fetchAll();
	}
	
	public static function validarUsuario($nombre,$password){

		$con = Database::getConexion();
    	$records = $con->prepare("call validar_Usuario(:userName,:password);");

    	$records->bindValue(":userName", $nombre,PDO::PARAM_STR);
		$records->bindValue(":password", $password,PDO::PARAM_STR);

		$records->execute();
		return $records->fetch();
	}

	public static function existePermiso($array, $nombre){

		$length = count($array);
		for($i=0; $i< $length; $i++){
			if($array[$i]["nombre_per"] == $nombre){
				return true;
			}			
		}
		return false;
	}

}