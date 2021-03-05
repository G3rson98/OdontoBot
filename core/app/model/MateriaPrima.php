<?php
class MateriaPrima{
	private $id_mat;
	private $nombre_mat;
	private $descripcion_mat;
	private $estado_mat;
	private $cantidad_usos;
	private $total_usos;
	private $unidades_mat;
 	public function MateriaPrima($id,$nombre_mat,$descripcion,$estado,$cant_usos,$total_usos,$stock){
        $this->id_mat=$id;
        $this->nombre_mat=$nombre_mat;
        $this->descripcion_mat=$descripcion;
        $this->estado_mat=$estado;
        $this->cantidad_usos=$cant_usos;
        $this->total_usos=$total_usos;
        $this->unidades_mat=$stock;
    }
        public function set_MateriaPrima(){
        $con=Database::getConexion(); 
		$stmt=$con->prepare("insert into mat_prima values(null,:nombre_mat,:descripcion_mat,:estado_mat,:cant_usos,:tot_usos,:stock);"); 
        $stmt->bindValue(":nombre_mat", $this->nombre_mat,PDO::PARAM_STR);
        $stmt->bindValue(":descripcion_mat", $this->descripcion_mat,PDO::PARAM_STR);
        $stmt->bindValue(":estado_mat",$this->estado_mat,PDO::PARAM_STR);
        $stmt->bindValue(":cant_usos", $this->cantidad_usos,PDO::PARAM_INT);
        $stmt->bindValue(":tot_usos", $this->total_usos,PDO::PARAM_INT);
        $stmt->bindValue(":stock", $this->unidades_mat,PDO::PARAM_INT);
        
		if ($stmt->execute()){
		//	echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
    }
    public static function delete_Mat_Prima($id){
    	          $con=Database::getConexion(); 
            $sql="update  mat_prima set mat_prima.estado_mat = 'b' WHERE mat_prima.id_mat=:id ";
            $stmt=$con->prepare($sql);
            $stmt->bindValue(":id", $id,PDO::PARAM_INT);
            if ($stmt->execute()){
                return true;
                
            }else
            {
            	
                return false;
            }

    }

    public static function update_Mat_Prima($id,$nom,$des,$tot){
            $con=Database::getConexion(); 
            $sql="UPDATE mat_prima SET mat_prima.nombre_mat= :nombre,mat_prima.descripcion_mat =:des, mat_prima.tot_usos=:tot WHERE mat_prima.id_mat=:id";
            $stmt=$con->prepare($sql);
            $stmt->bindValue(":id", $id,PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nom,PDO::PARAM_STR);
            $stmt->bindValue(":des", $des,PDO::PARAM_STR);
            $stmt->bindValue(":tot", $tot,PDO::PARAM_INT);
            if ($stmt->execute()){
                return true;
            }else
            {
                return false;
            }

    }
	public static function mostrarMateriaPrima(){
		$sql = "Select * from mat_prima";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }
    public static function getMateriaPrima($id){
        $sql = "Select * from mat_prima where id_mat=:id;";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}

   
}