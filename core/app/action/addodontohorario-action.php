<?php 

	if(count($_POST)){

		// echo '<pre>'; print_r($_POST); echo '</pre>';
		$ci = $_POST["ciOdont"];
		$horarios = $_POST["horarios"];

		if(is_array($horarios) ){

			$odoHor = new OdontoHorario($ci,$horarios,"");

			$odoHor->insertarHorarioOdontologo();

			Core::alert("Se agrego los nuevos horarios");
			$url="<script> history.go(-2); </script>";
			 Core::imprimir($url);


		}else{
			$url="<script> history.go(-1); </script>";
			Core::alert("Selecione almenos un horario");
			Core::imprimir($url); exit;
		}


	}