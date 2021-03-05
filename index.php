<?php 
/**
 * Archivo Principal
 * 
 */
/*==================================================
=            CONSTANTES DE LA CONECCION            =
==================================================*/
	define('DB_HOST','localhost');
	define('DB_NAME','consultorio_dr_roblesvd');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_ENCODE','utf8');
	define('PRO_NOMBRE','ODONTOBOT');

/*=====  End of CONSTANTES DE LA CONECCION  ======*/



include "core/autoload.php";

Core::$mensaje = false;

// ini_set('display_errors', 1);

// ini_set('memory_limit', '256M');


Core::$root=""; // primera instancia


$lb = new Lb();
$lb->start();
