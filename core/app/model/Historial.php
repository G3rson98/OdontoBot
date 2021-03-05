<?php
class Historial{
    public static function getHistorial($ci){
        $sql = "SELECT * 
        FROM Historial,consulta
        Where 	historial.ci_paciente=:ci_pa
        and		historial.id_his=consulta.id_historial";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_pa",$ci,PDO::PARAM_INT);
		if ($stmt->execute()){
			//echo '<pre>'; print_r("exito"); echo '</pre>';
			return $stmt->fetchall();

		}else{
			echo '<pre>'; print_r("no exito"); echo '</pre>';
			return false;	
		}

    }




}