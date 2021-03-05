<?php 

if(count($_POST)>0){
	echo '<pre>'; print_r($_POST); echo '</pre>';

	// Atributos de receplogo
	$ciRec = $_POST["ci"]; // required
	$nombreRec = $_POST["nombre"]; // required
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
	$idRol = $_POST["nuevoUsuario"];

	if(Validator::validarNumero($ciRec) && Validator::validarString($nombreRec) &&
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
 
			$recep = new Recepcionista($_POST["ci"],$_POST["nombre"],$_POST["apellidoPaterno"],$_POST["apellidoMaterno"],$_POST["sexo"],$_POST["telefono"], $_POST["celular"],$_POST["fechaNacimiento"], $_POST["direccion"],"a");

			$usuario= new Usuario($_POST["nombreUsuario"], $_POST["password"],"a",$_POST["ci"],$_POST["nuevoUsuario"]);


			$recep->addRecepcionista();
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "un Recepcionista");
			$usuario->addUsuario();
			$usuario->permisos = $_POST["permisos"];
			$usuario->addPermisos();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "un Usuario");
			
			Core::alert("Se insertó un nuevo recepcionista");
			$url ="index.php?view=recepcionista";
			 Core::redir($url);

		
		}else{

			Core::alert("Error al insertar recepcionista");
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

  ?>