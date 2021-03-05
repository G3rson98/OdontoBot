<?php
   // echo '<pre>'; print_r($_POST); echo '</pre>';
   $id_mat=$_GET["id"];
  //echo $Tot_uso;
    echo $id_mat;
   if (MateriaPrima::delete_Mat_Prima($id_mat)) {
     Core::alert("Eliminacion  exitosa");
     session_start();
        Log::registrarAccion($_SESSION['idUsuario'],$_SESSION['nombreUsuario'],$_SESSION['idRol'],"Elimino", "Una Materia Prima");
    } else{
      Core::alert("El material esta siendo usado en un servicio");
    }
    
    $url="index.php?view=MateriaPrima";
    core::redir($url);
      
?>