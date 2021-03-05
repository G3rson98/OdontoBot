<?php
  //  echo '<pre>'; print_r($_POST); echo '</pre>';
    $id=$_POST["id"];
    $nombre=$_POST["nombre"];
    $patologia= new Patologia($id,$nombre);
    if(Validator::validarString($nombre)){
      if($patologia->editPatologia()){
          core::alert("Patologia Editada");        
      }

    }else{
      core::alert("Datos Erroneos");    
    }
    $url="index.php?view=patologia";
    core::redir($url);
    ?>