<?php
class ConsultaProducto
{
    public $id_historial; 
    public $id_consulta;
    public $idProd;
    public $precio; 
    public $cantidad; 

    public function ConsultaProducto($id_historial,$id_consulta,$id_producto,$precio_producto,$cantidad_producto)
    {
        
        $this->id_historial=$id_historial; 
        $this->id_consulta=$id_consulta;
        $this->idProd=$id_producto;
        $this->precio=$precio_producto;
        $this->cantidad=$cantidad_producto; 
        
    }

    public function addConsultaProducto(){
        $sql="insert into prod_con values(:id_prod,:id_historial,:id_consulta,:precio_prod,:cantidad_prod);"; 
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_prod", $this->idProd,PDO::PARAM_INT);
        $stmt->bindValue(":id_historial", $this->id_historial,PDO::PARAM_INT);
        $stmt->bindValue(":id_consulta", $this->id_consulta,PDO::PARAM_INT);
        $stmt->bindValue(":precio_prod", $this->precio,PDO::PARAM_STR);
        $stmt->bindValue(":cantidad_prod", $this->cantidad,PDO::PARAM_INT);

        if ($stmt->execute()){
            return "true";
            // echo '<pre>'; print_r("exito"); echo '</pre>';
        }else{
            return "false";
            // echo '<pre>'; print_r("fallo"); echo '</pre>';

        }
       
    }

    public static function mostrarProdActivosNoUsados($id_his,$id_cons){
        $sql="select * from producto where producto.id_prod not in (
            select producto.id_prod from historial,consulta,prod_con,producto
            where consulta.id_historial=historial.id_his 
            and prod_con.id_historial=historial.id_his and prod_con.id_consulta=consulta.id_con and prod_con.id_prod=producto.id_prod 
            and historial.id_his=:id_his and consulta.id_con=:id_con)"; 
        $con=Database::getConexion();
        $stmt=$con->prepare($sql);
        $stmt->bindValue(":id_his", $id_his,PDO::PARAM_INT);
        $stmt->bindValue(":id_con", $id_cons,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
