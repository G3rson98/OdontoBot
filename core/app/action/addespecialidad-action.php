<?php 

if(count($_POST)>0){
	// echo '<pre>'; print_r($_POST); echo '</pre>';

	// Atributos de especialidad 
	$nombre_espe=$_POST["nombre_espe"];
	$estado_esp="a";

	if(!Validator::validarString($nombre_espe)){
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo nombre especialidad con caracteres invalidos");
			Core::imprimir($url); exit;
	}else{
		 $especialidad=new Especialidad("",$nombre_espe,$estado_esp);
		 if($especialidad->addEspecialidad()){
		 		session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "una especialidad");
				Core::alert("Exito al insertar una especialidad");
		 }
			 $url="index.php?view=especialidad";
				Core::redir($url);
	}

		
}
