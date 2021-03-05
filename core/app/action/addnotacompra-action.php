<?php 
if(count($_POST)){
	
	$idNotaCompra = NotaCompra::getNewID();
	$nit = $_POST["nit"];
	$nombreEmp = $_POST["nombre"];
	$fecha = $_POST["fechaCompra"];
	$montoTotal = $_POST["total"];

	if( $montoTotal > 0){

		if(Validator::validarNumero($nit) && Validator::validarString($nombreEmp)){
				// registrar nota compra
			session_start();
			$bandera = NotaCompra::registar($idNotaCompra,$nit,$fecha,$montoTotal,$nombreEmp,$_SESSION['idUsuario']);
			if($bandera ){
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "una nota compra");
				//insertando el detalle de producto
				$idMateriaPrima = $_POST["idMat"];
				$cantidad = $_POST["cantidad"];
				$precio = $_POST["precio"];
				$fechaVen = $_POST["fechaVen"];
				echo '<pre>'; print_r($fechaVen); echo '</pre>';
				$length = count($idMateriaPrima); $ban = true;
				//insertando detalle de venta
				for($i=0; $i< $length && $ban; $i++){
					$ban = NotaCompra::insertarDetalleNotaCompra($idNotaCompra,$idMateriaPrima[$i],$cantidad[$i],$precio[$i],$fechaVen[$i]);
				}

				if($ban){
					Core::alert("Nota compra insertado correctamente");
					$url="index.php?view=registrocompra";
					Core::redir($url);

				}else{
					Core::alert("detalle nota compra error");
					$url="<script> history.go(-1); </script>";
					Core::imprimir($url); exit;

				}

			}else{
				Core::alert("Nota compra error");
					$url="<script> history.go(-1); </script>";
					Core::imprimir($url); exit;
			}

		}else{
			// no validado campos invalidos
			Core::alert("Campo required llenado con caracteres invalidos");
			$cadena = "<script>
	           javascript:history.go(-1);
	       </script>";
			Core::imprimir($cadena);
			exit;		
		}
		

	}else{//no se calculo monto total
		Core::alert("por favor calcule el monto total de la nota compra");
				$url="<script> history.go(-1); </script>";
				Core::imprimir($url); exit;

	}
}