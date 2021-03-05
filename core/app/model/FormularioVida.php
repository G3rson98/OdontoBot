<?php 
class FormularioVida{
	public $id_for;
	public $altura; 
	public $peso; 
	public $temperatura;
	public $frecuencia_cardiaca; 
	public $presion_arterial; 
	public $id_historial;
	public $id_consulta; 

	public function FormularioVida($id_for,$altura,$peso,$temperatura,$frecuencia_cardiaca,$presion_arterial,$id_historial,$id_consulta){
		$this->id_for=$id_for;
		$this->altura=$altura; 
		$this->peso=$peso; 
		$this->temperatura=$temperatura;
		$this->frecuencia_cardiaca=$frecuencia_cardiaca;
		$this->presion_arterial=$presion_arterial; 
		$this->id_historial=$id_historial;
		$this->id_consulta=$id_consulta; 
	}

	public function addFormularioVida(){
		$sql="insert into form_de_vida values (null,:altura,:peso,:temperatura,:frecuencia_cardiaca,:presion_arterial,:id_historial,:id_consulta)";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":altura",$this->altura, PDO::PARAM_STR);
        $stmt->bindValue(":peso",$this->peso, PDO::PARAM_STR);
        $stmt->bindValue(":temperatura",$this->temperatura, PDO::PARAM_STR);
        $stmt->bindValue(":frecuencia_cardiaca",$this->frecuencia_cardiaca, PDO::PARAM_STR);
        $stmt->bindValue(":presion_arterial",$this->presion_arterial, PDO::PARAM_STR);
        $stmt->bindValue(":id_historial",$this->id_historial, PDO::PARAM_STR);
        $stmt->bindValue(":id_consulta",$this->id_consulta, PDO::PARAM_STR);

        if($stmt->execute()){
        	return "true";
        }else{
        	return "false";
        }
	}

	public function ConsultaTieneFV($id_consulta,$id_historial){
		 $sql="select count(*) from consulta,form_de_vida where consulta.id_con=form_de_vida.id_consulta and consulta.id_historial=form_de_vida.id_historial  and consulta.id_con=:id_consulta and consulta.id_historial=:id_historial";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_consulta",$id_consulta, PDO::PARAM_INT);
        $stmt->bindValue(":id_historial",$id_historial, PDO::PARAM_INT);
        $stmt->execute();
        $array=$stmt->fetch();
        if ($array["0"]=="0") {
            return "false"; 
        }else{
            return "true";
        }
	}
    public function getFormularioByCons($id_consulta,$id_historial){
    	 $sql="select form_de_vida.id_for,form_de_vida.altura,form_de_vida.peso,form_de_vida.temperatura,form_de_vida.frecuencia_cardiaca,form_de_vida.precion_arterial,form_de_vida.id_historial,form_de_vida.id_consulta from consulta,form_de_vida where consulta.id_con=form_de_vida.id_consulta and form_de_vida.id_historial=consulta.id_historial and form_de_vida.id_historial=:id_historial and consulta.id_con=:id_consulta";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_consulta",$id_consulta, PDO::PARAM_INT);
        $stmt->bindValue(":id_historial",$id_historial, PDO::PARAM_INT);
        $stmt->execute();
        $array=$stmt->fetch();
        return $array;
    }
	
	public function editFormularioVida(){
		$con=Database::getConexion(); 
		$sql="update form_de_vida set form_de_vida.altura=:altura, form_de_vida.peso=:peso,form_de_vida.temperatura=:temperatura,form_de_vida.frecuencia_cardiaca=:frecuencia_cardiaca,form_de_vida.precion_arterial=:precion_arterial where form_de_vida.id_for=:id_for";
		$stmt=$con->prepare($sql);
		$stmt->bindValue(":altura", $this->altura,PDO::PARAM_STR);
		$stmt->bindValue(":peso", $this->peso,PDO::PARAM_STR);
		$stmt->bindValue(":temperatura", $this->temperatura,PDO::PARAM_STR);
		$stmt->bindValue(":frecuencia_cardiaca", $this->frecuencia_cardiaca,PDO::PARAM_STR);
		$stmt->bindValue(":precion_arterial", $this->presion_arterial,PDO::PARAM_STR);
		$stmt->bindValue(":id_for", $this->id_for,PDO::PARAM_STR);
		
		if ($stmt->execute()){
			return "true";
		}else
		{
			return "false";
		}
	}
	
}


 ?>