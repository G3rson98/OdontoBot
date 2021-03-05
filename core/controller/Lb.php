<?php

/**
 * Clase que lanza(incluye) los primeros archivos para ejecutar
 */

class Lb {

	public function Lb(){

		
	}

	public function start(){
		include "core/app/autoload.php";
		include "core/app/init.php";
	}

}
