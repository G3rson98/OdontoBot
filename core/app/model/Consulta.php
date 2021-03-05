<?php
class Consulta
{
    private $id_consulta;
    private $id_historia;
    private $motivo;
    private $diagnostico;
    private $tratamiento;
    private $fecha_retorno;
    private $id_ficha;

    public function Consulta($id_historia, $motivo, $diagnostico, $tratamiento, $fecha_retorno, $id_ficha)
    {
        $array=$this->AIllave();
        
        $this->id_consulta = ($array[0]) +1;        
        $this->id_historia = $id_historia;
        $this->motivo = $motivo;
        $this->diagnostico = $diagnostico;
        $this->tratamiento = $tratamiento;
        $this->fecha_retorno = $fecha_retorno;
        $this->id_ficha = $id_ficha;
    }
    private function AIllave()
    {
        $sql = "select MAX(id_con) from consulta";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function crear_consulta()
    {
        $sql = "INSERT INTO consulta VALUES(:id_historial,:id_con,:motivo,:diagnostico,:tratamiento,:fecha_retorno,:id_ficha);";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_historial", $this->id_historia, PDO::PARAM_INT);
        $stmt->bindValue(":id_con", $this->id_consulta, PDO::PARAM_INT);
        $stmt->bindValue(":motivo", $this->motivo, PDO::PARAM_STR);
        $stmt->bindValue(":diagnostico", $this->diagnostico, PDO::PARAM_STR);
        $stmt->bindValue(":tratamiento", $this->tratamiento, PDO::PARAM_STR);
        $stmt->bindValue(":fecha_retorno", $this->fecha_retorno, PDO::PARAM_STR);
        $stmt->bindValue(":id_ficha", $this->id_ficha, PDO::PARAM_INT);
        if ($stmt->execute()) {
           
            return "true";
            
        } else {
            
            return "false";
        }
    }

    public static function getUltimaConsulta(){
        $sql="select max(consulta.id_con) from consulta";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $array=$stmt->fetch();
       
        return $array; 

    }

    public static function FichaYaTieneConsulta($id_ficha){
        $sql="select count(*) from ficha,consulta where ficha.id_fic=consulta.id_ficha and ficha.id_fic=:id_ficha";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_ficha",$id_ficha, PDO::PARAM_INT);
        $stmt->execute();         
        $array=$stmt->fetch();
        echo '<pre>'; print_r($array); echo '</pre>';
        if ($array["0"]==0) {
            return "false";             
        }else{
            return "true";
        }
       
    }
    public static function getconsultabyficha($nroficha){
        $sql = "SELECT id_historial,id_con FROM consulta where id_ficha=:nroficha;";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nroficha",$nroficha, PDO::PARAM_INT);        
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function edit_consulta($id_historia,$motivo,$diagnostico,$tratamiento,$fecha_retorno,$id_ficha,$id_consulta)
    {
        $sql = "update consulta set consulta.motivo=:motivo,consulta.diagnostico=:diagnostico,consulta.tratamiento=:tratamiento,consulta.fecha_retorno=:fecha_retorno where consulta.id_historial=:id_historial and consulta.id_con=:id_con and consulta.id_ficha=:id_ficha";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_historial", $id_historia, PDO::PARAM_INT);
        $stmt->bindValue(":id_con", $id_consulta, PDO::PARAM_INT);
        $stmt->bindValue(":motivo", $motivo, PDO::PARAM_STR);
        $stmt->bindValue(":diagnostico", $diagnostico, PDO::PARAM_STR);
        $stmt->bindValue(":tratamiento", $tratamiento, PDO::PARAM_STR);
        $stmt->bindValue(":fecha_retorno", $fecha_retorno, PDO::PARAM_STR);
        $stmt->bindValue(":id_ficha", $id_ficha, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->execute()) {
           
            return "true";
            
        } else {
            
            return "false";
        }
    }
     public static function getSolaconsulta($id_ficha,$id_consulta,$id_historial){
        $sql = "SELECT * FROM consulta where id_ficha=:nroficha and id_con=:con and id_historial=:historial;";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nroficha",$id_ficha, PDO::PARAM_INT);        
        $stmt->bindValue(":con",$id_consulta, PDO::PARAM_INT);        
        $stmt->bindValue(":historial",$id_historial, PDO::PARAM_INT);        
        $stmt->execute();
        return $stmt->fetch();
    }
}
