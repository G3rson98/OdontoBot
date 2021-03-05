<?php 

	if(count($_POST) > 0 ){
		// echo '<pre>'; print_r($_POST); echo '</pre>';

		$id= $_POST["idHorario"];
		$dia = $_POST["dia"];
		$horaInicio = $_POST["horaInicio"];
		$horaFinal = $_POST["horaFinal"];
		$estado = "a";

		$horario = new Horario($id,$dia,$horaInicio,$horaFinal,$estado);
		// echo '<pre>'; print_r($horario->toString()); echo '</pre>';

		if($horario->edit()) {
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Edito", "un horario");

			Core::alert("Se edito corectamente horario");
			$url ="index.php?view=horario";
			 Core::redir($url);


		}else{

			echo '<pre>'; print_r("fallo al insertar"); echo '</pre>';
		}



	}