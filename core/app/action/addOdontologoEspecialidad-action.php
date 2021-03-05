<?php 

	if (count($_POST)>0){
		// echo '<pre>'; print_r(count($_POST)); echo '</pre>';
		// echo '<pre>'; print_r($_POST); echo '</pre>';
		
		foreach ($_POST as $key => $value) {
			// echo '<pre>'; print_r($key); echo '</pre>';
			$i=0;
			while ($i<count($value)) {
				// echo '<pre>'; print_r(count($value)); echo '</pre>';
				$id_esp=$value["$i"];
				// echo '<pre>'; print_r($id_esp); echo '</pre>';
				$i=$i + 1;
				// echo '<pre>'; print_r($i); echo '</pre>';
				$odEsp=new OdontologoEspecialidad($id_esp,$_GET["id"]);
				// echo '<pre>'; print_r($_GET["id"]); echo '</pre>';
				if ($odEsp->addOdontologoEspecialidad()){
					session_start();
					Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "especialidad a un odontologo");
				}else{
					echo "no exito";
				}
			}
			
		}
			$id=$_GET['id'];
			// echo '<pre>'; print_r($id); echo '</pre>';
			Core::alert("Se insertaron nuevas especialidades");
			 $url ="index.php?view=odontologoEspecialidad&id=$id";
			 Core::redir($url);

		// for ($i=0; $i <count($_POST) ; $i++) { 
		// 	$id_esp=$_POST["$i"];
		// 	echo '<pre>'; print_r($id_esp); echo '</pre>';
		// 	// $odEsp= new OdontologoEspecialidad($id_esp,$ci_odont);

		// }
	}


 ?>