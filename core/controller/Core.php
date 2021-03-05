<?php

/**
* Clase Nucleo o Core del software
* Descripcion: Funcion de manejar el redireccionamiento de las paginas, alertas de las diferentes paginas
* 
*/
class Core {
	/**
	 * [$root : identificar que tipo de Usurio: admin,odont, recep]
	 * @var string
	 */
	public static $root = ""; 

	

	/**
	 * [$mensaje: Si true : permite muestra un mensaje
	 * @var boolean
	 */
	public static $mensaje = false;

	public static function alert($text){

		echo "<script>alert('".$text."');</script>";

	}


	public static function redir($url){

		echo "<script>window.location='".$url."';</script>";
		
	}
	
	public static function mensajeMostrar($tipo, $accion, $mensaje){
		switch ($tipo) {
			case 'exito':
				echo"<div class='alert alert-success alert-dismissible'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                		<h4><i class='icon fa fa-check'></i> Alerta al ".$accion."!</h4>
                		".$mensaje."
    				</div>";
				break;
			case 'error':
				echo"<div class='alert alert-warning alert-dismissible'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                		<h4><i class='icon fa fa-warning'></i> Alert ".$accion."!</h4>
                			".$mensaje."
    				</div>";
				break;
			
		}

	}

	public static function imprimir($cadena){

		echo $cadena;

	}


}
