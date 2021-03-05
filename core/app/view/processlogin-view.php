<?php 

if( !isset($_SESSION["nombreUsuario"])) {

	$userName = $_POST["nombre_usu"];
	
	// $password = crypt($_POST["password"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
	$password = $_POST["password"];
	// echo '<pre>'; print_r($password); echo '</pre>';
	// header("location=index.php");

	// $user = $_POST['mail'];
	// $pass = sha1(md5($_POST['password']));

		$results = Usuario::validarUsuario($userName,$password);
		// echo '<pre>'; print_r($results); echo '</pre>';
	
		if ( is_array($results) ) {

			$_SESSION["nombreUsuario"] = $userName;
			$_SESSION["idUsuario"] = $results["id_usu"];
			$_SESSION["idPersona"] = $results["ci_persona"];
			$_SESSION["idRol"] = $results["id_rol"];
			
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Ingreso", " al Sistema");
			// Module::loadLayout("index");
			 $url="index.php?view=inicio";
			 Core::redir($url);

		}else{
			Core::$mensaje = true;
			$url="index.php?view=login";
			 Core::redir($url);

		}

}
