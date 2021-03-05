 <?php 

	if(count($_POST) > 0) {
		echo '<pre>'; print_r($_POST); echo '</pre>';
		echo '<pre>'; print_r($_GET); echo '</pre>';

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

		if(Validator::validarNumero($ciOdo) && Validator::validarString($nombreOdo) &&
	   Validator::validarString($paterno) && Validator::validarString($materno) ){

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
		if( $direccion != "" && !Validator::validarStringDescripcion($direccion)){

			$url="<script> history.go(-1); </script>";
			Core::alert("Campo direccion con caracteres invalidos");
			Core::imprimir($url); exit;
		}

		$odontologo = new Odontologo($_POST["ci"],$_POST["nombre"],$_POST["apellidoPaterno"],$_POST["apellidoMaterno"],$_POST["sexo"],$_POST["telefono"],$_POST["celular"],$_POST["fechaNacimiento"],$_POST["direccion"],"a");
		

		  if($odontologo->edit()){
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Edito", "un Odontologo");

			Core::alert("Se ha editado correctamente un Odontologo");
			$url="index.php?view=odontologo";
			Core::redir($url);
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
