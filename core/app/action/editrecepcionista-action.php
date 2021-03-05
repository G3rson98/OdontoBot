<?php 

	if(count($_POST) > 0) {
		echo '<pre>'; print_r($_POST); echo '</pre>';


	$recepcionista = new Recepcionista($_POST["ci"],$_POST["nombre"],$_POST["apellidoPaterno"],$_POST["apellidoMaterno"],$_POST["sexo"],$_POST["telefono"],$_POST["celular"],$_POST["fechaNacimiento"],$_POST["direccion"],"a");
		

		if($recepcionista->edit()){
			session_start();
			Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Edito", "un recepcionista");

			Core::alert("Se ha editado correctamente un recepcionista");
			$url="index.php?view=recepcionista";
			Core::redir($url);
		}

	}