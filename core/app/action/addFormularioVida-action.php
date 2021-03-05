<?php 
if (count($_POST)>0) {
	 $id_historial=$_GET["id_his"];
     $id_consulta=$_GET["id_cons"];
     $id_pac=$_GET['ci_per'];
     $id_ficha=$_GET['id_ficha'];
	echo '<pre>'; print_r($_POST); echo '</pre>';
	$altura=$_POST["altura"]; 
	$peso=$_POST["peso"];
	$temperatura=$_POST["temperatura"]; 
	$frec_cardiaca=$_POST["frec_cardiaca"];
	$prec_arterial=$_POST["prec_arterial"];
	if(Validator::validarNumero($altura) && Validator::validarNumero($peso) && Validator::validarNumero($temperatura) 
		&& Validator::validarNumero($frec_cardiaca)){
		 $formVida=new FormularioVida("",$altura,$peso,$temperatura,$frec_cardiaca,$prec_arterial,$id_historial,$id_consulta);
		 if($formVida->addFormularioVida()=="true"){
		 		session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Insertó", "formulario de vida a la consulta");
				Core::alert("Exito al insertar el formulario de vida");
		 }
			 $url="index.php?view=addconsulta&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha";
				Core::redir($url);
	}else{
		$url="<script> history.go(-1); </script>";
			Core::alert("Algunos de los campos es invalido");
			Core::imprimir($url); exit;
	}


	
}




 ?>