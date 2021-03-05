<?php 


if(count($_POST)){
	// echo '<pre>'; print_r($_POST); echo '</pre>';
	$arrayDientes = array("11"=>'Incisivo central',"12"=>'Incisivo lateral',"13"=>'Canino',"14"=>'Premolar',"15"=>'Premolar',"16"=>'Primer Molar',"17"=>'Segundo Molar',"18"=>'Tercer Molar',"21"=>'Incisivo central',"22"=>'Incisivo lateral',"23"=>'Canino',"24"=>'Premolar',"25"=>'Premolar',"26"=>'Primer Molar',"27"=>'Segundo Molar',"28"=>'Tercer Molar',"31"=>'Incisivo central',"32"=>'Incisivo lateral',"33"=>'Canino',"34"=>'Premolar',"35"=>'Premolar',"36"=>'Primer Molar',"37"=>'Segundo Molar',"38"=>'Tercer Molar',"41"=>'Incisivo central',"42"=>'Incisivo lateral',"43"=>'Canino',"44"=>'Premolar',"45"=>'Premolar',"46"=>'Primer Molar',"47"=>'Segundo Molar',"48"=>'Tercer Molar');
	// campos de tabla Pieza_dental
	$campoidNom = $_POST["iddiente"];

	$idOdot = $_POST["idOdot"];
	$idD = substr($campoidNom, 0,2);
	$nombreDiente = $arrayDientes[$idD];
	$estadoPieza = $_POST["estadoPieza"];

	$bandera = Odontograma::insertarPiezaDental($idOdot,$idD,$nombreDiente,$estadoPieza);

	// campos tabla cp_dental
	$nombre = substr($campoidNom, 2);
	$idCaraDental ;
	switch ($nombre) {
		case 'X':
			$idCaraDental = 1;
			break;
		case 'S':
			$idCaraDental = 2;
			break;
		case 'I':
			$idCaraDental = 3;
			break;
		case 'D':
			$idCaraDental = 4;
			break;
		case 'Z':
			$idCaraDental = 5;
			break;
		
	}

	$diagnostico = $_POST["diagnostico"];
	$estadoCaraDental = $_POST["estadoCaraDental"];
 
	$bandera1 =Odontograma::insertarCara_Dental($idOdot,$idD,$idCaraDental,$diagnostico,$estadoCaraDental);

	if($bandera1 && $bandera){
		Core::alert("Se agrego corectamente");
    		$url="<script> history.go(-1); </script>";
			Core::imprimir($url); exit;
	}
}