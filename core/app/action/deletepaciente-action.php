<?php 

$ci=$_GET["id"];
echo '<pre>'; print_r($ci); echo '</pre>';
$sql="select * from persona, paciente where persona.ci=paciente.ci_pac and paciente.ci_pac=".$ci;
$con=DataBase::getConexion();
$stmt=$con->prepare($sql);
$stmt->execute();
$array=$stmt->fetchAll();
echo '<pre>'; print_r($array); echo '</pre>';

foreach ($array as $key => $value) {


$paciente = new Paciente($value["ci"],$value["nombre_per"],$value["paterno"],$value["materno"],$value["sexo"],$value["telefono"],$value["celular"],$value["fecha_nac"],$value["direccion"],"a",$value["lugar_nac"]);

if ($paciente->deletePaciente()){
	session_start();
	Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Eliminó", "un Paciente");
}
}
	Core::alert("Se dio de baja a un paciente");
	$url ="index.php?view=paciente";
	 Core::redir($url);	
 ?>