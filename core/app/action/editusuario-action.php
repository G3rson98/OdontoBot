<?php 



if(count($_POST) ){

	echo '<pre>'; print_r($_POST); echo '</pre>';

	$ciPersona = $_POST["ciPersona"];
	$nombreUsu = $_POST["nombreUsu"] ;
	// $contrasena=crypt($_POST["contrasenaEditar"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
	$password = (isset($_POST["newPassword"]) && $_POST["newPassword"]!= "") ? $_POST["newPassword"] : $_POST["oldPassword"] ;
	// echo '<pre>'; print_r($password); echo '</pre>';
	$idRol = $_POST["idRol"];
	$estado = "a";
	$permisos = $_POST["permisos"];

	// Usuario($nombre_usuario,$contrasena, $estado_usu,$ci_persona,$id_rol)
	$usuario = new Usuario($nombreUsu,$password,$estado,$ciPersona,$idRol);
	$usuario->permisos = $permisos;
	echo '<pre>'; print_r($usuario->permisos); echo '</pre>';

	if($usuario->editUsuario()){
		
		$usuario->addPermisos();
		echo '<pre>'; print_r("edito usuario"); echo '</pre>';

		session_start();
		Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Edito", "un usuario");

		Core::alert("Se ha editado correctamente un usuario");
		$url="index.php?view=usuario";
		Core::redir($url);
	}

}