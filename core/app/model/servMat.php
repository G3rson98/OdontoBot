<?php
class servMat {
   
   public static function asignarMateriales($id_serv,$id_mat,$cant_Uso_Serv){
       $sql = "INSERT INTO serv_mat VALUES(:id_serv,:id_mat_pri,:cant_usos_serv);";
       $con = Database::getConexion();
       $stmt = $con->prepare($sql);
       $stmt->bindValue(":id_serv",$id_serv,PDO::PARAM_INT);
       $stmt->bindValue(":id_mat_pri",$id_mat,PDO::PARAM_INT);
       $stmt->bindValue(":cant_usos_serv",$cant_Uso_Serv,PDO::PARAM_STR);
       $stmt->execute();
      
   }

   public static function ActualizarMateriales($id_serv,$id_mat,$cant_Uso_Serv){
      $sql = "UPDATE  serv_mat SET serv_mat.cant_usos_serv = :cant_uso_serv WHERE serv_mat.id_serv =:id_serv AND serv_mat.id_mat_pri =:id_mat";
      $con = Database::getConexion();
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":id_serv",$id_serv,PDO::PARAM_INT);
      $stmt->bindValue(":id_mat",$id_mat,PDO::PARAM_INT);
      $stmt->bindValue(":cant_uso_serv",$cant_Uso_Serv,PDO::PARAM_STR);
      $stmt->execute();
     
  }
     public static function DeleteMatDeServ($id_serv,$id_mat){
      $sql = "DELETE FROM serv_mat WHERE serv_mat.id_serv =:id_serv AND serv_mat.id_mat_pri =:id_mat";
      $con = Database::getConexion();
      $stmt = $con->prepare($sql);
      $stmt->bindValue(":id_serv",$id_serv,PDO::PARAM_INT);
      $stmt->bindValue(":id_mat",$id_mat,PDO::PARAM_INT);
      //$stmt->bindValue(":cant_uso_serv",$cant_Uso_Serv,PDO::PARAM_STR);
      $stmt->execute();
     
  }
  public static function existe($id_serv,$id_mat){
     $sql ="SELECT * FROM serv_mat WHERE serv_mat.id_serv=:id AND serv_mat.id_mat_pri=:id_m";
     $con = Database::getConexion();
     $stmt = $con->prepare($sql);
     $stmt->bindValue(":id",$id_serv,PDO::PARAM_INT);
     $stmt->bindValue(":id_m",$id_mat,PDO::PARAM_INT);
     $stmt->execute();
     return $stmt->fetch();

  }
 public static function existeMat_en_serv($id_Mat,$editMat){
  
  //echo "$id_Mat";
 //echo '<pre>'; print_r($editMat); echo '</pre>';
  foreach ($editMat as $key => $value) {
    if ($value["id_mat_pri"]==$id_Mat) {
      return true;
    }
  }
  return false;
  }
  public static function get_SerxMat($id_serv){
    $sql ="SELECT * FROM serv_mat WHERE serv_mat.id_serv=:id ";
     $con = Database::getConexion();
     $stmt = $con->prepare($sql);
     $stmt->bindValue(":id",$id_serv,PDO::PARAM_INT);
     $stmt->execute();
     return $stmt->fetchAll();

  }
    public static function ExisteServMat($id_serv,$id_mat){
     // echo "id_serv=".$id_serv;
      //echo "id_mat=".$id_mat;
     $sql ="SELECT * FROM serv_mat WHERE serv_mat.id_serv=:id AND serv_mat.id_mat_pri=:id_m";
     $con = Database::getConexion();
     $stmt = $con->prepare($sql);
     $stmt->bindValue(":id",$id_serv,PDO::PARAM_INT);
     $stmt->bindValue(":id_m",$id_mat,PDO::PARAM_INT);
     $stmt->execute();
      $servmat=$stmt->fetch();
     
      if ($servmat["id_serv"]>0){
          return true;
      }else{
        return false;
      }

      //echo '<pre>'; print_r($servmat); echo '</pre>';

  }
}

?>