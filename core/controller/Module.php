<?php

/**
 * Clase que maneja la parte de los modulos que le corresponde a cada Usuario
 * 
 */
class Module {

	public static function loadLayout(){

		if(Core::$root==""){

			include "core/app/layouts/layout.php";

		}
	}

	// public static function getNombreDeModulo($nombre){

	// 	$Module = array(1 => "inicio",2=>"paciente",3=>"empleado",4 => "atencion", 5 => "usuario", 6 => "servicio");
		
	// 	$resp = "";
	// 	for ($i=1; $i <= 6; $i++) {

	// 		if(substr_count($nombre, $Module[$i]) > 0){
	// 			$resp = "module-".$Module[$i];
	// 			break;
	// 		}
		
	// 	}
	// 	return $resp;
	// }

}



?>