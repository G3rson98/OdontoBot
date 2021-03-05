
<?php 

if(count($_POST)>0){
	$ci_pac=$_POST["ci_pac"];
	$n_pac=$_POST["nombre_pac"];
	$pat_pac=$_POST["paterno"];
	$mat_pac=$_POST["materno"];
	$se_pac=$_POST["sexo"];
	$tel_pac=$_POST["telefono"];
	$cel_pac=$_POST["celular"];
	$fech_pac=$_POST["fecha_nac"];
	$dir_pac=$_POST["direccion"];
	$est_pac="a";
	$lug_pac=$_POST["lugar_nac"];

	if(Validator::validarNumero($ci_pac) && Validator::validarString($n_pac) &&
	   Validator::validarString($pat_pac) && Validator::validarString($mat_pac) && Validator::validarString($lug_pac) ){

		
		if( $cel_pac != "" && !Validator::validarNumero($cel_pac) ){
			echo '<pre>'; print_r($cel_pac); echo '</pre>';
			$url="<script> history.go(-1); </script>";
			Core::alert("Campo celular con caracteres invalidos");
			Core::imprimir($url); exit;

		}
		if( $tel_pac != "" && !Validator::validarNumero($tel_pac)){

			$url="<script> history.go(-1); </script>";
			Core::alert("Campo telefono con caracteres invalidos");
			Core::imprimir($url); exit;
		}
		if( $dir_pac != "" && !Validator::validarString($dir_pac)){

			$url="<script> history.go(-1); </script>";
			Core::alert("Campo direccion con caracteres invalidos");
			Core::imprimir($url); exit;
		}


		
		$paciente = new Paciente($_POST["ci_pac"],$_POST["nombre_pac"],$_POST["paterno"],$_POST["materno"],$_POST["sexo"],$_POST["telefono"],$_POST["celular"],$_POST["fecha_nac"],$_POST["direccion"],"a",$_POST["lugar_nac"]);

	 
			if($paciente->add()){
				session_start();
				Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "un Paciente");
				$url="index.php?view=paciente";
				Core::alert("Exito al insertar Paciente");
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
?>