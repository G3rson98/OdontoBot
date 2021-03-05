<?php 
/**
 * Archivo donde se hace todo los incluye(incluir un archivo)
 * 
 */

/*====================================================
=            Seccion de Archivios Nucleos            =
====================================================*/
// archivo principal o Nucleo
	include "controller/Core.php";
	include "controller/View.php";
	include "controller/Module.php";
	include "controller/Database.php";
	include "controller/Validator.php";




/*=====  End of Seccion de Archivios Nucleos  ======*/

	include "controller/Model.php";
	include "controller/Action.php";


/*================================================
=            Seccion de Archivos Init            =
================================================*/
// arch. Clase que ejecuta primero
	// include "controller/Session.php";
	include "controller/Lb.php";

/*=====  End of Seccion de Archivos Init  ======*/

