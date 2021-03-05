<?php 

if(count($_POST)>0){
	echo '<pre>'; print_r($_POST); echo '</pre>';

	// Atributos de producto
	$nombre_prod=$_POST["nombre_prod"];
	$estado_prod="a";

	if(!Validator::validarString($nombre_prod)){
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo nombre producto con caracteres inválidos");
			Core::imprimir($url); exit;
	}else{
		 $producto=new Producto("",$nombre_prod,$estado_prod);
		 if($producto->addProducto()){
		 		session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "un producto");
				Core::alert("Exito al insertar una producto");
		 }
			 $url="index.php?view=producto";
				Core::redir($url);
	}

		
}
