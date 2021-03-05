<?php
   echo '<pre>'; print_r($_POST); echo '</pre>';
    $id=$_POST["id_mat"];
    $nombre=$_POST["nombre_mat"];
  // $estado=$_POST["estado"];
    $descripcion=$_POST["descripcion_mat"];
    $tot_uso=$_POST["tot_usos"];
    if(Validator::validarString($nombre) && Validator::validarString($descripcion)){
       // $MateriaPrima= new Servicio($id,$nombre,$descripcion,$estado,$duracion);
       // if($patologia->editServicio()){
        MateriaPrima::update_Mat_Prima($id,$nombre,$descripcion,$tot_uso);
        core::alert("Servicio Editado"); 

        //}
        
    }else{
        core::alert("Datos Erroneos");  
    }
    $url="index.php?view=MateriaPrima";
        core::redir($url);
        