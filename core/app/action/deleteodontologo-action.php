<?php 

$ci=$_GET["id"];
// echo '<pre>'; print_r($ci); echo '</pre>';
$sql="select * from persona, odontologo where persona.ci=odontologo.ci_odont and odontologo.ci_odont=".$ci;
$con=DataBase::getConexion();
$stmt=$con->prepare($sql);
$stmt->execute();
$array=$stmt->fetchAll();
// echo '<pre>'; print_r($array); echo '</pre>';

foreach ($array as $key => $value) {
	$odontologo = new Odontologo($value["ci"], $value["nombre_per"],$value["paterno"],$value["materno"] , $value["sexo"] , $value["telefono"] , $value["celular"], $value["fecha_nac"], $value["direccion"], $value["estado_odon"]);
	if ($odontologo->deleteOdontologo()){
	session_start();
	Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Eliminó", "un Odontólogo");
	}
}
Core::alert("Se dio de baja a un Odontólogo");
	$url ="index.php?view=odontologo";
	 Core::redir($url);

 ?>