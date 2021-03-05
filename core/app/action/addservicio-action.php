<?php
    //echo '<pre>'; print_r($_POST); echo '</pre>';
    $nombre_serv=$_POST["nombre"];
    $descripcion=$_POST["descripcion"];
    $estado_serv="a";
    $duracion=$_POST["duracion"];;
    if(Validator::validarString($nombre_serv) && Validator::validarString($descripcion)){
        $servicio= new Servicio("",$nombre_serv,$descripcion,$estado_serv,$duracion);
        if($servicio->add()){
            core::alert("Servicio Insertada");        
        }
    }else{
        core::alert("Datos Erroneos");  
    }
    $url="index.php?view=servicio";
    core::redir($url);