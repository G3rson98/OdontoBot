<?php 
    $nombre=$_POST["nombre"];
    if(Validator::validarString($nombre)){
        $patologia= new Patologia("",$nombre);
        if($patologia->add()){
            core::alert("Patologia Insertada");        
        }

    }else{
        core::alert("Datos Erroneos");
    }
    $url="index.php?view=patologia";
    core::redir($url);
?>