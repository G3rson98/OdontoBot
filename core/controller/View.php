<?php

/**
 * Clase que permite manejar las diferentes View
 * Una vista corresponde a cada componente visual dentro de un modulo.
 */
class View {
	

	/**
	 * Funcion que se encarga de cargar las diferentes vistas que se dan en la URL
	 * @param  [string] $view: nombre de la vista
	 * @return [null]  no retorna nada solo tiene la funcion de hacer un include a la vista
	 */
	public static function load($view){

		if(!isset($_GET['view'])){

			if(Core::$root==""){
				// echo '<pre>'; print_r("no hay var get"); echo '</pre>';

					include "core/app/view/".$view."-view.php";
			}

		}else{

			if(View::isValid()){
				$url ="";
				if($_GET["view"] != "inicio"){

					// echo '<pre>'; print_r("vista completa"); echo '</pre>';
					
					$url = "core/app/view/".$_GET['view']."-view.php";

				}else{

					echo '<pre>'; print_r("modelo completa"); echo '</pre>';

					Module::loadLayout();
				}

				include $url;				
			}else{

				View::Error("<b>404 NOT FOUND</b> View <b>".$_GET['view']."</b> folder !! - <a href='http://evilnapsis.com/legobox/help/' target='_blank'>Help</a>");
			}
		}
	}

	/**
	 * Funcion que valida si la url existe
	 * @return boolean [true: si existe | false: sino existe]
	 */
	public static function isValid(){

		$valid=false;
		if(isset($_GET["view"])){
			$url ="";
			if(Core::$root==""){


				$url = "core/app/view/".$_GET['view']."-view.php";

			}

			if(file_exists($file = $url)){
				$valid = true;
			}
		}
		return $valid;
	}


	public static function Error($message){
		print $message;
	}

}
?>