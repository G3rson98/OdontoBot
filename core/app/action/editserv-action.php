<?php
   // echo '<pre>'; print_r($_POST); echo '</pre>';
    $id=$_POST["id"];
    $nombre=$_POST["nombre"];
    $estado=$_POST["estado"];
    $descripcion=$_POST["descripcion"];
    $duracion=$_POST["duracion"];
    if(Validator::validarString($nombre) && Validator::validarString($descripcion)){
        $patologia= new Servicio($id,$nombre,$descripcion,$estado,$duracion);
        if($patologia->editServicio()){
            core::alert("Servicio Editado");        
        }
        
    }else{
        core::alert("Datos Erroneos");  
    }
    $url="index.php?view=servicio";
        core::redir($url);