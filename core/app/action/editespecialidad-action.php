<?php 
if (count($_POST)>0){
	$id_esp=$_POST["id_esp"];
	$nombre_espe=$_POST["nombre_espe"];
	$estado_esp="a";

	if(!Validator::validarString($nombre_espe)){
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo nombre especialidad con caracteres invalidos");
			Core::imprimir($url); exit;
	}else{
		 $especialidad=new Especialidad($id_esp,$nombre_espe,$estado_esp);
		 if($especialidad->editEspecialidad()){
		 		session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Editó", "una especialidad");
				Core::alert("Exito al modificar una especialidad");
		 }
			 $url="index.php?view=especialidad";
				Core::redir($url);
	}
}



 ?>