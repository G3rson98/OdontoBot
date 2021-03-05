<?php
    //echo '<pre>'; print_r($_POST); echo '</pre>';
    $nombre_materia=$_POST["nombre"];
    $descripcion_materia=$_POST["descripcion"];
    $estado_materia="a";
    $cantidad_usada=0;
    $Utilidad=$_POST["utilidad"];;
    //$Stock=$_POST["stock"];
    $Stock=0;
    if(Validator::validarString($nombre_materia) && Validator::validarString($descripcion_materia)&&Validator::validarNumero($Utilidad) ){
        //echo $Stock;
        $servicio= new MateriaPrima("",$nombre_materia,$descripcion_materia,$estado_materia,$cantidad_usada,$Utilidad,$Stock);

        if($servicio->set_MateriaPrima()){
            session_start();
                Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Inserto", "una MateriaPrima");
            core::alert("Materia Prima Insertada");        
        }
    }else{
        Core::alert("Campos llenados con caracteres invalidos");
        $cadena = "<script>
           javascript:history.go(-1);
       </script>";
        Core::imprimir($cadena);
        exit;     
    }
   $url="index.php?view=MateriaPrima";
   core::redir($url);