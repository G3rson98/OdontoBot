<?php
    $servicio= Servicio::getservicio($_GET["id"]) ;
    echo '<pre>'; print_r($servicio); echo '</pre>';
    $id=$servicio["id_ser"];
    $nombre=$servicio["nombre_ser"];
    $estado=$servicio["estado_ser"];
    $descripcion=$servicio["descripcion_ser"];
    $duracion=$servicio["t_duracion"];
    $patologia= new Servicio($id,$nombre,$descripcion,$estado,$duracion);
    if($patologia->delServicio()){
        core::alert("Servicio Editado");        
    }
    $url="index.php?view=servicio";
     core::redir($url);