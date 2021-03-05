<?php 

$ci=$_GET["id"];
// echo '<pre>'; print_r($ci); echo '</pre>';
$sql="select * from persona, recepcionista where persona.ci=recepcionista.ci_rec and recepcionista.ci_rec=".$ci;
$con=DataBase::getConexion();
$stmt=$con->prepare($sql);
$stmt->execute();
$array=$stmt->fetchAll();
echo '<pre>'; print_r($array); echo '</pre>';

foreach ($array as $key => $value) {
	$recepcionista = new Recepcionista($value["ci"], $value["nombre_per"],$value["paterno"],$value["materno"] , $value["sexo"] , $value["telefono"] , $value["celular"], $value["fecha_nac"], $value["direccion"], $value["estado_rec"]);
	if ($recepcionista->deleteRecepcionista()){
	session_start();
	Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Eliminó", "un Recepcionista");
	}
}
	$url ="index.php?view=recepcionista";
	Core::alert("Se dio de baja a un Recepcionista");
	 Core::redir($url);


 ?>