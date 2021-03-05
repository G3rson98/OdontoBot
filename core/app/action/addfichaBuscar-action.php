<?php 

	$ci=$_POST["ci_pac"];
	// echo '<pre>'; print_r($ci); echo '</pre>';
	$valor=Paciente::existePaciente($ci);
	// echo '<pre>'; print_r($valor); echo '</pre>';
	$v1=$valor["0"]; 
	// echo '<pre>'; print_r($v1); echo '</pre>';
	if ($v1=="0") {
		Core::alert("El CI $ci no existe");
		$url="<script> history.go(-1); </script>";
		Core::imprimir($url); exit;
	}else{
		$url="index.php?view=addficha&ci=$ci";
		Core::redir($url);
	}



 ?>