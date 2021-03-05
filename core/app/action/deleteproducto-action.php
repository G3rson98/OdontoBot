<?php 
$id_prod=$_GET["id"];
$arrayProd=Producto::getProductoById($id_prod);
echo '<pre>'; print_r($arrayProd); echo '</pre>';
$producto=new Producto($id_prod,$arrayProd["nombre_prod"],$arrayProd["estado_prod"]);
if ($producto->deleteProducto()) {
	session_start();
	Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Eliminó", "un  producto");
	Core::alert("Exito al eliminar un producto");
}
 $url="index.php?view=producto";
				Core::redir($url);


 ?>