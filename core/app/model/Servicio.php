<?php
class Servicio{
    private $id;
    private $nombre_serv;
    private $descripcion;
    private $estado_serv;
    private $duracion;
    public function Servicio($id,$nombre_serv,$descripcion,$estado_serv,$duracion){
        $this->id=$id;
        $this->nombre_serv=$nombre_serv;
        $this->descripcion=$descripcion;
        $this->estado_serv=$estado_serv;
        $this->duracion=$duracion;
    }
    public function add(){
        $con=Database::getConexion(); 
		$stmt=$con->prepare("insert into servicio values(null,:nombre_serv,:descripcion,:estado_serv,:duracion);"); 
        $stmt->bindValue(":nombre_serv", $this->nombre_serv,PDO::PARAM_STR);
        $stmt->bindValue(":descripcion", $this->descripcion,PDO::PARAM_STR);
        $stmt->bindValue(":estado_serv", $this->estado_serv,PDO::PARAM_STR);
        $stmt->bindValue(":duracion", $this->duracion,PDO::PARAM_INT);
        
		if ($stmt->execute()){
			echo '<pre>'; print_r("exito"); echo '</pre>';
			return true;

		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}
    }
    public static function mostrarServicio(){
		$sql = "Select * from servicio";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function mostrarServicioOdont($ci_odont){
        $sql = "select * from odontologo,odont_servicio,servicio where odontologo.ci_odont=odont_servicio.ci_odont and odont_servicio.id_serv=servicio.id_ser and odontologo.ci_odont=:ci_odont";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":ci_odont",$ci_odont,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function getservicio($id){
        $sql = "Select * from servicio where id_ser=:id;";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
    }
    public  function editServicio(){
        $sql = "update servicio set nombre_ser=:nombre,estado_ser=:estado,descripcion_ser=:descripcion,t_duracion=:duracion where id_ser=:id;";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$this->id,PDO::PARAM_INT);
        $stmt->bindValue(":nombre",$this->nombre_serv,PDO::PARAM_STR);
        $stmt->bindValue(":estado",$this->estado_serv,PDO::PARAM_STR);
        $stmt->bindValue(":descripcion",$this->descripcion,PDO::PARAM_STR);
        $stmt->bindValue(":duracion",$this->duracion,PDO::PARAM_INT);
		return $stmt->execute()>0?true:false;
    }
    public  function delServicio(){
        $baja='b';
        $sql = "update servicio set estado_ser=:estado where id_ser=:id;";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$this->id,PDO::PARAM_INT);
        $stmt->bindValue(":estado",$baja,PDO::PARAM_STR);
		return $stmt->execute()>0?true:false;
    }
}