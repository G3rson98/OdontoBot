<?php 
	$id=$_GET["id"];
	$array=Especialidad::getEspecialidadByID($id);
	echo '<pre>'; print_r($array); echo '</pre>';

	$especialidad= new Especialidad($array["id_esp"],$array["nombre_esp"],"a");
	if ($especialidad->deleteEspecialidad()){
		session_start();
		Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Eliminó", "una especialidad");
		Core::alert("Exito al dar de baja a una especialidad");
	}
	$url="index.php?view=especialidad";
				Core::redir($url);


 ?>