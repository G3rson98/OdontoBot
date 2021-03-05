<?php 

	if(count($_POST) > 0) {

	$paciente = new Paciente($_POST["ci_pac"],$_POST["nombre_pac"],$_POST["paterno"],$_POST["materno"],$_POST["sexo"],$_POST["telefono"],$_POST["celular"],$_POST["fecha_nac"],$_POST["direccion"],"a",$_POST["lugar_nac"]);
		

		if($paciente->edit()){
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Edito", "un Paciente");
			$url="index.php?view=paciente";
			Core::alert("Se ha editado correctamente Paciente");
			Core::redir($url);
		}

	}