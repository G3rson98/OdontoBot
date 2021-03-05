<?php 

if(count($_POST)> 0){

	echo '<pre>'; print_r($_POST); echo '</pre>';
	$montoPagar = $_POST["montoAPagar"];
	$idNota = $_POST["idNota"];
	$ciPaciente = $_POST["ciPaciente"];
	
	if(Cuota::insertaCuota($idNota,$montoPagar,$ciPaciente)){
		Core::alert("Se agrego corectamente la cuota");
			$url="index.php?view=registroventa";
			 Core::redir($url);
	}

}