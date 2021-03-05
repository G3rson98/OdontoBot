<?php
class Receta {
    private $idhistorial;
    private $idconsulta;
    private $descripcion;

    public function Receta($descripcion,$idconsulta,$idhistorial){
        $this->descripcion=$descripcion;
        $this->idhistorial=$idhistorial;
        $this->idconsulta=$idconsulta;
    }
    public function addReceta(){   
            $con=Database::getConexion(); 
            $stmt=$con->prepare("insert into receta values(null,:descripcion,:idhistorial,:idconsulta);"); 
            $stmt->bindValue(":descripcion", $this->descripcion,PDO::PARAM_STR);
            $stmt->bindValue(":idhistorial", $this->idhistorial,PDO::PARAM_INT);
            $stmt->bindValue(":idconsulta", $this->idconsulta,PDO::PARAM_INT);                
            $stmt->execute();        	
    }
    public function editreceta(){
            $con=Database::getConexion(); 
            $stmt=$con->prepare("update receta set descripcion_rece=:descripcion where id_historial=:idhistorial and id_consulta=:idconsulta");
            $stmt->bindValue(":descripcion", $this->descripcion,PDO::PARAM_STR);
            $stmt->bindValue(":idhistorial", $this->idhistorial,PDO::PARAM_INT);
            $stmt->bindValue(":idconsulta", $this->idconsulta,PDO::PARAM_INT);                
            if($stmt->execute()){

                echo '<pre>'; print_r("Hola"); echo '</pre>';
            }else{
                echo '<pre>'; print_r("Holano"); echo '</pre>';
            }


    }
    public static function getReceta($idhistorial,$idconsulta){
        $con=Database::getConexion(); 
		$stmt=$con->prepare("SELECT * FROM receta Where id_historial=:idhistorial and id_consulta=:idconsulta");     
        $stmt->bindValue(":idhistorial",$idhistorial,PDO::PARAM_INT);
        $stmt->bindValue(":idconsulta",$idconsulta,PDO::PARAM_INT);                
        $stmt->execute();
        return $stmt->fetchall();      		
    }

    public static function getrecetabyficha($idficha){
        $sql = "select id_historial,id_con from consulta where id_ficha=:idficha";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idficha", $idficha,PDO::PARAM_STR);
        $stmt->execute();
        $array=$stmt->fetch();
        
        $id_historial=$array["id_historial"];
        $id_consulta=$array["id_con"];
        
        $receta=Receta::getReceta($id_historial,$id_consulta);
        
        return $receta;
    }    
}