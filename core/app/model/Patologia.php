<?php
class Patologia{
    private $nombre;
    private $id;
    public function Patologia($id,$nombre){
       $this->nombre=$nombre; 
       $this->id=$id;
    }
    public function add(){
        $con=Database::getConexion(); 
        $stmt=$con->prepare("insert into patologia values(null,:nombre);"); 
        $stmt->bindValue(":nombre", $this->nombre,PDO::PARAM_STR);
        if ($stmt->execute()){
            echo '<pre>'; print_r("exito"); echo '</pre>';
            return true;

        }else{
            echo '<pre>'; print_r("no exito"); echo '</pre>';
            return false;   
        }
    }
    public static function mostrarPatologia(){
        $sql = "Select * from patologia";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function getpatologia($id){
        $sql = "Select * from patologia where id_pat=:id;";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    public  function editPatologia(){
        $sql = "update patologia set nombre_pat=:nombre where id_pat=:id;";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id",$this->id,PDO::PARAM_INT);
        $stmt->bindValue(":nombre",$this->nombre,PDO::PARAM_STR);
        return $stmt->execute()>0?true:false;
    }

}