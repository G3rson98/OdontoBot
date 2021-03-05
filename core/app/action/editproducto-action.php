<?php 
if (count($_POST)>0){
	echo '<pre>'; print_r($_POST); echo '</pre>';

	$id_prod=$_POST["id_prod"];
	$nombre_prod=$_POST["nombre_prod"];
	$estado_prod="a";

	if(!Validator::validarString($nombre_prod)){
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo nombre producto con caracteres invalidos");
			Core::imprimir($url); exit;
	}else{
		 $producto=new producto($id_prod,$nombre_prod,$estado_prod);
		 if($producto->editProducto()){
		 		session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Editó", "un  producto");
				Core::alert("Exito al modificar un producto");
		 }
			 $url="index.php?view=producto";
				Core::redir($url);
	}
}



 ?>