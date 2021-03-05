<?php 

if(count($_POST) > 0){

	echo '<pre>'; print_r($_POST); echo '</pre>';
	// campos validando
	$montoPagado = $_POST["montoPago"];
	$montoTotal = $_POST["montoTotal"];
	$ciPaciente = $_POST["ci"];

	if(Validator::validarNumero($montoPagado) && $montoPagado <= $montoTotal){
		$idHist = $_POST["idHist"];
		$idCons = $_POST["idCons"];
		

		if(NotaVenta::registar($montoTotal,$montoTotal,$idHist,$idCons)){

		// echo '<pre>'; print_r("esta todo buen"); echo '</pre>';
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"registro", "un venta");
		$idNota = NotaVenta::existeNotaVenta($idHist,$idCons);
		echo '<pre>'; print_r($idNota); echo '</pre>';
		$res=Cuota::insertaCuota($idNota,$montoPagado,$ciPaciente);
		echo '<pre>'; print_r($res); echo '</pre>';

			Core::alert("Se insertó la nota venta correctamente");
			$url="<script> history.go(-2); </script>";
			 Core::imprimir($url);
		}

	}else{

		$url="<script> history.go(-1); </script>";
			Core::alert("ingrese un monto de pago valido");
			Core::imprimir($url); exit;
	}


}