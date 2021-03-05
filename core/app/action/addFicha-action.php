 <?php 
 	$array=$_POST;
 	echo '<pre>'; print_r($array); echo '</pre>';
 // 	date_default_timezone_set('America/La_Paz');
 // 	$fecha=getdate();
 // 	echo '<pre>'; print_r($fecha); echo '</pre>';
 //    $fechaco=$fecha["year"]."-".$fecha["mon"]."-".$fecha["mday"];
 //    echo '<pre>'; print_r($fechaco); echo '</pre>';
 //    $datetime1 = new DateTime($fechaco);
	// $datetime2 = new DateTime($array['fechaFicha']);
	// $interval = $datetime1->diff($datetime2);
	// $dias= $interval->format('%R%a');
	// if ($dias>=0) {
	// 		echo "true"; 
	// 	}else{
	// 		echo "false";
	// 	}


 	 //    date_default_timezone_set('America/La_Paz');
 		// $fecha=getdate();
 		// echo '<pre>'; print_r($fecha); echo '</pre>';
 		// $horaActual= $fecha["hours"].":".$fecha["minutes"];
 		// echo '<pre>'; print_r($horaActual); echo '</pre>';
 		// $min1=substr($array["horaFicha"], -2);
 		// $min2=substr($horaActual, -2);
 		// echo '<pre>'; print_r($min1); echo '</pre>';
 		// echo '<pre>'; print_r($min2); echo '</pre>';
 		// $hora1=substr($array["horaFicha"], 0 ,-3);
 		// echo '<pre>'; print_r($hora1); echo '</pre>';
 		// $hora2=substr($horaActual, 0 ,-3);
 		// echo '<pre>'; print_r($hora2); echo '</pre>';
 		
 		// if ($hora1 > $hora2) {
 		// 	echo "yes";
 		// }else if ($hora1 = $hora2) {
 		// 	if ($min1 >= $min2) {
 		// 		echo "yes";
 		// 	}else{
 		// 		echo "no";
 		// 	}
 		// }else{
 		// 	echo "no";
 		// }


 	$id_agenda=Ficha::getAgendaByCiOdont($array["setOdontologo"]);
 	echo '<pre>'; print_r($id_agenda); echo '</pre>';
    $ficha= new Ficha($array["fechaFicha"],$array["horaFicha"],"a",$_GET["ci"],$id_agenda);
    echo '<pre>'; print_r($ficha); echo '</pre>';

    if ($ficha->esFechaValida()) {
    	if (($ficha->esFechaHoy())=="true") {
    		if (!($ficha->esHoraValida())){

    		Core::alert("La hora ingresada ya pasó");
    		$url="<script> history.go(-2); </script>";
			Core::imprimir($url); exit;
		    }
    		
    	}

    	$dia=Ficha::getDiaxFecha($array["fechaFicha"]); 
    	$res=Ficha::esDiaCorrecto($dia,$array["setOdontologo"]);
    	echo '<pre>'; print_r($res); echo '</pre>';
    	if ($res=="false") {
    		Core::alert("Fecha errónea: El odontologo no atiende ese día");
    		$url="<script> history.go(-2); </script>";
			Core::imprimir($url); exit;
    	}

    	$correctoDia=Ficha::esHoraCorrecta($array["horaFicha"],$dia,$array["setOdontologo"]);
    	if ($correctoDia=="false") {
    		Core::alert("Hora errónea: La hora no coincide con el horario del ondontologo");
    		$url="<script> history.go(-2); </script>";
			Core::imprimir($url); exit;
    	}

    	$horaFinReserva=Ficha::obtenerHoraFin($array["horaFicha"],$array["setServicio"]);
		$FichasAgenda=Ficha::mostrarFichasDeAgenda($id_agenda,$array["fechaFicha"]);
		if (count($FichasAgenda)>0) {
			$cont=0;
			foreach ($FichasAgenda as $key => $value) {
				$fichaServ=Ficha::mostrarFichaServicio($value["id_fic"]);
				echo '<pre>'; print_r($fichaServ); echo '</pre>';
				$HorafinFichaReservada=Ficha::obtenerHoraFin($value["hora"],$fichaServ["id_ser"]);
				
				$hora1=strtotime($array["horaFicha"]);
				
				$hora2=strtotime($value["hora"]);
				
				$hora3=strtotime($HorafinFichaReservada);
				
				$hora4=strtotime($horaFinReserva);
				
				
				if ($hora1>=$hora2 and $hora1<=$hora3) {
					$cont=$cont + 1; 
					Core::alert("No se puede reservar ficha, TIEMPO reservado por otra ficha");
    				$url="<script> history.go(-2); </script>";
					Core::imprimir($url); exit;
				}else{
					if ($hora4>=$hora2 and $hora4<=$hora3) {
						$cont=$cont + 1; 
					Core::alert("No se puede reservar ficha, TIEMPO reservado por otra ficha");
    				$url="<script> history.go(-2); </script>";
					Core::imprimir($url); exit;

					}else{
						echo "PUEDO AGREGAR";
					}
				}
			}
			
			if ($cont==0) {
				
				if ($ficha->addFicha($array["setServicio"])) {
							$uf=Ficha::ObtenerUltFicha();
							$agg=Ficha::addFichaServ($uf,$array["setServicio"]);
							session_start();
							Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "una Ficha");
							Core::alert("Exito al insertar una Ficha");
						}
						$url="index.php?view=inicio";
						Core::redir($url);


				
			}
		}else{
						if ($ficha->addFicha($array["setServicio"])) {
							
							$uf=Ficha::ObtenerUltFicha();
							$agg=Ficha::addFichaServ($uf,$array["setServicio"]);
							session_start();
							Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "una Ficha");
							Core::alert("Exito al insertar una Ficha");
						}
						$url="index.php?view=inicio";

						Core::redir($url);
		}

		

    }else{
    	Core::alert("La fecha ingresada ya pasó");
    	$url="<script> history.go(-2); </script>";
		Core::imprimir($url); exit;
    }

 	

  ?>