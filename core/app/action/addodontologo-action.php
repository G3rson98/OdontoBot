<?php 

if(count($_POST)>0){
	// echo '<pre>'; print_r($_POST); echo '</pre>';

	// Atributos de Odontologo
	$ciOdo = $_POST["ci"]; // required
	$nombreOdo = $_POST["nombre"]; // required
	$paterno = $_POST["apellidoPaterno"]; // required
	$materno = $_POST["apellidoMaterno"]; // required
	$sexo = $_POST["sexo"]; // required
	$telefono = $_POST["telefono"];
	$celular = $_POST["celular"];
	$fechaNac = $_POST["fechaNacimiento"]; // required
	$direccion = $_POST["direccion"]; 
	$estado = "a";

	// Atributos de un Usuario
	$nombreUsu = $_POST["nombreUsuario"]; 
	$password = $_POST["password"]; 
	$estadoUsu ="a"; 
	$idRol = $_POST["nombre_rol"];

	if(Validator::validarNumero($ciOdo) && Validator::validarString($nombreOdo) &&
	   Validator::validarString($paterno) && Validator::validarString($materno) && Validator::validarString($nombreUsu) ){

		if( $celular != "" && !Validator::validarNumero($celular) ){
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo celular con caracteres invalidos");
			Core::imprimir($url); exit;

		}
		if( $telefono != "" && !Validator::validarNumero($telefono)){

			$url="<script> history.go(-1); </script>";
			Core::alert("Campo telefono con caracteres invalidos");
			Core::imprimir($url); exit;
		}


		$odonto = new Odontologo($ciOdo,$nombreOdo,$paterno,$materno,$sexo,$telefono,$celular,$fechaNac,$direccion,$estado);

		
		$usuario = new Usuario($nombreUsu,$password,$estadoUsu,$ciOdo,$idRol);

		$usuario->permisos = $_POST["permisos"];
		// echo '<pre>'; print_r($usuario->permisos); echo '</pre>';

		if($odonto->addOdontologo()) {
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "un Odontologo");
			
			if($usuario->addUsuario()){
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "un Usuario");
				$usuario->addPermisos();
			}else{
				Core::alert("Error al insertar usuario");
				exit;
			}
		
			Core::alert("Se insertó un nuevo odontólogo");
			$url ="index.php?view=odontologo";
			 Core::redir($url);

		}else{

			Core::alert("Error al insertar odontólogo");
		}

	}else{
		//campos invalidos
		Core::alert("Campo required llenado con caracteres invalidos");
		$cadena = "<script>
           javascript:history.go(-1);
       </script>";
		Core::imprimir($cadena);
		exit;		
	}

}

