<?php 
/**
 * $validoEmail = '/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/';
			if(preg_match('/^[0-9]+$/',$_POST["insertarCi"]) &&
		       preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["insertarNombre"]) &&
		   	   preg_match($validoEmail,$_POST["insertarCorreo"]) &&
		   	   preg_match('/^[0-9]+$/',$_POST["insertarTelefono"])){
	$encriptar=crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
 */

Class Validator {

	public static function validarString($nombre){
		return preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$nombre);
	}

	public static function validarStringDescripcion($nombre){
		return preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,.-\/ ]+$/',$nombre);
	}


	public static function validarNumero($numero){
		return preg_match('/^[0-9.]+$/',$numero);
	}

	public static function validarCorreo(){
		$validoEmail = '/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/';
		return preg_match($validoEmail,$_POST["insertarCorreo"]);
	}

	public static function validarContrasena($contrasena){
		return preg_match('/^[a-zA-Z0-9 ]+$/',$contraseña);
		
	}

	
}