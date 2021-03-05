<?php 

// session_start();
// registrarAccion($idUsu,$nombreUsu,$idRol,$accion, $descripcion){
Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Salio", "del Sistema");

if(isset($_SESSION['nombreUsuario'])){
	unset($_SESSION['nombreUsuario']);
	unset($_SESSION["idUsuario"]);
	unset($_SESSION["idPersona"]);
	unset($_SESSION["idRol"]);
}

session_destroy();

 $url="index.php?view=login";
	Core::redir($url);