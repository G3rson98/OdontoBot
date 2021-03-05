<?php 
if (count($_POST)>0) {
	$url=$_GET;
	// echo '<pre>'; print_r($url); echo '</pre>';
	$from=$_POST;
	echo '<pre>'; print_r($from); echo '</pre>';
	$id_his=$url['id_his'];
	$id_cons=$url['id_cons'];
	$id_pac=$url['id_pac'];
	$id_ficha=$url['id_ficha'];

	foreach ($from as $key => $value) {
		$l=0;
		if (!Validator::validarNumero($value[$l])) {
			$flag="false"; 
		}else{
			$flag="true";
		}
	}


	if ($flag=="false") {
		$url="<script> history.go(-1); </script>";
			Core::alert("Campo con caracteres inválidos");
			Core::imprimir($url); exit;
	}else{

	$i=1;
	foreach ($from as $key => $value) {
		$cantidad=count($value);
	}

		// echo '<pre>'; print_r($cantidad); echo '</pre>';
		while ($i<=$cantidad) {
			
			 ${"objeto" . $i}= new ConsultaProducto($id_his,$id_cons,"","",""); 
			 $i=$i + 1; 
		}

		
		foreach ($from as $key => $value) {
			$j=1;
			while ($j<=$cantidad) {
				${"objeto" . $j}->$key=$value[$j-1];
				$j=$j+1; 
			}
		}

		$k=1;
					 session_start();

		while ($k<=$cantidad) {
			$sw = ${"objeto" . $k}->addConsultaProducto();
			// echo '<pre>'; print_r(${"objeto" . $k}); echo '</pre>';
			// echo '<pre>'; print_r($sw); echo '</pre>';
			 $k=$k+1;
		     Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "un producto a una consulta");
			 Core::alert("Exito al insertar una producto a una consulta");
		}
		 $url="index.php?view=addconsulta&ci_per=$id_pac&id_ficha=$id_ficha&id_his=$id_his&id_cons=$id_cons";
		Core::redir($url);


	}
	
}

 ?>