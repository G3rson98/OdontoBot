<?php
class Producto{
	public $id_producto; 
	public $nombre_producto; 
	public $estado_prod;

	public function Producto($id_producto,$nombre_producto,$estado_prod){
		$this->id_producto=$id_producto; 
		$this->nombre_producto=$nombre_producto;
		$this->estado_prod=$estado_prod;
	}

	public static function mostrarProducto(){
		$sql="select * from producto"; 
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function addProducto(){
		$con=Database::getConexion(); 
		$sql="insert into producto values(null,:nombre_prod,'a')";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":nombre_prod", $this->nombre_producto,PDO::PARAM_STR);
		// $stmt->bindValue(":estado_espe", $this->estado_espe,PDO::PARAM_STR);
		if ($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public static function getProductoById($id_producto){
		$sql="select * from producto where producto.id_prod=:id_producto";
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":id_producto", $id_producto,PDO::PARAM_STR);
		$stmt->execute(); 
		return $stmt->fetch();
	}

	public function editProducto(){
		$sql="update producto set producto.nombre_prod=:nombre_prod where producto.id_prod=:id_prod"; 
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":nombre_prod", $this->nombre_producto,PDO::PARAM_STR);
		$stmt->bindValue(":id_prod", $this->id_producto,PDO::PARAM_INT);
		if($stmt->execute()){
			return true; 
		} else {
			return false;
		}
		
	}

	public function deleteProducto(){
		$sql="update producto set producto.estado_prod='b' where producto.id_prod=:id_prod";
		$con=Database::getConexion(); 
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":id_prod", $this->id_producto,PDO::PARAM_INT);
		if ($stmt->execute()) {
			return true; 
		}else{
			return false; 
		}
	}

	public static function mostrarProdActivos(){
		$sql="select * from producto where producto.estado_prod='a'"; 
		$con=Database::getConexion();
		$stmt=$con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
?>