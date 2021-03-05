<?php
class Trigger{
	private $valor1;

    public function Trigger($valor1){
        $this->valor1=$valor1;
    }


    public static function get_mat_prima($id){
		$conexion=Database::getConexion();
		$sql="SELECT * FROM mat_prima WHERE mat_prima.id_mat=:id;";
		$result=$conexion->prepare($sql);
		$result->bindValue(":id",$id,PDO::PARAM_INT);
		$result->execute();
		return $result->fetch();
    }

    public static function get_mat_serv($id_serv){
		$conexion=Database::getConexion();
		$sql="SELECT * FROM serv_mat WHERE serv_mat.id_serv=:id_serv;";
		$result=$conexion->prepare($sql);
		$result->bindValue(":id_serv",$id_serv,PDO::PARAM_INT);
		if ($result->execute()) {
			//echo "get_mat_serv exitp";
		}else{
			//echo " get_mat_serv fracaso";
		}
		return  $result->fetchall();
	}

	public static function ajustar_stock(&$cant_usos_serv,&$estado_mat,&$cant_uso,&$tot_uso,&$stock){

		if ($cant_usos_serv<=($stock*$tot_uso-$cant_uso)) {
			$cant_uso=$cant_uso+$cant_usos_serv;
		if ($cant_uso>=$tot_uso) {
			while ($cant_uso>=$tot_uso) {
				$cant_uso=$cant_uso-$tot_uso;
				$stock=$stock-1;				
			}			
			if ($stock==0) {
				$estado_mat='b';
				# code...
			}
			# code...
		}
		return true;
		}else{
			
			return false;
		}
		
	}
	public static function update_mat_prima($id_mat,$estado_mat,$cant_usos,$stock){
			$sql="UPDATE mat_prima SET mat_prima.estado_mat=:estado_mat ,mat_prima.cant_usos=:cant_usos ,mat_prima.stock=:stock WHERE mat_prima.id_mat=:id_mat";
			$conexion=Database::getConexion();
			$result=$conexion->prepare($sql);
			$result->bindValue(":id_mat",$id_mat,PDO::PARAM_INT);
			$result->bindValue(":estado_mat",$estado_mat,PDO::PARAM_STR);
			$result->bindValue(":cant_usos",$cant_usos,PDO::PARAM_INT);
			$result->bindValue(":stock",$stock,PDO::PARAM_INT);
			if ($result->execute()) {
				//echo "si";
			}else{
				//echo "no";
			}
	}
	public static function set_actualizar_mat_prima($id_serv){
		
		echo '<pre>'; echo "serv".$id_serv; echo '</pre>';
		$array_serv=Trigger::get_mat_serv($id_serv);
		echo "<pre>";print_r($array_serv);echo" <pre>";
		//$lentgh=sizeof($array_serv);
		$boolean=Trigger::Hay_Materiales_Suficientes($array_serv);
		if ($boolean) {
			foreach ($array_serv as $key => $value) {
			echo "<pre>";print_r($value);echo" <pre>";
			$id_mat=$value["id_mat_pri"];
			//echo $id_mat;
			$cant_usos_serv=$value["cant_usos_serv"];
			$array_mat=Trigger::get_mat_prima($id_mat);
		echo "<pre>";print_r($array_mat);echo" <pre>";
			$estado_mat=$array_mat["estado_mat"];
			$cant_usos=$array_mat["cant_usos"];
			$tot_usos=$array_mat["tot_usos"];
			$stock=$array_mat["stock"];
			Trigger::ajustar_stock($cant_usos_serv,$estado_mat,$cant_usos,$tot_usos,$stock);
			Trigger::update_mat_prima($id_mat,$estado_mat,$cant_usos,$stock);			
			}
			
		}
		return $boolean;


	}
	    public static function Hay_Materiales_Suficientes($array_serv){
    	$boolean=true;
    	/*echo "<pre>";
    	print_r($array_serv);
    	echo"<pre>";
    	*/
    	foreach ($array_serv as $key => $value) {
    		$id_mat=$value["id_mat_pri"];
    		$cant_usos_serv=$value["cant_usos_serv"];
    		$array_mat=Trigger::get_mat_prima($id_mat);
    		if ($cant_usos_serv>($array_mat["stock"]*$array_mat["tot_usos"]-$array_mat["cant_usos"])){
				return false;
    		}
    		
    	}
    	return true;
  	  }
}
?>