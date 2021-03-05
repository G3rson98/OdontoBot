<?php 

/**
 * [__autoload: Metodo Magico PHP: se ejecuta cada vez que se hace una instancia de una clase]
 * @param  [type] $modelname [Nomble de la clase modelo]
 * @return [type]            [hace una inclusion]
 */
function __autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	}	 
}


